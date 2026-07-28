<?php
require __DIR__ . '/db.php';

function biz_table(string $suffix): string
{
    return 'zm' . 'top_s_' . 'fin' . 'jz_' . $suffix;
}

function base_table(string $suffix): string
{
    return 'zm' . 'top_s_base_' . $suffix;
}

function temp_log_table(): string
{
    return 'zm' . 'top_tmp_log';
}

function table_aliases(): array
{
    return [
        'ledgers' => biz_table('zt'),
        'ledger_profiles' => biz_table('zd'),
        'ledger_settings' => biz_table('zt_ext_cfg'),
        'units' => biz_table('unit_cfg'),
        'currencies' => biz_table('currency_list'),
        'exchange_rates' => biz_table('exchange_rate_his'),
        'account_subjects' => biz_table('km_user'),
        'subject_aux_opening' => biz_table('km_fz_qichu'),
        'subject_currency_opening' => biz_table('km_wb_qichu'),
        'vouchers' => biz_table('pingzheng'),
        'voucher_items' => biz_table('pingzheng_item'),
        'voucher_templates' => biz_table('pingzheng_template'),
        'voucher_types' => biz_table('pingzheng_type'),
        'voucher_settings' => biz_table('pz_cfg'),
        'voucher_print_settings' => biz_table('pz_cfg_print'),
        'voucher_drafts' => biz_table('pz_temporarydata'),
        'files' => biz_table('files'),
        'recycle_bin' => biz_table('recycle_bin'),
        'balance_sheet_formula' => biz_table('zichanfuzhai_formula'),
        'balance_sheet_result' => biz_table('zichanfuzhai_jz'),
        'balance_sheet_year_formula' => biz_table('zichanfuzhainb_formula'),
        'balance_sheet_year_result' => biz_table('zichanfuzhainb_jz'),
        'income_statement_formula' => biz_table('lirun_formula'),
        'income_statement_result' => biz_table('lirun_jz'),
        'cashflow_formula' => biz_table('xjliuliang_formula'),
        'cashflow_result' => biz_table('xjliuliang_jz'),
        'operation_formula' => biz_table('yewuhd_formula'),
        'operation_result' => biz_table('yewuhd_jz'),
        'receivable_formula' => biz_table('shouruzhichu_formula'),
        'payable_formula' => biz_table('shouruzhichunb_formula'),
        'equity_change_formula' => biz_table('suoyouzhequanyibiandong_formula'),
        'asset_cards' => biz_table('gudingzc_arc'),
        'asset_depreciations' => biz_table('gudingzc_main'),
        'asset_depreciation_items' => biz_table('gudingzc_main_item'),
        'asset_categories' => biz_table('gudingzc_type'),
        'asset_voucher_templates' => biz_table('gudingzc_to_pz_tpl'),
        'salary_people' => biz_table('gongzi_arc'),
        'salary_sheets' => biz_table('gongzitb'),
        'salary_voucher_templates' => biz_table('gongzi_pz_template'),
        'salary_deductions' => biz_table('gongzi_specialadditional'),
        'salary_social_params' => biz_table('gongzisocial_security_parameters'),
        'salary_personal_social_params' => biz_table('gongzipersonalsocial_security_parameters'),
        'invoices' => biz_table('invoice'),
        'invoice_voucher_templates' => biz_table('invoice_to_pz_tpl'),
        'journals' => biz_table('journal'),
        'journal_items' => biz_table('journal_item'),
        'journal_categories' => biz_table('journal_sztype'),
        'journal_voucher_templates' => biz_table('journal_to_pz_tpl'),
        'closing_settings' => biz_table('qmjz_cfg'),
        'closing_custom' => biz_table('qmjz_zdy'),
        'tax_declarations' => biz_table('taxx_sfjsb'),
        'tax_metrics' => biz_table('fx_cfg'),
        'base_masters' => base_table('lan_mst'),
        'base_users' => base_table('lan_mst_usr'),
        'base_sessions' => base_table('lan_session'),
        'base_permissions' => base_table('zt_auth'),
        'base_report_exports' => base_table('reportexport'),
        'theme_settings' => biz_table('theme'),
        'backup_files' => biz_table('bf_files'),
        'backup_paths' => biz_table('bf_filespath'),
        'file_backups' => biz_table('file_backups'),
        'archive_index' => biz_table('archive_index'),
        'import_packages' => biz_table('zt_pack_index'),
        'aux_depts' => biz_table('fuzhuhs_arc_bumen'),
        'aux_inventory' => biz_table('fuzhuhs_arc_cunhuo'),
        'aux_suppliers' => biz_table('fuzhuhs_arc_gongyingshang'),
        'aux_customers' => biz_table('fuzhuhs_arc_kehu'),
        'aux_projects' => biz_table('fuzhuhs_arc_xiangmu'),
        'aux_staff' => biz_table('fuzhuhs_arc_yuangong'),
        'aux_custom' => biz_table('fuzhuhs_arc_zdy'),
        'aux_types' => biz_table('fuzhuhs_type'),
        'aux_type_data' => biz_table('fuzhuhs_type_data'),
        'guide_logs' => temp_log_table(),
    ];
}

