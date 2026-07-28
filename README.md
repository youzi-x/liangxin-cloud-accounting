# 良心云会计本地财务系统

良心云会计是一个本地财务系统半成品源码，主要用于个人学习、功能参考、界面研究和二次开发。当前项目不是完整可交付的商业成品，很多业务流程、保存逻辑、报表取数、权限体系和异常处理仍需要使用者自行补全。

需要使用的开发者可以基于现有源码继续二开，按自己的业务场景补齐数据库、接口、凭证处理、账簿报表、资产工资、发票资金等模块。

## 当前状态

- 这是一个半成品源码工程。
- 已搭建本地 Web 运行框架。
- 已还原一部分财务系统界面和菜单结构。
- 已实现首页工作台、动态页签、模块菜单、数据浏览和新增凭证界面原型。
- 多数核心业务能力仍处于待开发状态，需要自行二次开发后使用。
- 不包含正式生产环境部署方案，不包含完整权限、安全审计、数据校验和财税规则闭环。

## 适合人群

- 想学习本地财务系统结构的开发者。
- 想基于现有界面继续二次开发的个人或团队。
- 想快速搭建财务系统原型、再按业务需求改造的人。
- 有 PHP、JavaScript、MySQL 基础，能自行补全业务逻辑的人。

## 功能概览

- 首页工作台：账套、账期、快捷入口、常用功能、凭证统计、余额详情、费用统计和经营状态入口。
- 动态页签：默认只显示首页，打开菜单或快捷入口后再新增页签。
- 菜单模块：首页、凭证、账簿、报表、资产、工资、发票管理、资金管理、结账、税务、账务分析、设置、使用指南。
- 二级菜单：覆盖新增凭证、查看凭证、总账、余额表、资产负债表、工资表、发票、日记账、期末结转、智能报税、科目期初等入口。
- 新增凭证页：已实现记账凭证界面原型，包含凭证头、分录表格、借贷金额栏、合计区和底部操作按钮。
- 数据浏览：通过公开别名查看本地 MySQL 表结构和记录，方便二次开发时定位业务数据。

## 尚未完成

- 凭证新增、编辑、审核、反审核、删除、回收站、附件上传等完整流程。
- 科目选择、辅助核算、借贷平衡校验、凭证字号生成和保存草稿。
- 总账、明细账、余额表、序时账、多栏账等真实账簿计算。
- 资产负债表、利润表、现金流量表等报表真实取数和公式计算。
- 固定资产、工资、发票、资金管理、税务申报等完整业务闭环。
- 用户、角色、权限、日志、备份恢复、导入导出等生产级能力。
- 安装程序、部署脚本、升级脚本和正式运维方案。

## 技术栈

- 前端：HTML / CSS / JavaScript
- 后端：PHP 8 内置 Web Server
- 数据库：MySQL 5.7 兼容数据源
- 运行环境：Windows + PowerShell

## 目录结构

```text
_finance_local/
├─ public/
│  ├─ index.html      # 页面入口
│  ├─ app.js          # 菜单、页签、首页、凭证页和表浏览逻辑
│  └─ styles.css      # UI 样式
├─ src/
│  ├─ api.php         # 本地 API 路由
│  └─ db.php          # MySQL 连接、端口探测、查询封装
├─ router.php         # PHP 内置服务路由
├─ start.ps1          # 启动 Web 服务和数据库
├─ start-mysql.ps1    # 单独启动/检测 MySQL
├─ stop.ps1           # 停止本地 Web 服务
└─ README.md
```

## 快速启动

在项目根目录执行：

```powershell
.\_finance_local\start.ps1
```

启动后访问：

```text
http://127.0.0.1:8788/
```

停止本地 Web 服务：

```powershell
.\_finance_local\stop.ps1
```

## 数据源配置

默认读取本地兼容数据源，也可以通过环境变量覆盖：

```powershell
$env:FINANCE_DB_HOST = "127.0.0.66"
$env:FINANCE_DB_PORT = "2000"
$env:FINANCE_DB_NAME = "finance_local"
$env:FINANCE_DB_USER = "root"
$env:FINANCE_DB_PASS = "password"
$env:FINANCE_LEDGER_ID = "100"
```

如果未指定端口，系统会自动探测 `2000-2010`。

## 公开数据别名

前端和 API 使用业务别名访问数据：

- `ledgers`：账套
- `account_subjects`：会计科目
- `vouchers`：凭证主数据
- `voucher_items`：凭证明细
- `voucher_templates`：凭证模板
- `balance_sheet_formula`：资产负债表公式
- `income_statement_formula`：利润表公式
- `cashflow_formula`：现金流量表公式
- `asset_cards`：资产卡片
- `salary_sheets`：工资表
- `invoices`：发票
- `journals`：资金流水/日记账

## API 简介

```text
GET /api/summary
GET /api/modules
GET /api/table?name=account_subjects
GET /api/accounts?q=现金
GET /api/templates
GET /api/reports
GET /api/basic
```

## 二次开发建议

1. 先确认本地数据库结构和账套数据是否可用。
2. 按模块优先级补齐保存接口和数据校验。
3. 先完成凭证模块，再做账簿和报表计算。
4. 生产使用前自行补齐权限、日志、备份、安全校验和异常处理。
5. 根据自己的财税规则和业务场景调整科目、公式、凭证模板和报表逻辑。

## 开源上传建议

建议只提交当前本地二开源码目录和必要说明文件：

```text
_finance_local/
README.md
.gitignore
LICENSE
```

建议不要提交以下内容：

- 原始商业程序、打包可执行文件、DLL、运行时目录。
- 私有数据库数据目录、账套数据、用户信息、备份文件。
- 审计临时目录、还原源码目录、日志文件。
- 包含第三方服务地址、授权信息、密码或客户数据的文件。

## 推荐 `.gitignore`

```gitignore
server.out.log
server.err.log
*.log
*.pid
data/
bin/
node_modules/
vendor/
.env
.env.*
_audit_restored/
_audit_tmp/
_local_preview/
```

## 许可

本项目使用 MIT License。生产或商业使用前，请自行确认代码、数据、素材和业务规则的授权与合规性。
