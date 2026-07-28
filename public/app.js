const state = {
  summary: null,
  modules: [],
  activeModule: "home",
  tabs: [{ title: "首页", type: "home", key: "home" }],
  activeTab: "home",
};
let currentTable = "";

const menu = [
  { key: "home", title: "首页", icon: "⌂", table: "ledgers", items: [] },
  {
    key: "voucher", title: "凭证", icon: "▤", items: [
      { title: "新增凭证", table: "vouchers" },
      { title: "凭证回收站", table: "recycle_bin" },
      { title: "查看凭证", table: "vouchers" },
      { title: "凭证汇总表", table: "vouchers_item" },
      { title: "凭证附件中心", badge: "New", table: "files" },
    ],
  },
  {
    key: "books", title: "账簿", icon: "￥", items: [
      { title: "总账", table: "account_subjects" },
      { title: "科目辅助明细账", table: "subject_aux_opening" },
      { title: "明细账", table: "journal_items" },
      { title: "科目辅助余额表", table: "aux_type_data" },
      { title: "余额表", table: "account_subjects" },
      { title: "辅助核算明细账", table: "aux_type_data" },
      { title: "序时账", table: "vouchers_item" },
      { title: "辅助核算余额表", table: "aux_types" },
      { title: "多栏账", table: "account_subjects" },
    ],
  },
  {
    key: "reports", title: "报表", icon: "▥", items: [
      { title: "资产负债表", table: "balance_sheet_formula" },
      { title: "经营状况表", table: "operation_formula" },
      { title: "利润表", table: "income_statement_formula" },
      { title: "应收统计表", table: "receivable_formula" },
      { title: "项目利润表", badge: "New", table: "income_statement_formula" },
      { title: "应付统计表", table: "payable_formula" },
      { title: "利润表季报", table: "income_statement_formula" },
      { title: "其他应收统计表", table: "receivable_formula" },
      { title: "现金流量表", table: "cashflow_formula" },
      { title: "其他应付统计表", table: "payable_formula" },
      { title: "现金流量表季报", table: "cashflow_formula" },
      { title: "应收账龄表", table: "invoices" },
      { title: "费用统计表", table: "income_statement_formula" },
    ],
  },
  {
    key: "assets", title: "资产", icon: "▧", items: [
      { title: "资产卡片", table: "asset_cards" },
      { title: "资产折旧统计表", table: "asset_depreciations" },
      { title: "资产类别", table: "asset_categories" },
      { title: "资产明细账", table: "asset_depreciation_items" },
    ],
  },
  {
    key: "salary", title: "工资", icon: "♙", items: [
      { title: "工资表", table: "salary_sheets" },
      { title: "专项附加扣除", table: "salary_deductions" },
      { title: "工资统计报表", table: "salary_people" },
      { title: "凭证配置", table: "salary_voucher_templates" },
      { title: "部门员工基本信息", badge: "New", table: "salary_people" },
    ],
  },
  { key: "invoice", title: "发票管理", icon: "▥", items: [{ title: "发票", table: "invoices" }] },
  {
    key: "fund", title: "资金管理", icon: "▤", items: [
      { title: "日记账", table: "journals" },
      { title: "资金分析", table: "journal_items" },
      { title: "收支汇总表", badge: "New", table: "journal_categories" },
    ],
  },
  {
    key: "closing", title: "结账", icon: "▿", items: [
      { title: "期末结转", table: "closing_settings" },
      { title: "结账", table: "closing_custom" },
    ],
  },
  {
    key: "tax", title: "税务", icon: "☷", items: [
      { title: "智能报税", badge: "Hot", table: "tax_declarations" },
      { title: "税费计算表", badge: "Beta", table: "tax_declarations" },
      { title: "纳税统计表", badge: "Beta", table: "tax_declarations" },
      { title: "税务指标", badge: "Beta", table: "tax_metrics" },
      { title: "税务信息", badge: "Beta", table: "tax_declarations" },
    ],
  },
  {
    key: "analysis", title: "账务分析", icon: "⌞", items: [
      { title: "偿债能力分析", badge: "Beta", table: "balance_sheet_formula" },
      { title: "运营能力分析", badge: "Beta", table: "operation_formula" },
      { title: "盈利能力分析", badge: "Beta", table: "income_statement_formula" },
      { title: "发展能力分析", badge: "Beta", table: "cashflow_formula" },
    ],
  },
  {
    key: "settings", title: "设置", icon: "⚙", items: [
      { title: "科目期初", table: "journal_items" },
      { title: "账套管理", table: "ledgers" },
      { title: "辅助核算", table: "aux_types" },
      { title: "财税设置", table: "closing_settings" },
      { title: "计量单位", table: "units" },
      { title: "备份恢复", table: "backup_files" },
      { title: "币种设置", table: "currencies" },
      { title: "旧账导入", badge: "New", table: "import_packages" },
      { title: "凭证类型", table: "vouchers_type" },
      { title: "归档管理", table: "archive_index" },
      { title: "凭证配置", table: "voucher_settings" },
      { title: "现金流量科目对照", table: "cashflow_formula" },
    ],
  },
  {
    key: "guide", title: "使用指南", icon: "▦", items: [
      { title: "快速上手", table: "guide_logs" },
      { title: "快速记账", badge: "New", table: "vouchers_template" },
      { title: "旧账导入", badge: "New", table: "import_packages" },
    ],
  },
];