function real_table(string $alias): ?string
{
    $aliases = table_aliases();
    return $aliases[$alias] ?? null;
}

function module_map(): array
{
    return [
        'home' => ['title' => '首页', 'source' => 'modules/home', 'tables' => ['ledgers', 'ledger_profiles', 'ledger_settings', 'units', 'currencies']],
        'voucher' => ['title' => '凭证', 'source' => 'modules/voucher', 'tables' => ['vouchers', 'voucher_items', 'voucher_templates', 'voucher_types', 'voucher_settings', 'voucher_print_settings', 'voucher_drafts']],
        'books' => ['title' => '账簿', 'source' => 'modules/books', 'tables' => ['account_subjects', 'journal_items', 'subject_aux_opening', 'subject_currency_opening', 'aux_types', 'aux_type_data']],
        'reports' => ['title' => '报表', 'source' => 'modules/reports', 'tables' => ['balance_sheet_formula', 'balance_sheet_result', 'balance_sheet_year_formula', 'balance_sheet_year_result', 'income_statement_formula', 'income_statement_result', 'cashflow_formula', 'cashflow_result', 'operation_formula', 'operation_result', 'receivable_formula', 'payable_formula', 'equity_change_formula']],
        'assets' => ['title' => '资产', 'source' => 'modules/assets', 'tables' => ['asset_cards', 'asset_depreciations', 'asset_depreciation_items', 'asset_categories', 'asset_voucher_templates']],
        'salary' => ['title' => '工资', 'source' => 'modules/salary', 'tables' => ['salary_people', 'salary_sheets', 'salary_voucher_templates', 'salary_deductions', 'salary_social_params', 'salary_personal_social_params']],
        'invoice' => ['title' => '发票管理', 'source' => 'modules/invoice', 'tables' => ['invoices', 'invoice_voucher_templates']],
        'fund' => ['title' => '资金管理', 'source' => 'modules/fund', 'tables' => ['journals', 'journal_items', 'journal_categories', 'journal_voucher_templates']],
        'closing' => ['title' => '结账', 'source' => 'modules/closing', 'tables' => ['closing_settings', 'closing_custom', 'balance_sheet_result', 'income_statement_result', 'cashflow_result']],
        'tax' => ['title' => '税务', 'source' => 'modules/tax', 'tables' => ['tax_declarations', 'tax_metrics', 'currencies', 'exchange_rates']],
        'analysis' => ['title' => '账务分析', 'source' => 'modules/analysis', 'tables' => ['operation_formula', 'operation_result', 'income_statement_formula', 'balance_sheet_formula', 'cashflow_formula']],
        'settings' => ['title' => '设置', 'source' => 'modules/settings', 'tables' => ['base_masters', 'base_users', 'base_sessions', 'base_permissions', 'base_report_exports', 'theme_settings', 'recycle_bin', 'files', 'file_backups', 'backup_files', 'backup_paths', 'aux_depts', 'aux_inventory', 'aux_suppliers', 'aux_customers', 'aux_projects', 'aux_staff', 'aux_custom']],
        'guide' => ['title' => '使用指南', 'source' => 'modules/guide', 'tables' => ['guide_logs']],
    ];
}

function module_payload(FinanceDb $db): array
{
    $items = [];
    foreach (module_map() as $key => $module) {
        $tables = [];
        $total = 0;
        foreach ($module['tables'] as $alias) {
            $table = real_table($alias);
            if (!$table || !$db->tableExists($table)) {
                continue;
            }
            $count = $db->count($table);
            $total += $count;
            $tables[] = ['name' => $alias, 'count' => $count];
        }
        $items[] = ['key' => $key, 'title' => $module['title'], 'source' => $module['source'], 'total' => $total, 'tables' => $tables];
    }
    return $items;
}

