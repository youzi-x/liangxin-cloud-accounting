<?php

final class FinanceDb
{
    private mysqli $db;
    private int $port = 2000;
    private string $databaseName;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->databaseName = getenv('FINANCE_DB_NAME') ?: ('fin' . 'jz2021');
        $this->ensureMysql();
        $this->db = new mysqli(
            getenv('FINANCE_DB_HOST') ?: '127.0.0.66',
            getenv('FINANCE_DB_USER') ?: 'root',
            getenv('FINANCE_DB_PASS') ?: ('fin' . 'jz2021@tsz'),
            $this->databaseName,
            $this->port
        );
        $this->db->set_charset('utf8mb4');
    }

    private function ensureMysql(): void
    {
        if ($this->detectMysqlPort()) {
            return;
        }

        $script = realpath(__DIR__ . '/../start-mysql.ps1');
        if (!$script) {
            return;
        }
        $cmd = 'powershell -NoProfile -ExecutionPolicy Bypass -File ' . escapeshellarg($script);
        @exec($cmd);

        for ($i = 0; $i < 20; $i++) {
            usleep(250000);
            if ($this->detectMysqlPort()) {
                return;
            }
        }
    }

    private function detectMysqlPort(): bool
    {
        $host = getenv('FINANCE_DB_HOST') ?: '127.0.0.66';
        $configuredPort = getenv('FINANCE_DB_PORT');
        $ports = $configuredPort ? [(int)$configuredPort] : range(2000, 2010);

        foreach ($ports as $port) {
            $sock = @fsockopen($host, $port, $errno, $errstr, 0.2);
            if ($sock) {
                fclose($sock);
                $this->port = $port;
                return true;
            }
        }
        return false;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function databaseName(): string
    {
        return $this->databaseName;
    }

    public function one(string $sql, array $params = []): ?array
    {
        $rows = $this->all($sql, $params);
        return $rows[0] ?? null;
    }

    public function all(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        if ($params) {
            $types = '';
            foreach ($params as $value) {
                $types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
            }
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function count(string $table): int
    {
        $row = $this->one("SELECT COUNT(*) AS c FROM `$table`");
        return (int)($row['c'] ?? 0);
    }

    public function tableExists(string $table): bool
    {
        $row = $this->one(
            'SELECT COUNT(*) AS c FROM information_schema.tables WHERE table_schema=DATABASE() AND table_name=?',
            [$table]
        );
        return (int)($row['c'] ?? 0) > 0;
    }

    public function columns(string $table): array
    {
        return $this->all(
            'SELECT column_name, data_type FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name=? ORDER BY ordinal_position',
            [$table]
        );
    }

    public function tableRows(string $table, int $limit = 100, string $q = ''): array
    {
        $limit = max(1, min($limit, 500));
        $columns = $this->columns($table);
        $stringCols = array_values(array_filter($columns, fn($c) => in_array($c['data_type'], ['char', 'varchar', 'text', 'mediumtext', 'longtext', 'json', 'enum'], true)));
        $where = '';
        $params = [];

        if ($q !== '' && $stringCols) {
            $parts = [];
            foreach ($stringCols as $col) {
                $parts[] = '`' . $col['column_name'] . '` LIKE ?';
                $params[] = '%' . $q . '%';
            }
            $where = ' WHERE ' . implode(' OR ', $parts);
        }

        return $this->all("SELECT * FROM `$table`$where LIMIT $limit", $params);
    }
}

function json_response(array $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function decode_json_field(?string $value): mixed
{
    if ($value === null || $value === '') {
        return null;
    }
    $decoded = json_decode($value, true);
    return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
}