const quickFlow = [
  ["快速上手", "guide_logs", "video"],
  ["旧账导入", "import_packages", "import"],
  ["科目期初", "journal_items", "list"],
  ["日记账", "journals", "wallet"],
  ["录入凭证", "vouchers", "plus"],
  ["期末结账", "closing_settings", "close"],
  ["审核凭证", "vouchers", "pin"],
  ["结账检查", "closing_custom", "check"],
  ["税额申报", "tax_declarations", "chart"],
];

const commonItems = [
  ["资产负债表", "balance_sheet_formula", "pie"],
  ["利润表", "income_statement_formula", "line"],
  ["现金流量表", "cashflow_formula", "cards"],
  ["余额表", "account_subjects", "brief"],
  ["明细账", "journal_items", "blocks"],
  ["辅助核算余额表", "aux_type_data", "box"],
];

async function api(path) {
  const res = await fetch(path);
  const data = await res.json();
  if (!res.ok) throw new Error(data.error || "request failed");
  return data;
}

function money(value) {
  return Number(value || 0).toLocaleString("zh-CN", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function periodFromSummary() {
  const date = state.summary?.zt?.account_date || "2026-07-01";
  return date.slice(0, 7);
}

function table(el, columns, rows) {
  if (!el) return;
  const head = `<thead><tr>${columns.map(col => `<th>${col.label}</th>`).join("")}</tr></thead>`;
  const body = rows.map(row => `<tr>${columns.map(col => {
    const raw = typeof col.value === "function" ? col.value(row) : row[col.key];
    return `<td class="${col.num ? "num" : ""}">${raw ?? ""}</td>`;
  }).join("")}</tr>`).join("");
  el.innerHTML = `${head}<tbody>${body || `<tr><td colspan="${columns.length}" class="muted">暂无数据</td></tr>`}</tbody>`;
}

function cellValue(value) {
  if (value === null || value === undefined) return "";
  if (typeof value === "object") return JSON.stringify(value);
  const text = String(value);
  return text.length > 180 ? `${text.slice(0, 180)}...` : text;
}

function moduleInfo(key) {
  return state.modules.find(item => item.key === key) || { key, title: menu.find(m => m.key === key)?.title || key, path: "", total: 0, tables: [] };
}

function setActiveNav(key) {
  state.activeModule = key;
  document.querySelectorAll(".nav").forEach(el => el.classList.toggle("active", el.dataset.module === key));
}

function setView(view) {
  document.querySelectorAll(".view").forEach(el => el.classList.remove("active"));
  document.getElementById(view).classList.add("active");
}

function renderVoucherEntry() {
  const period = periodFromSummary();
  document.getElementById("voucherDate").value = `${period}-28`;
  const moneyUnits = ["百", "十", "亿", "千", "百", "十", "万", "千", "百", "十", "元", "角", "分"];
  const sideUnits = ["百", "十", "亿", "千", "百", "十", "万", "千", "百", "十", "元"];
  document.getElementById("moneyHeader").innerHTML = [...sideUnits, ...sideUnits].map((unit, index) => `
    <th class="${index === 10 || index === 21 ? "red-line" : ""}">${unit}</th>
  `).join("");
  document.getElementById("voucherRows").innerHTML = Array.from({ length: 5 }, (_, rowIndex) => `
    <tr>
      <td class="row-no">${rowIndex + 1}</td>
      <td class="summary-cell" contenteditable="${rowIndex === 0 ? "true" : "false"}">${rowIndex === 0 ? "" : ""}</td>
      <td class="subject-cell" contenteditable="true"></td>
      ${Array.from({ length: 22 }, (_, colIndex) => `<td class="money-cell ${colIndex === 10 || colIndex === 21 ? "red-line" : ""}"></td>`).join("")}
    </tr>
  `).join("");
  const firstCell = document.querySelector(".summary-cell");
  if (firstCell) firstCell.classList.add("editing");
}

function renderNav() {
  document.getElementById("primaryNav").innerHTML = menu.map(item => `
    <button class="nav ${item.key === "home" ? "active" : ""}" data-module="${item.key}">
      <span class="nav-icon">${item.icon}</span>
      <span>${item.title}</span>
    </button>
  `).join("");
}

function renderTabs() {
  document.getElementById("tabStrip").innerHTML = state.tabs.map(tab => `
    <button class="tab ${state.activeTab === tab.key ? "active" : ""}" data-tab-key="${tab.key}">
      <span>${tab.title}</span>
      ${tab.type === "home" ? "" : `<b data-close-tab="${tab.key}">×</b>`}
    </button>
  `).join("") + `<button class="tab-tools">↻</button><button class="tab-tools">×</button>`;
}

function addTab(tab) {
  if (!state.tabs.some(item => item.key === tab.key)) {
    state.tabs.push(tab);
  }
  state.activeTab = tab.key;
  renderTabs();
}

function activateHomeTab() {
  state.activeTab = "home";
  renderTabs();
}

function actionIcon(kind) {
  const labels = { video: "▶", import: "▣", list: "▤", wallet: "▰", plus: "＋", close: "▧", pin: "⌘", check: "✓", chart: "▟", pie: "◔", line: "↗", cards: "▰", brief: "▣", blocks: "▦", box: "▥" };
  return labels[kind] || "·";
}

function renderActionGrid(el, items, flow = false) {
  el.innerHTML = items.map(([title, tableName, icon], index) => `
    <button class="action-item" data-table="${tableName}">
      <span class="action-icon ${icon}">${actionIcon(icon)}</span>
      <span>${title}</span>
    </button>
    ${flow && index < items.length - 1 ? `<i class="flow-arrow">›</i>` : ""}
  `).join("");
}

function renderDashboard() {
  const { zt, metrics, accountTypes } = state.summary;
  const period = periodFromSummary();
  document.getElementById("topAccountName").textContent = zt?.name || "111";
  document.getElementById("topPeriod").textContent = period;
  document.getElementById("balancePeriod").textContent = period;
  document.getElementById("voucherMonth").textContent = period;
  document.getElementById("expensePeriod").textContent = period;
  document.getElementById("voucherTotal").textContent = metrics?.凭证 || 0;
  renderActionGrid(document.getElementById("quickFlow"), quickFlow, true);
  renderActionGrid(document.getElementById("commonGrid"), commonItems);
}

function renderSubmenu(moduleKey) {
  const item = menu.find(m => m.key === moduleKey);
  return (item?.items || []).map(sub => `
    <button class="sub-item" data-sub-table="${sub.table || ""}" data-sub-title="${sub.title}">
      <span>${sub.title}</span>
      ${sub.badge ? `<b class="badge">${sub.badge}</b>` : ""}
    </button>
  `).join("");
}

function renderModuleCard(module) {
  return `
    <article class="module-card">
      <div class="module-head">
        <h3>${module.title}</h3>
        <strong>${module.total}</strong>
      </div>
      <div class="table-links">
        ${module.tables.map(t => `
          <button data-table="${t.name}">
            <span>${t.name}</span>
            <b>${t.count}</b>
          </button>
        `).join("")}
      </div>
    </article>
  `;
}

async function loadModuleView(key, subTitle = "") {
  const module = moduleInfo(key);
  setView("module");
  setActiveNav(key);
  document.getElementById("moduleSummary").innerHTML = `
    <strong>${subTitle || module.title}</strong>
    <span>${module.tables.length} 张表</span>
    <span>${module.total} 条记录</span>
    ${module.path ? `<span>源码目录：${module.path}</span>` : ""}
  `;
  document.getElementById("moduleTablesTitle").textContent = `${module.title}数据表`;
  document.getElementById("modulePath").textContent = module.path || "";
  document.getElementById("submenuGrid").innerHTML = renderSubmenu(key);
  document.getElementById("activeModuleGrid").innerHTML = renderModuleCard(module);
}

async function openTable(name) {
  if (!name) return;
  currentTable = name;
  setView("module");
  const q = document.getElementById("tableSearch").value.trim();
  const data = await api(`/api/table?name=${encodeURIComponent(name)}&q=${encodeURIComponent(q)}&limit=120`);
  document.getElementById("tableTitle").textContent = name;
  document.getElementById("tableMeta").textContent = `${data.count} 条记录 · ${data.columns.length} 个字段`;
  const columns = data.columns.slice(0, 14).map(col => ({ label: col.column_name, value: row => cellValue(row[col.column_name]) }));
  table(document.getElementById("genericTable"), columns.length ? columns : [{ label: "数据", value: () => "" }], data.items);
}

async function openFeature(title, tableName, moduleKey = state.activeModule) {
  if (title === "新增凭证") {
    addTab({ title, type: "voucherEntry", key: "voucher:new", module: "voucher" });
    setActiveNav("voucher");
    setView("voucherEntry");
    renderVoucherEntry();
    document.getElementById("flyout").classList.add("hidden");
    return;
  }
  addTab({ title, type: "table", key: `table:${tableName}:${title}`, table: tableName, module: moduleKey });
  await loadModuleView(moduleKey, title);
  await openTable(tableName);
}

function showFlyout(moduleKey, navButton) {
  const item = menu.find(m => m.key === moduleKey);
  const flyout = document.getElementById("flyout");
  if (!item || !item.items.length) {
    flyout.classList.add("hidden");
    return;
  }
  const rect = navButton.getBoundingClientRect();
  flyout.style.top = `${Math.max(28, rect.top)}px`;
  flyout.innerHTML = `<div class="flyout-grid">${renderSubmenu(moduleKey)}</div>`;
  flyout.classList.remove("hidden");
}

function bind() {
  const nav = document.getElementById("primaryNav");
  nav.addEventListener("click", async event => {
    const btn = event.target.closest(".nav");
    if (!btn) return;
    const key = btn.dataset.module;
    if (key === "home") {
      setView("dashboard");
      setActiveNav("home");
      activateHomeTab();
      renderDashboard();
      document.getElementById("flyout").classList.add("hidden");
      return;
    }
    await loadModuleView(key);
    showFlyout(key, btn);
  });
  nav.addEventListener("mouseover", event => {
    const btn = event.target.closest(".nav");
    if (btn) showFlyout(btn.dataset.module, btn);
  });

  document.body.addEventListener("click", async event => {
    const close = event.target.closest("[data-close-tab]");
    if (close) {
      event.stopPropagation();
      const key = close.dataset.closeTab;
      state.tabs = state.tabs.filter(tab => tab.key !== key);
      if (state.activeTab === key) {
        state.activeTab = "home";
        setView("dashboard");
        setActiveNav("home");
        renderDashboard();
      }
      renderTabs();
      return;
    }
    const tabBtn = event.target.closest("[data-tab-key]");
    if (tabBtn) {
      const tab = state.tabs.find(item => item.key === tabBtn.dataset.tabKey);
      if (!tab) return;
      state.activeTab = tab.key;
      renderTabs();
      if (tab.type === "home") {
        setView("dashboard");
        setActiveNav("home");
        renderDashboard();
      } else if (tab.type === "voucherEntry") {
        setView("voucherEntry");
        setActiveNav("voucher");
        renderVoucherEntry();
      } else {
        await loadModuleView(tab.module, tab.title);
        await openTable(tab.table);
      }
      return;
    }
    const sub = event.target.closest("[data-sub-table]");
    if (sub) {
      const active = state.activeModule;
      await openFeature(sub.dataset.subTitle, sub.dataset.subTable, active);
      return;
    }
    const tableBtn = event.target.closest("[data-table]");
    if (tableBtn) {
      const title = tableBtn.dataset.title || tableBtn.textContent.trim().replace(/^＋\s*/, "") || tableBtn.dataset.table;
      await openFeature(title, tableBtn.dataset.table, state.activeModule);
    }
  });

  document.getElementById("tableSearchBtn").addEventListener("click", async () => {
    if (currentTable) await openTable(currentTable);
  });
  document.getElementById("tableSearch").addEventListener("keydown", async event => {
    if (event.key === "Enter" && currentTable) await openTable(currentTable);
  });
}

async function init() {
  renderNav();
  renderTabs();
  state.summary = await api("/api/summary");
  state.modules = state.summary.modules || (await api("/api/modules")).items;
  renderDashboard();
  bind();
}

init().catch(err => {
  document.body.innerHTML = `<pre style="padding:20px;color:#b91c1c">${err.stack || err}</pre>`;
});