try {
    $db = new FinanceDb();
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/api/summary';
    $ztId = (int)($_GET['zt'] ?? 100);

    switch ($path) {
        case '/api/summary':
            $zt = $db->one('SELECT * FROM `' . real_table('ledgers') . '` WHERE id=?', [$ztId]);
            $accountTypes = $db->all(
                'SELECT km_type, COUNT(*) AS total, SUM(qichu_amount) AS qichu, SUM(bennian_jie_amount) AS debit, SUM(bennian_dai_amount) AS credit
                 FROM `' . real_table('account_subjects') . '` WHERE kjzt_id=? GROUP BY km_type ORDER BY FIELD(km_type, "资产", "负债", "权益", "成本", "损益"), km_type',
                [$ztId]
            );
            json_response([
                'zt' => $zt,
                'db' => ['host' => getenv('FINANCE_DB_HOST') ?: '127.0.0.66', 'port' => $db->port(), 'name' => $db->databaseName()],
                'metrics' => [
                    '账套' => $db->count(real_table('ledgers')),
                    '会计科目' => $db->count(real_table('account_subjects')),
                    '凭证' => $db->count(real_table('vouchers')),
                    '凭证模板' => $db->count(real_table('voucher_templates')),
                    '凭证字' => $db->count(real_table('voucher_types')),
                    '币别' => $db->count(real_table('currencies')),
                    '固定资产类别' => $db->count(real_table('asset_categories')),
                ],
                'accountTypes' => $accountTypes,
                'tables' => [
                    ['name' => 'account_subjects', 'title' => '会计科目'],
                    ['name' => 'voucher_templates', 'title' => '凭证模板'],
                    ['name' => 'balance_sheet_formula', 'title' => '资产负债表公式'],
                    ['name' => 'income_statement_formula', 'title' => '利润表公式'],
                    ['name' => 'cashflow_formula', 'title' => '现金流量表公式'],
                ],
                'modules' => module_payload($db),
            ]);
            break;

        case '/api/modules':
            json_response(['items' => module_payload($db)]);
            break;

        case '/api/table':
            $alias = (string)($_GET['name'] ?? '');
            $table = real_table($alias);
            if (!preg_match('/^[a-z0-9_]+$/', $alias) || !$table || !$db->tableExists($table)) {
                json_response(['error' => 'bad table'], 400);
                break;
            }
            $limit = (int)($_GET['limit'] ?? 100);
            $q = trim((string)($_GET['q'] ?? ''));
            json_response([
                'name' => $alias,
                'count' => $db->count($table),
                'columns' => $db->columns($table),
                'items' => $db->tableRows($table, $limit, $q),
            ]);
            break;

        case '/api/accounts':
            $q = trim((string)($_GET['q'] ?? ''));
            $type = trim((string)($_GET['type'] ?? ''));
            $where = 'WHERE kjzt_id=?';
            $params = [$ztId];
            if ($type !== '') {
                $where .= ' AND km_type=?';
                $params[] = $type;
            }
            if ($q !== '') {
                $where .= ' AND (iden LIKE ? OR name LIKE ? OR long_name LIKE ?)';
                $like = '%' . $q . '%';
                array_push($params, $like, $like, $like);
            }
            $rows = $db->all(
                'SELECT id, iden, name, long_name, km_type, balance_direct, disabled, qichu_amount, bennian_jie_amount, bennian_dai_amount
                 FROM `' . real_table('account_subjects') . "` $where ORDER BY iden LIMIT 500",
                $params
            );
            json_response(['items' => $rows]);
            break;

        case '/api/templates':
            $rows = $db->all(
                'SELECT id, name, type, sort_index, detail_json FROM `' . real_table('voucher_templates') . '` WHERE kjzt_id=? ORDER BY sort_index, id',
                [$ztId]
            );
            foreach ($rows as &$row) {
                $row['detail'] = decode_json_field($row['detail_json']);
                unset($row['detail_json']);
            }
            json_response(['items' => $rows]);
            break;

        case '/api/voucher-types':
            json_response([
                'items' => $db->all(
                    'SELECT se_num, name_short, name_long, enabled, is_default FROM `' . real_table('voucher_types') . '` WHERE kjzt_id=? ORDER BY se_num',
                    [$ztId]
                ),
            ]);
            break;

        case '/api/reports':
            $items = [];
            foreach ([
                ['资产负债表', 'balance_sheet_formula', 'data_json'],
                ['利润表', 'income_statement_formula', 'data_json'],
                ['现金流量表', 'cashflow_formula', 'data_json'],
            ] as [$title, $alias, $field]) {
                $table = real_table($alias);
                $rows = $db->all("SELECT id, last_modified_datetime, $field FROM `$table` WHERE kjzt_id=? ORDER BY id", [$ztId]);
                foreach ($rows as $row) {
                    $data = decode_json_field($row[$field]);
                    $items[] = [
                        'title' => $title,
                        'id' => $row['id'],
                        'last_modified_datetime' => $row['last_modified_datetime'] ?? null,
                        'formula_rows' => is_array($data) ? count($data) : 0,
                        'sample' => is_array($data) ? array_slice($data, 0, 5, true) : $data,
                    ];
                }
            }
            json_response(['items' => $items]);
            break;

        case '/api/basic':
            json_response([
                'currency' => $db->all('SELECT code, name, b_sign, conv_method, enabled, exc_rate_type FROM `' . real_table('currencies') . '` WHERE kjzt_id=? ORDER BY code', [$ztId]),
                'assetTypes' => $db->all('SELECT * FROM `' . real_table('asset_categories') . '` WHERE kjzt_id=? ORDER BY id LIMIT 100', [$ztId]),
                'journalTypes' => $db->all('SELECT * FROM `' . real_table('journal_categories') . '` WHERE kjzt_id=? ORDER BY id LIMIT 100', [$ztId]),
                'units' => $db->all('SELECT * FROM `' . real_table('units') . '` WHERE kjzt_id=? ORDER BY id LIMIT 100', [$ztId]),
            ]);
            break;

        default:
            json_response(['error' => 'not found'], 404);
    }
} catch (Throwable $e) {
    json_response(['error' => $e->getMessage()], 500);
}
