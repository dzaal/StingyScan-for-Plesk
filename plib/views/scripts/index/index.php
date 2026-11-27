<style>
/* VirusTotal Dashboard — inline styles (Plesk wraps this in its layout) */
#vt-wrap *{box-sizing:border-box}
#vt-wrap{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;font-size:14px;color:#1a1d23}
#vt-wrap :root,#vt-wrap{
  --bg:#f4f5f7;--surface:#fff;--border:#dde1e7;
  --text:#1a1d23;--muted:#6b7280;--heading:#111827;
  --red:#dc2626;--red-bg:#fef2f2;--red-border:#fca5a5;
  --green:#16a34a;--green-bg:#f0fdf4;--green-border:#86efac;
  --yellow:#d97706;--yellow-bg:#fffbeb;--yellow-border:#fcd34d;
  --blue:#2563eb;--blue-bg:#eff6ff;--blue-border:#93c5fd;
  --gray:#6b7280;--gray-bg:#f9fafb;
  --radius:8px;
}

/* Our branded header replaces Plesk's page header (breadcrumb + title); only on this page */
body:has(#vt-wrap) .pul-page-header.page-content-header{display:none}
#vt-wrap{padding-top:8px}

/* About */
.vt-update-banner{display:none;align-items:center;gap:10px;padding:9px 16px;margin-bottom:12px;border-radius:var(--radius);background:#fefce8;border:1px solid #fde047;font-size:13px;color:#713f12}
.vt-update-banner a{color:#92400e;font-weight:700;text-decoration:none;border-bottom:1px solid #d97706}
.vt-update-banner a:hover{color:#78350f}
.vt-update-icon{font-size:16px;flex-shrink:0}
.vt-update-btn{margin-left:4px;padding:4px 12px;border-radius:5px;border:none;background:#d97706;color:#fff;font-size:12px;font-weight:700;cursor:pointer}
.vt-update-btn:hover{background:#b45309}
.vt-update-btn:disabled{opacity:.6;cursor:not-allowed}
.vt-about{max-width:760px}
.vt-about .vt-card{max-width:none}
.vt-about p{font-size:13px;line-height:1.6;color:var(--text);margin:10px 0}
.vt-about-hero{display:flex;gap:18px;align-items:flex-start}
.vt-about-logo{flex-shrink:0;width:64px;height:64px}
.vt-about-mark{width:64px;height:64px;flex-shrink:0;border-radius:16px;background:linear-gradient(135deg,#b91c1c,#7f1d1d);color:#fff;font-weight:800;font-size:22px;display:flex;align-items:center;justify-content:center;letter-spacing:1px}
.vt-about-sub{font-size:13px;color:var(--muted)}
.vt-about-sub a{color:#b91c1c;font-weight:600;text-decoration:none}
.vt-about-list{margin:6px 0 0;padding-left:18px;font-size:13px;line-height:1.6}
.vt-about-list li{margin-bottom:6px}
.vt-coffee{display:flex;align-items:center;gap:16px;background:linear-gradient(135deg,#fffbeb,#fff 70%);border-color:#fde68a}
.vt-coffee-cup{font-size:34px;line-height:1}
.vt-paypal{flex-shrink:0;display:inline-flex;align-items:center;gap:8px;padding:10px 18px;border-radius:24px;background:#ffc439;color:#111827;font-weight:700;font-size:13px;text-decoration:none;box-shadow:0 1px 2px rgba(0,0,0,.15)}
.vt-paypal:hover{background:#f2b52e;color:#111827}
.vt-paypal-pp{font-style:italic;font-weight:800;color:#003087}.vt-paypal-pp b{color:#009cde}
@media (max-width:640px){.vt-about-hero,.vt-coffee{flex-direction:column;align-items:flex-start}}

/* Brand header */
.vt-brand{display:flex;align-items:center;gap:14px;padding:14px 18px;margin-bottom:14px;border-radius:var(--radius);background:linear-gradient(135deg,#eff6ff 0%,#fff 60%);border:1px solid #dbe5f5}
.vt-brand-logo{width:48px;height:48px;flex-shrink:0;filter:drop-shadow(0 2px 4px rgba(37,99,235,.25))}
.vt-brand-text{flex:1;min-width:0}
.vt-brand-name{font-size:16px;font-weight:700;color:var(--heading);line-height:1.3}
.vt-brand-ver{font-size:11px;font-weight:600;color:var(--blue);background:#dbeafe;border-radius:10px;padding:1px 7px;vertical-align:2px;margin-left:4px}
.vt-brand-tag{font-size:12px;color:var(--muted);margin-top:2px}
.vt-brand-by{flex-shrink:0;font-size:12px;color:var(--muted);text-decoration:none;padding:6px 12px;border:1px solid var(--border);border-radius:20px;background:#fff}
.vt-brand-by strong{color:#b91c1c;font-weight:700;letter-spacing:.2px}
.vt-brand-by:hover{border-color:#b91c1c}
@media (max-width:640px){.vt-brand-tag{display:none}}

/* Tabs */
.vt-tabs{display:flex;border-bottom:2px solid var(--border);margin-bottom:16px}
.vt-tab{padding:10px 18px;font-size:13px;font-weight:500;color:var(--muted);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px}
.vt-tab:hover{color:var(--text)}
.vt-tab.active{color:var(--blue);border-bottom-color:var(--blue);font-weight:600}

.vt-panel{display:none}.vt-panel.active{display:block}

/* Alert */
.vt-alert{padding:12px 16px;border-radius:var(--radius);font-size:13px;margin-bottom:14px;display:flex;align-items:center;gap:8px}
.vt-alert.warn{background:var(--yellow-bg);border:1px solid var(--yellow-border);color:#92400e}
.vt-alert a{font-weight:600;color:inherit;text-decoration:underline;cursor:pointer}

/* Budget strip */
.vt-budget{display:flex;align-items:center;gap:24px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);margin-bottom:14px;padding:10px 20px}
.vt-bc-cell{display:flex;flex-direction:column;align-items:center;gap:1px}
.vt-bc-wrap{position:relative;width:72px;height:72px}
.vt-bc-svg{width:72px;height:72px;transform:rotate(-90deg)}
.vt-bc-track{fill:none;stroke:var(--border);stroke-width:8}
.vt-bc-arc{fill:none;stroke-width:8;stroke-linecap:butt;stroke-dasharray:0 100;transition:stroke-dasharray .5s}
.vt-bc-arc.auto{stroke:#2563eb}
.vt-bc-arc.manual{stroke:#16a34a}
.vt-bc-arc.quota{stroke:#d97706}
.vt-bc-mid{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:800;color:var(--heading)}
.vt-bc-name{font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-top:3px}
.vt-bc-sub{font-size:10px;color:var(--muted)}
.vt-bc-sep{width:1px;height:72px;background:var(--border);align-self:center}
.vt-bc-meta{flex:1;padding-left:4px;font-size:12px;color:var(--muted);display:flex;flex-direction:column;gap:4px}
.vt-bc-meta strong{color:var(--heading);font-weight:700}
.vt-bc-mlbl{font-size:10px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;margin-right:3px}
.vt-b-fill{height:100%;background:var(--green);border-radius:2px;transition:width .4s}
.vt-b-fill.warn{background:var(--yellow)}.vt-b-fill.crit{background:var(--red)}

/* Toolbar */
.vt-toolbar{display:flex;align-items:center;gap:8px;margin-bottom:10px;flex-wrap:wrap}
.vt-search{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:6px 11px;color:var(--text);font-size:13px;width:190px;outline:none}
.vt-search:focus{border-color:var(--blue)}
.vt-filters{display:flex;gap:4px;flex-wrap:wrap}
.vt-fbtn{padding:4px 10px;border-radius:20px;border:1px solid var(--border);background:var(--surface);font-size:12px;font-weight:500;cursor:pointer;color:var(--muted);display:flex;align-items:center;gap:4px}
.vt-fbtn:hover{border-color:var(--blue);color:var(--blue)}
.vt-fbtn.active{background:var(--blue);border-color:var(--blue);color:#fff}
/* Category button + arrow menu */
.vt-fgroup{position:relative;display:inline-flex}
.vt-fgroup .vt-fbtn{border-top-right-radius:0;border-bottom-right-radius:0;border-right:none}
.vt-fcaret{padding:0 7px;border:1px solid var(--border);border-left:1px solid var(--border);border-radius:0 20px 20px 0;background:var(--surface);color:var(--muted);font-size:10px;cursor:pointer}
.vt-fcaret:hover{color:var(--blue);border-color:var(--blue)}
.vt-fgroup .vt-fbtn.active+.vt-fcaret{background:var(--blue);border-color:var(--blue);color:#fff;border-left-color:rgba(255,255,255,.4)}
.vt-fmenu{display:none;position:absolute;top:calc(100% + 4px);left:0;min-width:170px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 6px 18px rgba(0,0,0,.12);padding:4px;z-index:50}
.vt-fmenu.open{display:block}
.vt-fmenu button{display:block;width:100%;text-align:left;padding:7px 10px;border:none;background:none;border-radius:5px;font-size:13px;color:var(--text);cursor:pointer}
.vt-fmenu button:hover{background:var(--blue-bg);color:var(--blue)}
.vt-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0;display:inline-block}
.dot-r{background:var(--red);box-shadow:0 0 0 2px #fca5a5}
.dot-y{background:#f59e0b;box-shadow:0 0 0 2px #fde68a}
.dot-g{background:var(--green);box-shadow:0 0 0 2px #86efac}
.dot-b{background:var(--blue)}.dot-gr{background:var(--gray)}
@keyframes vt-pulse{0%,100%{opacity:1}50%{opacity:.4}}
.dot-r{animation:vt-pulse 1.4s ease-in-out infinite}
.vt-spacer{flex:1}
.vt-btn{padding:6px 12px;border-radius:var(--radius);border:1px solid transparent;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:4px}
.vt-btn:disabled{opacity:.4;cursor:not-allowed}
.vt-btn.primary{background:var(--blue);color:#fff;border-color:var(--blue)}
.vt-btn.primary:hover:not(:disabled){background:#1d4ed8}
.vt-btn.ghost{background:var(--surface);color:var(--muted);border-color:var(--border)}
.vt-btn.ghost:hover:not(:disabled){color:var(--text)}
.vt-btn.danger{background:var(--red-bg);color:var(--red);border-color:var(--red-border)}
.vt-status-txt{font-size:12px;color:var(--muted)}

/* Progress */
.vt-prog-wrap{height:2px;background:var(--border);margin-bottom:1px}
.vt-prog-fill{height:100%;background:var(--blue);transition:width .4s;width:0}
#vt-load-bar{padding:18px 0 12px;text-align:center}
#vt-load-bar.vt-load-done{display:none}
#vt-load-msg{font-size:13px;font-weight:600;color:var(--text);margin-bottom:8px}
.vt-load-track{height:10px;background:var(--border);border-radius:6px;overflow:hidden;margin:0 auto 6px;max-width:480px}
.vt-load-fill{height:100%;background:var(--blue);border-radius:6px;transition:width .5s ease;width:0}
#vt-load-pct{font-size:12px;color:var(--muted)}

/* Table */
.vt-tbl-wrap{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.vt-tbl-wrap table{width:100%;border-collapse:collapse}
.vt-tbl-wrap thead th{padding:9px 13px;text-align:left;font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;background:var(--gray-bg);border-bottom:1px solid var(--border);white-space:nowrap}
th.vt-sortable{cursor:pointer;user-select:none}th.vt-sortable:hover{color:var(--blue)}th.vt-sortable::after{content:"";display:inline-block;width:14px;text-align:left}th.vt-sort-asc::after{content:" ↑"}th.vt-sort-desc::after{content:" ↓"}
.vt-tbl-wrap tbody tr{border-bottom:1px solid var(--border);transition:background .1s;border-left:3px solid transparent}
.vt-tbl-wrap tbody tr:last-child{border-bottom:none}
.vt-tbl-wrap tbody tr:hover{background:#fafbfc}
.vt-tbl-wrap tbody tr[data-status=infected]{background:#fff5f5;border-left-color:var(--red)}
.vt-tbl-wrap tbody tr[data-status=infected]:hover{background:#fee2e2}
.vt-tbl-wrap tbody tr[data-status=suspicious]{background:#fffbeb;border-left-color:#f59e0b}
.vt-tbl-wrap tbody tr[data-status=suspicious]:hover{background:#fef3c7}
.vt-tbl-wrap tbody td{padding:9px 13px;vertical-align:middle}
.vt-badge{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap}
.vt-badge .vt-dot{width:7px;height:7px;border-radius:50%}
.vt-badge.infected  {background:var(--red-bg);   color:var(--red);   border:1px solid var(--red-border)}
.vt-badge.suspicious{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border)}
.vt-badge.clean     {background:var(--green-bg);  color:var(--green); border:1px solid var(--green-border)}
.vt-badge.pending   {background:var(--blue-bg);   color:var(--blue);  border:1px solid var(--blue-border)}
.vt-badge.nokey{background:#fffbeb;color:#92400e;border:1px solid #fcd34d}
.vt-badge.scanning,.vt-badge.waiting{background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-border)}
.vt-badge.loading,.vt-badge.unchecked,.vt-badge.error,.vt-badge.ratelimit,.vt-badge.quota_exceeded,.vt-badge.budget_exceeded{background:var(--gray-bg);color:var(--gray);border:1px solid var(--border)}
.vt-fs-badge{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;padding:2px 7px;border-radius:10px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);cursor:pointer;margin-top:3px;white-space:nowrap}
.vt-fs-badge:hover{background:var(--red);color:#fff}
.vt-domain-name{font-weight:600;font-size:13px;color:var(--heading)}
.vt-domain-ip{font-size:11px;color:var(--muted);margin-top:1px}
.vt-ext{display:inline-block;font-size:10px;padding:1px 5px;border-radius:4px;font-weight:600;margin-left:4px;vertical-align:middle;background:#eef1fd;color:#3346b8;border:1px solid #c5cdf3;cursor:help}
.vt-pw-add{display:flex;gap:8px;align-items:center;flex-wrap:wrap;margin:8px 0}
.vt-pw-add input{flex:0 1 320px;padding:7px 9px;border:1px solid var(--border);border-radius:5px;font:inherit;color:var(--text);background:var(--surface)}
.vt-pw-ok{color:var(--green)}
.vt-pw-bad{color:var(--red);font-weight:600}
.vt-pw-wait{color:var(--muted)}
.vt-pw-br{font-size:11px;color:var(--muted);margin-top:2px;line-height:1.5}
.vt-pw-src{display:flex;gap:14px;flex-wrap:wrap;align-items:center;margin:6px 0 10px;font-size:13px}
.vt-pw-src label{display:flex;gap:5px;align-items:center;cursor:pointer}
.vt-pw-src input[type=password]{padding:6px 8px;border:1px solid var(--border);border-radius:5px;font-family:monospace;width:280px}
.vt-fs-tbl.vt-pw-tbl td,.vt-fs-tbl.vt-pw-tbl td:last-child{white-space:normal;color:var(--text);word-break:normal;font-family:inherit}.vt-fs-tbl.vt-pw-tbl td:first-child{word-break:break-word}.vt-fs-tbl.vt-pw-tbl td.vt-fa-cell{white-space:nowrap}
.vt-pw-tbl td.site{font-weight:600;vertical-align:top;width:28%}
.vt-pw-tbl th:first-child{width:32%;min-width:260px}
.vt-pw-em.bad{color:#dc2626;font-weight:600}
.vt-pw-fixlink{font-weight:600}
.vt-pw-fixbtn{display:inline-flex;align-items:center;gap:4px;padding:2px 10px;border-radius:5px;border:1px solid #dc2626;background:#dc2626;color:#fff!important;font-size:11px;font-weight:700;cursor:pointer;text-decoration:none!important;vertical-align:1px}
.vt-pw-fixbtn:hover{background:#b91c1c;border-color:#b91c1c}
.vt-aw{border:1px solid var(--border);border-radius:var(--radius);background:var(--surface);margin:0 0 14px;padding:10px 14px}
.vt-aw.alert{border-color:#fca5a5;background:#fef2f2}
.vt-aw-top{display:flex;align-items:center;gap:10px;flex-wrap:wrap;cursor:pointer}
.vt-aw-title{font-weight:700;font-size:14px;color:var(--heading)}
.vt-aw.alert .vt-aw-title{color:#b91c1c}
.vt-aw-arrow{color:var(--muted);font-size:11px}
.vt-aw-ev{border:1px solid var(--border);border-radius:6px;background:var(--surface);padding:8px 10px;margin-top:8px;font-size:13px}
.vt-aw-ev.open{border-left:4px solid #dc2626}
.vt-aw-ev.info{opacity:.8}
.vt-aw-head{display:flex;gap:8px;align-items:baseline;flex-wrap:wrap}
.vt-aw-when{margin-left:auto;font-size:12px;color:var(--muted)}
.vt-aw-body{margin:4px 0 6px}
.vt-aw-act{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
.vt-aw-ok{color:var(--green,#16a34a);font-size:12px;font-weight:600}
.vt-aw-explain{margin-top:8px;padding-top:8px;border-top:1px dashed var(--border)}
.vt-aw-sub{font-weight:700;font-size:12px;margin:10px 0 4px;color:var(--heading)}
.vt-aw-more{margin-top:8px;font-size:12px}
.vt-fs-tbl.vt-aw-tbl td,.vt-fs-tbl.vt-aw-tbl td:last-child{white-space:normal;word-break:break-word;font-family:inherit;color:var(--text)}
/* Same address on sites of different customers: the address column has one fixed width, a long address wraps */
.vt-fs-tbl.vt-aw-cross{table-layout:fixed;width:100%}
.vt-fs-tbl.vt-aw-cross td:first-child{width:300px;overflow-wrap:anywhere}
.vt-aw-toolbar{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:12px}
.vt-aw-search{flex:1;min-width:160px;padding:5px 8px;border:1px solid var(--border);border-radius:5px;font-size:13px;background:var(--surface);color:var(--text)}
.vt-aw-summary{font-size:13px;margin-bottom:12px}
.vt-aw-domain-group{margin-bottom:16px}
.vt-aw-domain-header{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:700;padding:6px 0;border-bottom:1px solid var(--border);margin-bottom:6px}
.vt-aw-domain-header a{cursor:pointer;color:var(--heading)}
.vt-aw-domain-pend{background:#dc2626;color:#fff;border-radius:9px;font-size:11px;font-weight:700;padding:1px 6px}
.vt-tools-nav{display:flex;align-items:center;gap:4px;padding:0 0 12px;margin-bottom:16px;border-bottom:1px solid var(--border);overflow-x:auto;flex-wrap:nowrap;scrollbar-width:none}
.vt-tools-nav::-webkit-scrollbar{display:none}
.vt-tools-nav-item{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:20px;font-size:13px;font-weight:600;color:var(--muted);background:transparent;border:1px solid transparent;cursor:pointer;white-space:nowrap;text-decoration:none;transition:background .15s,color .15s}
.vt-tools-nav-item:hover{background:var(--gray-bg);color:var(--heading)}
.vt-tools-nav-item.active{background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe}
.vt-tools-nav-badge{display:inline-flex;align-items:center;justify-content:center;min-width:16px;height:16px;padding:0 4px;border-radius:8px;font-size:10px;font-weight:700;line-height:1}
.vt-tools-nav-badge.orange{background:#fef3c7;color:#d97706}
.vt-tools-nav-badge.red{background:#fee2e2;color:#dc2626}
.vt-tools-nav-badge.gray{background:#f3f4f6;color:#6b7280}
.vt-vnd-grid{display:flex;flex-direction:column;gap:10px}
.vt-vnd-group{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.vt-vnd-head{display:flex;align-items:center;gap:8px;padding:9px 14px;background:var(--gray-bg);border-bottom:1px solid var(--border);flex-wrap:wrap;row-gap:6px}
.vt-vnd-name{font-weight:700;font-size:15px;color:var(--heading)}
/* The sites under a vendor are indented, so the vendor name stands out */
.vt-vnd-group>.vt-why-tbl,.vt-vnd-group>.vt-vnd-tip,.vt-vnd-group>.vt-vnd-how{margin-left:28px;width:calc(100% - 28px)}
.vt-vnd-how{font-size:12.5px;line-height:1.5;padding:8px 14px 8px 0;border-bottom:1px solid var(--border);box-sizing:border-box}
.vt-vnd-how-h{font-weight:700;color:var(--heading);display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.vt-vnd-prog{font-weight:600;font-size:11px;color:var(--muted);background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:0 8px}
.vt-vnd-how ol{margin:4px 0 0 18px;padding:0}
.vt-alert-id{display:inline-flex;align-items:center;gap:6px;font-size:11.5px;margin-left:6px;white-space:nowrap}
.vt-alert-id label{display:inline-flex;align-items:center;gap:5px;color:var(--muted)}
.vt-alert-id input{width:130px;padding:2px 6px;border:1px solid var(--border);border-radius:4px;font:12px ui-monospace,monospace;background:var(--surface);color:var(--text)}
.vt-alert-ok{color:#15803d;font-weight:600}
.vt-vnd-cp{display:inline-flex;vertical-align:middle;margin-left:4px;color:var(--muted);opacity:.7}
.vt-vnd-cp:hover{opacity:1;color:var(--blue)}.vt-vnd-cp svg{width:13px;height:13px}.vt-vnd-cp.done{color:#16a34a;opacity:1}
.vt-rt-btn{font-size:11.5px;margin-left:6px;cursor:pointer;white-space:nowrap;color:var(--blue)}
.vt-rt-panel{position:fixed;inset:0;background:rgba(0,0,0,.35);z-index:1000;display:flex;align-items:center;justify-content:center;padding:16px}
.vt-rt-box{background:var(--surface,#fff);border-radius:10px;box-shadow:0 10px 40px rgba(0,0,0,.25);padding:16px 18px;width:min(640px,100%);max-height:90vh;overflow:auto}
.vt-rt-head{display:flex;align-items:center;gap:8px}
.vt-rt-x{cursor:pointer;font-size:16px;color:var(--muted)}
.vt-rt-txt{width:100%;box-sizing:border-box;font:13px/1.5 inherit;padding:8px 10px;border:1px solid var(--border);border-radius:6px;resize:vertical;background:var(--surface);color:var(--text)}
.vt-rt-acts{margin-top:10px;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.vt-vnd-how li{margin:2px 0}
.vt-vnd-group>.vt-why-tbl{border-left:3px solid var(--border)}
/* Find box above a tool (Vendors, Scan log) */
.vt-tool-find{display:flex;align-items:center;gap:10px;margin:0 0 12px;flex-wrap:wrap}
.vt-tool-find input{width:340px;max-width:100%;padding:6px 9px;border:1px solid var(--border);border-radius:6px;font-size:13px;background:var(--surface);color:var(--text)}
mark.vt-hit{background:#fde68a;color:inherit;padding:0 1px;border-radius:2px}
.vt-vnd-cnt{font-size:12px;color:var(--muted);background:var(--border);border-radius:9px;padding:1px 7px;font-weight:600;white-space:nowrap}
.vt-vnd-actions{margin-left:auto;display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.vt-vnd-link{font-size:12px;color:var(--blue);text-decoration:none;cursor:pointer;white-space:nowrap}
.vt-vnd-link:hover{text-decoration:underline}
.vt-vnd-copy{font-size:11px;font-weight:600;padding:3px 10px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;border-radius:12px;cursor:pointer;white-space:nowrap;transition:background .15s}
.vt-vnd-copy:hover{background:#dbeafe}
.vt-vnd-sites{display:flex;flex-wrap:wrap;gap:6px;padding:10px 14px}
.vt-vnd-site{display:inline-flex;align-items:center;gap:5px;font-size:12px;padding:2px 9px;border-radius:12px;background:var(--red-bg,#fef2f2);border:1px solid var(--red-border,#fecaca);color:var(--red,#dc2626)}
.vt-vnd-site.susp{background:#fffbeb;border-color:#fde68a;color:#d97706}
.vt-vnd-site a{color:inherit;text-decoration:none;cursor:pointer}
.vt-vnd-site a:hover{text-decoration:underline}
.vt-vnd-verdict{opacity:.65;font-size:11px}
.vt-vnd-tip{font-size:12px;color:var(--muted);padding:7px 14px;border-bottom:1px solid var(--border);background:var(--gray-bg);line-height:1.45}
.vt-blue-link{color:var(--blue);cursor:pointer;text-decoration:none}
.vt-blue-link:hover{text-decoration:underline}
.vt-wu-pill.hintpill{background:var(--gray-bg);color:var(--muted);border:1px solid var(--border)}
.vt-fs-tbl.vt-ms-tbl td,.vt-fs-tbl.vt-ms-tbl td:last-child{white-space:normal;color:var(--text);font-family:inherit;word-break:normal}.vt-ms-tbl td:first-child{width:90px}
.vt-pw-cms{display:inline-block;font-size:10px;font-weight:600;padding:0 5px;border-radius:4px;background:#eef2ff;color:#3730a3;border:1px solid #c7d2fe;margin-left:4px;vertical-align:middle}
.vt-pw-fixed{color:var(--green,#16a34a);font-weight:600;cursor:help}
.vt-pw-fixbox{border:1px solid #fca5a5;background:#fff;border-radius:8px;padding:12px 14px;margin:10px 0 14px}
.vt-pw-fixbox .vt-pw-shield svg{width:18px;height:18px}
.vt-pw-fixhead{display:flex;align-items:center;gap:8px;margin-bottom:8px}.vt-pw-fixhead .sp{flex:1}
.vt-pw-steps{margin:4px 0 10px;padding-left:20px;font-size:13px}.vt-pw-steps ul{margin:4px 0;padding-left:18px}
.vt-pw-subj{font-size:13px;margin:6px 0}
.vt-pw-kinds{display:flex;flex-direction:column;gap:6px;margin:4px 0 10px}
.vt-pw-kinds label{display:block;padding:7px 10px;border:1px solid var(--border);border-radius:6px;cursor:pointer;font-size:13px}
.vt-pw-kinds label.on{border-color:#2563eb;background:#eff6ff}.vt-pw-kinds label.on.danger{border-color:#dc2626;background:#fef2f2}
.vt-pw-steps li.skip{opacity:.55}
.vt-pw-prev{width:100%;height:420px;border:1px solid var(--border);border-radius:6px;background:#fff}
.vt-pw-shield{color:#dc2626;display:inline-block;vertical-align:middle;margin-right:5px;cursor:help;line-height:0}
.vt-pw-tbl td.site small{display:block;font-weight:400;color:var(--muted)}
.vt-domain-age{display:inline-block;font-size:10px;padding:1px 5px;border-radius:4px;font-weight:600;margin-left:4px;vertical-align:middle}
.vt-domain-age.new-30d{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
.vt-domain-age.new-1y{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border)}
.vt-tag{display:inline-block;font-size:10px;padding:1px 5px;border-radius:4px;font-weight:600;margin:1px 1px 0 0;background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
.vt-dlinks{display:inline-flex;gap:5px;margin-left:7px}
.vt-dlinks a{display:inline-flex;align-items:center;justify-content:center;min-width:22px;height:20px;box-sizing:border-box;font-size:11px;color:var(--blue);text-decoration:none;padding:1px 5px;border:1px solid var(--blue-border);border-radius:4px;background:var(--blue-bg)}
.vt-dlinks a:hover{background:var(--blue);color:#fff}
.vt-dlinks a img{display:block;border-radius:2px}
.vt-dlinks a.done{background:var(--green,#16a34a);border-color:var(--green,#16a34a);color:#fff}
.vt-score{display:flex;align-items:center;gap:7px}
.vt-sbar{flex:1;height:5px;background:var(--border);border-radius:3px;overflow:hidden;min-width:50px}
.vt-sbar-fill{height:100%;border-radius:3px}
.vt-sbar-fill.infected{background:var(--red)}.vt-sbar-fill.clean{background:var(--green)}
.vt-snum{font-size:12px;font-weight:600;min-width:38px;text-align:right;color:var(--muted)}
.vt-snum.infected{color:var(--red);font-size:13px}
.vt-snum.clean{color:var(--green)}
.vt-row-btn{padding:4px 9px;border-radius:5px;border:1px solid var(--border);background:var(--surface);color:var(--muted);font-size:11px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:4px}
.vt-row-btn:hover:not(:disabled){color:var(--blue);border-color:var(--blue-border);background:var(--blue-bg)}
.vt-row-btn:disabled{opacity:.5;cursor:not-allowed}
.vt-spin{display:inline-block;width:10px;height:10px;border:2px solid var(--border);border-top-color:var(--blue);border-radius:50%;animation:vtspin .6s linear infinite}
.vt-empty td{text-align:center;padding:40px;color:var(--muted)}
.vt-stale{font-size:10px;color:var(--yellow);font-weight:600;margin-left:4px}

/* Scan Monitor panel — fixed right, starts at app header height, 50% wide */
.vt-queue{position:fixed;right:0;top:var(--vt-header-h,56px);width:50vw;max-height:calc(100vh - var(--vt-header-h,56px));
  overflow-y:auto;z-index:900;background:var(--surface);border:1px solid var(--blue-border);border-right:none;
  border-radius:10px 0 0 10px;box-shadow:-4px 0 24px rgba(0,0,0,.13);display:none}
.vt-queue.vt-q-collapsed{max-height:none;overflow:visible}
.vt-queue.vt-q-collapsed .vt-q-body{display:none}
.vt-q-head{display:flex;align-items:center;gap:8px;padding:9px 13px;background:var(--blue-bg);border-bottom:1px solid var(--blue-border);position:sticky;top:0;z-index:1;cursor:pointer;user-select:none}
.vt-q-head button,.vt-q-head a{cursor:pointer}
.vt-queue.vt-q-collapsed .vt-q-head{border-bottom:none}
.vt-q-title{font-size:12px;font-weight:700;color:var(--blue);text-transform:uppercase;letter-spacing:.4px}
.vt-q-sum{font-size:12px;color:var(--muted)}
.vt-q-toggle{margin-left:2px;background:var(--blue-bg);border:1px solid var(--blue-border);cursor:pointer;padding:3px 10px;font-size:11px;font-weight:600;color:var(--blue);border-radius:4px;line-height:1.5;flex-shrink:0;white-space:nowrap}
.vt-q-toggle:hover{background:var(--blue);color:#fff;border-color:var(--blue)}
.vt-q-head .vt-row-btn{margin-left:4px}
.vt-q-body{}
.vt-q-list{}
/* Animated pause bar for VirusTotal's 4 requests/minute limit */
.vt-q-pause{display:none;align-items:center;gap:12px;padding:8px 13px;border-top:1px solid var(--border);background:#fafbff;font-size:12px;color:var(--muted)}
.vt-q-ptrack{flex:0 0 180px;height:8px;border-radius:4px;background:var(--border);overflow:hidden}
.vt-q-pfill{height:100%;width:0;border-radius:4px;transition:width 1s linear;
  background:repeating-linear-gradient(-45deg,#2563eb 0 6px,#60a5fa 6px 12px);background-size:17px 17px;animation:vt-stripes .8s linear infinite}
.vt-q-pfill.limit{background:repeating-linear-gradient(-45deg,#d97706 0 6px,#fbbf24 6px 12px);background-size:17px 17px}
@keyframes vt-stripes{to{background-position:17px 0}}
.vt-q-item{display:flex;align-items:center;gap:12px;padding:8px 13px 8px 10px;border-bottom:1px solid var(--border);font-size:13px;border-left:3px solid transparent}
.vt-q-item:last-child{border-bottom:none}
/* Active: blue left bar */
.vt-q-item.queued,.vt-q-item.submit,.vt-q-item.ratewait,.vt-q-item.processing,.vt-q-item.fetch,.vt-q-item.live{border-left-color:var(--blue);background:var(--surface)}
/* Completed: green or red tint */
.vt-q-item.done{background:var(--green-bg);border-left-color:var(--green-border)}
.vt-q-item.failed{background:var(--red-bg);border-left-color:var(--red-border)}
/* Section divider between active queue and completed */
.vt-q-divider{padding:4px 13px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);background:var(--gray-bg);border-bottom:1px solid var(--border);border-top:1px solid var(--border)}
/* File scanner jobs — amber accent */
.vt-q-item.vt-q-fs.running,.vt-q-item.vt-q-fs.queued{border-left-color:#f59e0b;background:#fffbeb}
/* Server-queue items — purple accent */
.vt-q-item.vt-q-srv{border-left-color:#7c3aed;background:#faf5ff}
.vt-q-kind.srv{background:#ede9fe;border-color:#c4b5fd;color:#5b21b6}
.vt-q-kind.fs{background:#fef3c7;border-color:#fcd34d;color:#92400e}
.vt-q-kind.pw{background:#fee2e2;border-color:#fca5a5;color:#991b1b}
.vt-q-item.vt-q-pw.running,.vt-q-item.vt-q-pw.queued{border-left-color:#dc2626;background:#fff5f5}
.vt-q-icon{width:26px;text-align:center;flex-shrink:0;font-weight:700;font-size:12px;color:var(--muted)}
.vt-q-icon.ok{color:var(--green)}.vt-q-icon.bad{color:var(--red)}
.vt-q-main{flex:1;min-width:0}
.vt-q-dom{font-weight:600;color:var(--heading)}
.vt-q-kind{font-size:10px;font-weight:600;padding:1px 5px;border-radius:4px;margin-left:6px;background:var(--gray-bg);border:1px solid var(--border);color:var(--muted);vertical-align:middle}
.vt-q-msg{font-size:12px;color:var(--muted);margin-top:1px}
.vt-q-steps{display:flex;gap:3px;margin-top:5px}
.vt-q-steps span{font-size:10px;padding:1px 6px;border-radius:10px;background:var(--gray-bg);border:1px solid var(--border);color:var(--muted)}
.vt-q-steps span.done{background:var(--green-bg);border-color:var(--green-border);color:var(--green)}
.vt-q-steps span.on{background:var(--blue);border-color:var(--blue);color:#fff}
.vt-q-steps span.bad{background:var(--red-bg);border-color:var(--red-border);color:var(--red)}
.vt-q-pbar{height:3px;background:var(--border);border-radius:2px;margin-top:5px;overflow:hidden;max-width:260px}
.vt-q-pbar div{height:100%;background:var(--blue);transition:width .4s}
/* Unknown duration (ClamAV scans one file and reports nothing until it is done): a moving stripe, no fake percentage */
.vt-q-pbar.indet div{width:30%!important;animation:vtIndet 1.2s ease-in-out infinite}
@keyframes vtIndet{0%{transform:translateX(-100%)}100%{transform:translateX(340%)}}
.vt-q-stats{font-size:11px;color:var(--muted);margin-top:3px;line-height:1.45}
.vt-q-item.vt-q-fs .vt-q-pbar div{background:#f59e0b}
.vt-q-right{text-align:right;font-size:12px;color:var(--muted);white-space:nowrap}
.vt-q-skip{margin-top:4px}.vt-q-skip:hover{color:var(--red)!important;border-color:var(--red)!important;background:transparent!important}
.vt-q-right .vt-badge{margin-bottom:2px}

/* Settings */
.vt-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;max-width:600px;margin-bottom:14px}
.vt-card h3{font-size:14px;font-weight:700;color:var(--heading);margin-bottom:14px;padding-bottom:9px;border-bottom:1px solid var(--border)}
.vt-field{margin-bottom:14px}
.vt-field label{display:block;font-size:11px;font-weight:600;color:var(--muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.4px}
.vt-field input[type=text],.vt-field input[type=number]{width:100%;padding:8px 11px;border:1px solid var(--border);border-radius:var(--radius);font-size:13px;color:var(--text);outline:none;background:var(--surface);font-family:monospace}
.vt-field input:focus{border-color:var(--blue)}
.vt-field .hint{font-size:11px;color:var(--muted);margin-top:4px}
.vt-field-row{display:flex;gap:10px}
.vt-field-row .vt-field{flex:1}
.vt-save-row{display:flex;align-items:center;gap:10px;margin-top:4px}
.vt-smsg{font-size:12px;font-weight:600;display:none}
.vt-smsg.ok{color:var(--green)}.vt-smsg.err{color:var(--red)}
.vt-key-display{margin-top:8px;padding:8px 11px;background:var(--gray-bg);border:1px solid var(--border);border-radius:var(--radius);font-family:monospace;font-size:12px;color:var(--text);word-break:break-all;display:none}
.vt-key-display .vt-key-label{font-size:10px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px}

/* Notifications */
.vt-n-group{margin:10px 0 12px 26px}
.vt-n-label{font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px}
.vt-check{display:flex;align-items:center;gap:6px;padding:3px 0;font-size:13px;cursor:pointer}
.vt-check .hint{font-size:12px;color:var(--muted)}
.vt-n-email{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:7px 11px;font-size:13px;width:100%;max-width:340px;outline:none}
.vt-n-email:focus{border-color:var(--blue)}
.vt-n-group.hint{color:var(--muted)}
/* File scanners (ClamAV, maldet, …) */
.vt-fs-tools{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin:0 0 10px;font-size:12px;font-weight:600}
.vt-fs-tools .hint{font-weight:400}
.vt-fs-n{background:var(--red);color:#fff;border-radius:8px;padding:0 5px;font-size:10px;font-weight:700}
.vt-scanbar{display:inline-flex;border:1px solid var(--border);border-radius:5px;overflow:hidden;vertical-align:middle;margin-right:6px}
.vt-sbtn{padding:4px 9px;border:0;border-left:1px solid var(--border);background:var(--gray-bg);color:#374151;font-size:11px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:4px;white-space:nowrap}
.vt-sbtn:first-child{border-left:0}
.vt-sbtn:disabled{cursor:not-allowed;color:#6b7280;background:#f3f4f6}
.vt-sbtn:not(:disabled):hover{color:var(--blue);background:var(--blue-bg)}
.vt-sbtn.open{color:var(--blue);background:var(--blue-bg);box-shadow:inset 0 -2px 0 var(--blue)}
.vt-sbtn .n{background:var(--red);color:#fff;border-radius:8px;padding:0 5px;font-size:10px}
.vt-sbtn .ok{color:var(--green,#16a34a)}
tr.vt-fs-row>td{background:var(--gray-bg);border-top:0;padding:10px 13px 12px}
.vt-fs{font-size:12.5px;overflow-wrap:anywhere}
.vt-fs-row>td{max-width:0} /* the details never make the site table wider than the page */
.vt-why-tbl{table-layout:fixed}
.vt-why-tbl th:nth-child(1){width:22%}.vt-why-tbl th:nth-child(2){width:38%}
.vt-why-tbl td:last-child{white-space:normal;color:inherit}
.vt-why-tbl .vt-why-tip{white-space:normal;overflow-wrap:anywhere}
.vt-why-tbl code{word-break:break-all}
.vt-tbl-wrap tbody tr[data-domain]:has(.vt-why-btn):not(.vt-fs-row){cursor:pointer}
.vt-fs-head{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.vt-fs-head strong{color:var(--heading)}
.vt-fs-head .sp{flex:1}
.vt-fs-head a{cursor:pointer;color:var(--blue);font-weight:600}
.vt-fs-bar{height:6px;border-radius:3px;margin-top:8px;background:repeating-linear-gradient(45deg,var(--blue) 0 10px,#93c5fd 10px 20px);background-size:28px 28px;animation:vtFsMove 1s linear infinite;opacity:.8}
.vt-fs-prog{height:8px;border-radius:4px;margin-top:8px;background:#e2e8f0;overflow:hidden}
.vt-fs-prog>div{height:100%;background:var(--blue);border-radius:4px;transition:width .8s ease}
.vt-fs-bar.wait{background:repeating-linear-gradient(45deg,#cbd5e1 0 10px,#e2e8f0 10px 20px);background-size:28px 28px}
@keyframes vtFsMove{to{background-position:28px 0}}
.vt-fs .bad{color:var(--red);font-weight:600}
.vt-fs .good{color:var(--green,#16a34a);font-weight:600}
.vt-fs-tbl{width:100%;border-collapse:collapse;margin-top:8px;font-size:12px;background:var(--surface)}
.vt-fs-tbl th,.vt-fs-tbl td{text-align:left;padding:5px 8px;border:1px solid var(--border);vertical-align:top}
.vt-fs-tbl th{font-size:11px;color:var(--muted);font-weight:600}
.vt-fs-tbl td:first-child{font-family:ui-monospace,Consolas,monospace;word-break:break-all}
.vt-fs-tbl td:last-child{color:var(--red);white-space:nowrap}
.vt-fs-tbl tr.handled td{color:var(--muted)!important;text-decoration:line-through}
.vt-fs-tbl td.vt-fa-sig{color:var(--red)}.vt-fs-tbl td.vt-fa-cell{color:#202020;white-space:nowrap}.vt-fs-tbl tr.handled td.vt-fa-cell{text-decoration:none}.vt-fs-tbl tr.vt-fa-row td{background:#f8fafc;color:#202020;font-family:inherit;word-break:normal;white-space:normal}.vt-fa-done{color:var(--green,#16a34a);font-weight:600}.vt-fa-diff{max-height:260px;overflow:auto;margin:6px 0;padding:8px;border:1px solid var(--border);border-radius:4px;background:#fff;font-size:11px;line-height:1.45;white-space:pre-wrap;word-break:break-all}.vt-fa-diff .del,.vt-fa-q .del{color:#b91c1c;background:#fee2e2}.vt-fa-diff .add{color:#15803d;background:#dcfce7}.vt-fa-diff .hunk{color:#6b21a8}.vt-fa-q{margin:4px 0 8px;font-size:12px;color:#202020}.vt-fa-q.ok{color:#15803d}.vt-fa-q.err{color:#b91c1c}.vt-fa-bulk{margin:8px 0 0;font-size:12px}
.vt-sc-sub{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;margin:14px 0 2px}
.vt-sc-sub:first-child{margin-top:0}
.vt-sc-row{display:flex;align-items:center;gap:12px;padding:9px 0;border-top:1px solid var(--border)}
.vt-sc-row:first-child{border-top:0}
.vt-sc-row .vt-sc-name{font-weight:700;min-width:80px}
.vt-sc-row .vt-sc-info{flex:1;font-size:12px;color:var(--muted);overflow-wrap:anywhere}
.vt-sc-row.missing .vt-sc-name{color:var(--muted)}
.vt-sw{position:relative;width:36px;height:20px;flex:none}
.vt-sw input{opacity:0;width:0;height:0;position:absolute}
.vt-sw span{position:absolute;inset:0;border-radius:20px;background:#cbd5e1;cursor:pointer;transition:.15s}
.vt-sw span:before{content:"";position:absolute;width:16px;height:16px;left:2px;top:2px;border-radius:50%;background:#fff;transition:.15s}
.vt-sw input:checked+span{background:#16a34a}
.vt-sw input:checked+span:before{transform:translateX(16px)}
.vt-sw input:disabled+span{opacity:.45;cursor:not-allowed}
.vt-fs-note{color:var(--muted);font-size:11.5px;margin-top:6px;line-height:1.45}
.vt-rel{margin-top:4px}
tr.vt-grp-r>td{background:#e8edf5;font-size:13px;font-weight:700;padding:8px 12px!important;border-top:2px solid #cbd5e1;color:#1f2937}
tr.vt-grp-c>td{background:#f8fafc;font-size:12.5px;padding:6px 12px!important;cursor:pointer;color:#374151;font-weight:600}
tr.vt-grp-c:hover>td{background:#f1f5f9}
.vt-grp-badge{display:inline-block;font-size:10px;font-weight:600;padding:1px 5px;border-radius:4px;background:#dbeafe;color:#1d4ed8;vertical-align:middle;margin-left:5px}
.vt-grp-login{font-weight:400;color:var(--muted);font-size:11.5px}
.vt-grp-n{font-weight:400;color:var(--muted);font-size:11.5px;margin-left:6px}
.vt-grp-n .bad{color:#b91c1c;font-weight:600}
.vt-grp-caret{display:inline-block;transition:transform .15s;color:var(--muted)}
tr.vt-grp-c.closed .vt-grp-caret{transform:rotate(-90deg)}
.vt-seg{display:inline-flex;border:1px solid var(--border);border-radius:8px;overflow:hidden}
.vt-seg button{all:unset;cursor:pointer;font-size:12px;padding:5px 12px;color:var(--text);border-left:1px solid var(--border)}
.vt-seg button:first-child{border-left:0}
.vt-seg button.on{background:#2563eb;color:#fff}

.vt-tr-tiles{display:flex;gap:12px;flex-wrap:wrap;margin:6px 0 14px}
.vt-tr-tile{border:1px solid var(--border);border-radius:8px;padding:10px 14px;min-width:150px}
.vt-tr-tile .l{font-size:11px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted)}
.vt-tr-tile .v{font-size:22px;font-weight:800;margin-top:2px}
.vt-tr-tile .d{font-size:12px;color:var(--muted)}
.vt-tr-tile .d.up{color:#b91c1c}.vt-tr-tile .d.down{color:#15803d}
.vt-tr-legend{display:flex;gap:8px;font-size:12px;color:var(--text);margin-bottom:4px;flex-wrap:wrap;align-items:center}
.vt-tr-legend button{all:unset;cursor:pointer;display:inline-flex;align-items:center;gap:6px;padding:3px 10px;border:1px solid var(--border);border-radius:12px;color:var(--text)}
.vt-tr-legend button:hover{border-color:#9ca3af}
.vt-tr-legend button.off{opacity:.45;text-decoration:line-through}
.vt-tr-legend i{display:inline-block;width:14px;height:0;border-top:2px solid;vertical-align:middle}
.vt-tr-legend i.dash{border-top-style:dashed}
.vt-tr-legend .hint{margin-left:6px}
.vt-tr-chart{position:relative;width:100%}
.vt-tr-chart svg{display:block;width:100%;overflow:visible}
.vt-tr-title{font-size:13px;font-weight:600;margin:16px 0 4px}
.vt-tr-tip{position:fixed;pointer-events:none;background:#fff;border:1px solid var(--border);border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,.15);padding:8px 10px;font-size:12px;line-height:1.5;display:none;z-index:50;min-width:150px}
.vt-tr-tip b{display:block;margin-bottom:2px}
.vt-tr-tip .row{display:flex;justify-content:space-between;gap:14px}
.vt-tr-tip i{display:inline-block;width:8px;height:8px;border-radius:50%;margin-right:6px}
.vt-tr-table{margin-top:10px;font-size:12px}
.vt-tr-table table{border-collapse:collapse;margin-top:6px}
.vt-tr-table td,.vt-tr-table th{padding:3px 10px;border-bottom:1px solid var(--border);text-align:right}
.vt-tr-table td:first-child,.vt-tr-table th:first-child{text-align:left}
.vt-orphan{font-size:11.5px;color:var(--muted);margin-top:4px;line-height:1.45}
.vt-orphan code{font-size:11px}
.vt-orphan-kind{font-size:11px;margin-top:1px}
.vt-orphan-kind.free{color:#15803d}
.vt-orphan-kind.part{color:#b45309}
.vt-orphan-kind.live{color:#b91c1c;font-weight:600}
.vt-orph-bar{display:flex;align-items:center;gap:10px;margin:0 0 10px;flex-wrap:wrap}
.vt-orph-q{width:340px;max-width:100%;padding:6px 9px;border:1px solid var(--border);border-radius:6px;font-size:13px;background:var(--surface);color:var(--text)}
/* Orphan databases: columns size to their content (no fixed widths), long names wrap */
.vt-orph-tbl{table-layout:auto;width:100%}
.vt-orph-tbl th,.vt-orph-tbl td{width:auto!important;min-width:0;white-space:normal;overflow-wrap:anywhere;vertical-align:top}
.vt-orph-tbl .num{text-align:right;white-space:nowrap;overflow-wrap:normal;font-variant-numeric:tabular-nums}
.vt-orph-tbl .vt-orph-act{text-align:right}
/* Action buttons stacked, one per line, all as wide as the widest */
.vt-orph-tbl td.vt-orph-act .vt-orph-btns{display:inline-flex;flex-direction:column;align-items:stretch;gap:4px}
.vt-orph-tbl td.vt-orph-act .vt-row-btn{margin:0;text-align:center;white-space:nowrap}
.vt-clam{font-size:12px;line-height:1.4}
.vt-clam.ok{color:#15803d}.vt-clam.bad{color:#b91c1c;font-weight:600}.vt-clam.none{color:var(--muted)}
.vt-clam small{display:block;font-weight:400;color:var(--muted);font-size:11px}
a.vt-row-btn{text-decoration:none;display:inline-block;margin-right:4px}
#vt-tbody-rel .vt-row-btn{margin-left:4px}
.vt-rel h3{font-size:15px;margin:0 0 6px;display:flex;align-items:center;gap:8px}
.vt-rel .vt-rel-cnt{font-size:12px;font-weight:600;background:var(--gray-bg);border:1px solid var(--border);border-radius:10px;padding:1px 8px;color:var(--muted)}
.vt-rel .hint{font-size:12.5px;line-height:1.5;margin:0 0 10px;max-width:900px}
.vt-why-btn{all:unset;cursor:pointer;display:flex;flex-direction:column;gap:2px;padding:3px 6px;margin:-3px -6px;border-radius:6px}
.vt-why-btn:hover,.vt-why-btn.open{background:var(--gray-bg)}
.vt-why-lbl{font-size:10.5px;color:#2563eb;font-weight:600}
.vt-why-howto{font-size:12.5px;line-height:1.55;color:#374151;background:#f8fafc;border:1px solid #e5e7eb;border-radius:6px;padding:8px 11px;margin:8px 0}
.vt-why-howto code{font-size:12px}
.vt-why-note{background:#fffbeb;border:1px solid #fcd34d;color:#92400e;border-radius:6px;padding:8px 11px;font-size:12.5px;line-height:1.5;margin:8px 0}
.vt-why-steps{margin:10px 0 4px 18px;padding:0;font-size:12.5px;line-height:1.55}
.vt-why-steps li{margin-bottom:5px}
.vt-why-tbl td:first-child{font-family:inherit;font-weight:600}
.vt-sh-row{display:flex;align-items:center;gap:12px;padding:6px 2px;border-bottom:1px solid var(--border);font-size:12.5px;flex-wrap:wrap}
.vt-sh-row:last-child{border-bottom:none}
.vt-sh-time{color:var(--muted);white-space:nowrap;min-width:150px;font-variant-numeric:tabular-nums}
.vt-sh-time small{font-size:11px}
.vt-sh-what{display:flex;align-items:center;gap:6px;min-width:215px}
.vt-sh-what .vt-badge{min-width:80px;justify-content:center}
.vt-sh-arr{color:var(--muted);font-weight:700}
.vt-sh-text{flex:1;min-width:200px}
.vt-sh-pill{display:inline-flex;justify-content:center;min-width:92px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;background:var(--gray-bg);color:var(--gray);border:1px solid var(--border)}
.vt-sh-pill.bad{background:var(--red-bg);color:var(--red);border-color:var(--red-border)}
.vt-sh-pill.good{background:var(--green-bg);color:var(--green);border-color:var(--green-border)}
.vt-sh-pill.warn{background:var(--yellow-bg);color:var(--yellow);border-color:var(--yellow-border)}
.vt-av-badge{all:unset;cursor:pointer;display:inline-flex;white-space:nowrap;flex-shrink:0;align-items:center;gap:5px;margin-top:3px;padding:1px 8px;border-radius:20px;font-size:10.5px;font-weight:600;background:var(--red-bg);color:var(--red);border:1px dashed var(--red-border)}
.vt-av a{cursor:pointer}
.vt-av{font-size:12.5px;line-height:1.7}
.vt-rev-deny{display:flex;align-items:center;gap:6px;margin-top:4px;font-size:11.5px}
.vt-rev-deny input{flex:1;min-width:180px;padding:3px 7px;border:1px solid var(--border);border-radius:6px;font-size:12px}
.vt-rev-deny a{color:var(--muted);cursor:pointer}
.vt-sh-pill.info{background:var(--blue-bg);color:var(--blue);border-color:var(--blue-border)}
.vt-rev-done{display:block;margin-top:3px}
.vt-rev-pill{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;color:var(--green);background:var(--green-bg);border:1px solid var(--green-border);border-radius:20px;padding:1px 8px;white-space:nowrap}
.vt-rev-actions{display:flex;flex-wrap:wrap;gap:4px;margin-top:3px;font-size:11px;color:var(--muted)}
.vt-rev-actions a{color:var(--blue);cursor:pointer;text-decoration:none}
.vt-rev-actions a:hover{text-decoration:underline}
.vt-rev-confirmed{display:block;margin-top:3px}
.vt-rev-conf-pill{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;color:#14532d;background:#bbf7d0;border:1px solid #4ade80;border-radius:20px;padding:1px 8px;white-space:nowrap}
.vt-rev-conf-pill a{color:#166534;font-weight:400;cursor:pointer;text-decoration:none}
.vt-rev-conf-pill a:hover{text-decoration:underline}
.vt-why-tbl tr.asked.confirmed td:first-child::after{content:' \2713 delisting confirmed';font-size:11px}
.vt-why-tbl tr.vt-av-row td{background:var(--gray-bg)}
.vt-why-tbl tr.vt-why-grp td{background:var(--gray-bg);font-weight:700;font-size:12px;text-transform:uppercase;letter-spacing:.04em;color:var(--heading);padding-top:8px;padding-bottom:6px;white-space:normal}
.vt-why-tbl tr.vt-why-grp td span{font-weight:400;text-transform:none;letter-spacing:0;color:var(--muted);margin-left:8px}
.vt-why-tbl tr.asked td:first-child::after{content:' \2713';color:var(--green)}
.vt-why-tip{font-size:11px;color:var(--muted);margin-top:2px;line-height:1.35}
#vt-n-opts{margin-left:0}
#vt-n-opts>.vt-btn{margin-left:26px}
#vt-n-opts.off{opacity:.45;pointer-events:none}

/* Settings: primary service, experimental providers, then server scanners. */
#vtpanel-settings{max-width:1080px}
#vtpanel-settings>.vt-card,#vtpanel-settings>.vt-set-group{scroll-margin-top:16px}
#vtpanel-settings>.vt-card.vt-toc{padding:16px 24px}
#vtpanel-settings .vt-card.vt-toc>*{margin-left:0!important}
.vt-toc-title{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);margin-bottom:10px}
.vt-toc-cols{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:14px 24px}
.vt-toc-col{display:flex;flex-direction:column;gap:5px;border-left:3px solid var(--border);padding-left:12px}
.vt-toc-col a{font-size:13px;color:var(--blue);text-decoration:none;cursor:pointer}
.vt-toc-col a:hover{text-decoration:underline}
.vt-toc-col a.vt-toc-grp{font-weight:700;color:var(--heading);font-size:14px;margin-bottom:2px}
.vt-set-group{display:flex;align-items:baseline;gap:12px;margin:30px 0 10px;padding-bottom:6px;border-bottom:2px solid var(--heading)}
.vt-set-group h2{margin:0;font-size:22px;font-weight:700;color:var(--heading)}
.vt-set-group span{font-size:13px;color:var(--muted)}
.vt-set-group .vt-totop{margin-left:auto}
.vt-totop{font-size:12px;font-weight:600;color:var(--blue);text-decoration:none;cursor:pointer;white-space:nowrap}
.vt-totop:hover{text-decoration:underline}
#vtpanel-settings .vt-card>.vt-totop-row{display:flex;justify-content:flex-end;margin-top:12px}
@keyframes vtTocHit{0%{box-shadow:0 0 0 3px #2563eb}100%{box-shadow:0 0 0 3px transparent}}
.vt-toc-hit{animation:vtTocHit 1.6s ease-out}
.vt-stats-info{margin-top:10px}
.vt-fs-tbl.vt-stats-tbl td,.vt-fs-tbl.vt-stats-tbl td:last-child{white-space:normal;font-family:inherit;color:var(--text)}.vt-stats-tbl td:first-child{width:160px;font-weight:600}
.vt-pwcfg-opts{display:flex;flex-direction:column;gap:2px;margin-top:10px}
.vt-pwcfg-tag{display:inline-block;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;padding:1px 6px;border-radius:4px;background:#dcfce7;color:#166534;vertical-align:1px}
.vt-pwcfg-tag.paid{background:#e0e7ff;color:#3730a3}
#vtpanel-settings>.vt-card{max-width:none;padding:24px}
#vtpanel-settings .vt-field label{font-size:12px;text-transform:none;letter-spacing:0;color:var(--text)}
#vtpanel-settings .vt-field input{font-family:inherit}
#vtpanel-settings .hint{font-size:12px;line-height:1.5;color:var(--muted)}
#vtpanel-settings .vt-save-row{flex-wrap:wrap;gap:10px;margin-top:16px}
#vtpanel-settings .vt-save-row button{white-space:nowrap;flex-shrink:0}
/* Settings: clear section names, the section's content indented below them */
#vtpanel-settings .vt-card>h3,#vtpanel-settings .vt-settings-title h3{font-size:18px;font-weight:700;color:var(--heading);border-left:4px solid #2563eb;padding:2px 0 2px 10px;line-height:1.3}
#vtpanel-settings .vt-card>h3{border-bottom:0;margin-bottom:14px}
#vtpanel-settings .vt-settings-title{border-bottom:1px solid var(--border);padding-bottom:9px}
#vtpanel-settings .vt-card>*:not(h3):not(.vt-settings-title){margin-left:5em}
@media (max-width:900px){#vtpanel-settings .vt-card>*:not(h3):not(.vt-settings-title){margin-left:1.5em}}
.vt-settings-title{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.vt-settings-title h3{margin:0}
.vt-settings-title .hint{margin-left:auto}
.vt-settings-main{border-left:3px solid var(--blue)}
.vt-settings-numbers{display:grid;grid-template-columns:repeat(12,minmax(0,1fr));gap:16px;margin-top:20px}
.vt-settings-numbers .vt-field{grid-column:span 2}
.vt-settings-numbers .vt-field.wide{grid-column:span 6}
.vt-settings-numbers .vt-field{min-width:0;margin:0}
.vt-settings-usage{margin-top:18px;padding-top:12px;border-top:1px solid var(--border);font-size:12px}
.vt-usage-heading,.vt-usage-line{display:flex;align-items:center;justify-content:space-between;gap:8px}
.vt-usage-heading{margin-bottom:10px}
.vt-usage-heading>span,.vt-usage-line>span{color:var(--muted)}
.vt-usage-columns{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.vt-usage-columns .vt-b-track{height:3px;width:100%;margin-top:5px}
.vt-usage-line{flex-wrap:wrap;row-gap:2px}
.vt-settings-experimental{border-color:var(--yellow-border);border-left:3px solid var(--yellow)}
.vt-experimental-tag{font-size:11px;font-weight:600;color:#92400e;background:var(--yellow-bg);border:1px solid var(--yellow-border);padding:3px 8px;border-radius:4px}
.vt-provider-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;margin-top:18px}
.vt-provider{display:grid;grid-template-columns:1fr auto;gap:8px 16px;align-items:center;padding:14px 0;border-top:1px solid var(--border)}
.vt-provider .vt-radio{margin:0}
.vt-provider .hint{grid-column:1/-1}
.vt-rate{display:flex;gap:7px;align-items:center;font-size:12px;color:var(--muted);white-space:nowrap}
.vt-rate input{width:58px;padding:7px;border:1px solid var(--border);border-radius:5px;font:inherit;color:var(--text);background:var(--surface)}
#vtpanel-settings .vt-sc-row{flex-wrap:wrap;padding:14px 0}
#vtpanel-settings .vt-sc-info{flex:1;min-width:220px}
#vtpanel-settings input:focus-visible{outline:2px solid var(--blue);outline-offset:2px}
@media(max-width:850px){.vt-settings-numbers .vt-field{grid-column:span 4}}
@media(max-width:560px){.vt-settings-numbers .vt-field{grid-column:span 6}}
/* ── Tools tab ───────────────────────────────────────────────── */
/* Badge on tab label */
.vt-tab-badge{display:inline-flex;align-items:center;justify-content:center;min-width:17px;height:17px;border-radius:9px;background:var(--red);color:#fff;font-size:10px;font-weight:800;padding:0 4px;margin-left:5px;vertical-align:-2px;line-height:17px}
/* Tool cards grid: responsive, 240 px minimum per card */
.vt-tools-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:12px;margin-bottom:24px}
.vt-tool-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;cursor:pointer;transition:border-color .15s,box-shadow .15s;display:flex;flex-direction:column;gap:10px;border-left:4px solid transparent}
.vt-tool-card:hover{border-color:var(--blue-border);box-shadow:0 2px 8px rgba(37,99,235,.08)}
.vt-tool-card.active,.vt-tool-card:focus-visible{border-color:var(--blue);border-left-color:var(--blue);box-shadow:0 2px 14px rgba(37,99,235,.13);outline:none}
.vt-tool-card.alert{border-left-color:var(--red)}
.vt-tool-card.alert:hover,.vt-tool-card.alert.active{border-color:var(--red-border);box-shadow:0 2px 8px rgba(220,38,38,.1)}
.vt-tool-top{display:flex;gap:16px;align-items:flex-start}
.vt-tool-icon{width:52px;height:52px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.vt-tool-info{flex:1;min-width:0}
.vt-tool-title{font-size:14px;font-weight:700;color:var(--heading);display:flex;align-items:center;gap:7px;flex-wrap:wrap;line-height:1.3}
.vt-tool-badge{font-size:10px;font-weight:700;padding:1px 7px;border-radius:10px;white-space:nowrap}
.vt-tool-badge.red{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
.vt-tool-badge.orange{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border)}
.vt-tool-badge.gray{background:var(--gray-bg);color:var(--gray);border:1px solid var(--border)}
.vt-tool-badge.blue{background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-border)}
.vt-tool-badge.purple{background:#fdf4ff;color:#9333ea;border:1px solid #e9d5ff}
.vt-tools-nav-badge.purple{background:#fdf4ff;color:#9333ea}
.vt-tool-desc{font-size:12px;color:var(--muted);line-height:1.5;margin-top:4px}
.vt-tool-open{font-size:12px;font-weight:600;color:var(--blue);text-align:right;padding-top:4px;margin-top:auto}
.vt-tool-card.active .vt-tool-open,.vt-tool-card:hover .vt-tool-open{color:#1d4ed8}
/* Back link + section heading when a tool is open */
.vt-tool-back{display:flex;align-items:center;gap:12px;margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid var(--border)}
.vt-tool-back a{font-size:13px;font-weight:600;color:var(--blue);cursor:pointer;text-decoration:none;white-space:nowrap;flex-shrink:0}
.vt-tool-back a:hover{text-decoration:underline}
.vt-tool-back h2{margin:0;font-size:18px;font-weight:700;color:var(--heading)}
/* Show/hide tool sections */
.vt-tool-section{display:none}.vt-tool-section.active{display:block}

/* Settings: no text lighter than rgb(32,32,32) */
#vtpanel-settings{--muted:#202020;color:#202020}
#vtpanel-settings .hint,#vtpanel-settings label,#vtpanel-settings .vt-sl-name span,#vtpanel-settings .vt-sl-part.manual .vt-sl-name span,
#vtpanel-settings .vt-av-title small,#vtpanel-settings .vt-av-calls,#vtpanel-settings .vt-rate,#vtpanel-settings .vt-sl-scale,
#vtpanel-settings .vt-qs-today .parts,#vtpanel-settings .vt-gsb-key,#vtpanel-settings .vt-usage-heading>span{color:#202020}
/* Online services: each in its own tinted block with a large logo */
.vt-brand-ico.lg{width:32px;height:32px;border-radius:7px}
.vt-svc-head{padding:10px 14px;border-radius:9px;border:1px solid #c7d2fe;background:#eef2ff}
.vt-svc-head h3{font-size:17px}
.vt-provider-list .vt-provider.vt-svc{border:1px solid var(--border);border-radius:9px;padding:14px 16px;margin-top:12px}
.vt-svc.avg{background:#eef5fc;border-color:#bfd7f0}
.vt-svc.avast{background:#fff4ec;border-color:#fcd2b3}
.vt-svc.google{background:#f0f6ff;border-color:#c6dafc}
.vt-svc .vt-av-title strong{font-size:15px;gap:10px}
.vt-key-state{display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;border-radius:20px;padding:2px 10px;white-space:nowrap}
.vt-key-state:empty{display:none}
.vt-key-state.ok{color:#14532d;background:#dcfce7;border:1px solid #86efac}
.vt-key-state.ok::before{content:'\2713';font-weight:800;color:#16a34a}
.vt-key-state.bad{color:#7f1d1d;background:#fee2e2;border:1px solid #fca5a5}
.vt-key-state.bad::before{content:'\2717';font-weight:800;color:#dc2626}
.vt-key-state.off{color:#202020;background:#f3f4f6;border:1px solid var(--border)}
/* Brand favicons next to scanner names */
.vt-brand-ico{width:20px;height:20px;flex-shrink:0;border-radius:4px;vertical-align:middle;object-fit:contain}
.vt-sc-row .vt-sc-name,.vt-provider .vt-radio strong,.vt-settings-title h3{display:inline-flex;align-items:center;gap:7px}
/* VirusTotal daily budget: two sliders, each with its name inside, coloured ranges and today's usage (orange) */
.vt-qs-today{display:flex;align-items:baseline;flex-wrap:wrap;gap:4px 14px;margin:2px 0 14px}
.vt-qs-today .big{font-size:26px;font-weight:700;color:var(--heading);font-variant-numeric:tabular-nums;line-height:1}
.vt-qs-today .lbl{font-size:13px;color:var(--text)}
.vt-qs-today .parts{font-size:12px;color:var(--muted);display:inline-flex;gap:14px;flex-wrap:wrap}
.vt-qs-today .parts>span{display:inline-flex;align-items:center;gap:5px}
.vt-qs-today .parts strong{color:var(--text);font-variant-numeric:tabular-nums}
.vt-sl{position:relative;height:44px;margin:0 10px;touch-action:none;user-select:none}
.vt-sl-track{position:absolute;inset:0;border-radius:8px;overflow:hidden;cursor:pointer;border:1px solid var(--border);
  background:repeating-linear-gradient(135deg,#f3f4f6 0 6px,#e9ebef 6px 12px)}
.vt-sl-fill,.vt-sl-part{position:absolute;top:0;bottom:0;left:0;overflow:hidden}
.vt-sl-fill{background:#dbeafe;border-right:1px solid var(--blue-border)}
.vt-sl-part.auto{background:#dbeafe}
.vt-sl-part.manual{background:#ede9fe;border-left:1px solid #c4b5fd}
.vt-sl-used{position:absolute;left:0;bottom:0;height:7px;background:#f59e0b;max-width:100%}
.vt-sl-used.on{min-width:3px}
.vt-sl-name{position:absolute;left:10px;top:5px;right:6px;display:flex;flex-direction:column;line-height:1.15;white-space:nowrap;overflow:hidden;pointer-events:none}
.vt-sl-name span{font-size:10.5px;text-transform:uppercase;letter-spacing:.4px;color:#1e40af;text-overflow:ellipsis;overflow:hidden}
.vt-sl-part.manual .vt-sl-name span{color:#5b21b6}
.vt-sl-part .vt-sl-name span{text-transform:none;letter-spacing:0;font-size:11.5px;font-weight:600}
.vt-sl-part.manual .vt-sl-name{left:10px}
.vt-sl-name strong{font-size:14px;color:var(--heading);font-variant-numeric:tabular-nums}
.vt-sl-knob{position:absolute;top:-6px;width:6px;height:56px;margin-left:-3px;border-radius:3px;background:#111827;box-shadow:0 0 0 2px #fff,0 1px 4px rgba(0,0,0,.35);cursor:ew-resize;outline:none}
.vt-sl-knob:focus-visible,.vt-sl-knob.drag{box-shadow:0 0 0 2px #fff,0 0 0 5px rgba(37,99,235,.35)}
.vt-sl-scale{position:relative;height:15px;margin:8px 10px 16px;font-size:10.5px;color:var(--muted);font-variant-numeric:tabular-nums}
.vt-sl-scale span{position:absolute;transform:translateX(-50%);white-space:nowrap}
.vt-sl-scale span:first-child{transform:none}.vt-sl-scale span:last-child{transform:translateX(-100%)}
.vt-qs-legend{display:flex;flex-wrap:wrap;align-items:center;gap:8px 22px;font-size:12px}
.vt-qs-legend>span,.vt-qs-legend>label{display:inline-flex;align-items:center;gap:6px;color:var(--muted)}
.vt-qs-legend input{width:78px;padding:5px 7px;border:1px solid var(--border);border-radius:5px;font:inherit;color:var(--text);background:var(--surface)}
.vt-qs-legend input#vt-s-manual-pct{width:56px}
.vt-qs-sw{width:11px;height:11px;border-radius:3px;display:inline-block;flex-shrink:0}
.vt-qs-sw.auto{background:#dbeafe;border:1px solid var(--blue-border)}
.vt-qs-sw.manual{background:#ede9fe;border:1px solid #c4b5fd}
.vt-qs-sw.free{background:repeating-linear-gradient(135deg,#f3f4f6 0 3px,#dde0e6 3px 6px);border:1px solid var(--border)}
.vt-qs-sw.used{background:#f59e0b}
/* AVG / Avast: one below the other */
.vt-provider-list{display:flex;flex-direction:column;margin-top:14px}
.vt-provider-list .vt-provider{grid-template-columns:1fr auto auto}
.vt-av-title{display:flex;flex-direction:column;gap:2px}
.vt-av-title small{font-weight:400;color:var(--muted);font-size:12px}
.vt-av-calls{font-size:12px;color:var(--muted);white-space:nowrap}
.vt-gsb-help summary{cursor:pointer;font-size:13px}
.vt-gsb-key{grid-column:1/-1;display:flex;align-items:center;gap:10px;flex-wrap:wrap;font-size:12px;color:var(--muted)}
.vt-gsb-key input{flex:0 1 380px;padding:7px 9px;border:1px solid var(--border);border-radius:5px;font:inherit;font-family:monospace;color:var(--text);background:var(--surface)}
.vt-av-badge.stale{opacity:.6;border-style:dotted}
.vt-av-calls strong{font-size:16px;color:var(--heading);font-variant-numeric:tabular-nums;margin-right:4px}
@media(max-width:560px){#vtpanel-settings>.vt-card{padding:16px}.vt-provider-grid{grid-template-columns:1fr}.vt-settings-numbers{gap:14px}.vt-settings-title{flex-wrap:wrap}.vt-settings-title .hint{margin-left:0}}

/* Status-change events feed */
.vt-ev-wrap{margin-top:14px}
.vt-ev-row{display:flex;align-items:center;gap:12px;padding:7px 2px;border-bottom:1px solid var(--border);font-size:13px;flex-wrap:wrap}
.vt-ev-row:last-of-type{border-bottom:none}
.vt-ev-time{color:var(--muted);white-space:nowrap;flex-shrink:0;min-width:150px;font-variant-numeric:tabular-nums}
.vt-ev-time small{font-size:11px}
.vt-ev-domain{font-weight:600;flex:1;min-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:var(--heading)}
.vt-ev-domain a{color:inherit;text-decoration:none}
.vt-ev-domain a:hover{text-decoration:underline}
.vt-ev-change{display:flex;align-items:center;gap:6px;flex-shrink:0}
.vt-ev-change .vt-badge{min-width:92px;justify-content:center}
.vt-ev-arrow{display:inline-flex;align-items:center;flex-shrink:0}
.vt-ev-arrow svg{width:22px;height:14px;display:block}
.vt-ev-change .vt-badge.gone{background:var(--gray-bg);color:var(--gray);border:1px dashed var(--gray)}

/* Radio options */
.vt-radio{display:flex;align-items:flex-start;gap:10px;padding:8px 0;cursor:pointer;font-size:13px}
.vt-radio input{margin-top:3px;flex-shrink:0} /* a long text next to it must not squeeze the box */
.vt-radio .hint{font-size:12px;color:var(--muted)}

/* Toasts */
.vt-toasts{position:fixed;bottom:20px;right:20px;display:flex;flex-direction:column;gap:6px;z-index:9999;pointer-events:none}
.vt-toast{background:#fff;border:1px solid #dde1e7;border-radius:var(--radius);padding:10px 14px;font-size:13px;animation:vt-tin .2s ease;max-width:320px;box-shadow:0 4px 16px rgba(0,0,0,.18);line-height:1.4}
.vt-toast.ok  {background:#f0fdf4;border-color:#86efac;color:#166534}
.vt-toast.err {background:#fef2f2;border-color:#fca5a5;color:#991b1b}
.vt-toast.info{background:#eff6ff;border-color:#93c5fd;color:#1e40af}
.vt-toast.warn{background:#fffbeb;border-color:#fcd34d;color:#92400e}
@keyframes vtspin{to{transform:rotate(360deg)}}
@keyframes vt-tin{from{transform:translateX(16px);opacity:0}to{transform:translateX(0);opacity:1}}
/* Collapsible sections in details panel */
.vt-collapsible,.vt-wu-collapsible{margin-top:14px;border-top:1px solid var(--border);padding-top:10px}
.vt-collapsible>summary,.vt-wu-collapsible>summary{cursor:pointer;font-size:13px;font-weight:600;padding:4px 0;user-select:none;list-style:none;display:flex;align-items:center;gap:8px}
.vt-collapsible>summary::-webkit-details-marker,.vt-wu-collapsible>summary::-webkit-details-marker{display:none}
.vt-collapsible>summary::before,.vt-wu-collapsible>summary::before{content:'▶';font-size:15px;color:var(--accent,#2563eb);flex-shrink:0;line-height:1}
.vt-collapsible[open]>summary::before,.vt-wu-collapsible[open]>summary::before{content:'▼'}
/* WordPress admin user scan */
.vt-wu-tbl{width:100%;border-collapse:collapse;font-size:12px;margin-top:4px}
.vt-wu-tbl th{text-align:left;padding:4px 8px;border-bottom:2px solid var(--border);font-weight:600;color:var(--muted);font-size:11px;text-transform:uppercase;letter-spacing:.04em}
.vt-wu-tbl td{padding:5px 8px;border-bottom:1px solid var(--border);vertical-align:middle;white-space:nowrap}
.vt-wu-tbl td.wrap{white-space:normal}
.vt-wu-tbl tr:last-child td{border-bottom:none}
.vt-wu-pill{display:inline-block;padding:1px 6px;border-radius:999px;font-size:10px;font-weight:700;white-space:nowrap;cursor:help;margin-right:3px}
.vt-wu-pill.warn{background:#fef9c3;color:#854d0e;border:1px solid #fde047}
.vt-wu-pill.info{background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe}
.vt-wu-pill.bad{background:#fef2f2;color:#991b1b;border:1px solid #fca5a5}
.vt-wu-actions{display:flex;gap:5px;justify-content:flex-end}
.vt-wu-actions button{font-size:11px;padding:2px 8px;line-height:1.6}
.vt-wu-new-pass{font-family:monospace;font-size:11px;background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:3px 8px;border-radius:5px;word-break:break-all}
</style>

<div id="vt-wrap">

  <div class="vt-brand">
    <img class="vt-brand-logo" src="<?= htmlspecialchars(($this->baseUrl ?: '') . 'images/logo-128.png') ?>" alt="" width="48" height="48">
    <div class="vt-brand-text">
      <div class="vt-brand-name">Stingy Reputation Scanner<?php if ($this->version): ?> <span class="vt-brand-ver">v<?= htmlspecialchars($this->version) ?></span><?php endif; ?></div>
      <div class="vt-brand-tag">Watches the reputation of every website on this server, finds malware, phishing and hacked admin accounts, and helps a site win its good name back after an attack</div>
    </div>
    <a class="vt-brand-by" href="#about" onclick="vtShowTab('about');return false;" title="About the maker">
      <span>by</span> <strong>Digizaal</strong>
    </a>
  </div>

  <div class="vt-update-banner" id="vt-update-banner">
    <span class="vt-update-icon">🔔</span>
    <span id="vt-update-msg"></span>
  </div>

  <!-- Scan Monitor: fixed right panel, starts below the app header -->
  <div class="vt-queue" id="vt-queue">
    <div class="vt-q-head" onclick="vtQueueToggle(event)">
      <span class="vt-q-title">Scan Monitor</span>
      <span class="vt-q-sum" id="vt-q-sum"></span>
      <div class="vt-spacer"></div>
      <button class="vt-row-btn" id="vt-q-cancel" onclick="vtCancelWaiting();event.stopPropagation()" style="display:none">Cancel waiting</button>
      <button class="vt-row-btn" onclick="vtClearFinished();event.stopPropagation()" style="margin-left:4px">Clear done</button>
      <button class="vt-q-toggle" id="vt-q-toggle" onclick="event.stopPropagation();vtQueueToggle()">▲ Collapse</button>
    </div>
    <div class="vt-q-body" id="vt-q-body">
      <div class="vt-q-list" id="vt-q-list"></div>
      <div class="vt-q-pause" id="vt-q-pause">
        <div class="vt-q-ptrack"><div class="vt-q-pfill" id="vt-q-pfill"></div></div>
        <span id="vt-q-ptext"></span>
      </div>
    </div>
  </div>

  <div class="vt-tabs">
    <div class="vt-tab active" id="vtab-dashboard" onclick="vtShowTab('dashboard')">Dashboard</div>
    <div class="vt-tab" id="vtab-tools" onclick="vtShowTab('tools')">Tools<span class="vt-tab-badge" id="vt-tools-badge" style="display:none"></span></div>
    <div class="vt-tab" id="vtab-trend" onclick="vtShowTab('trend');vtLoadTrend()">Statistics</div>
    <div class="vt-tab" id="vtab-settings" onclick="vtShowTab('settings')">Settings</div>
    <div class="vt-tab" id="vtab-about" onclick="vtShowTab('about')">About</div>
  </div>

  <!-- Dashboard -->
  <div class="vt-panel active" id="vtpanel-dashboard">

<?php if (!empty($this->oldVtInstalled)): ?>
    <div class="vt-alert warn">
      <strong>VT Site Scanner (the old name of Stingy Scanner) is still installed.</strong> Its settings, keys and history have been copied to Stingy Scanner,
      but both run their own scans and use your VirusTotal budget. Remove the old one as root:
      <code>plesk bin extension --uninstall virustotal-extension</code>
    </div>
<?php endif; ?>
    <div class="vt-alert warn" id="vt-aw-alert" style="display:none">
      &#x26A1; <strong><span id="vt-aw-alert-text"></span></strong>
      &mdash; <a onclick="vtShowTab('tools');vtToolSelect('adminwatch')" style="cursor:pointer">Review in Tools &rarr;</a>
    </div>
    <div class="vt-alert warn" id="vt-api-warning" style="display:none">
      No valid API key configured or key is invalid (HTTP 401) &mdash; scans will not work.
      <a onclick="vtShowTab('settings')" style="cursor:pointer">Configure in Settings &rarr;</a>
    </div>

    <div class="vt-budget">
      <div class="vt-bc-cell">
        <div class="vt-bc-wrap">
          <svg class="vt-bc-svg" viewBox="0 0 44 44"><circle class="vt-bc-track" cx="22" cy="22" r="15.9"/><circle class="vt-bc-arc auto" id="vt-auto-ring" cx="22" cy="22" r="15.9"/></svg>
          <div class="vt-bc-mid" id="vt-auto-num">—</div>
        </div>
        <div class="vt-bc-name">Auto</div>
        <div class="vt-bc-sub" id="vt-auto-sub">of —</div>
      </div>
      <div class="vt-bc-cell">
        <div class="vt-bc-wrap">
          <svg class="vt-bc-svg" viewBox="0 0 44 44"><circle class="vt-bc-track" cx="22" cy="22" r="15.9"/><circle class="vt-bc-arc manual" id="vt-manual-ring" cx="22" cy="22" r="15.9"/></svg>
          <div class="vt-bc-mid" id="vt-manual-num">—</div>
        </div>
        <div class="vt-bc-name">Manual left</div>
        <div class="vt-bc-sub" id="vt-manual-sub">of —</div>
      </div>
      <div class="vt-bc-cell">
        <div class="vt-bc-wrap">
          <svg class="vt-bc-svg" viewBox="0 0 44 44"><circle class="vt-bc-track" cx="22" cy="22" r="15.9"/><circle class="vt-bc-arc quota" id="vt-quota-ring" cx="22" cy="22" r="15.9"/></svg>
          <div class="vt-bc-mid" id="vt-quota-num">—</div>
        </div>
        <div class="vt-bc-name">VT quota</div>
        <div class="vt-bc-sub" id="vt-quota-sub">of 500</div>
      </div>
      <div class="vt-bc-sep"></div>
      <div class="vt-bc-meta">
        <div><span class="vt-bc-mlbl">Limit</span> <strong id="vt-daily-total">—</strong> req/day</div>
        <div><span class="vt-bc-mlbl">Date</span> <strong id="vt-budget-date">—</strong></div>
        <div style="font-size:10px">resets at midnight UTC</div>
      </div>
    </div>

    <div class="vt-toolbar">
      <input class="vt-search" type="search" id="vt-search" placeholder="Search domain or customer..." oninput="vtApplyFilter()" aria-label="Search domain or customer">
      <div class="vt-filters">
        <div class="vt-fgroup" data-f="all">
          <button class="vt-fbtn active" data-f="all" onclick="vtSetFilter('all')">All <strong id="vt-cnt-all">—</strong></button>
          <button class="vt-fcaret" onclick="vtToggleMenu(event,'all')" aria-label="All options">&#9662;</button>
          <div class="vt-fmenu" id="vt-fmenu-all">
            <button onclick="vtMenuAction('rescan','all')">Rescan</button>
            <button onclick="vtMenuAction('refresh')">Refresh site list</button>
          </div>
        </div>
        <div class="vt-fgroup" data-f="infected">
          <button class="vt-fbtn" data-f="infected" onclick="vtSetFilter('infected')"><span class="vt-dot dot-r"></span> Infected <strong id="vt-cnt-infected">0</strong></button>
          <button class="vt-fcaret" onclick="vtToggleMenu(event,'infected')" aria-label="Infected options">&#9662;</button>
          <div class="vt-fmenu" id="vt-fmenu-infected">
            <button onclick="vtMenuAction('rescan','infected')">Rescan</button>
          </div>
        </div>
        <div class="vt-fgroup" data-f="suspicious">
          <button class="vt-fbtn" data-f="suspicious" onclick="vtSetFilter('suspicious')"><span class="vt-dot dot-y"></span> Suspicious <strong id="vt-cnt-suspicious">0</strong></button>
          <button class="vt-fcaret" onclick="vtToggleMenu(event,'suspicious')" aria-label="Suspicious options">&#9662;</button>
          <div class="vt-fmenu" id="vt-fmenu-suspicious">
            <button onclick="vtMenuAction('rescan','suspicious')">Rescan</button>
          </div>
        </div>
        <div class="vt-fgroup" data-f="clean">
          <button class="vt-fbtn" data-f="clean" onclick="vtSetFilter('clean')"><span class="vt-dot dot-g"></span> Clean <strong id="vt-cnt-clean">0</strong></button>
          <button class="vt-fcaret" onclick="vtToggleMenu(event,'clean')" aria-label="Clean options">&#9662;</button>
          <div class="vt-fmenu" id="vt-fmenu-clean">
            <button onclick="vtMenuAction('rescan','clean')">Rescan</button>
          </div>
        </div>
        <div class="vt-fgroup" data-f="pending">
          <button class="vt-fbtn" data-f="pending" onclick="vtSetFilter('pending')"><span class="vt-dot dot-b"></span> Queued <strong id="vt-cnt-pending">0</strong></button>
          <button class="vt-fcaret" onclick="vtToggleMenu(event,'pending')" aria-label="Queued options">&#9662;</button>
          <div class="vt-fmenu" id="vt-fmenu-pending">
            <button onclick="vtMenuAction('rescan','pending')">Rescan</button>
          </div>
        </div>
      </div>
      <div class="vt-spacer"></div>
      <div class="vt-seg" id="vt-view-seg" style="margin-right:4px"><button type="button" data-mode="group" onclick="vtSetViewMode('group')">Grouped</button><button type="button" data-mode="sort" onclick="vtSetViewMode('sort')">Sort</button></div>
      <span id="vt-grp-opts"><label title="Every customer folded up; its header still shows how many sites are flagged. Click a customer to open or close it."><input type="checkbox" id="vt-grp-collapse" onchange="vtSetGrpCollapse(this.checked)"> Collapsed</label></span><!-- grouped view only: fold every customer up -->
      <span class="vt-status-txt" id="vt-scan-status"></span>
    </div>

    <div id="vt-load-bar">
      <div id="vt-load-msg">Loading domain list…</div>
      <div class="vt-load-track"><div class="vt-load-fill" id="vt-load-fill"></div></div>
      <div id="vt-load-pct">0%</div>
    </div>
    <div class="vt-prog-wrap"><div class="vt-prog-fill" id="vt-prog"></div></div>

    <div class="vt-tbl-wrap">
      <table>
        <thead id="vt-thead-main">
          <tr>
            <th style="width:230px">Status</th>
            <th data-col="domain">Domain</th>
            <th style="width:155px" data-col="score">Score</th>
            <th style="width:135px" data-col="lastscan">Last scan</th>
            <th style="width:85px;text-align:right">Action</th>
          </tr>
        </thead>
        <tbody id="vt-tbody"><tr class="vt-empty"><td colspan="5">Loading...</td></tr></tbody>
      </table>
    </div>

  </div><!-- end vtpanel-dashboard -->

  <!-- Statistics -->
  <div class="vt-panel" id="vtpanel-trend">
    <div class="vt-card" style="max-width:100%">
      <h3 style="display:flex;align-items:center;gap:10px;flex-wrap:wrap"><span id="vt-tr-h">Infections on this server</span>
        <span class="hint" style="font-weight:400" id="vt-tr-sub"></span>
        <span style="flex:1"></span>
        <span class="vt-seg" id="vt-tr-range">
          <button data-d="30" onclick="vtTrendRange(30)">1 month</button><button data-d="61" onclick="vtTrendRange(61)">2 months</button><button data-d="92" onclick="vtTrendRange(92)">3 months</button>
        </span>
      </h3>
      <div class="vt-tr-tiles" id="vt-tr-tiles"></div>
      <div class="vt-tr-legend" id="vt-tr-legend" role="group" aria-label="Lines in the chart"></div>
      <div class="vt-tr-chart" id="vt-tr-lines"></div>
      <div class="vt-tr-title">Sites cleaned per day <span class="hint">(infected or suspicious, then clean again)</span></div>
      <div class="vt-tr-chart" id="vt-tr-bars"></div>
      <div class="vt-tr-tip" id="vt-tr-tip"></div>
      <div class="vt-fs-note" id="vt-tr-note"></div>
      <details class="vt-tr-table"><summary>Show as table</summary><div id="vt-tr-table"></div></details>
      <div class="vt-ev-wrap">
        <div class="vt-tr-title">Recent status changes <span class="hint">(per site, newest first)</span></div>
        <div id="vt-ev-list"><span class="hint">Loading…</span></div>
      </div>
    </div>
  </div>

  <!-- ── Tools ─────────────────────────────────────────────────────── -->
  <div class="vt-panel" id="vtpanel-tools">

    <!-- Persistent tools submenu — visible while inside any tool -->
    <nav class="vt-tools-nav" id="vt-tools-nav" style="display:none">
      <a class="vt-tools-nav-item" id="vtnav-overview" onclick="vtToolSelect(null)">&#8592; All tools</a>
      <a class="vt-tools-nav-item" id="vtnav-vendors" onclick="vtToolSelect('vendors')">Vendor requests <span class="vt-tools-nav-badge purple" id="vtnb-vendors" style="display:none"></span></a>
      <a class="vt-tools-nav-item" id="vtnav-pwned" onclick="vtToolSelect('pwned')"<?= $this->pwnedOn === false ? ' style="display:none"' : '' ?>>Pwned Admins <span class="vt-tools-nav-badge red" id="vtnb-pwned" style="display:none"></span></a>
      <a class="vt-tools-nav-item" id="vtnav-adminwatch" onclick="vtToolSelect('adminwatch')">Admin changes <span class="vt-tools-nav-badge orange" id="vtnb-adminwatch" style="display:none"></span></a>
      <a class="vt-tools-nav-item" id="vtnav-orphan" onclick="vtToolSelect('orphan')">Orphan DBs <span class="vt-tools-nav-badge gray" id="vtnb-orphan" style="display:none"></span></a>
      <a class="vt-tools-nav-item" id="vtnav-log" onclick="vtToolSelect('log')">Scan log</a>
    </nav>

    <!-- Tool launcher: grid of cards, hidden when a tool is open -->
    <div id="vt-tools-home">
      <div class="vt-tools-grid">

        <!-- Vendor requests -->
        <div class="vt-tool-card" id="vtcard-vendors" tabindex="0" onclick="vtToolSelect('vendors')" onkeydown="if(event.key==='Enter')vtToolSelect('vendors')">
          <div class="vt-tool-top">
            <div class="vt-tool-icon" style="color:#9333ea">
              <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" aria-hidden="true" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3,24 H7 Q4,22 5,18 Q7,12 13,14 L16,17 M12,18 L10,22 16,24 H20 M21,20 A3,3 0 1 1 15,20 A3,3 0 1 1 21,20 M25,8 H30 L29,20 30,24 H23 Q23,21 26,20 Z"/></svg>
            </div>
            <div class="vt-tool-info">
              <div class="vt-tool-title">Vendor requests <span class="vt-tool-badge purple" id="vttb-vendors" style="display:none"></span></div>
              <div class="vt-tool-desc">Every security vendor that flags one of your sites, with how to ask each one for a review — request, track and confirm delisting per site</div>
            </div>
          </div>
          <div class="vt-tool-open">Open &rarr;</div>
        </div>

        <!-- Pwned Admins -->
        <div class="vt-tool-card" id="vtcard-pwned" tabindex="0" onclick="vtToolSelect('pwned')" onkeydown="if(event.key==='Enter')vtToolSelect('pwned')"<?= $this->pwnedOn === false ? ' style="display:none"' : '' ?>>
          <div class="vt-tool-top">
            <div class="vt-tool-icon" style="color:#dc2626">
              <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" aria-hidden="true" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6,27 V4 H26 V27 M4,28 H28 M16,4 V8 M10,8 H22 V11 L10,15 Z M7,23 H11 M21,23 H25 M21,22 A5,5 0 1 1 11,22 A5,5 0 1 1 21,22 M14,21 H14.2 M17.8,21 H18 M15,24 Q16,23 17,24"/></svg>
            </div>
            <div class="vt-tool-info">
              <div class="vt-tool-title">Pwned Admins <span class="vt-tool-badge red" id="vttb-pwned" style="display:none"></span></div>
              <div class="vt-tool-desc">Admin e-mail addresses found in known data breaches — change their passwords and enable two-factor login</div>
            </div>
          </div>
          <div class="vt-tool-open">Open &rarr;</div>
        </div>

        <!-- Admin changes -->
        <div class="vt-tool-card" id="vtcard-adminwatch" tabindex="0" onclick="vtToolSelect('adminwatch')" onkeydown="if(event.key==='Enter')vtToolSelect('adminwatch')">
          <div class="vt-tool-top">
            <div class="vt-tool-icon" style="color:#d97706">
              <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" aria-hidden="true" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13,6 Q16,1 19,6 L29,24 Q31,28 27,28 H5 Q1,28 3,24 Z M16,11 V18 M16,23 H16.1"/></svg>
            </div>
            <div class="vt-tool-info">
              <div class="vt-tool-title">Admin changes <span class="vt-tool-badge orange" id="vttb-adminwatch" style="display:none"></span></div>
              <div class="vt-tool-desc">New or changed admin accounts since the last hourly scan — approve what you did, investigate anything unexpected</div>
            </div>
          </div>
          <div class="vt-tool-open">Open &rarr;</div>
        </div>

        <!-- Orphan databases -->
        <div class="vt-tool-card" id="vtcard-orphan" tabindex="0" onclick="vtToolSelect('orphan')" onkeydown="if(event.key==='Enter')vtToolSelect('orphan')">
          <div class="vt-tool-top">
            <div class="vt-tool-icon" style="color:#16a34a">
              <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" aria-hidden="true" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6,20 V13 Q6,6 12,6 H21 Q27,6 27,13 V20 M6,13 H14 M19,13 H27 M12,7 Q10,9 10,13 M22,7 Q24,9 24,13 M14,12 H19 V17 H14 Z M2,23 Q5,23 7,21 Q10,19 13,22 Q16,25 19,22 Q22,19 25,22 Q28,25 30,22 M5,28 Q8,25 11,28 Q14,31 17,28 Q20,25 23,28 Q26,31 29,28"/></svg>
            </div>
            <div class="vt-tool-info">
              <div class="vt-tool-title">Orphan databases <span class="vt-tool-badge gray" id="vttb-orphan" style="display:none"></span></div>
              <div class="vt-tool-desc">WordPress databases for domains that no longer exist in DNS — back up and remove what is no longer needed</div>
            </div>
          </div>
          <div class="vt-tool-open">Open &rarr;</div>
        </div>

        <!-- Scan log -->
        <div class="vt-tool-card" id="vtcard-log" tabindex="0" onclick="vtToolSelect('log')" onkeydown="if(event.key==='Enter')vtToolSelect('log')">
          <div class="vt-tool-top">
            <div class="vt-tool-icon" style="color:#6b7280">
              <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" aria-hidden="true" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8,4 H21 Q24,4 24,7 V12 Q24,15 19,16 Q15,17 15,20 Q15,23 23,23 Q28,23 28,27 Q28,30 24,30 H13 Q9,30 9,27 V24 Q9,21 13,20 M8,4 Q4,4 4,8 Q4,11 8,11 H11 V8 Q11,4 8,4 M14,8 H20 M14,12 H19 M19,26 H24"/></svg>
            </div>
            <div class="vt-tool-info">
              <div class="vt-tool-title">Scan log</div>
              <div class="vt-tool-desc">Background scan history, errors and event log</div>
            </div>
          </div>
          <div class="vt-tool-open">Open &rarr;</div>
        </div>

      </div>
    </div><!-- end vt-tools-home -->

    <!-- ── Tool sections ─────────────────────────────────────────── -->

    <div class="vt-tool-section" id="vtool-pwned">
      <div class="vt-card" style="max-width:100%">
        <h3 style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">Pwned Admins <span class="hint" style="font-weight:400" id="vt-pw-sub"></span>
          <span style="flex:1"></span><span id="vt-pw-actions"></span></h3>
        <div class="hint">The administrator accounts of every WordPress, Joomla, Drupal, Wotan, Nextcloud, WHMCS and Laravel site, and whether their e-mail address appears in a known data breach.
          A breached address means a password used with it may be known: change the WordPress password (and any other place it was used) and turn on two-factor login.
          Each address is checked once; the result stays valid, so it is never checked again.</div>
        <div id="vt-pw-src"></div>
        <div id="vt-pw-note"></div>
        <div id="vt-pw-fix"></div>
        <div class="vt-toolbar" style="margin-top:6px">
          <input class="vt-search" type="text" id="vt-pw-search" placeholder="Search site, customer, login, e-mail or breach..." oninput="vtRenderPwned()" style="width:300px">
          <div class="vt-filters">
            <button class="vt-fbtn active" data-pwf="all" onclick="vtPwFilter('all')">All <strong id="vt-pw-cnt-all">0</strong></button>
            <button class="vt-fbtn" data-pwf="bad" onclick="vtPwFilter('bad')"><span class="vt-dot dot-r"></span> Pwned <strong id="vt-pw-cnt-bad">0</strong></button>
            <button class="vt-fbtn" data-pwf="ok" onclick="vtPwFilter('ok')"><span class="vt-dot dot-g"></span> Not pwned <strong id="vt-pw-cnt-ok">0</strong></button>
            <button class="vt-fbtn" data-pwf="new" onclick="vtPwFilter('new')"><span class="vt-dot dot-gr"></span> Not tested <strong id="vt-pw-cnt-new">0</strong></button>
          </div>
          <div class="vt-spacer"></div>
          <div class="vt-seg" id="vt-pw-view"><button data-v="group" onclick="vtPwView('group')" title="One block per site">Group</button><button data-v="sort" onclick="vtPwView('sort')" title="One row per e-mail address, with the sites it administers; click a column to sort">Sort</button></div>
        </div>
        <div id="vt-pw-list"><span class="hint">Loading…</span></div>
        <div class="vt-tr-title">Other e-mail addresses <span class="hint">(added by hand, for example your own or a customer's)</span></div>
        <div class="vt-pw-add"><input type="email" id="vt-pw-new" placeholder="name@example.com" autocomplete="off" onkeydown="if(event.key==='Enter')vtPwAdd()"><button type="button" class="vt-btn primary" onclick="vtPwAdd()">Add address</button><span id="vt-pw-addmsg" class="hint"></span></div>
        <div id="vt-pw-custom"></div>
        <div class="hint" id="vt-pw-attr" style="margin-top:12px"></div>
      </div>
    </div>

    <div class="vt-tool-section" id="vtool-adminwatch">
      <div id="vt-aw-box"></div>
    </div>

    <div class="vt-tool-section" id="vtool-orphan">
      <div class="vt-rel" id="vt-rel">
        <h3>Orphan databases <span class="vt-rel-cnt" id="vt-rel-cnt"></span></h3>
        <p class="hint">WordPress databases on this server for a hostname under one of your domains that doesn&rsquo;t exist in DNS:
          usually old copies, test or staging sites. Nobody can visit them, but VirusTotal often still lists them, sometimes as infected,
          and an old, never-updated copy is an easy target. <strong>Scan with ClamAV</strong> checks the data for known malware
          (injected scripts, spam links, web shells): a temporary dump is made in a root-only folder, scanned and deleted again right after.
          If the copy is no longer needed: click <strong>Back up</strong> (a <code>.sql.gz</code> copy in the subscription&rsquo;s <code>private/vt-db-backups</code> folder),
          then delete it in Plesk. Stingy Scanner never deletes a database or a backup itself. Click a column heading to sort.</p>
        <div class="vt-orph-bar">
          <input type="search" id="vt-orph-q" class="vt-orph-q" placeholder="Search domain, database, prefix or subscription&hellip;" oninput="vtOrphanFilter()" aria-label="Search orphan databases">
          <span class="hint" id="vt-orph-shown"></span>
        </div>
        <div class="vt-tbl-wrap">
          <table class="vt-orph-tbl">
            <thead>
              <tr id="vt-orph-head">
                <th data-ocol="domain">Domain</th>
                <th data-ocol="db">Database</th>
                <th data-ocol="tables" class="num">Tables</th>
                <th data-ocol="size" class="num">Size</th>
                <th data-ocol="kind">Why orphan</th>
                <th data-ocol="clam">ClamAV</th>
                <th class="vt-orph-act">Actions</th>
              </tr>
            </thead>
            <tbody id="vt-tbody-rel"></tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="vt-tool-section" id="vtool-vendors">
      <div class="vt-card" style="max-width:100%">
        <h3 style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
          Vendor requests <span class="hint" style="font-weight:400" id="vt-vnd-sub"></span>
          <span style="flex:1"></span>
          <button class="vt-btn ghost" onclick="vtVendorsRender()">Refresh</button>
        </h3>
        <div class="hint" style="margin-bottom:12px">Every security vendor that flags one or more of your sites. Click a site name to open its detail panel.
          Use <strong>Copy URLs</strong> to copy all flagged site addresses to the clipboard at once — handy for vendors whose form accepts multiple URLs (like <a href="https://threatcenter.crdf.fr/false_positive.html" target="_blank" rel="noopener">CRDF / Fortinet ↗</a>).</div>
        <div class="vt-tool-find"><input type="search" id="vt-vnd-q" placeholder="Search vendor or domain&hellip;" oninput="vtVendorsRender()" aria-label="Search vendors and domains"><span class="hint" id="vt-vnd-shown"></span></div>
        <div id="vt-vnd-box"><span class="hint">Loading…</span></div>
      </div>
    </div>

    <div class="vt-tool-section" id="vtool-log">
      <div class="vt-card" style="max-width:100%">
        <h3 style="display:flex;align-items:center;gap:10px">
          Scan Log
          <span style="font-size:11px;font-weight:400;color:var(--muted)" id="vt-log-meta"></span>
          <div style="flex:1"></div>
          <button class="vt-btn ghost" onclick="vtLoadLog()">Refresh</button>
          <button class="vt-btn danger" onclick="vtClearLog()" style="margin-left:4px">Clear log</button>
        </h3>
        <div class="vt-tool-find"><input type="search" id="vt-log-q" placeholder="Find in the log (domain, [db], error&hellip;)" oninput="vtLogFilter()" aria-label="Find in the scan log"><span class="hint" id="vt-log-shown"></span></div>
        <pre id="vt-log-pre" style="margin:0;padding:10px;background:var(--gray-bg);border:1px solid var(--border);border-radius:var(--radius);font-size:11px;line-height:1.6;overflow-x:auto;white-space:pre-wrap;max-height:600px;overflow-y:auto;color:var(--text)">Loading...</pre>
      </div>
    </div>

  </div><!-- end vtpanel-tools -->

  <!-- Settings -->
  <div class="vt-panel" id="vtpanel-settings">
    <nav class="vt-card vt-toc" id="vt-toc" aria-label="Settings sections">
      <div class="vt-toc-title">Settings</div>
      <div class="vt-toc-cols" id="vt-toc-cols"></div>
    </nav>
    <div class="vt-set-group" id="vt-grp-rep" data-toc-group="Reputation services"><h2>Reputation services</h2><span>Who checks the reputation of the sites</span></div>
    <div class="vt-card vt-settings-main" id="vt-set-vt" data-toc="VirusTotal">
      <div class="vt-settings-title vt-svc-head"><h3><img class="vt-brand-ico lg" src="<?= htmlspecialchars(($this->baseUrl ?: '') . 'images/brands/virustotal.png') ?>" alt="" width="32" height="32">VirusTotal</h3><span class="vt-key-state" id="vt-vt-keystate"></span><span class="hint">Primary website reputation service</span></div>
      <div class="vt-field">
        <label for="vt-s-apikey">API Key</label>
        <input type="text" id="vt-s-apikey" placeholder="Paste your VirusTotal API key here..." autocomplete="off" spellcheck="false">
        <div class="hint">Get your free key at virustotal.com &rarr; Profile &rarr; API key</div>
        <div class="vt-key-display" id="vt-key-display">
          <div class="vt-key-label">Stored key</div>
          <div id="vt-key-value">—</div>
        </div>
      </div>
      <section class="vt-settings-usage" aria-label="VirusTotal daily API budget and usage today">
        <div class="vt-usage-heading"><strong>Daily API budget</strong><span>today: <span id="vts-date">—</span></span></div>
        <div class="vt-qs-today">
          <span class="big" id="vts-total">—</span><span class="lbl">VirusTotal calls made today</span>
          <span class="parts"><span><i class="vt-qs-sw auto"></i> background <strong id="vts-auto-label">—</strong></span>
            <span><i class="vt-qs-sw manual"></i> manual rescans <strong id="vts-manual-label">—</strong></span></span>
        </div>
        <div class="vt-settings-numbers" style="margin:0 0 16px">
          <div class="vt-field">
            <label for="vt-s-daily">Max calls / day</label>
            <input type="number" id="vt-s-daily" min="1" max="1000000" step="10" value="500">
          </div>
          <div class="vt-field wide"><label>&nbsp;</label><div class="hint" style="padding-top:8px">500 = free tier &nbsp;|&nbsp; more needs a premium key</div></div>
        </div>
        <div class="vt-sl" id="vt-sl-split">
          <div class="vt-sl-track" id="vt-sl-split-track">
            <div class="vt-sl-part auto" id="vt-sl-auto"><div class="vt-sl-used" id="vt-sl-auto-used" title="Background calls made today"></div>
              <div class="vt-sl-name"><span>Background scan</span><strong id="vt-sl-auto-val">—</strong></div></div>
            <div class="vt-sl-part manual" id="vt-sl-manual"><div class="vt-sl-used" id="vt-sl-manual-used" title="Manual rescans made today"></div>
              <div class="vt-sl-name" title="Reserved for manual scans (%)"><span>Reserved for manual scans</span><strong id="vt-sl-manual-val">—</strong></div></div>
          </div>
          <div class="vt-sl-knob split" id="vt-sl-split-knob" role="slider" tabindex="0" aria-label="Reserved for manual scans (%)" title="Drag: reserved for manual scans (%)"></div>
        </div>
        <div class="vt-sl-scale"><span style="left:0">0%</span><span style="left:25%">25%</span><span style="left:50%">50%</span><span style="left:75%">75%</span><span style="left:100%">100%</span></div>
        <div class="vt-qs-legend">
          <label for="vt-s-manual-pct">Reserved for manual scans <input type="number" id="vt-s-manual-pct" min="5" max="90" step="1" value="20"> %</label>
          <span><i class="vt-qs-sw used"></i>used today</span>
        </div>
        <input type="hidden" id="vt-s-share" value="80">
        <div class="hint" style="margin-top:6px">Drag the black line: what is left of it is for the nightly background scan, what is right of it is kept for manual rescans.</div>
      </section>
      <div class="vt-settings-numbers">
        <div class="vt-field">
          <label for="vt-s-clean-ttl">Cache clean sites (days)</label>
          <input type="number" id="vt-s-clean-ttl" min="1" max="365" value="30">
        </div>
        <div class="vt-field">
          <label for="vt-s-inf-ttl">Cache infected sites (days)</label>
          <input type="number" id="vt-s-inf-ttl" min="1" max="30" value="1">
        </div>
      </div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
        <span class="vt-smsg" id="vt-smsg"></span>
      </div>
    </div>

    <div class="vt-card" id="vt-gsb-card" style="display:none" data-toc="Google Safe Browsing">
      <div class="vt-settings-title"><h3>Google Safe Browsing</h3><span class="hint">Official Google API &middot; optional</span></div>
      <div class="vt-provider-list" style="margin-top:0">
        <div class="vt-provider vt-svc google" style="margin-top:0">
          <label class="vt-radio"><input type="checkbox" id="vt-gsb-on"><span class="vt-av-title"><strong><img class="vt-brand-ico lg" src="<?= htmlspecialchars(($this->baseUrl ?: '') . 'images/brands/google.png') ?>" alt="" width="32" height="32">Google Safe Browsing <span class="vt-key-state" id="vt-gsb-keystate"></span></strong><small>Google's list of unsafe sites, used by Chrome, Firefox and Safari to warn visitors</small></span></label>
          <span class="vt-av-calls"><strong id="vt-gsb-calls">0</strong>calls today</span>
          <label class="vt-rate" for="vt-rate-google"><input type="number" id="vt-rate-google" min="1" max="5" step="1" value="2" data-check-rate="google" aria-label="Google requests per minute"> / minute</label>
          <div class="vt-gsb-key"><label for="vt-gsb-key">API key</label><input type="password" id="vt-gsb-key" placeholder="Paste a new Google API key to replace the stored one" autocomplete="off" spellcheck="false"><span id="vt-gsb-stored">no key stored</span></div>
          <span class="hint">Every site is checked each night (up to 250 per request), and live when you open its details or rescan it. Adds no VirusTotal API usage.</span>
        </div>
      </div>
      <details class="vt-gsb-help" style="margin-top:12px">
        <summary><strong>How to get an API key</strong> (Google Cloud Console, free)</summary>
        <ol class="vt-why-steps">
          <li>Open or create a project in the <a href="https://console.cloud.google.com/projectselector2/home/dashboard" target="_blank" rel="noopener">Google Cloud Console &#8599;</a>.</li>
          <li>Enable the API: <a href="https://console.cloud.google.com/apis/library/safebrowsing.googleapis.com" target="_blank" rel="noopener">Safe Browsing API &rarr; Enable &#8599;</a>.</li>
          <li>Create the key: <a href="https://console.cloud.google.com/apis/credentials" target="_blank" rel="noopener">APIs &amp; Services &rarr; Credentials &#8599;</a> &rarr; <em>+ Create credentials</em> &rarr; <em>API key</em>.</li>
          <li>Restrict it (Edit API key): <em>API restrictions</em> &rarr; only <strong>Safe Browsing API</strong>; <em>Application restrictions</em> &rarr; <strong>IP addresses</strong> &rarr; this server's outgoing IP address.</li>
          <li>Paste the key above and click <strong>Save settings</strong>. It is tested with Google's own test page first; the green check shows it works.</li>
          <li>Usage and limits: <a href="https://console.cloud.google.com/apis/api/safebrowsing.googleapis.com/quotas" target="_blank" rel="noopener">Quotas &#8599;</a> and <a href="https://console.cloud.google.com/apis/api/safebrowsing.googleapis.com/metrics" target="_blank" rel="noopener">Metrics &#8599;</a> of the Safe Browsing API.</li>
        </ol>
        <div class="hint">Google allows the Safe Browsing API for <strong>non-commercial use only</strong>. Only the site addresses are sent; Google may use them to improve its services. A result is used for 30 minutes at most, then shown as <em>last known</em> and checked again.</div>
      </details>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
      </div>
    </div>

    <div class="vt-card vt-settings-experimental" id="vt-av-card" style="display:none" data-toc="AVG &amp; Avast">
      <div class="vt-settings-title"><h3>External reputation checks</h3><span class="vt-experimental-tag">Experimental</span></div>
      <p class="hint">Optional direct checks with AVG and Avast. Checks run when opening site details and after a rescan. Off by default.</p>
      <div class="vt-why-note" style="margin-top:6px"><strong>Experimental, undocumented endpoints.</strong> AVG and Avast do not offer a public API for these checks: Stingy Scanner asks the same reputation service their browser protection uses. That service is not documented or supported by Gen Digital, so it may change, give different answers, limit requests or stop working at any time, without notice. Use the results as a hint, not as proof; VirusTotal (which also includes AVG and Avast) stays the main source.</div>
      <div class="vt-provider-list">
        <div class="vt-provider vt-svc avg">
          <label class="vt-radio"><input type="checkbox" name="vt-av" value="147"><span class="vt-av-title"><strong><img class="vt-brand-ico lg" src="<?= htmlspecialchars(($this->baseUrl ?: '') . 'images/brands/avg.png') ?>" alt="" width="32" height="32">AVG Web Shield</strong><small>URL reputation of AVG AntiVirus and the AVG Online Security browser extension</small></span></label>
          <span class="vt-av-calls"><strong id="vt-av-calls-147">0</strong>calls today</span>
          <label class="vt-rate" for="vt-rate-avg"><input type="number" id="vt-rate-avg" min="1" max="5" step="1" value="2" data-check-rate="avg" aria-label="AVG requests per minute"> / minute</label>
          <span class="hint">The verdict an AVG user gets when opening the site, asked directly from AVG's reputation service. Adds no VirusTotal API usage.</span>
        </div>
        <div class="vt-provider vt-svc avast">
          <label class="vt-radio"><input type="checkbox" name="vt-av" value="146"><span class="vt-av-title"><strong><img class="vt-brand-ico lg" src="<?= htmlspecialchars(($this->baseUrl ?: '') . 'images/brands/avast.png') ?>" alt="" width="32" height="32">Avast Web Shield</strong><small>URL reputation of Avast Antivirus and the Avast Online Security &amp; Privacy browser extension</small></span></label>
          <span class="vt-av-calls"><strong id="vt-av-calls-146">0</strong>calls today</span>
          <label class="vt-rate" for="vt-rate-avast"><input type="number" id="vt-rate-avast" min="1" max="5" step="1" value="2" data-check-rate="avast" aria-label="Avast requests per minute"> / minute</label>
          <span class="hint">The verdict an Avast user gets when opening the site, asked directly from Avast's reputation service. Can be switched on separately from AVG.</span>
        </div>
      </div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
      </div>
    </div>

    <div class="vt-set-group" id="vt-grp-sites" data-toc-group="Sites"><h2>Sites</h2><span>Which sites are watched, and their admin accounts</span></div>
    <div class="vt-card" id="vt-set-access" style="display:none" data-toc="Access for resellers and customers">
      <h3>Access for resellers and customers</h3>
      <label class="vt-radio"><input type="checkbox" id="vt-acc-res"> <span><strong>Resellers can use Stingy Scanner</strong><br><span class="hint">For their own sites and their customers' sites: the entry in their Plesk menu, the page and the e-mails</span></span></label>
      <label class="vt-radio"><input type="checkbox" id="vt-acc-cl"> <span><strong>Customers can use Stingy Scanner</strong><br><span class="hint">For their own sites only: the entry in their Plesk menu (and the tab on their subscription), the page and the e-mails</span></span></label>
      <div class="hint" style="margin-top:6px">When switched off, the entry disappears from their menu and the page refuses them. The sites are still scanned; only you see the results. Plesk may need a page reload before the menu changes.</div>
      <div class="vt-save-row"><button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button></div>
    </div>

    <div class="vt-card" id="vt-set-scope" data-toc="Sites to scan">
      <h3>Sites to scan</h3>
      <label class="vt-radio"><input type="radio" name="vt-s-scope" id="vt-s-scope-all" value="all" checked>
        <span><strong>All hosted websites</strong><br><span class="hint">Every active domain and subdomain with web hosting, whatever it runs</span></span></label>
      <label class="vt-radio"><input type="radio" name="vt-s-scope" id="vt-s-scope-wp" value="wp">
        <span><strong>WordPress sites only</strong><br><span class="hint">Only sites with a WordPress database on this server</span></span></label>
    </div>

    <div class="vt-card" id="vt-ext-card" data-toc="Add custom not hosted domains">
      <div class="vt-settings-title"><h3>Add custom not hosted domains</h3><span class="hint">Sites hosted elsewhere, watched like the others</span></div>
      <div class="hint">Watch the reputation of a site hosted somewhere else. It is checked like the other sites by VirusTotal, Google Safe Browsing and Avast / AVG,
        and listed under Infected, Suspicious or Clean, marked <span class="vt-ext">External</span>. ClamAV, Maldet, Imunify and Pwned? do not apply: its files and accounts are not on this server.</div>
      <div class="vt-pw-add"><input type="text" id="vt-ext-new" placeholder="example.com" autocomplete="off" spellcheck="false" onkeydown="if(event.key==='Enter')vtExtAdd()"><button type="button" class="vt-btn primary" onclick="vtExtAdd()">Add site</button><span id="vt-ext-msg" class="hint"></span></div>
      <div id="vt-ext-list"></div>
    </div>

    <div class="vt-card" id="vt-set-wp" data-toc="WordPress admin accounts">
      <h3>WordPress admin accounts</h3>
      <label class="vt-radio"><input type="checkbox" id="vt-s-rogue-scan">
        <span><strong>Scan for rogue WordPress admin accounts</strong><br>
        <span class="hint">Shows every account with admin rights in a site's details and flags suspicious ones. Only visible to the server administrator.</span></span></label>
      <label class="vt-radio"><input type="checkbox" id="vt-s-wp-delete">
        <span><strong>Show a Delete button for admin accounts</strong><br>
        <span class="hint">Off by default. When on, each account in a site's details gets a <em>Delete</em> button (click it twice to confirm); its posts and pages go to another admin of that site. Deleting cannot be undone: <em>Reset pwd</em> or <em>🛠 Fix</em> locks an account out without losing anything.</span></span></label>
      <div class="hint" style="margin-top:10px;font-size:12px;line-height:1.6">
        <strong>What makes an account suspected.</strong> Only a <strong>strong signal</strong> (red) marks an account <em>to review</em>:
        <ul style="margin:4px 0 0;padding-left:18px">
          <li><strong>A change in admin rights</strong> since the scan before (checked every hour; the first scan is the baseline): a new admin, an existing account made admin, admin rights through capabilities or a custom role instead of the administrator role, a new Multisite super admin, an admin's e-mail address changed, or a new application password. These show on <em>Dashboard → Admin changes</em> with <em>Approve</em> and <em>Explain</em>. Joomla, Drupal and the other systems in Pwned Admins are compared too.</li>
          <li><strong>A breached address</strong>: the e-mail address is in a known data breach, so a reused password may let an attacker in.</li>
          <li><strong>A new account</strong> (yellow): younger than 30 days.</li>
        </ul>
        <strong>Hints</strong> (grey) are not suspicious on their own, because many real admins have them: a generic username (<code>admin2</code>, <code>support</code>…), a free e-mail provider, an e-mail domain unrelated to the site, or admin rights on sites of other customers.
        A badge is a reason to investigate, not proof. Always check before deleting an account.
      </div>
      <div class="vt-settings-numbers" style="margin-top:12px">
        <div class="vt-field wide"><label for="vt-aw-trusted">Trusted admin addresses</label>
          <textarea id="vt-aw-trusted" rows="4" style="width:100%;font-family:inherit;font-size:13px;padding:6px 8px;border:1px solid var(--border);border-radius:5px" placeholder="you@your-agency.com&#10;@your-agency.com"></textarea>
          <div class="hint">One per line: an address, or <code>@domain</code> for everyone at that domain. Your own and your agencies' addresses: their admin changes are approved automatically, they are not flagged for being admin on sites of different customers, and they are left out of <em>Pwned Admins</em> (not shown, not checked; an address you added there by hand stays).</div></div>
      </div>
      <label class="vt-radio" style="margin-top:6px"><input type="checkbox" id="vt-aw-mail">
        <span><strong>E-mail me when admin rights change</strong><br><span class="hint">Once per change, to the notification address (or your Plesk address). Checked every hour.</span></span></label>
      <div class="hint" style="margin-top:8px;font-size:12px"><strong>Data breach check:</strong> each admin e-mail address is checked once against the breach service chosen under <a href="#vt-pwcfg-card" onclick="vtTocGo(event,'vt-pwcfg-card')">Breached admin accounts</a> (XposedOrNot, free, by default; or Have I Been Pwned with your own key). A red badge appears when an address was found in known breach data, with the breach names in the tooltip. The Pwned Admins tab lists every site's administrators at once.</div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
      </div>
    </div>

    <div class="vt-card" id="vt-pwcfg-card" style="display:none" data-toc="Breached admin accounts">
      <div class="vt-settings-title"><h3>Breached admin accounts</h3><span class="hint">The Pwned Admins tab &middot; optional</span></div>
      <div class="hint">Which service tests whether the e-mail addresses of the site administrators appear in a known data breach. Only the e-mail address is sent.
        Each address is tested once; addresses that were never tested are also tested in the background and each night.</div>
      <div class="vt-pwcfg-opts">
        <label class="vt-radio"><input type="radio" name="vt-pw-src" value=""><span><strong>Off</strong><br><span class="hint">Nothing is sent, and the Pwned Admins tab is hidden</span></span></label>
        <label class="vt-radio"><input type="radio" name="vt-pw-src" value="xon"><span><strong>XposedOrNot</strong> <span class="vt-pwcfg-tag">free</span><br><span class="hint">No key needed. About 25 addresses an hour and 90 a day; the rest is tested in the background.</span></span></label>
        <label class="vt-radio"><input type="radio" name="vt-pw-src" value="hibp"><span><strong>Have I Been Pwned</strong> <span class="vt-pwcfg-tag paid">own API key</span><br><span class="hint">Paid subscription; faster, with the full breach details. Get a key at <a href="https://haveibeenpwned.com/API/Key" target="_blank" rel="noopener">haveibeenpwned.com/API/Key &#8599;</a>.</span></span></label>
      </div>
      <div class="vt-settings-numbers" style="margin-top:6px">
        <div class="vt-field wide"><label for="vt-pw-key">Have I Been Pwned API key</label><input type="password" id="vt-pw-key" placeholder="Paste a key to replace the stored one" autocomplete="off" spellcheck="false" style="width:100%"><div class="hint" id="vt-pw-keyinfo">no key stored</div></div>
      </div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtPwSaveSrc()">Save</button>
        <span class="hint" id="vt-pw-srcmsg"></span>
      </div>
    </div>

    <div class="vt-set-group" id="vt-grp-server" data-toc-group="On this server"><h2>On this server</h2><span>File scanners and what they found</span></div>
    <div class="vt-card" id="vt-set-scanners" data-toc="File scanners">
      <h3 style="display:flex;align-items:center;gap:10px">Internal serverside file scanners
        <div style="flex:1"></div>
        <button class="vt-btn ghost" type="button" onclick="vtDetectScanners()" id="vt-sc-detect">Re-detect engines</button></h3>
      <div class="hint" style="margin-bottom:10px">A file scan uses one engine, chosen automatically: ClamAV when it is installed (with Maldet installed too, ClamAV already uses the Maldet signatures), otherwise Maldet if you enable it. File scans run one at a time and only when you click the button in a site's details. The rate limits how often a scan can start. Imunify only reads existing results.</div>
      <div id="vt-sc-list"><span class="hint">Loading…</span></div>
      <span class="vt-smsg" id="vt-sc-msg"></span>
      <div class="vt-save-row"><button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button><span class="hint">Scanner switches save immediately. Save settings to apply request limits.</span></div>
    </div>

    <div class="vt-card" id="vt-q-card" style="display:none" data-toc="Quarantine">
      <h3>Quarantine</h3>
      <div class="hint">Files you move to quarantine from a site's file scan are kept in <code>/var/lib/stingyscan/quarantine</code>, a folder only root can open. <strong>Restore</strong> in the site's details puts a file back; deleted files are gone for good.</div>
      <div id="vt-q-info" style="margin:12px 0;font-size:13px"></div>
      <div class="vt-settings-numbers">
        <div class="vt-field">
          <label for="vt-s-q-days">Delete quarantined files after (days)</label>
          <input type="number" id="vt-s-q-days" min="0" max="3650" value="30">
        </div>
      </div>
      <div class="hint">0 = keep them until you delete them. Checked every night.</div>
      <div id="vt-q-del" style="margin-top:14px"></div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
      </div>
    </div>

    <div class="vt-set-group" id="vt-grp-mail" data-toc-group="E-mail"><h2>E-mail</h2><span>What is sent, and from which address</span></div>
    <div class="vt-card" id="vt-set-notify" data-toc="Notifications">
      <h3>Notifications</h3>
      <label class="vt-radio"><input type="checkbox" id="vt-n-enabled" onchange="vtNotifyUi()">
        <span><strong>E-mail me when a site's status changes</strong><br><span class="hint">One summary with the changes and all infected sites</span></span></label>
      <div id="vt-n-opts">
        <div class="vt-n-group">
          <div class="vt-n-label">When a site becomes</div>
          <label class="vt-check"><input type="checkbox" name="vt-n-ev" value="infected"> <span class="vt-dot dot-r"></span> Infected</label>
          <label class="vt-check"><input type="checkbox" name="vt-n-ev" value="suspicious"> <span class="vt-dot dot-y"></span> Suspicious</label>
          <label class="vt-check"><input type="checkbox" name="vt-n-ev" value="clean"> <span class="vt-dot dot-g"></span> Clean again <span class="hint">(after being infected or suspicious)</span></label>
        </div>
        <div class="vt-n-group">
          <div class="vt-n-label">Send to</div>
          <input type="email" id="vt-n-email" class="vt-n-email" placeholder="" autocomplete="email">
          <div class="hint" style="margin-top:4px">One address. Leave empty to use the address of your Plesk account.</div>
        </div>
        <div class="vt-n-group hint" style="font-size:12px;line-height:1.5">
          You get <strong>one summary e-mail</strong> with the status changes and the full list of your infected sites:
          after the nightly scan, and during the day 10 minutes after a change (so several changes share one e-mail).
        </div>
        <button class="vt-btn ghost" type="button" onclick="vtTestNotify()">Send test e-mail</button>
        <span class="vt-smsg" id="vt-n-msg"></span>
      </div>
      <div id="vt-pn-box" style="display:none;margin-top:14px;padding-top:12px;border-top:1px solid var(--border)">
        <div class="vt-n-label"><strong>Plesk notifications</strong> <span class="hint">(the bell at the top of Plesk, for the administrator)</span></div>
        <label class="vt-check"><input type="checkbox" name="vt-pn" value="infected"> <span class="vt-dot dot-r"></span> A site became infected</label>
        <label class="vt-check"><input type="checkbox" name="vt-pn" value="suspicious"> <span class="vt-dot dot-y"></span> A site became suspicious</label>
        <label class="vt-check"><input type="checkbox" name="vt-pn" value="clean"> <span class="vt-dot dot-g"></span> A site is clean again</label>
        <label class="vt-check"><input type="checkbox" name="vt-pn" value="admin_change"> Admin rights changed on a site <span class="hint">(Tools → Admin changes)</span></label>
        <div class="hint" style="margin:4px 0 8px">Several status changes are combined into one notification, within 5 minutes. Plesk can also switch each kind off: <em>Tools &amp; Settings → Notifications → Panel</em>.</div>
        <button class="vt-btn ghost" type="button" onclick="vtPanelTest(this)">Send a test notification</button>
      </div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
        <span class="vt-smsg" id="vt-smsg2"></span>
      </div>
    </div>

    <div class="vt-card" id="vt-set-review" data-toc="Review requests">
      <h3>Review requests to vendors</h3>
      <div class="hint" style="margin-bottom:10px">Who signs a review request. Filled in on the vendor forms that allow it (AVG, Fortinet) and used in the ready-made texts behind <strong>📋 text</strong> next to every <em>request a review</em>. Only sent when you open a vendor's form and send it yourself.</div>
      <div class="vt-settings-numbers">
        <div class="vt-field"><label for="vt-rv-name">Your name</label><input type="text" id="vt-rv-name" maxlength="100" placeholder="First and last name"></div>
        <div class="vt-field"><label for="vt-rv-company">Company</label><input type="text" id="vt-rv-company" maxlength="100" placeholder="Your hosting company or agency"></div>
        <div class="vt-field"><label for="vt-rv-email">E-mail address</label><input type="email" id="vt-rv-email" maxlength="200" placeholder="the notification address"></div>
      </div>
      <div class="vt-save-row"><button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button></div>
    </div>

    <div class="vt-card" id="vt-ms-card" style="display:none" data-toc="E-mail sender">
      <h3>E-mail sender</h3>
      <div class="hint">The address every e-mail of Stingy Scanner is sent from: the Pwned? warnings to site administrators and the status notifications.
        It is also used as the envelope sender, so receiving mail servers check SPF, DKIM and DMARC against this address. Empty = your Plesk administrator address<span id="vt-ms-default"></span>.</div>
      <div class="vt-settings-numbers" style="margin-top:10px">
        <div class="vt-field wide"><label for="vt-ms-from">Sender address</label><input type="email" id="vt-ms-from" placeholder="webmaster@example.com" autocomplete="off" spellcheck="false" style="width:100%"></div>
        <div class="vt-field" style="grid-column:span 4"><label for="vt-ms-name">Sender name</label><input type="text" id="vt-ms-name" placeholder="Company name in Plesk" maxlength="100" style="width:100%"></div>
      </div>
      <div class="vt-pw-add"><button type="button" class="vt-btn" onclick="vtMsCheck()">Check SPF, DKIM and DMARC</button>
        <input type="email" id="vt-ms-testto" placeholder="send a test to…" autocomplete="off"><button type="button" class="vt-btn ghost" onclick="vtMsTest()">Send test</button>
        <span class="hint">check and test use the saved address; save first</span></div>
      <div id="vt-ms-result"></div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
      </div>
    </div>

    <div class="vt-set-group" id="vt-grp-maint" data-toc-group="Maintenance"><h2>Maintenance</h2><span>Housekeeping</span></div>
    <div class="vt-card" id="vt-stats-card" style="display:none" data-toc="Talk to mama (statistics)">
      <h3>Installation statistics</h3>
      <label class="vt-radio"><input type="checkbox" id="vt-stats-share">
        <span><strong>Talk to mama: Share installation statistics</strong><br>
        <span class="hint">Off by default; nothing is sent until you tick this and save. When on, StingyScan sends your server’s hostname, StingyScan version, number of hosted websites, and a random installation ID
          to stats.digizaal.nl once a week. Digizaal uses this information to count active installations and understand which versions and hosting sizes it supports.
          Individual server details are visible to Digizaal. You can turn sharing off again at any time: untick this and save. StingyScan does not send hosted domain names, customer information, API keys, or scan results.</span></span></label>
      <div class="vt-stats-info" id="vt-stats-info"></div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
      </div>
    </div>

    <div class="vt-card" id="vt-lr-card" style="display:none" data-toc="Log rotation">
      <h3>Log rotation</h3>
      <div class="hint">Keeps the scan logs small. A log larger than the limit is compressed to an old copy and a new log is started. Server-wide; checked every 5 minutes.</div>
      <div class="vt-settings-numbers">
        <div class="vt-field">
          <label for="vt-s-log-mb">Rotate above (MB)</label>
          <input type="number" id="vt-s-log-mb" min="1" max="100" value="5">
        </div>
        <div class="vt-field">
          <label for="vt-s-log-keep">Old copies to keep</label>
          <input type="number" id="vt-s-log-keep" min="1" max="30" value="5">
        </div>
        <div class="vt-field">
          <label for="vt-s-log-days">Delete copies after (days)</label>
          <input type="number" id="vt-s-log-days" min="1" max="365" value="90">
        </div>
      </div>
      <div class="hint" id="vt-lr-info" style="margin-top:10px"></div>
      <div class="vt-save-row">
        <button class="vt-btn primary" onclick="vtSaveSettings()">Save settings</button>
      </div>
    </div>


  </div>

  <!-- About -->
  <div class="vt-panel" id="vtpanel-about">
    <div class="vt-about">
      <div class="vt-card vt-about-hero">
        <img class="vt-about-logo" src="<?= htmlspecialchars(($this->baseUrl ?: '') . 'images/logo-128.png') ?>" alt="" width="64" height="64">
        <div>
          <h3 style="margin:0 0 4px">Why Stingy Scanner exists</h3>
          <div class="vt-about-sub">A reputation scanner, and a helper to win a site's good name back</div>
          <p><strong>What happens when a WordPress administrator is pwned.</strong> Passwords from old data breaches are traded by the billion,
          and bots try them on every WordPress login page. When an administrator once used the same password elsewhere, the attacker simply logs in.
          The site gets infected, and its reputation goes down fast: it lands on the blocklists of security vendors, and the
          web shields that people buy or get with their computer (antivirus suites, browser protection, Chrome and Firefox warnings) block it for every visitor.
          Even your e-mail suffers: a message can be refused or sent to spam only because it mentions your website, which is now listed as a malware site.
          And one hacked site can drag down the server's IP address and every other site on it.</p>
          <p><strong>What this tool does about it.</strong> Stingy Scanner shows the damage to a site's reputation as soon as it happens, and helps you get delisted again
          after cleaning: which vendors flag the site, a review request per vendor, and the history until every one of them has removed it.
          It also watches the cause: whether an administrator's e-mail address appears in a known data breach (<a onclick="vtOpenPwned(event)" style="cursor:pointer">Pwned?</a>),
          and whether a site has a rogue administrator account that an attacker added.</p>
          <p><strong>Free to run.</strong> Stingy Scanner is built for the free APIs of external services (VirusTotal, Google Safe Browsing, XposedOrNot),
          and spends their limited quota carefully, so it works completely free of charge. If they are installed on the server, it can also use
          the server's own malware scanners: Imunify, and the free open-source scanners Maldet and ClamAV.</p>
        </div>
      </div>

      <div class="vt-card">
        <h3>Who this tool is for</h3>
        <p>For hosting companies, agencies and server admins who look after <strong>more sites than VirusTotal's free API can check in a day</strong>.
        The free key allows 500 requests per day and 4 per minute. With 500 sites or more you can't check them all daily,
        and a simple scanner burns the whole quota before you get to the site you just cleaned up.</p>
        <ul class="vt-about-list">
          <li><strong>Every site gets its turn.</strong> The nightly scan picks up where it stopped, so all sites are checked in rotation, however many there are.</li>
          <li><strong>Quota left for you.</strong> Part of the daily budget is always kept for manual rescans, for the moment you need one.</li>
          <li><strong>No wasted calls.</strong> Results are cached: clean sites are re-checked after 30 days, infected or suspicious sites after 1 day.</li>
          <li><strong>One overview.</strong> All sites with their status on one page and on the Plesk Home page, so a flagged site stands out right away.</li>
        </ul>
      </div>

      <div class="vt-card">
        <h3>Cleaned, but still red?</h3>
        <p>The status in this extension comes from <strong>VirusTotal</strong>, not from the files on your server. VirusTotal shows what dozens of
        security vendors think of the site, and each vendor keeps its own blocklist. After you clean a site, it can stay
        <strong>infected</strong> or <strong>suspicious</strong> here for days or even weeks, until those vendors check it again and take it off their list.</p>
        <ul class="vt-about-list">
          <li><strong>Click the score</strong> (for example <em>8/92 · Why?</em>) to see which vendors flag the site, with a link per vendor to ask for a review.</li>
          <li><strong>Click Rescan</strong> after cleaning. VirusTotal then asks all vendors again; the ones that find nothing turn clean right away.</li>
          <li><strong>Ask the rest for a review</strong>, and for Chrome warnings use Google Search Console. Then rescan again after a few days.</li>
        </ul>
        <p class="hint">Before asking for a review, make sure the site is really clean and safe: updates installed, unused plugins removed and all passwords changed. Otherwise it is soon hacked again and listed again.</p>
      </div>

      <div class="vt-card">
        <h3>Help and support</h3>
        <p>Questions, a problem or an idea? The Stingy Scanner page has the answers to common questions and how to reach Digizaal.</p>
        <a class="vt-btn ghost" href="https://www.digizaal.nl/stingy-scanner/#support" target="_blank" rel="noopener">Support &rarr;</a>
        <a class="vt-btn ghost" href="https://www.digizaal.nl/stingy-scanner/privacy/" target="_blank" rel="noopener">Privacy policy &rarr;</a>
      </div>

      <div class="vt-card">
        <h3>What's new</h3>
        <p>You are using version <strong><?= htmlspecialchars($this->version ?: '?') ?></strong>. See what changed in this version and in every version before it.</p>
        <a class="vt-btn ghost" href="https://github.com/dzaal/StingyScan-for-Plesk/releases/latest" target="_blank" rel="noopener">Latest changes &rarr;</a>
        <a class="vt-btn ghost" href="https://github.com/dzaal/StingyScan-for-Plesk/blob/main/CHANGELOG.md" target="_blank" rel="noopener">All versions &rarr;</a>
      </div>

      <div class="vt-card">
        <h3>License and trademarks</h3>
        <p>&copy; 2026 Dirk Zaal, trading as Digizaal. All rights reserved. Stingy Scanner, its code, design and the way it works, is the intellectual property of Dirk Zaal. You may install and use it exactly as published, free of charge; changing or distributing it needs written permission. <a href="https://github.com/dzaal/StingyScan-for-Plesk/blob/main/LICENSE" target="_blank" rel="noopener">License &rarr;</a></p>
        <p class="hint">Stingy Scanner is an independent product. It is not affiliated with, endorsed or sponsored by VirusTotal, Google, Gen Digital (AVG, Avast), WebPros (Plesk) or the makers of the file scanners. VirusTotal, Google Safe Browsing and Chrome are trademarks of Google LLC; AVG and Avast of Gen Digital Inc.; Plesk of WebPros International GmbH; WordPress of the WordPress Foundation; ClamAV of Cisco Systems, Inc.; Imunify360 and ImunifyAV of CloudLinux Software, Inc. All other names and logos belong to their respective owners and are used only to identify their services. <a href="https://github.com/dzaal/StingyScan-for-Plesk#trademarks" target="_blank" rel="noopener">All trademarks &rarr;</a></p>
      </div>

      <div class="vt-card vt-coffee">
        <div class="vt-coffee-cup" aria-hidden="true">&#9749;</div>
        <div style="flex:1">
          <h3 style="margin:0 0 4px">Buy me a cup of coffee</h3>
          <p style="margin:0">Stingy Scanner is free. If it saves you time or catches a hacked site, a coffee is a nice way to say thanks.</p>
        </div>
        <?php if ($this->paypalUrl): ?>
          <a class="vt-paypal" href="<?= htmlspecialchars($this->paypalUrl) ?>" target="_blank" rel="noopener">
            <span class="vt-paypal-pp">Pay<b>Pal</b></span> Buy me a coffee &middot; $3
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div><!-- #vt-wrap -->

<div class="vt-toasts" id="vt-toasts"></div>


<script>
// Opened inside a Plesk frame (e.g. a custom button with "Open URL in Plesk"):
// that nests a second Plesk UI, so notifications appear twice. Break out.
try{ if(window.top!==window && top.location.origin===location.origin) top.location.replace(location.href); }catch(e){}
(function(){
const BASE = <?= json_encode($this->baseUrl ?: '') ?> || location.pathname;
const BRAND_IMG = <?= json_encode(($this->baseUrl ?: '') . 'images/brands/') ?>;
const BRAND_ICO = {clamav:1,maldet:1,imunify:1,virustotal:1,avast:1,avg:1,google:1,146:'avast',147:'avg'};
/** 20px favicon of a scanner or reputation service, or '' when there is none */
function vtBrandIco(id){const k=BRAND_ICO[id]; if(!k) return ''; return '<img class="vt-brand-ico" src="'+BRAND_IMG+(k===1?id:k)+'.png" alt="" width="20" height="20">';}

// Keep --vt-header-h in sync so the fixed Scan Monitor panel starts right below the app header
function vtSyncHeaderH(){
  const brand=document.querySelector('.vt-brand');
  const banner=document.getElementById('vt-update-banner');
  const h=(brand?brand.offsetHeight:56)+((banner&&banner.offsetHeight>0)?banner.offsetHeight:0);
  document.documentElement.style.setProperty('--vt-header-h',h+'px');
}
window.addEventListener('resize',vtSyncHeaderH);
document.addEventListener('DOMContentLoaded',vtSyncHeaderH);

let domains=[], results={}, budget={}, activeFilter='all', gsb={enabled:false};
let scanners=[], scans={}, fsOpen={}, fsFull={}, reviews={}, histSites=new Set(), siteHist={}, avast={products:[]}, dbScanOk=false, alertIds={}, myEmail='', reviewFrom={name:'',company:''}; // file scanners: installed list, results per site, open panel per site
let scanQueue=[], inFlight=0;
const MAX_C=1;          // one at a time to stay within VT rate limits
const PUMP_DELAY=15500; // 15.5s between requests = safe for 4 req/min free tier
const MAX_PUMP=10;      // max domains to auto-scan per page load (cron handles bulk)
const LABELS={
  infected:'Infected',suspicious:'Suspicious',clean:'Clean',
  loading:'Loading',pending:'Queued',error:'Error',
  ratelimit:'Rate limit',quota_exceeded:'Quota exceeded',budget_exceeded:'Daily limit',
  scanning:'Scanning...',waiting:'VT processing...',nokey:'Needs API key',unchecked:'Not checked'
};
let external=[], extSet=new Set(), extAsk=null; // sites not hosted on this server, added by hand
let related=[], relSet=new Set(), orphans={}, owners={}, grpClosed=new Set(); // hostnames from WordPress databases that are not in DNS, and their databases
let noKey=false; // no (valid) VirusTotal API key: don't look anything up yet
const DOT_CLS={infected:'dot-r',suspicious:'dot-y',clean:'dot-g',pending:'dot-b'};
// Dangerous VT tags to highlight
const DANGER_TAGS=['malware','phishing','spam','ransomware','trojan','malicious','phishing-site','malware-site'];

// ── Init ──────────────────────────────────────────────────────
function vtLoadProgress(pct,msg){
  const bar=document.getElementById('vt-load-bar');
  if(!bar) return;
  if(msg) document.getElementById('vt-load-msg').textContent=msg;
  document.getElementById('vt-load-fill').style.width=Math.min(pct,100)+'%';
  document.getElementById('vt-load-pct').textContent=Math.min(pct,100)+'%';
  if(pct>=100) setTimeout(()=>bar.classList.add('vt-load-done'),500);
}

async function init(){
  // Phase 1 — fast: get domain list only, render table skeleton immediately
  vtLoadProgress(5,'Loading domain list…');
  const quick=await vtFetch('?action=domains-quick').catch(()=>({}));
  domains=quick.domains||[];
  budget=quick.budget||{};
  vtSet('vt-cnt-all',domains.length);
  updateBudget();
  for(const d of domains) if(!results[d]) results[d]={status:'loading',domain:d};
  vtSyncViewSeg();
  renderTable(); updateCounts();
  vtLoadProgress(30,`Found ${domains.length} domain${domains.length===1?'':'s'} — loading scan results…`);

  // Phase 2 — full data and settings in parallel
  vtBuildToc(); // show static settings TOC immediately while data loads
  const [data,cfg]=await Promise.all([
    vtFetch('?action=all').catch(()=>({})),
    vtFetch('?action=get-settings').catch(()=>({}))
  ]);
  external=data.external||[]; extSet=new Set(external.map(x=>x.domain)); vtRenderExternal();
  panelUrl=data.panel||{}; domains=data.domains||domains; related=data.related||[]; relSet=new Set(related); orphans=data.orphans||{}; owners=data.owners||{}; results=data.results||{};
  for(const d of related) if(!results[d]) results[d]={status:'unchecked',domain:d}; budget=data.budget||budget; scanners=data.scanners||[]; dbScanOk=!!data.dbscan; fileact=data.fileact||fileact; scans=data.scans||{}; reviews=data.reviews||{}; if(data.vendors?.vendors){ VENDORS=data.vendors.vendors; vendorSrc=data.vendors.source; } alertIds=data.alert_ids||{}; myEmail=data.my_email||''; reviewFrom=data.review_from||reviewFrom; histSites=new Set(data.history||[]); avast=data.avast||{products:[]}; gsb=data.gsb||{enabled:false};
  for(const d in scans) for(const id in scans[d]) if(fsBusy(d,id)) vtFsPoll(d,id);
  vtSet('vt-cnt-all',domains.length);
  vtSyncViewSeg();
  updateBudget(); renderTable(); updateCounts(); vtRenderExternal();
  vndLoaded=true; vtVendorsRender(); // the scan results are in: draw the vendor list (and its badges) now
  vtLoadProgress(100,'Ready');

  if(!cfg.has_key||cfg.api_key_invalid) document.getElementById('vt-api-warning').style.display='flex';
  loadSettingsForm(cfg); // also rebuilds TOC with dynamic sections
  vtAwLoad();
  if(!cfg.has_key||cfg.api_key_invalid){
    // Without a working key every lookup fails: show the sites as waiting for a key, not as errors
    noKey=true;
    for(const d of domains) if(!results[d]||results[d].status==='error') results[d]={status:'nokey',domain:d};
    scanQueue=[]; renderTable(); updateCounts();
    return;
  }

  // Auto-pump: only scan truly unseen domains (no cache at all) + errors
  // Cron handles bulk stale refresh; web UI just fills gaps
  scanQueue=domains
    .filter(d=>!results[d]||['error','ratelimit','pending'].includes(results[d].status))
    .slice(0, MAX_PUMP);
  renderTable(); updateCounts();
  pump();

  // Check server queue — show any domains queued from a previous browser session
  vtPollServerQueue().then(()=>{ if(serverQueue.length) startServerQueuePoll(); });
}
async function vtCheckUpdate(){
  try{
    const r=await vtFetch('?action=check-update');
    if(!r.update_available) return;
    const releaseLink='<a href="'+vtEsc(r.url)+'" target="_blank" rel="noopener">release notes</a>';
    let installBtn='';
    if(r.zip) installBtn='<button class="vt-update-btn" id="vt-update-install-btn" data-zip="'+vtEsc(r.zip)+'" data-ver="'+vtEsc(r.latest)+'" onclick="vtInstallUpdate(this.dataset.zip,this.dataset.ver)">Install v'+vtEsc(r.latest)+'</button>';
    document.getElementById('vt-update-msg').innerHTML=
      'Version <strong>v'+vtEsc(r.latest)+'</strong> is available (you have v'+vtEsc(r.current)+') — '+releaseLink+installBtn;
    document.getElementById('vt-update-banner').style.display='flex'; vtSyncHeaderH();
  }catch(e){}
}
window.vtInstallUpdate=async function(zip,ver){
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const btn=document.getElementById('vt-update-install-btn');
  btn.disabled=true; btn.innerHTML='<span class="vt-spin"></span> Installing…';
  const fail=(msg)=>{document.getElementById('vt-update-msg').textContent='Update failed: '+msg;};
  try{
    const res=await fetch(BASE+'?action=install-update',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams({version:ver})});
    const j=await res.json();
    if(!res.ok||!j.ok) throw new Error(j.error||'Could not start updater');
    document.getElementById('vt-update-msg').textContent='Downloading and installing v'+ver+'…';
    for(let i=0;i<150;i++){
      await new Promise(resolve=>setTimeout(resolve,2000));
      let status;
      try{status=await vtFetch('?action=update-status');}catch(e){continue;}
      if(status.state==='failed'||status.error) throw new Error(status.error||status.message||'Plesk rejected the update');
      if(status.state==='done'){
        const installed=await vtFetch('?action=check-update');
        if(installed.current!==ver) throw new Error('Plesk finished, but the installed version is '+installed.current+' instead of '+ver);
        location.reload(); return;
      }
    }
    throw new Error('Update has not finished. Reload to check the installed version.');
  }catch(e){fail(e.message||'Connection lost. Reload to check the installed version.');}
};

function isStale(d){
  if(!results[d]||!results[d].cached_at) return true;
  const st=results[d].status;
  if(st==='error'||st==='ratelimit') return true;
  const ttl=['infected','suspicious'].includes(st)?86400:30*86400;
  return (Date.now()/1000-results[d].cached_at)>ttl;
}

// ── Tabs ──────────────────────────────────────────────────────
window.vtShowTab=function(name){
  document.querySelectorAll('.vt-tab').forEach(t=>t.classList.remove('active'));
  document.querySelectorAll('.vt-panel').forEach(p=>p.classList.remove('active'));
  document.getElementById('vtab-'+name)?.classList.add('active');
  document.getElementById('vtpanel-'+name)?.classList.add('active');
  if(name==='settings'&&document.getElementById('vt-q-card').style.display!=='none')
    vtFetch('?action=quarantine-info').then(r=>{ if(r?.quarantine) vtRenderQuarantine(r.quarantine); }).catch(()=>{});
};

// ── Tools ──────────────────────────────────────────────────────
let currentTool=null;
window.vtToolSelect=function(name){
  currentTool=name;
  document.querySelectorAll('.vt-tool-card').forEach(c=>c.classList.remove('active'));
  document.querySelectorAll('.vt-tool-section').forEach(s=>s.classList.remove('active'));
  document.querySelectorAll('.vt-tools-nav-item').forEach(i=>i.classList.remove('active'));
  const nav=document.getElementById('vt-tools-nav');
  if(nav) nav.style.display=name?'':'none';
  document.getElementById('vt-tools-home').style.display=name?'none':'';
  if(!name) return;
  document.getElementById('vtcard-'+name)?.classList.add('active');
  document.getElementById('vtool-'+name)?.classList.add('active');
  document.getElementById('vtnav-'+name)?.classList.add('active');
  if(name==='pwned')      vtLoadPwned();
  if(name==='adminwatch') vtAwLoad();
  if(name==='vendors')    vtVendorsRender();
  if(name==='log')        vtLoadLog();
};
function vtToolsBadge(){
  const badge=document.getElementById('vt-tools-badge'); if(!badge) return;
  const awCount=aw?(aw.events||[]).filter(e=>!e.approved&&e.type!=='removed').length:0;
  if(awCount>0){ badge.textContent=awCount>9?'!':awCount; badge.style.display=''; }
  else badge.style.display='none';
}

// ── Vendors tool ──────────────────────────────────────────────
function vtVendorsBuild(){
  const map={};
  for(const domain of domains){
    const d=results[domain]||{};
    const st=d.status||'';
    const flags=d.flagged_by||[];
    const gThreats=gsb.enabled?(gsb.results?.[domain]?.threats||[]):[];
    const avHit=(avast.products||[]).some(pr=>(avast.results?.[domain]?.[pr.id]?.findings||[]).length);
    // Also a site that only Google or AVG / Avast flags (VirusTotal may call it clean)
    if(!flags.length&&!gThreats.length&&!avHit&&!['infected','suspicious'].includes(st)) continue;
    for(const s of flags){
      const i=s.indexOf(': ');
      const vendor=i>0?s.slice(0,i):s, verdict=i>0?s.slice(i+2):'';
      if(!map[vendor]) map[vendor]=[];
      map[vendor].push({domain,verdict,status:st});
    }
    // Google Safe Browsing
    if(gThreats.length){
      if(!map['Google Safe Browsing']) map['Google Safe Browsing']=[];
      map['Google Safe Browsing'].push({domain,verdict:gThreats.join(', '),status:st});
    }
    // AVG / Avast products
    for(const pr of (avast.products||[])){
      if((avast.results?.[domain]?.[pr.id]?.findings||[]).length){
        const vname=pr.name||pr.id;
        if(!map[vname]) map[vname]=[];
        // A finding is {classification: "URL:Botnet", detection: "URF9C…-0200", raw}: show it as in the site list
        const fs=avast.results[domain][pr.id].findings;
        const verdict=fs.map(f=>typeof f==='string'?f:String(f.classification||f.raw||'flagged').replace(/^URL:/,'')+(f.detection?' ('+f.detection+')':'')).join(', ');
        map[vname].push({domain,verdict:verdict||'flagged',status:st});
      }
    }
  }
  return map;
}
let vndLoaded=false; // true once the scan results of all sites are loaded
window.vtVendorsRender=vtVendorsRender; // called from the search box and the Refresh button
function vtVendorsRender(){
  const box=document.getElementById('vt-vnd-box'), sub=document.getElementById('vt-vnd-sub');
  if(!box) return;
  const map=vtVendorsBuild();
  const vendors=Object.keys(map).sort((a,b)=>map[b].length-map[a].length||a.localeCompare(b));
  const tb=document.getElementById('vttb-vendors'), nb=document.getElementById('vtnb-vendors');
  if(vendors.length){
    if(tb){tb.textContent=vendors.length;tb.style.display='';}
    if(nb){nb.textContent=vendors.length;nb.style.display='';}
  } else {
    if(tb) tb.style.display='none';
    if(nb) nb.style.display='none';
  }
  const totalFlags=Object.values(map).reduce((s,a)=>s+a.length,0);
  if(sub) sub.textContent=vendors.length?vendors.length+' vendor'+(vendors.length===1?'':'s')+', '+totalFlags+' flag'+(totalFlags===1?'':'s'):'no flags';
  if(!vndLoaded){ box.innerHTML='<p class="hint"><span class="vt-spin"></span> Loading the scan results…</p>'; if(sub) sub.textContent=''; return; }
  if(!vendors.length){ box.innerHTML='<p class="hint">No sites are currently flagged by any vendor.</p>'; return; }
  // Keyword search: every word must match the vendor name or the domain. A vendor that matches shows all its sites.
  const words=(document.getElementById('vt-vnd-q')?.value||'').trim().toLowerCase().split(/\s+/).filter(Boolean);
  const shownEl=document.getElementById('vt-vnd-shown');
  let h='<div class="vt-vnd-grid">', nV=0, nS=0;
  for(const vendor of vendors){
    const vl=vendor.toLowerCase();
    const sites=words.length?map[vendor].filter(x=>words.every(w=>vl.includes(w)||x.domain.toLowerCase().includes(w))):map[vendor];
    if(!sites.length) continue;
    nV++; nS+=sites.length;
    const k=vtFpKey(vendor), tip=k&&VENDORS[k].advice?VENDORS[k].advice:'';
    vndCopyLists[vendor]=sites.map(s=>s.domain); // the shown sites (search applied): copied one per line
    h+='<div class="vt-vnd-group">';
    // Header row
    h+='<div class="vt-vnd-head">'
      +'<span class="vt-vnd-name">'+vtEsc(vendor)+'</span>'
      +'<span class="vt-vnd-cnt">'+sites.length+' site'+(sites.length===1?'':'s')+'</span>'
      +'<div class="vt-vnd-actions">'
      +'<button class="vt-vnd-copy" data-vendor="'+vtEsc(vendor)+'" onclick="vtVndCopy(this)" title="Copy the domain names, one per line">Copy '+(sites.length>1?sites.length+' domain names':'domain name')+'</button>'
      +'</div></div>';
    // How to ask this vendor for a review: the steps, the vendor's own requirements, and what to do afterwards
    h+=vtVndHowTo(vendor,sites,tip);
    // Sites table — same columns as the Why? panel
    h+='<table class="vt-fs-tbl vt-why-tbl"><thead><tr><th style="width:200px">Site</th><th style="width:120px">Verdict</th><th>Ask for a review</th></tr></thead><tbody>';
    for(const {domain,verdict,status} of sites){
      const rev=reviews[domain]?.[vendor];
      const rowCls=rev?' class="asked'+(rev.confirmed_at?' confirmed':'')+'\"':'';
      h+='<tr'+rowCls+'>'
        +'<td><a class="vt-blue-link" onclick="vtVndOpenSite(\''+vtEsca(domain)+'\')">'+vtEsc(domain)+'</a>'
        +' <a href="#" class="vt-vnd-cp" data-copy="'+vtEsc(domain)+'" onclick="return vtCopyDomain(this)" title="Copy the domain name" aria-label="Copy the domain name">'+ICO.copy+'</a></td>'
        +'<td>'+vtEsc(verdict||status)+'</td>'
        +'<td>'+vtFpLink(vendor,domain,false)+'</td>'
        +'</tr>';
    }
    h+='</tbody></table></div>';
  }
  h+='</div>';
  if(shownEl) shownEl.textContent=words.length?nV+' vendor'+(nV===1?'':'s')+', '+nS+' site'+(nS===1?'':'s')+' match':'';
  box.innerHTML=nV?h:'<p class="hint">No vendor or site matches \u201c'+vtEsc(words.join(' '))+'\u201d.</p>';
}
function vtVndHowTo(vendor,sites,tip){
  const v=vtVendorOf(vendor), c=v?.form||'', mail=v?.method==='email', n=sites.length;
  const asked=sites.filter(x=>reviews[x.domain]?.[vendor]).length, done=sites.filter(x=>reviews[x.domain]?.[vendor]?.confirmed_at).length;
  let how;
  if(!c) how='<li>No review form is known for this vendor. Look on the vendor\'s website for a <em>false positive</em> or <em>dispute</em> form, or wait: some vendors clear a site by themselves.</li>';
  else if(mail) how='<li>Click <em>request a review ↗</em> next to a site: an e-mail to <strong>'+vtEsc(String(c).replace(/^mailto:/,'').split('?')[0])+'</strong> opens, already filled in with the site and the VirusTotal link. Check it and send it.</li>';
  else if(v.method==='prefill') how='<li>Click <em>request a review ↗</em> next to a site: the vendor\'s form opens <strong>already filled in</strong>'
    +(v.copy==='text'?', and the text for the description box is <strong>copied</strong>: paste it there':'')+'. Check it, '+(v.captcha?'pass the '+vtEsc(v.captcha)+' check ':'')+'and send it.</li>';
  else if(v.copy==='text') how='<li>Click <em>request a review ↗</em> next to a site: the vendor\'s form opens and the <strong>text for the description</strong> is copied: paste it there'
    +(v.account?' (log in or sign up first)':'')+'.</li>';
  else how='<li>Click <em>request a review ↗</em> next to a site: the vendor\'s form opens in a new tab and the site address is <strong>copied to your clipboard</strong>. Paste it into the form'
    +(n>1?' (or use <strong>Copy '+n+' URLs</strong> above if the form takes several addresses at once)':'')+'.</li>';
  return '<div class="vt-vnd-how"><div class="vt-vnd-how-h">How to ask '+vtEsc(vendor)+' for a review'
    +'<span class="vt-vnd-prog">'+asked+' of '+n+' requested'+(done?' · '+done+' delisting confirmed':'')+'</span></div><ol>'
    +'<li>Make sure the site is clean first (a file scan, the admin accounts): a vendor that finds the problem still there will refuse.</li>'
    +how
    +(tip?'<li><strong>What '+vtEsc(vendor)+' asks for:</strong> '+vtEsc(tip)+'</li>':'')
    +'<li>Stingy Scanner remembers the request (<em>✓ Requested</em>, with date and who). When the vendor answers, click <em>✓ delisting confirmed</em>, or <em>denied</em> with the reason.</li>'
    +'</ol></div>';
}
window.vtVndOpenSite=function(domain){
  // Switch to Overview tab, then open the site's Why? panel
  document.querySelectorAll('.vt-tab').forEach(t=>t.classList.remove('active'));
  document.querySelectorAll('.vt-panel').forEach(p=>p.classList.remove('active'));
  document.getElementById('vtab-overview')?.classList.add('active');
  document.getElementById('vtpanel-overview')?.classList.add('active');
  setTimeout(()=>vtFsOpen(domain),80);
};
const vndCopyLists={};
// Copy the domain names of a vendor, one per line, the same way as a single name (works inside the Plesk frame,
// where the clipboard API is often not allowed). Before, the list itself broke the button's onclick.
window.vtVndCopy=function(btn){
  const list=vndCopyLists[btn.dataset.vendor]||[], text=list.join('\n');
  const ok=()=>{const orig=btn.textContent; btn.textContent='✓ Copied '+list.length; btn.style.background='#dcfce7'; btn.style.color='#166534'; btn.style.borderColor='#4ade80';
    setTimeout(()=>{btn.textContent=orig; btn.style.cssText='';},2000);};
  if(vtCopyNow(text)) ok();
  else navigator.clipboard?.writeText(text).then(ok,()=>vtToast('Could not copy to the clipboard','err'));
};

// ── Scan pump ─────────────────────────────────────────────────
// Sequential with delay — stays within VT free tier (4 req/min).
// Manual rescans bypass the pump entirely (they use vtReanalyzeSingle directly).
let pumpRunning=false, pumpCurrent=null, pumpPauseFrom=0, pumpPauseUntil=0, pumpPauseLimit=false;
async function pump(){
  if(pumpRunning) return;
  pumpRunning=true;
  while(scanQueue.length){
    const d=scanQueue.shift();
    const st=results[d]?.status;
    if(activeJob(d)) continue; // being manually rescanned
    if(st&&st!=='error'&&st!=='ratelimit'&&st!=='quota_exceeded'&&st!=='pending') continue; // already has a valid result
    inFlight=1; pumpCurrent=d;
    const prev=results[d]||null, t0=Date.now();
    updateProgress();
    try{
      const data=await withVtSlot(()=>vtFetch('?action=scan&domain='+encodeURIComponent(d)));
      if(data.status==='ratelimit'){
        // Per-minute limit (shared with manual rescans): wait it out and retry
        scanQueue.unshift(d);
        const wait=Math.max(5,Number(data.wait||data.retry_after||60));
        inFlight=0; pumpCurrent=null; pumpPauseFrom=Date.now(); pumpPauseUntil=pumpPauseFrom+wait*1000; pumpPauseLimit=true; updateProgress();
        await delay(wait*1000);
        pumpPauseUntil=0; pumpPauseLimit=false;
        continue;
      }
      results[d]=data; updateRow(d,data); updateCounts();
      logAutoJob(d,prev,data,t0);
      if(data.status==='quota_exceeded'){ scanQueue=[]; inFlight=0; pumpCurrent=null; renderTable(); updateCounts(); break; }
      // Bump counters locally — no extra server round-trip needed
      if(data.status!=='error'){ budget.auto_used=(budget.auto_used??0)+1; budget.vt_quota_used=(budget.vt_quota_used??0)+1; updateBudget(); }
    }catch(e){
      results[d]={status:'error',domain:d}; updateRow(d,results[d]);
      logAutoJob(d,prev,results[d],t0);
    }
    inFlight=0; pumpCurrent=null;
    updateProgress(); updateCounts();
    if(scanQueue.length){ // respect 4 req/min limit
      pumpPauseFrom=Date.now(); pumpPauseUntil=pumpPauseFrom+PUMP_DELAY; pumpPauseLimit=false; renderQueue();
      await delay(PUMP_DELAY);
      pumpPauseUntil=0;
    }
  }
  pumpRunning=false; pumpCurrent=null;
  updateProgress();
}

function updateProgress(){
  const remaining=scanQueue.length+inFlight;
  const loaded=domains.filter(d=>results[d]&&!['loading','scanning','waiting'].includes(results[d].status)).length;
  document.getElementById('vt-prog').style.width=(domains.length?loaded/domains.length*100:0)+'%';
  document.getElementById('vt-scan-status').textContent=remaining>0?('Loading: '+remaining+' remaining...'):(domains.length?'All loaded':'');
  renderQueue();
}

// ── Budget ────────────────────────────────────────────────────
function updateBudget(){
  if(!budget.auto_max) return;
  const au=budget.auto_used??0, am=budget.auto_max;
  const mu=budget.manual_used??0, mm=budget.manual_max;
  vtSet('vt-auto-num',    au);
  vtSet('vt-auto-sub',    'of '+am);
  vtSet('vt-manual-num',  mm-mu);
  vtSet('vt-manual-sub',  'of '+mm);
  vtSet('vt-daily-total', am+mm);
  vtSet('vt-budget-date', budget.date??'—');
  vtRing('vt-auto-ring',   Math.round(au/am*100));
  vtRing('vt-manual-ring', Math.round((mm-mu)/mm*100));
  const qused=budget.vt_quota_used??0;
  vtSet('vt-quota-num', qused);
  vtSet('vt-quota-sub', 'of 500');
  vtRing('vt-quota-ring', Math.round(qused/500*100));
  vtSet('vts-auto-label',   au+' / '+am);
  vtSet('vts-manual-label', mu+' / '+mm);
  vtSet('vts-date', budget.date??'—');
  vtQsRender();
}

// ── VirusTotal daily budget (Settings) ─────────────────────────
// Max calls per day is a number field. The slider sets the share reserved for manual rescans; the rest
// is for the background scan. Each coloured range shows in orange how much of it was used today.
function vtQsVals(){
  const lim=Math.max(1,parseInt(document.getElementById('vt-s-daily').value)||500);
  const share=Math.min(95,Math.max(10,parseInt(document.getElementById('vt-s-share').value)||80));
  return {lim,share};
}
function vtQsRender(){
  if(!document.getElementById('vt-sl-split')) return;
  const {lim,share}=vtQsVals(), man=100-share, clamp=v=>Math.min(100,Math.max(0,v));
  const am=Math.floor(lim*share/100), mm=lim-am, au=budget.auto_used??0, mu=budget.manual_used??0;
  const st=(id,o)=>Object.assign(document.getElementById(id).style,o), on=(id,b)=>document.getElementById(id).classList.toggle('on',b);
  const n=x=>Number(x).toLocaleString('en-US');
  st('vt-sl-auto',{width:share+'%'}); st('vt-sl-manual',{left:share+'%',width:man+'%'});
  st('vt-sl-auto-used',{width:clamp(am?au/am*100:0)+'%'}); on('vt-sl-auto-used',au>0);
  st('vt-sl-manual-used',{width:clamp(mm?mu/mm*100:0)+'%'}); on('vt-sl-manual-used',mu>0);
  st('vt-sl-split-knob',{left:share+'%'});
  vtSet('vt-sl-auto-val',n(au)+' / '+n(am)+' used');
  vtSet('vt-sl-manual-val',man+'% · '+n(mu)+' / '+n(mm)+' used');
  vtSet('vts-total',n(au+mu)); vtSet('vts-auto-label',n(au)+' of '+n(am)); vtSet('vts-manual-label',n(mu)+' of '+n(mm));
  const mp=document.getElementById('vt-s-manual-pct'); if(document.activeElement!==mp) mp.value=man;
  const ks=document.getElementById('vt-sl-split-knob');
  ks.setAttribute('aria-valuemin',5); ks.setAttribute('aria-valuemax',90); ks.setAttribute('aria-valuenow',man);
}
(function vtQsInit(){
  if(!document.getElementById('vt-sl-split')) return;
  const share=document.getElementById('vt-s-share');
  const frac=x=>{const r=document.getElementById('vt-sl-split').getBoundingClientRect(); return Math.max(0,Math.min(1,(x-r.left)/r.width));};
  const setManual=p=>{share.value=100-Math.max(5,Math.min(90,Math.round(p))); vtQsRender();};
  const splitAt=x=>setManual(100-frac(x)*100), knob=document.getElementById('vt-sl-split-knob');
  const drag=el=>el.addEventListener('pointerdown',e=>{
    e.preventDefault(); e.stopPropagation();
    knob.focus(); knob.classList.add('drag'); el.setPointerCapture(e.pointerId); splitAt(e.clientX);
    const mv=ev=>splitAt(ev.clientX), up=()=>{knob.classList.remove('drag');el.removeEventListener('pointermove',mv);el.removeEventListener('pointerup',up);el.removeEventListener('pointercancel',up);};
    el.addEventListener('pointermove',mv); el.addEventListener('pointerup',up); el.addEventListener('pointercancel',up);
  });
  // Drag the line, or press anywhere on the bar and drag from there
  drag(knob); drag(document.getElementById('vt-sl-split-track'));
  knob.addEventListener('keydown',e=>{const d={ArrowLeft:-1,ArrowDown:-1,ArrowRight:1,ArrowUp:1}[e.key]; if(!d) return; e.preventDefault(); setManual(100-vtQsVals().share-d*(e.shiftKey?5:1));});
  document.getElementById('vt-s-daily').addEventListener('input',vtQsRender);
  const mp=document.getElementById('vt-s-manual-pct');
  mp.addEventListener('input',()=>{const v=parseInt(mp.value); if(v>=5&&v<=90){share.value=100-v; vtQsRender();}});
  mp.addEventListener('change',()=>setManual(parseInt(mp.value)||20));
  vtQsRender();
})();

function vtBar(id,pct){
  const el=document.getElementById(id);
  if(!el) return;
  el.style.width=pct+'%';
  el.className='vt-b-fill'+(pct>85?' crit':pct>65?' warn':'');
}
function vtRing(id,pct){
  const el=document.getElementById(id); if(!el) return;
  const p=Math.max(0,Math.min(100,pct));
  el.style.strokeDasharray=p+' 100';
  if(p>85) el.style.stroke='#dc2626'; else el.style.removeProperty('stroke');
}

// ── Table ─────────────────────────────────────────────────────
function vtBytes(n){n=+n||0;const u=['B','KB','MB','GB'];let i=0;while(n>=1024&&i<3){n/=1024;i++;}return (i?n.toFixed(1):n)+' '+u[i];}
const ORPHAN_KIND={
  database:['free','No WordPress install on this server uses this database'],
  tables:['part','Old tables inside a database a live site uses: delete only these tables, not the database'],
  inuse:['live','A WordPress install on disk uses these tables: check before deleting'],
  unknown:['live','Could not check whether a site uses it']
};
function orphanInfoHTML(domain){
  return (orphans[domain]||[]).map(o=>{
    const k=ORPHAN_KIND[o.kind]||ORPHAN_KIND.unknown;
    return '<div class="vt-orphan"><code>'+vtEsc(o.db)+'</code>'+(o.kind==='tables'?' · tables <code>'+vtEsc(o.prefix)+'*</code>':'')
      +' · '+o.tables+' table'+(o.tables===1?'':'s')+' · <strong>'+vtBytes(o.size)+'</strong>'
      +(o.webspace?' · '+vtEsc(o.webspace):'')
      +(o.in_plesk===false?' · <span title="Created outside Plesk, so Plesk cannot show or delete it">not registered in Plesk: remove it with phpMyAdmin or the mysql command</span>':'')
      +'<div class="vt-orphan-kind '+k[0]+'">'+vtEsc(k[1])+(o.used_by&&o.used_by.length&&o.kind!=='database'?' ('+o.used_by.map(vtEsc).join(', ')+')':'')+'</div></div>';
  }).join('');
}
function orphanBtns(domain){
  const e=vtEsca(domain);
  return (orphans[domain]||[]).map(o=>{
    let h='';
    if(o.kind==='database'||o.kind==='tables') h+='<button class="vt-row-btn" title="Make a .sql.gz copy in the private folder of the subscription" onclick="vtDumpDb(\''+e+'\',\''+vtEsca(o.db)+'\',this)">Back up</button>';
    if(o.plesk_url) h+='<a class="vt-row-btn" href="'+vtEsc(o.plesk_url)+'" target="_top" title="Open the Databases page of '+vtEsc(o.webspace)+' in Plesk">Delete in Plesk ↗</a>';
    return h;
  }).join('');
}
let orphSort={col:'size',dir:'desc'};
const ORPH_KIND_ORDER={inuse:0,unknown:1,tables:2,database:3};
function orphEntries(){
  const list=[];
  for(const d of related){
    const os=orphans[d]||[];
    if(!os.length) list.push({domain:d,o:null});
    for(const o of os) list.push({domain:d,o});
  }
  const k=orphSort.col, m=orphSort.dir==='asc'?1:-1;
  const val=e=>{const o=e.o||{};
    switch(k){
      case 'db': return (o.db||'')+'|'+(o.prefix||'');
      case 'tables': return +o.tables||0;
      case 'size': return +o.size||0;
      case 'kind': return ORPH_KIND_ORDER[o.kind]??9;
      case 'clam': return o.clamav?(o.clamav.clean?2:0):1;   // found, not scanned, clean
      default: return e.domain;
    }};
  return list.sort((a,b)=>{const x=val(a),y=val(b);
    const c=typeof x==='number'?x-y:String(x).localeCompare(String(y));
    return (c||a.domain.localeCompare(b.domain))*m;});
}
function orphClamHTML(o){
  const c=o.clamav;
  if(!c) return '<span class="vt-clam none">not scanned</span>';
  const when='<small>'+vtAgo(c.ts)+' · '+(c.tables?c.tables+' tables · ':'')+vtBytes(c.size)+' dump'+(c.secs!=null?' · '+vtSecs(c.secs):'')+'</small>';
  return c.clean?'<span class="vt-clam ok">✓ Nothing found'+when+'</span>'
    :'<span class="vt-clam bad">'+(c.found||[]).length+' found: '+(c.found||[]).map(vtEsc).join(', ')+when+'</span>';
}
function vtRenderOrphans(){
  const tb=document.getElementById('vt-tbody-rel'); if(!tb) return;
  document.querySelectorAll('#vt-orph-head th[data-ocol]').forEach(th=>{
    th.classList.add('vt-sortable');
    th.classList.toggle('vt-sort-asc',orphSort.col===th.dataset.ocol&&orphSort.dir==='asc');
    th.classList.toggle('vt-sort-desc',orphSort.col===th.dataset.ocol&&orphSort.dir==='desc');
    th.onclick=()=>vtOrphanSort(th.dataset.ocol);
  });
  const rows=orphEntries().map(({domain,o})=>{
    const e=vtEsca(domain);
    const dcell='<span class="vt-domain-name">'+vtEsc(domain)+'</span>'+(o&&o.webspace&&o.webspace!==domain?'<div class="hint" style="font-size:11px">in '+vtEsc(o.webspace)+'</div>':'');
    const search=(domain+' '+(o?[o.db,o.prefix,o.webspace,...(o.used_by||[])].join(' '):'')).toLowerCase();
    if(!o) return '<tr data-domain="'+vtEsc(domain)+'" data-q="'+vtEsc(search)+'"><td>'+dcell+'</td><td colspan="4" class="hint">No database details (administrator only)</td><td></td><td></td></tr>';
    const k=ORPHAN_KIND[o.kind]||ORPHAN_KIND.unknown, canDb=o.kind==='database'||o.kind==='tables';
    let act='';
    if(canDb){
      act+='<button class="vt-row-btn" title="Make a .sql.gz copy in the private folder of the subscription" onclick="vtDumpDb(\''+e+'\',\''+vtEsca(o.db)+'\',this)">Back up</button>';
      if(dbScanOk) act+=o.scanning
        ?'<button class="vt-row-btn" data-dbscan="'+vtEsc(o.db)+'" disabled><span class="vt-spin"></span> Scanning</button>'
        :'<button class="vt-row-btn" data-dbscan="'+vtEsc(o.db)+'" title="Scan the data with ClamAV: a temporary dump in a root-only folder, deleted right after the scan" onclick="vtScanDb(\''+e+'\',\''+vtEsca(o.db)+'\',this)">Scan with ClamAV</button>';
      if(o.scanning) setTimeout(()=>vtDbScanFollow(domain,o.db),0);
    }
    if(o.plesk_url) act+='<a class="vt-row-btn" href="'+vtEsc(o.plesk_url)+'" target="_top" title="Open the Databases page of '+vtEsc(o.webspace)+' in Plesk">Delete in Plesk ↗</a>';
    return '<tr data-domain="'+vtEsc(domain)+'" data-q="'+vtEsc(search)+'">'
      +'<td>'+dcell+'</td>'
      +'<td><code>'+vtEsc(o.db)+'</code>'+(o.kind==='tables'?'<div class="hint" style="font-size:11px">tables <code>'+vtEsc(o.prefix)+'*</code></div>':'')
        +(o.in_plesk===false?'<div class="hint" style="font-size:11px" title="Created outside Plesk, so Plesk cannot show or delete it">not in Plesk: remove with phpMyAdmin or mysql</div>':'')+'</td>'
      +'<td class="num">'+(+o.tables||0)+'</td>'
      +'<td class="num"><strong>'+vtBytes(o.size)+'</strong></td>'
      +'<td><div class="vt-orphan-kind '+k[0]+'">'+vtEsc(k[1])+(o.used_by&&o.used_by.length&&o.kind!=='database'?' ('+o.used_by.map(vtEsc).join(', ')+')':'')+'</div></td>'
      +'<td>'+(canDb?orphClamHTML(o):'<span class="vt-clam none">—</span>')+'</td>'
      +'<td class="vt-orph-act"><div class="vt-orph-btns">'+act+'</div></td></tr>';
  });
  tb.innerHTML=rows.length?rows.join(''):'<tr class="vt-empty"><td colspan="7">No orphan databases found.</td></tr>';
  vtOrphanFilter();
}
window.vtOrphanSort=function(col){
  if(orphSort.col===col) orphSort.dir=orphSort.dir==='asc'?'desc':'asc';
  else orphSort={col,dir:(col==='size'||col==='tables')?'desc':'asc'};
  vtRenderOrphans();
};
// Its own keyword search; the search box of the site list applies here too
window.vtOrphanFilter=function(){
  const q=(document.getElementById('vt-orph-q')?.value||'').trim().toLowerCase().split(/\s+/).filter(Boolean);
  const g=(document.getElementById('vt-search')?.value||'').toLowerCase();
  let shown=0, all=0;
  document.querySelectorAll('#vt-tbody-rel tr[data-domain]').forEach(row=>{
    all++;
    const ok=(!g||row.dataset.domain.includes(g))&&q.every(w=>row.dataset.q.includes(w));
    row.style.display=ok?'':'none'; if(ok) shown++;
  });
  const el=document.getElementById('vt-orph-shown');
  if(el) el.textContent=(q.length||g)?shown+' of '+all+' shown'+(g?' (also filtered by the site list search: '+g+')':''):'';
};
// ClamAV scan of an orphan database: runs in the background on the server; the Scan Monitor follows it every second
const dbPolls={};
const vtSecs=n=>{n=Math.max(0,Math.round(+n||0));return n<60?n+' s':Math.floor(n/60)+' min '+(n%60)+' s';};
function dbScanStats(st){
  const p=[];
  if(st.tables) p.push(st.tables+' table'+(st.tables===1?'':'s'));
  if(st.rows) p.push('≈'+(+st.rows).toLocaleString()+' rows');
  if(st.db_bytes) p.push(vtBytes(st.db_bytes)+' in the database');
  if(st.size) p.push(vtBytes(st.size)+' dump'+(st.dump_secs!=null?' in '+vtSecs(st.dump_secs):''));
  if(st.scan_secs!=null) p.push('scanned by '+(st.engine||'ClamAV')+' in '+vtSecs(st.scan_secs));
  if(st.signatures) p.push('ClamAV '+st.signatures);
  return p.join(' · ');
}
function vtDbScanFollow(domain,db){
  const key=domain+'|'+db; if(dbPolls[key]) return;
  const jid='db:'+db;
  let j=getFsJob(domain,jid);
  if(!j){ j=addFsJob(domain,jid); j.label='ClamAV · database'; j.msg='Starting the scan of '+db+'…'; j.indet=true; }
  renderQueue();
  const tick=async()=>{
    const st=await vtFetch('?action=scan-db-status&domain='+encodeURIComponent(domain)+'&db='+encodeURIComponent(db)).catch(()=>null);
    if(!st||st.status==='none'){ dbPolls[key]=setTimeout(tick,1500); return; }
    const el=(st.now||Math.floor(Date.now()/1000))-(st.started||0);
    if(st.status==='running'){
      j.stats=dbScanStats(st);
      if(st.phase==='dump'){
        // Real progress: tables written of all tables (the bytes as a fallback while the first table is dumped)
        j.indet=false;
        j.pct=st.tables?Math.round(100*(st.tables_done||0)/st.tables):(st.db_bytes?Math.min(95,Math.round(100*(st.bytes||0)/st.db_bytes)):0);
        j.msg='Dumping '+db+': table '+Math.min(st.tables||0,(st.tables_done||0))+' of '+(st.tables||'?')+' · '+vtBytes(st.bytes||0)+' written · '+vtSecs(el);
      }else if(st.phase==='scan'){
        j.pct=null; j.indet=true;
        j.msg='ClamAV ('+(st.engine||'')+') is scanning the '+vtBytes(st.size)+' dump · '+vtSecs((st.now||0)-(st.scan_started||st.now||0));
      }else{ j.indet=true; j.msg='Preparing the scan of '+db+'…'; }
      renderQueue();
      dbPolls[key]=setTimeout(tick,1000); return;
    }
    delete dbPolls[key];
    const btn=document.querySelector('#vt-tbody-rel button[data-dbscan="'+CSS.escape(db)+'"]');
    if(st.status==='done'){
      for(const o of orphans[domain]||[]) if(o.db===db){ o.clamav={clean:st.clean,found:st.found||[],size:st.size,engine:st.engine,secs:st.secs,ts:st.finished||Math.floor(Date.now()/1000),
        tables:st.tables,rows:st.rows,dump_secs:st.dump_secs,scan_secs:st.scan_secs}; o.scanning=false; }
      j.pct=null; j.indet=false; j.stats=dbScanStats(st)+' · dump deleted';
      updateFsJob(domain,jid,'done',{infected:st.clean?0:(st.found||[]).length,files:1},
        st.clean?'Nothing found in '+db+' · '+vtSecs(st.secs||el)+' in total':'Found in '+db+': '+(st.found||[]).join(', '));
      vtToast(st.clean?'ClamAV: nothing found in '+db+' (temporary dump deleted)':'ClamAV found '+(st.found||[]).join(', ')+' in '+db,st.clean?'ok':'err');
      histSites.add(domain);
    }else{
      for(const o of orphans[domain]||[]) if(o.db===db) o.scanning=false;
      j.pct=null; j.indet=false;
      updateFsJob(domain,jid,'failed',null,(st.error||'The scan failed')+' ('+db+')');
      vtToast(st.error||'The scan failed','err');
    }
    vtRenderOrphans();
  };
  tick();
}
window.vtScanDb=async function(domain,db,btn){
  btn.disabled=true; btn.innerHTML='<span class="vt-spin"></span> Scanning';
  for(const o of orphans[domain]||[]) if(o.db===db) o.scanning=true;
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const res=await fetch(BASE+'?action=scan-db',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams({domain,db})})
    .then(r=>r.json()).catch(()=>({error:'Network error'}));
  if(!res.started){
    for(const o of orphans[domain]||[]) if(o.db===db) o.scanning=false;
    btn.disabled=false; btn.textContent='Scan with ClamAV';
    vtToast(res.error||'The scan could not start','err'); return;
  }
  vtDbScanFollow(domain,db);
};
window.vtDumpDb=async function(domain,db,btn){
  btn.disabled=true; btn.innerHTML='<span class="vt-spin"></span> Backing up';
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const res=await fetch(BASE+'?action=dump-db',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams({domain,db})})
    .then(r=>r.json()).catch(()=>({error:'Network error'}));
  btn.disabled=false; btn.textContent='Back up';
  if(res.ok) vtToast('Backup saved: '+res.file+' ('+vtBytes(res.size)+')','ok');
  else vtToast(res.error||'The backup failed','err');
};
function renderTable(){
  const tbody=document.getElementById('vt-tbody');
  if(!domains.length){tbody.innerHTML='<tr class="vt-empty"><td colspan="5">No sites found. Click Refresh.</td></tr>';return;}
  updateSortHeaders();
  tbody.innerHTML=viewMode==='sort'?sortedDomains().map(d=>rowHTML(d,results[d]||null)).join(''):groupedRowsHTML();
  vtSet('vt-rel-cnt',related.length); vtSet('vt-cnt-orphan',related.length);
  const ocard=document.getElementById('vtcard-orphan'), obadge=document.getElementById('vttb-orphan');
  const onav=document.getElementById('vtnav-orphan'), onb=document.getElementById('vtnb-orphan');
  if(obadge){ obadge.textContent=related.length; obadge.style.display=related.length?'':'none'; }
  if(onb){ onb.textContent=related.length; onb.style.display=related.length?'':'none'; }
  vtRenderOrphans();
  vtApplyFilter();
}

// ── Grouping by reseller and customer ─────────────────────────
function grpKey(o){return (o.rl||'-')+'|'+o.cl;}
let viewMode=localStorage.getItem('vt_view_mode')||'group';
let sortCol=localStorage.getItem('vt_sort_col')||'domain';
let sortDir=localStorage.getItem('vt_sort_dir')||'asc';
function vtSyncViewSeg(){
  document.querySelectorAll('#vt-view-seg [data-mode]').forEach(b=>b.classList.toggle('on',b.dataset.mode===viewMode));
  const cb=document.getElementById('vt-grp-collapse'); if(cb) cb.checked=grpCollapse;
  const go=document.getElementById('vt-grp-opts'); if(go) go.hidden=viewMode!=='group'; // only in the grouped view
}
window.vtSetViewMode=function(m){
  viewMode=m;
  localStorage.setItem('vt_view_mode',m);
  vtSyncViewSeg();
  renderTable();
};
// Grouped → collapsed: every customer folded up; the header of each still shows how many of its sites are flagged.
// A customer you open or close yourself stays that way until the checkbox changes.
let grpCollapse=localStorage.getItem('vt_grp_collapsed')==='1', grpManual=new Set();
window.vtSetGrpCollapse=function(on){
  grpCollapse=!!on; localStorage.setItem('vt_grp_collapsed',on?'1':'0');
  grpManual.clear(); grpClosed.clear();
  if(viewMode!=='group'){ viewMode='group'; localStorage.setItem('vt_view_mode','group'); }
  vtSyncViewSeg();
  renderTable();
};
window.vtSortBy=function(col){
  if(sortCol===col) sortDir=sortDir==='asc'?'desc':'asc';
  else{sortCol=col;sortDir=col==='lastscan'?'desc':'asc';}
  localStorage.setItem('vt_sort_col',sortCol);
  localStorage.setItem('vt_sort_dir',sortDir);
  renderTable();
};
function sortedDomains(list){
  return [...(list||domains)].sort((a,b)=>{
    if(sortCol==='domain') return sortDir==='asc'?a.localeCompare(b,undefined,{sensitivity:'base'}):b.localeCompare(a,undefined,{sensitivity:'base'});
    if(sortCol==='score'){
      const va=results[a]?.malicious??-1, vb=results[b]?.malicious??-1;
      return sortDir==='asc'?va-vb:vb-va;
    }
    if(sortCol==='lastscan'){
      const va=results[a]?.cached_at??0, vb=results[b]?.cached_at??0;
      return sortDir==='asc'?va-vb:vb-va;
    }
    return 0;
  });
}
function updateSortHeaders(){
  const thead=document.getElementById('vt-thead-main');
  if(!thead) return;
  thead.querySelectorAll('th[data-col]').forEach(th=>{
    const col=th.dataset.col;
    th.classList.add('vt-sortable');
    th.classList.toggle('vt-sort-asc',sortCol===col&&sortDir==='asc');
    th.classList.toggle('vt-sort-desc',sortCol===col&&sortDir==='desc');
    th.onclick=()=>vtSortBy(col);
  });
}
function groupedRowsHTML(){
  const withOwner=domains.filter(d=>owners[d]);
  const custs=new Set(withOwner.map(d=>grpKey(owners[d])));
  if(custs.size<2) return domains.map(d=>rowHTML(d,results[d]||null)).join(''); // one customer: no headers
  const resellers=new Set(withOwner.map(d=>owners[d].rl).filter(Boolean));
  const byRes={};
  for(const d of domains){
    const o=owners[d]||{c:'Unknown owner',cl:'?',ct:'client',r:'',rl:''};
    const rk=o.rl||'-';
    (byRes[rk]=byRes[rk]||{name:o.r,cust:{}});
    const ck=grpKey(o);
    (byRes[rk].cust[ck]=byRes[rk].cust[ck]||{o,list:[]}).list.push(d);
  }
  const cmp=(a,b)=>a.localeCompare(b,undefined,{sensitivity:'base'});
  const resKeys=Object.keys(byRes).sort((a,b)=>a==='-'?-1:b==='-'?1:cmp(byRes[a].name,byRes[b].name));
  const bad=list=>list.filter(d=>['infected','suspicious'].includes(results[d]?.status)).length;
  let h='';
  for(const rk of resKeys){
    const R=byRes[rk], all=Object.values(R.cust).flatMap(c=>c.list);
    if(resellers.size){
      const b=bad(all);
      h+='<tr class="vt-grp-r" data-res="'+vtEsc(rk)+'"><td colspan="5">'
        +(rk==='-'?'Customers of the administrator':'<strong>'+vtEsc(R.name||rk)+'</strong><span class="vt-grp-badge">reseller</span> <span class="vt-grp-login">'+vtEsc(rk)+'</span>')
        +' <span class="vt-grp-n">'+all.length+' site'+(all.length===1?'':'s')+(b?' · <span class="bad">'+b+' flagged</span>':'')+'</span></td></tr>';
    }
    const custKeys=Object.keys(R.cust).sort((a,b)=>{const A=R.cust[a].o,B=R.cust[b].o;
      const w=o=>o.ct==='admin'||o.ct==='reseller'?0:o.ct==='external'?2:1; return w(A)-w(B)||cmp(A.c,B.c);});
    for(const ck of custKeys){
      const C=R.cust[ck], b=bad(C.list);
      if(grpCollapse&&!grpManual.has(ck)) grpClosed.add(ck); // collapsed: every customer folded up (the header still shows how many are flagged)
      const closed=grpClosed.has(ck);
      const label=C.o.ct==='reseller'?'Own sites of the reseller':C.o.ct==='admin'?'Administrator':C.o.ct==='external'?'External sites <span class="hint">(not hosted on this server)</span>':vtEsc(C.o.c);
      h+='<tr class="vt-grp-c'+(closed?' closed':'')+'" data-res="'+vtEsc(rk)+'" data-gk="'+vtEsc(ck)+'" onclick="vtGrpToggle(this)"><td colspan="5">'
        +'<span class="vt-grp-caret">▾</span> '+label+(C.o.ct==='client'?' <span class="vt-grp-login">'+vtEsc(C.o.cl)+'</span>':'')
        +' <span class="vt-grp-n">'+C.list.length+' site'+(C.list.length===1?'':'s')+(b?' · <span class="bad">'+b+' flagged</span>':'')+'</span></td></tr>';
      h+=sortedDomains(C.list).map(d=>rowHTML(d,results[d]||null)).join('');
    }
  }
  return h;
}
window.vtGrpToggle=function(tr){
  const k=tr.dataset.gk;
  if(grpClosed.has(k)) grpClosed.delete(k); else grpClosed.add(k);
  grpManual.add(k);
  tr.classList.toggle('closed',grpClosed.has(k));
  vtApplyFilter();
};
function updateRow(domain,data){
  if(relSet.has(domain)){vtRenderOrphans();return;}
  const row=document.getElementById('vtr-'+rid(domain));
  if(!row){renderTable();return;}
  document.getElementById('vtfs-'+rid(domain))?.remove();
  row.outerHTML=rowHTML(domain,data);
  vtApplyFilter();
}

function rid(d){return d.replace(/[^a-z0-9]/gi,'_');}
function vtAgo(ts){
  if(!ts) return null;
  const s=Math.floor(Date.now()/1000-ts);
  if(s<60) return 'just now';
  if(s<3600) return Math.floor(s/60)+'m ago';
  if(s<86400) return Math.floor(s/3600)+'h ago';
  if(s<86400*30) return Math.floor(s/86400)+'d ago';
  if(s<86400*365) return Math.floor(s/86400/30)+'mo ago';
  return Math.floor(s/86400/365)+'y ago';
}

function rowHTML(domain,data){
  const st=data?.status??'loading';
  const isScanning=st==='scanning'||st==='waiting';
  const dc=DOT_CLS[st]??'';
  const job=activeJob(domain);
  let badge;
  if(job){
    badge=job.state==='queued'
      ?'<span class="vt-badge pending"><span class="vt-dot dot-b"></span>In queue #'+queuePos(job)+'</span>'
      :'<span class="vt-badge scanning"><span class="vt-spin"></span> '+JOB_SHORT[job.state]+'</span>';
  }else if(isScanning){
    badge='<span class="vt-badge '+st+'"><span class="vt-spin"></span> '+(LABELS[st]??st)+'</span>';
  }else{
    const dot=dc?'<span class="vt-dot '+dc+'"></span>':'';
    // On the rows: this status is the site's reputation (VirusTotal and the other services), not its files
    badge='<span class="vt-badge '+st+'" title="Reputation of the site address (VirusTotal and the other online services), not a file scan">'+dot+(st==='infected'?'Infected Reputation':(LABELS[st]??st))+'</span>';
  }

  // Dangerous tags
  const dangerTags=(data?.tags??[]).filter(t=>DANGER_TAGS.some(k=>t.toLowerCase().includes(k)));
  const tagHtml=dangerTags.length?'<div style="margin-top:3px">'+dangerTags.slice(0,3).map(t=>'<span class="vt-tag">'+vtEsc(t)+'</span>').join('')+'</div>':'';
  // File scanner infected-files badge: show when any scanner has found infections
  let fsBadgeHtml='';
  if(!relSet.has(domain)&&scans[domain]){
    for(const id in scans[domain]){
      const r=scans[domain][id];
      if(r?.status==='done'&&r.infected>0){
        const e=vtEsca(domain);
        fsBadgeHtml+='<div><button type="button" class="vt-fs-badge" onclick="vtFsClick(\''+e+'\',\''+vtEsc(id)+'\')" title="Click to see the infected files found by '+vtEsc(fsName(id))+'">'
          +'<span class="vt-dot dot-r"></span>'+r.infected+' file'+(r.infected===1?'':'s')+' infected — '+vtEsc(fsName(id))+'</button></div>';
      }
    }
  }
  const avHtml=(avast.products||[]).map(pr=>{const avr=avast.results?.[domain]?.[pr.id];
  return avr&&avr.state==='ok'&&avr.findings?.length
    ?'<div><button type="button" class="vt-av-badge" onclick="vtWhyClick(\''+vtEsca(domain)+'\')" title="'+vtEsc(pr.name)+' classification: '+vtEsc(avr.findings.map(f=>f.raw).join(', '))+'"><span class="vt-dot dot-r"></span>'
      +vtEsc(pr.name)+': '+vtEsc(avr.findings.map(f=>f.classification.replace(/^URL:/,'')).join(', '))+'</button></div>':'';}).join('');
  const gr=gsb.enabled?gsb.results?.[domain]:null, gStale=gr&&Date.now()/1000-gr.checked_at>(gsb.fresh||1800);
  const gsbHtml=gr&&gr.state==='ok'&&gr.threats?.length
    ?'<div><button type="button" class="vt-av-badge'+(gStale?' stale':'')+'" onclick="vtWhyClick(\''+vtEsca(domain)+'\')" title="Google Safe Browsing'+(gStale?' (last known, checked again when you open the details)':'')+'"><span class="vt-dot dot-r"></span>Google: '+vtEsc(gr.threats.join(', '))+'</button></div>':'';
  const statusCell=badge+tagHtml+fsBadgeHtml+avHtml+gsbHtml;

  // Domain age badge
  let ageHtml='';
  if(data?.creation_date){
    const ageInDays=(Date.now()/1000-data.creation_date)/86400;
    if(ageInDays<30) ageHtml='<span class="vt-domain-age new-30d">&lt; 30 days old</span>';
    else if(ageInDays<365) ageHtml='<span class="vt-domain-age new-1y">&lt; 1 year old</span>';
  }
  // IP address
  const ipHtml=data?.ip?'<div class="vt-domain-ip">'+vtEsc(data.ip)+'</div>':'';
  const vtId=btoa('https://'+domain).replace(/=/g,'');
  const extHtml=extSet.has(domain)?'<span class="vt-ext" title="Not hosted on this server: only the online reputation services check it">External</span>':'';
  let domainCell='<span class="vt-domain-name">'+vtEsc(domain)+'</span>'+extHtml+ageHtml+'<span class="vt-dlinks">'
    +'<a href="https://'+vtEsc(domain)+'" target="_blank" rel="noopener" title="Open the website" aria-label="Open the website">'+ICO.site+'</a>'
    +'<a href="https://www.virustotal.com/gui/domain/'+vtEsc(domain)+'/detection" target="_blank" rel="noopener" title="VirusTotal report" aria-label="VirusTotal report"><img src="'+BRAND_IMG+'virustotal.png" alt="" width="14" height="14"></a>'
    +(panelUrl[domain]?'<a href="'+vtEsc(panelUrl[domain])+'" target="_blank" rel="noopener" title="Open this site in Plesk (Websites &amp; Domains)" aria-label="Open in Plesk">'+ICO.panel+'</a>':'')
    +'<a href="#" data-copy="'+vtEsc(domain)+'" onclick="return vtCopyDomain(this)" title="Copy the domain name" aria-label="Copy the domain name">'+ICO.copy+'</a></span>'+ipHtml;

  if(relSet.has(domain)) domainCell+=orphanInfoHTML(domain);

  let score='<span style="color:var(--muted)">—</span>';
  if(data?.malicious!==undefined&&data?.total!==undefined){
    const pct=data.total>0?Math.round(data.malicious/data.total*100):0;
    const c=data.malicious>0?'infected':'clean';
    const scoreNum=data.malicious>0?'<strong>'+data.malicious+'</strong>/'+data.total:data.malicious+'/'+data.total;
    score='<div class="vt-score"><div class="vt-sbar"><div class="vt-sbar-fill '+c+'" style="width:'+pct+'%"></div></div><span class="vt-snum '+c+'">'+scoreNum+'</span></div>';
    const avFlag=(avast.products||[]).some(pr=>avast.results?.[domain]?.[pr.id]?.findings?.length)||!!(gsb.enabled&&gsb.results?.[domain]?.threats?.length);
    const flagged=data.malicious>0||st==='suspicious'||(data.flagged_by||[]).length||avFlag;
    const fsOn=scanners.length&&!relSet.has(domain)&&!extSet.has(domain);
    if(flagged||histSites.has(domain)||avast.products?.length||gsb.enabled||fsOn||extSet.has(domain)){
      score='<button type="button" class="vt-why-btn'+(fsOpen[domain]==='vt'?' open':'')+'" title="'+(flagged?'Which vendors flag this site, how to get it reviewed after cleaning, and its history':'History of this site')+'" onclick="vtWhyClick(\''+vtEsca(domain)+'\')">'+score+'<span class="vt-why-lbl">'+(flagged?'Why?':histSites.has(domain)?'History':'Details')+fsMarkHTML(domain)+' ▾</span></button>';
    }
  }else if(isScanning){score='<span class="vt-spin"></span>';}
  else if(st==='loading'){score='<span class="vt-spin"></span>';}
  else if(st==='error'){score='<span style="color:var(--red);font-size:12px">No result</span>';}

  let scanDate='—';
  if(data?.cached_at){
    const _ago=vtAgo(data.cached_at);
    const _full=new Date(data.cached_at*1000).toLocaleString('nl-NL',{day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit'});
    scanDate='<span title="Checked: '+_full+'" style="cursor:default">'+_ago+'</span>';
    if(data?.stale) scanDate+=' <span class="vt-stale">stale</span>';
    if(data?.last_scan) scanDate+='<div style="font-size:10px;color:var(--muted);margin-top:2px">VT: '+vtEsc(data.last_scan)+'</div>';
  }else if(data?.last_scan){
    scanDate=vtEsc(data.last_scan)+(data?.stale?'<span class="vt-stale">stale</span>':'');
  }else if(st==='loading'||isScanning) scanDate='<span class="vt-spin"></span>';
  else if(st==='pending') scanDate='Queued...';

  // Rescan button: show spinner while scanning/waiting
  let actionBtn;
  if(job){
    actionBtn='<button class="vt-row-btn" disabled>'+(job.state==='queued'?'Queued':'<span class="vt-spin"></span> Busy')+'</button>';
  }else if(isScanning){
    const lbl=st==='waiting'?'VT processing...':'Scanning...';
    actionBtn='<button class="vt-row-btn" disabled><span class="vt-spin"></span> '+lbl+'</button>';
  }else{
    actionBtn='<button class="vt-row-btn" id="vrb-'+rid(domain)+'" onclick="vtReanalyzeSingle(\''+vtEsca(domain)+'\')">Rescan</button>';
  }
  // File scanners are for further investigation: their buttons are in the details (click the site), never started by a scan or rescan
  if(relSet.has(domain)) actionBtn=orphanBtns(domain)+actionBtn; // orphan databases have no files to scan

  const own=owners[domain];
  return '<tr id="vtr-'+rid(domain)+'" data-domain="'+vtEsc(domain)+'" data-status="'+st+'"'+(inQueue(domain)?' data-job="1"':'')
    +(own?' data-grp="'+vtEsc(grpKey(own))+'" data-own="'+vtEsc((own.c+' '+own.cl+' '+own.r).toLowerCase())+'"':'')+'>'
    +'<td>'+statusCell+'</td>'
    +'<td>'+domainCell+'</td>'
    +'<td>'+score+'</td>'
    +'<td style="font-size:12px;color:var(--muted)">'+scanDate+'</td>'
    +'<td style="text-align:right;white-space:nowrap">'+actionBtn+'</td>'
    +'</tr>'+fsRowHTML(domain,st);
}

// ── Trend (server totals per day, administrator) ──────────────
const TR_COL={infected:'#d03b3b',suspicious:'#d08a00',clean:'#2f8f5b',cleaned:'#0ca30c',grid:'#e1e0d9',axis:'#c3c2b7',muted:'#898781',surface:'#fcfcfb'};
let trDays=[], trRange=+localStorage.getItem('vt_tr_range')||61, trPin=null; // 2 months by default
// Lines in the chart: click one in the legend to hide or show it; the scale follows the visible lines
const TR_SERIES=[['infected','Infected'],['suspicious','Suspicious'],['clean','Clean sites']];
let trShow=(()=>{try{return Object.assign({infected:true,suspicious:true,clean:true},JSON.parse(localStorage.getItem('vt_tr_show')||'{}'));}catch(e){return {infected:true,suspicious:true,clean:true};}})();
let trLog=localStorage.getItem('vt_tr_log')!=='0'; // logarithmic scale by default: the small red line stays readable next to the clean sites
window.vtTrendLog=function(on){trLog=!!on; localStorage.setItem('vt_tr_log',on?'1':'0'); vtTrendDraw();};
window.vtTrendToggle=function(k){
  trShow[k]=!trShow[k];
  if(!TR_SERIES.some(([x])=>trShow[x])) trShow[k]=true; // never all off
  localStorage.setItem('vt_tr_show',JSON.stringify(trShow));
  vtTrendDraw();
};
window.vtLoadTrend=async function(){
  const [r,ev]=await Promise.all([
    vtFetch('?action=history').catch(()=>null),
    vtFetch('?action=events').catch(()=>null),
  ]);
  trDays=r?.days||[];
  document.getElementById('vt-tr-h').textContent=r?.scope==='own'?'Infections on your sites':'Infections on this server';
  vtTrendRange(trRange);
  vtRenderEvents(ev?.events||[]);
};
let evAll=[], evShowAll=false;
window.vtEvShowAll=function(){evShowAll=true; vtRenderEvents();};
function vtRenderEvents(events){
  if(events) evAll=events;
  const el=document.getElementById('vt-ev-list');
  if(!el) return;
  if(!evAll.length){
    el.innerHTML='<span class="hint">No status changes recorded yet. The list fills as sites are scanned.</span>';
    return;
  }
  const LBL={infected:'Infected',suspicious:'Suspicious',clean:'Clean',gone:'Left the list'};
  const RANK={clean:0,suspicious:1,infected:2};
  const badge=st=>'<span class="vt-badge '+(LBL[st]?st:'unchecked')+'">'
    +(st==='gone'?'':'<span class="vt-dot" style="background:currentColor"></span>')+vtEsc(LBL[st]||st||'unknown')+'</span>';
  const pad=n=>String(n).padStart(2,'0');
  const shown=evShowAll?evAll:evAll.slice(0,50);
  el.innerHTML=shown.map(e=>{
    const d=new Date(e.ts*1000);
    const when=pad(d.getDate())+'-'+pad(d.getMonth()+1)+'-'+d.getFullYear()
      +' <small>('+(e.approx?'last seen ':'')+pad(d.getHours())+':'+pad(d.getMinutes())+')</small>';
    const direct=e.type==='av';
    const better=direct?(e.observed?null:!e.to):e.to==='gone'?null:(RANK[e.to]??0)<(RANK[e.from]??0);
    const avBadge=(value,first)=>'<span class="vt-badge '+(first?'unchecked':value?'infected':'clean')+'">'
      +vtEsc(e.product)+': '+(first?'First check':value?vtEsc(value.replace(/^URL:/,'')):'No classification')+'</span>';
    const change=direct?avBadge(e.from,!!e.observed):badge(e.from);
    const arrow='<span class="vt-ev-arrow" style="color:'+(better===null?'var(--muted)':better?'var(--green)':'var(--red)')+'" aria-label="'+(better===null?'to':better?'better: to':'worse: to')+'">'
      +'<svg viewBox="0 0 22 14" aria-hidden="true"><path d="M1 5h12V1l8 6-8 6V9H1z" fill="currentColor"/></svg></span>';
    return '<div class="vt-ev-row">'
      +'<div class="vt-ev-time">'+when+'</div>'
      +'<div class="vt-ev-change">'+change+arrow+(direct?avBadge(e.to,false):badge(e.to))+'</div>'
      +'<div class="vt-ev-domain"><a href="https://www.virustotal.com/gui/domain/'+vtEsc(e.domain)+'/detection" target="_blank" rel="noopener" title="Open on VirusTotal">'+vtEsc(e.domain)+'</a></div>'
      +'</div>';
  }).join('')
  +(evAll.length>shown.length?'<button class="vt-btn ghost" style="margin-top:8px" onclick="vtEvShowAll()">Show all '+evAll.length+'</button>':'');
}

window.vtTrendRange=function(n){
  trRange=n; trPin=null; localStorage.setItem('vt_tr_range',n);
  document.querySelectorAll('#vt-tr-range button').forEach(b=>b.classList.toggle('on',+b.dataset.d===n));
  vtTrendDraw();
};
function trNice(max){for(const s of [1,2,5,10,20,25,50,100,200,250,500,1000]){if(max/s<=5)return s;}return Math.ceil(max/5);}
function trDate(iso,long){const p=iso.split('-');return long?p[2]+'-'+p[1]+'-'+p[0]:p[2]+'-'+p[1];}
function vtTrendDraw(){
  // Clean sites in the chart = every site that is not flagged, counted at today's number of sites. Earlier days
  // may have counted fewer sites (WordPress sites only, or sites not checked yet); the recorded number is in the tooltip.
  const nowTotal=+(trDays[trDays.length-1]?.total)||0;
  const days=trDays.slice(-trRange).map(d=>Object.assign({},d,{clean_rec:+d.clean||0,
    clean:Math.max(0,Math.max(nowTotal,+d.total||0)-(+d.infected||0)-(+d.suspicious||0))}));
  const tiles=document.getElementById('vt-tr-tiles');
  if(!days.length){
    tiles.innerHTML='<span class="hint">No history yet. Totals are saved once a day from now on.</span>';
    ['vt-tr-lines','vt-tr-bars','vt-tr-table'].forEach(id=>document.getElementById(id).innerHTML='');
    return;
  }
  const first=days[0], last=days[days.length-1];
  const sum=k=>days.reduce((a,d)=>a+(+d[k]||0),0);
  const delta=k=>{const v=(+last[k]||0)-(+first[k]||0);return '<div class="d '+(v>0?'up':v<0?'down':'')+'">'+(v>0?'+':'')+v+' since '+trDate(first.date)+'</div>';};
  tiles.innerHTML=
    '<div class="vt-tr-tile"><div class="l">Infected now</div><div class="v">'+last.infected+'</div>'+delta('infected')+'</div>'
   +'<div class="vt-tr-tile"><div class="l">Suspicious now</div><div class="v">'+last.suspicious+'</div>'+delta('suspicious')+'</div>'
   +'<div class="vt-tr-tile"><div class="l">Cleaned in this period</div><div class="v">'+sum('cleaned')+'</div><div class="d">sites</div></div>'
   +'<div class="vt-tr-tile"><div class="l">Clean sites now</div><div class="v">'+last.clean_rec+'</div><div class="d">of '+last.total+'</div></div>';
  document.getElementById('vt-tr-sub').textContent=trDate(first.date,1)+' to '+trDate(last.date,1);
  const demo=days.filter(d=>d.demo);
  document.getElementById('vt-tr-note').innerHTML=demo.length
    ?'<strong>Demo data:</strong> the days up to '+trDate(demo[demo.length-1].date,1)+' (shaded) are made-up example figures. Real totals replace them day by day.'
    :'Totals are saved once a day, by the nightly scan and when you open the dashboard.';

  const W=Math.max(320,document.getElementById('vt-tr-lines').clientWidth||900), L=36, R=14, T=10;
  const n=days.length, step=(W-L-R)/Math.max(1,n-1), x=i=>L+(n<=1?0:i*step), bw=Math.max(2,Math.min(24,(W-L-R)/n-2));
  const demoEnd=demo.length?days.findIndex(d=>!d.demo):-1;
  const shadeW=demo.length?(demoEnd<0?x(n-1)-L:x(demoEnd)-step/2-L):0;
  const shade=B=>shadeW>0?'<rect x="'+L+'" y="'+T+'" width="'+shadeW+'" height="'+(B-T)+'" fill="#f1f0ec"/>':'';
  const xticks=B=>{let h='';const st=Math.max(1,Math.round(n/6));for(let i=0;i<n;i+=st)h+='<text x="'+x(i)+'" y="'+(B+16)+'" font-size="11" fill="'+TR_COL.muted+'" text-anchor="middle">'+trDate(days[i].date)+'</text>';return h;};
  const yaxis=(max,B)=>{const st=trNice(max),top=Math.max(st,Math.ceil(max/st)*st);let h='';
    for(let v=0;v<=top;v+=st){const y=B-(v/top)*(B-T);
      h+='<line x1="'+L+'" x2="'+(W-R)+'" y1="'+y+'" y2="'+y+'" stroke="'+(v?TR_COL.grid:TR_COL.axis)+'" stroke-width="1"/>'
        +'<text x="'+(L-6)+'" y="'+(y+4)+'" font-size="11" fill="'+TR_COL.muted+'" text-anchor="end">'+v+'</text>';}
    return {h,top};};

  // Lines: infected, suspicious and clean sites, one scale. Hidden lines (legend) don't count for the scale.
  const vis=TR_SERIES.filter(([k])=>trShow[k]).map(([k])=>k);
  document.getElementById('vt-tr-legend').innerHTML=TR_SERIES.map(([k,name])=>
    '<button type="button" class="'+(trShow[k]?'':'off')+'" aria-pressed="'+trShow[k]+'" onclick="vtTrendToggle(\''+k+'\')" title="'+(trShow[k]?'Hide':'Show')+' this line">'
    +'<i class="'+(k==='clean'?'dash':'')+'" style="border-color:'+TR_COL[k]+'"></i>'+name+'</button>').join('')
    +'<span class="vt-seg" style="margin-left:6px"><button type="button" class="'+(trLog?'on':'')+'" onclick="vtTrendLog(1)" title="Logarithmic scale: small numbers stay readable next to large ones">Log</button><button type="button" class="'+(trLog?'':'on')+'" onclick="vtTrendLog(0)">Linear</button></span>'
    +'<span class="hint">Click a line name to hide or show it. Click the chart to pin a day.</span>';
  const H1=260, B1=H1-24, max1=Math.max(5,...days.map(d=>Math.max(0,...vis.map(k=>+d[k]||0))));
  let ya, y1;
  if(trLog){
    const TK=[0,1,2,5,10,20,50,100,200,500,1000,2000,5000,10000,20000,50000];
    const top=TK.find(v=>v>=max1)||max1, lt=Math.log10(1+top);
    y1=v=>B1-(Math.log10(1+Math.max(0,v))/lt)*(B1-T);
    let h='';
    for(const v of TK){ if(v>top) break; const y=y1(v);
      h+='<line x1="'+L+'" x2="'+(W-R)+'" y1="'+y+'" y2="'+y+'" stroke="'+(v?TR_COL.grid:TR_COL.axis)+'" stroke-width="1"/>'
        +'<text x="'+(L-6)+'" y="'+(y+4)+'" font-size="11" fill="'+TR_COL.muted+'" text-anchor="end">'+v+'</text>'; }
    ya={h,top};
  }else{
    ya=yaxis(max1,B1); y1=v=>B1-(v/ya.top)*(B1-T);
  }
  const path=k=>days.map((d,i)=>(i?'L':'M')+x(i).toFixed(1)+' '+y1(+d[k]||0).toFixed(1)).join(' ');
  const area=k=>path(k)+' L'+x(n-1).toFixed(1)+' '+B1+' L'+x(0).toFixed(1)+' '+B1+' Z';
  // End labels: name and value next to the last point; moved apart when two are close together
  const ends=vis.map(k=>({k,y:y1(+last[k]||0)})).sort((a,b)=>a.y-b.y);
  for(let i=1;i<ends.length;i++) if(ends[i].y-ends[i-1].y<14) ends[i].y=ends[i-1].y+14;
  const endY={}; ends.forEach(e=>endY[e.k]=e.y);
  const endLbl=(k,name)=>trShow[k]?'<circle cx="'+x(n-1)+'" cy="'+y1(+last[k]||0)+'" r="4" fill="'+TR_COL[k]+'" stroke="'+TR_COL.surface+'" stroke-width="2"/>'
     +'<text x="'+(x(n-1)-10)+'" y="'+(endY[k]+4)+'" font-size="11" fill="#333" text-anchor="end" paint-order="stroke" stroke="'+TR_COL.surface+'" stroke-width="3">'+name+' '+last[k]+'</text>':'';
  const line=(k,dash)=>trShow[k]?'<path d="'+path(k)+'" fill="none" stroke="'+TR_COL[k]+'" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"'+(dash?' stroke-dasharray="6 4"':'')+'/>':'';
  document.getElementById('vt-tr-lines').innerHTML='<svg viewBox="0 0 '+W+' '+H1+'" height="'+H1+'" role="img" aria-label="Infected and suspicious sites per day">'
    +shade(B1)+ya.h+xticks(B1)
    +(trShow.infected?'<path d="'+area('infected')+'" fill="'+TR_COL.infected+'" opacity=".1"/>':'')
    +line('clean',true)+line('suspicious')+line('infected')
    +endLbl('clean','Clean')+endLbl('suspicious','Suspicious')+endLbl('infected','Infected')
    +'<g id="vt-tr-dots"></g>'
    +'<line id="vt-tr-x1" y1="'+T+'" y2="'+B1+'" stroke="#9ca3af" stroke-width="1" style="display:none"/>'
    +'<rect x="'+L+'" y="'+T+'" width="'+(W-L-R)+'" height="'+(B1-T)+'" fill="transparent"/></svg>';

  // Bars: sites cleaned per day
  const H2=130, B2=H2-24, max2=Math.max(3,...days.map(d=>+d.cleaned||0));
  const yb=yaxis(max2,B2), y2=v=>B2-(v/yb.top)*(B2-T);
  const bar=(i,v)=>{if(!v)return '';const h=B2-y2(v),r=Math.min(4,h/2,bw/2),x0=x(i)-bw/2,y0=y2(v);
    return '<path d="M'+x0+' '+B2+' V'+(y0+r)+' Q'+x0+' '+y0+' '+(x0+r)+' '+y0+' H'+(x0+bw-r)+' Q'+(x0+bw)+' '+y0+' '+(x0+bw)+' '+(y0+r)+' V'+B2+' Z" fill="'+TR_COL.cleaned+'"/>';};
  document.getElementById('vt-tr-bars').innerHTML='<svg viewBox="0 0 '+W+' '+H2+'" height="'+H2+'" role="img" aria-label="Sites cleaned per day">'
    +shade(B2)+yb.h+xticks(B2)+days.map((d,i)=>bar(i,+d.cleaned||0)).join('')
    +'<line id="vt-tr-x2" y1="'+T+'" y2="'+B2+'" stroke="#9ca3af" stroke-width="1" style="display:none"/>'
    +'<rect x="'+L+'" y="'+T+'" width="'+(W-L-R)+'" height="'+(B2-T)+'" fill="transparent"/></svg>';

  // Hover: one crosshair over both charts, with a tooltip
  const tip=document.getElementById('vt-tr-tip');
  const dots=i=>{const g=document.getElementById('vt-tr-dots'); if(!g) return;
    g.innerHTML=vis.map(k=>'<circle cx="'+x(i)+'" cy="'+y1(+days[i][k]||0)+'" r="4.5" fill="'+TR_COL[k]+'" stroke="'+TR_COL.surface+'" stroke-width="2"/>').join('');};
  document.querySelectorAll('#vt-tr-lines svg,#vt-tr-bars svg').forEach(svg=>{
    svg.style.cursor='crosshair';
    svg.onclick=ev=>{
      const rc=svg.getBoundingClientRect(), px=(ev.clientX-rc.left)*W/rc.width;
      const i=Math.max(0,Math.min(n-1,Math.round((px-L)/step)));
      trPin=trPin===i?null:i; svg.onmousemove(ev);
    };
    svg.onmousemove=ev=>{
      const rc=svg.getBoundingClientRect(), px=(ev.clientX-rc.left)*W/rc.width;
      const i=trPin??Math.max(0,Math.min(n-1,Math.round((px-L)/step)));
      const d=days[i];
      dots(i);
      ['vt-tr-x1','vt-tr-x2'].forEach(id=>{const l=document.getElementById(id);l.setAttribute('x1',x(i));l.setAttribute('x2',x(i));l.style.display='';});
      tip.innerHTML='<b>'+trDate(d.date,1)+(d.demo?' (demo)':'')+'</b>'
        +'<div class="row"><span><i style="background:'+TR_COL.infected+'"></i>Infected</span><span>'+d.infected+'</span></div>'
        +'<div class="row"><span><i style="background:'+TR_COL.suspicious+'"></i>Suspicious</span><span>'+d.suspicious+'</span></div>'
        +'<div class="row"><span><i style="background:'+TR_COL.cleaned+'"></i>Cleaned</span><span>'+(d.cleaned||0)+'</span></div>'
        +'<div class="row"><span><i style="background:'+TR_COL.clean+'"></i>Clean sites</span><span>'+d.clean+'</span></div>'
        +(d.clean_rec!==d.clean?'<div class="row hint"><span>recorded that day</span><span>'+d.clean_rec+' of '+d.total+'</span></div>':'')
        +(trPin!==null?'<div class="hint" style="margin-top:4px">Pinned · click again to release</div>':'');
      tip.style.display='block';
      const tx=ev.clientX+14+tip.offsetWidth>innerWidth?ev.clientX-tip.offsetWidth-14:ev.clientX+14;
      tip.style.left=tx+'px'; tip.style.top=(ev.clientY+12)+'px';
    };
    svg.onmouseleave=()=>{if(trPin!==null) return; tip.style.display='none'; document.getElementById('vt-tr-dots')&&(document.getElementById('vt-tr-dots').innerHTML='');
      ['vt-tr-x1','vt-tr-x2'].forEach(id=>document.getElementById(id).style.display='none');};
  });

  document.getElementById('vt-tr-table').innerHTML='<table><thead><tr><th>Date</th><th>Infected</th><th>Suspicious</th><th>Clean (not flagged)</th><th>Clean recorded</th><th>Sites counted</th><th>Cleaned</th></tr></thead><tbody>'
    +days.slice().reverse().map(d=>'<tr><td>'+trDate(d.date,1)+(d.demo?' (demo)':'')+'</td><td>'+d.infected+'</td><td>'+d.suspicious+'</td><td>'+d.clean+'</td><td>'+d.clean_rec+'</td><td>'+(d.total||0)+'</td><td>'+(d.cleaned||0)+'</td></tr>').join('')+'</tbody></table>';
}
window.addEventListener('resize',()=>{if(document.getElementById('vtpanel-trend')?.classList.contains('active'))vtTrendDraw();});

// ── Filter ────────────────────────────────────────────────────
window.vtSetFilter=function(f){
  activeFilter=f;
  document.querySelectorAll('.vt-fbtn').forEach(b=>b.classList.toggle('active',b.dataset.f===f));
  vtApplyFilter();
};
window.vtApplyFilter=function(){
  const q=document.getElementById('vt-search').value.toLowerCase();
  // Orphan databases are their own view: shown only with the Orphan DBs button, instead of the site list
  document.getElementById('vt-tbody').closest('.vt-tbl-wrap').style.display='';
  vtOrphanFilter();
  document.querySelectorAll('#vt-tbody tr[data-domain]').forEach(row=>{
    const st=row.dataset.status;
    const match=activeFilter==='all'||st===activeFilter
      ||(activeFilter==='pending'&&(row.dataset.job==='1'||st==='scanning'||st==='waiting'));
    const show=match&&(!q||row.dataset.domain.includes(q)||(row.dataset.own||'').includes(q));
    row.dataset.vis=show?'1':'';
    row.style.display=show&&!(viewMode==='group'&&grpClosed.has(row.dataset.grp))?'':'none'; // folded-up customers only in the grouped view
  });
  // Group headers: only when the group has a site that matches the filter
  const tb=document.getElementById('vt-tbody'), resVis={};
  tb.querySelectorAll('tr.vt-grp-c').forEach(hd=>{
    const any=[...tb.querySelectorAll('tr[data-domain]')].some(r=>r.dataset.grp===hd.dataset.gk&&r.dataset.vis==='1');
    hd.style.display=any?'':'none';
    if(any) resVis[hd.dataset.res]=1;
  });
  tb.querySelectorAll('tr.vt-grp-r').forEach(hd=>{hd.style.display=resVis[hd.dataset.res]?'':'none';});
};

function updateCounts(){
  const c={infected:0,suspicious:0,clean:0,pending:0,error:0};
  for(const d of domains){
    const s=results[d]?.status??'loading';
    if(s in c) c[s]++;
    if(s!=='pending'&&inQueue(d)) c.pending++; // in the rescan queue or waiting for an automatic lookup
  }
  vtSet('vt-cnt-infected',c.infected);
  vtSet('vt-cnt-suspicious',c.suspicious);
  vtSet('vt-cnt-clean',c.clean);
  vtSet('vt-cnt-pending',c.pending);
}

// ── Rescan queue ──────────────────────────────────────────────
// Every Rescan click becomes a job. VT-quota calls (submit + fetch report) run
// one at a time through a shared slot (also used by the auto pump); polling the
// analysis doesn't need the slot, so the next job can submit meanwhile.
// Per-minute rate limits are waited out instead of failing the job.
let jobs=[], jobSeq=0, vtLock=Promise.resolve(), qTicker=null;
const ACTIVE=new Set(['queued','submit','ratewait','processing','fetch']);
const JOB_SHORT={submit:'Submitting...',ratewait:'Rate limit wait',processing:'VT processing...',fetch:'Fetching...'};
const STEPS=['Queued','Submit','VT analysis','Report','Done'];
const POLL_MAX=12, POLL_MS=5000;

function inQueue(d){return !!activeJob(d)||d===pumpCurrent||scanQueue.includes(d);}
function activeJob(d){return jobs.find(j=>j.domain===d&&ACTIVE.has(j.state));}
function queuePos(j){return jobs.filter(x=>x.state==='queued').indexOf(j)+1;}
function withVtSlot(fn){const p=vtLock.then(fn);vtLock=p.catch(()=>{});return p;}

function setJob(j,patch){
  Object.assign(j,patch);
  renderQueue();
  // Refresh rows of all waiting jobs too (their queue position may change)
  updateRow(j.domain,results[j.domain]||null);
  jobs.filter(x=>x!==j&&x.state==='queued').forEach(x=>updateRow(x.domain,results[x.domain]||null));
  updateCounts();
}

function finishJob(j,state,msg){
  if(!ACTIVE.has(j.state)) return; // already finished (e.g. cancelled)
  // For failed jobs that never reached the fetch step, results[domain] may still be
  // the initial {status:'loading'} placeholder — that keeps spinners in the row forever.
  // Restore the previous result (or fall back to 'error') so the row clears correctly.
  if(state==='failed'){
    const cur=results[j.domain];
    if(!cur||['loading','scanning','waiting'].includes(cur.status)){
      const prev=j.prev&&!['loading','scanning','waiting'].includes(j.prev?.status)
        ?j.prev:{status:'error',domain:j.domain,message:msg||'Failed'};
      results[j.domain]=prev;
    }
  }
  setJob(j,{state,msg:msg||'',endedAt:Date.now()});
}

// Call a VT-spending endpoint; on per-minute rate limit wait and retry.
async function vtCallRetry(j,url,stepState){
  for(let attempt=0;attempt<6;attempt++){
    if(j.cancelled) return {status:'cancelled'};
    setJob(j,{state:stepState,step:stepState});
    const data=await vtFetch(url).catch(()=>({status:'error',message:'Network error'}));
    if(data.status!=='ratelimit') return data;
    const wait=Math.max(5,Number(data.wait||data.retry_after||60));
    setJob(j,{state:'ratewait',waitFrom:Date.now(),until:Date.now()+wait*1000});
    await delay(wait*1000);
  }
  return {status:'ratelimit'};
}

async function runJob(j){
  const enc=encodeURIComponent(j.domain);

  // 1. Request re-analysis (costs 1 manual call)
  const sub=await withVtSlot(()=>{ if(!j.startedAt) j.startedAt=Date.now(); return vtCallRetry(j,'?action=reanalyze&domain='+enc,'submit'); });
  if(j.cancelled) return;
  if(sub.status==='budget_exceeded') return finishJob(j,'failed','Daily manual rescan limit reached');
  if(sub.status==='quota_exceeded')  return finishJob(j,'failed','VT daily quota exhausted — resumes after midnight UTC');
  if(sub.status==='ratelimit')       return finishJob(j,'failed','Still rate limited after retries');
  if(sub.status!=='queued')          return finishJob(j,'failed','Submit failed'+(sub.http_code?' (HTTP '+sub.http_code+')':''));
  budget.manual_used=(budget.manual_used??0)+1; budget.vt_quota_used=(budget.vt_quota_used??0)+1; updateBudget();

  // 2. Wait for VT to finish the analysis (polling doesn't use the slot)
  setJob(j,{state:'processing',step:'processing',polls:0,vtState:'queued'});
  if(sub.analysis_id){
    for(let i=1;i<=POLL_MAX;i++){
      await delay(POLL_MS);
      const poll=await vtFetch('?action=poll-analysis&id='+encodeURIComponent(sub.analysis_id)).catch(()=>({status:'unknown'}));
      setJob(j,{polls:i,vtState:poll.status});
      if(poll.status==='completed'||poll.status==='unknown') break;
    }
  }else{
    await delay(15000);
  }

  // 3. Fetch the fresh report (costs 1 call)
  const fresh=await withVtSlot(()=>vtCallRetry(j,'?action=scan&force=1&domain='+enc,'fetch'));
  if(['ratelimit','quota_exceeded','error','cancelled'].includes(fresh.status)){
    return finishJob(j,'failed','Could not fetch new report ('+fresh.status+') — previous result kept');
  }
  results[j.domain]=fresh;
  budget.auto_used=(budget.auto_used??0)+1; budget.vt_quota_used=(budget.vt_quota_used??0)+1; updateBudget();
  j.result=fresh;
  finishJob(j,'done');
  vtAvastLive(j.domain,1); vtGsbLive(j.domain,1); // a rescan also asks Avast / AVG and Google

  if(fresh.status==='infected') vtToast('⚠ INFECTED: '+j.domain,'err');
  else if(fresh.status==='suspicious') vtToast('Suspicious: '+j.domain,'warn');
  else if(fresh.status==='clean') vtToast('Clean: '+j.domain,'ok');
}

// Finished automatic lookups stay in the scan queue with their result
function logAutoJob(domain,prev,data,t0){
  const ok=['clean','suspicious','infected','pending'].includes(data.status);
  const msgs={quota_exceeded:'VT daily quota exhausted — resumes after midnight UTC',
              budget_exceeded:'Daily background budget used up — the nightly scan continues',
              error:data.message||'Lookup failed'};
  jobs.push({id:++jobSeq,domain,kind:'auto',state:ok?'done':'failed',prev,result:data,
             msg:ok?'':(msgs[data.status]||data.message||data.status),
             createdAt:t0,startedAt:t0,endedAt:Date.now()});
  renderQueue();
}

function enqueueRescan(domain){
  if(activeJob(domain)||relSet.has(domain)) return false; // orphan databases are never checked by VirusTotal
  scanQueue=scanQueue.filter(d=>d!==domain); // manual takes priority over auto pump
  const j={id:++jobSeq,domain,state:'queued',step:'queued',prev:results[domain]||null,createdAt:Date.now()};
  jobs.push(j);
  setJob(j,{});
  startQTicker();
  vtServerPost('enqueue-rescan',domain); // persist on server so cron can finish it if browser leaves
  startServerQueuePoll();
  runJob(j).finally(()=>vtServerPost('dequeue-rescan',domain)); // browser finished it: remove from server queue
  return true;
}

window.vtReanalyzeSingle=function(domain){
  if(noKey){vtToast('Add your VirusTotal API key in Settings first','warn');vtShowTab('settings');return;}
  if(!enqueueRescan(domain)) vtToast(domain+' is already in the scan queue','info');
};

// ── Category menus (arrow next to each filter button) ──────────
window.vtToggleMenu=function(ev,f){
  ev.stopPropagation();
  const m=document.getElementById('vt-fmenu-'+f), open=m.classList.contains('open');
  document.querySelectorAll('.vt-fmenu.open').forEach(x=>x.classList.remove('open'));
  if(!open) m.classList.add('open');
};
document.addEventListener('click',()=>document.querySelectorAll('.vt-fmenu.open').forEach(x=>x.classList.remove('open')));

function inCategory(d,f){
  const st=results[d]?.status;
  if(f==='all') return true;
  if(f==='error') return ['error','ratelimit','quota_exceeded','budget_exceeded'].includes(st);
  return st===f;
}

window.vtMenuAction=function(action,f){
  document.querySelectorAll('.vt-fmenu.open').forEach(x=>x.classList.remove('open'));
  if(action==='refresh') return vtRefreshDomains();
  const targets=domains.filter(d=>inCategory(d,f)&&!activeJob(d));
  if(!targets.length){vtToast('No sites to rescan in this category','info');return;}
  // Every rescan costs one manual call: never queue more than today's manual budget allows
  const left=Math.max(0,(budget.manual_max??0)-(budget.manual_used??0)-jobs.filter(j=>ACTIVE.has(j.state)).length);
  if(!left){vtToast('Daily manual rescan limit reached — resets at midnight UTC','warn');return;}
  // Worst first: infected, then suspicious, then the rest
  const rank={infected:0,suspicious:1};
  targets.sort((a,b)=>(rank[results[a]?.status]??2)-(rank[results[b]?.status]??2));
  const pick=targets.slice(0,left);
  pick.forEach(enqueueRescan);
  vtToast(pick.length+' site'+(pick.length===1?'':'s')+' added to the scan queue'
    +(pick.length<targets.length?' ('+(targets.length-pick.length)+' skipped: daily manual limit)':''),'info');
};

window.vtReanalyzeInfected=function(){
  const targets=domains.filter(d=>results[d]&&['infected','suspicious'].includes(results[d].status));
  if(!targets.length){vtToast('No infected or suspicious sites','info');return;}
  const added=targets.filter(enqueueRescan).length;
  vtToast(added?added+' sites added to the scan queue':'All already in the scan queue','info');
};

// Skip one waiting entry of the Scan Monitor (a VirusTotal rescan or a Pwned? check)
window.vtQSkip=function(id){
  const j=jobs.find(x=>x.id===id&&x.state==='queued');
  if(j){ j.cancelled=true; finishJob(j,'failed','Skipped'); return; } // runJob stops before it calls VirusTotal
  const p=pwJobs.find(x=>x.id===id&&x.state==='queued');
  if(p){ p.skipped=true; p.wake&&p.wake(); }
};
// Skip a rescan that waits in the server queue (for cron)
window.vtQSkipSrv=function(domain){
  if(!domain) return;
  vtServerPost('dequeue-rescan',domain);
  srvSkipped[domain]=Date.now(); // a queue poll already on its way may still list it
  serverQueue=serverQueue.filter(d=>d!==domain);
  renderQueue(); vtToast(domain+' taken out of the queue','info');
};

window.vtCancelWaiting=function(){
  jobs.filter(j=>j.state==='queued').forEach(j=>{ j.cancelled=true; finishJob(j,'failed','Cancelled'); });
};

window.vtClearFinished=function(){
  jobs=jobs.filter(j=>ACTIVE.has(j.state));
  fsJobs=fsJobs.filter(j=>j.state==='running'||j.state==='queued');
  renderQueue();
};

function startQTicker(){
  if(qTicker) return;
  qTicker=setInterval(()=>{
    // Auto-prune finished/failed jobs older than 30s
    const cut=Date.now()-30000;
    jobs=jobs.filter(j=>ACTIVE.has(j.state)||!j.endedAt||(j.endedAt>cut));
    fsJobs=fsJobs.filter(j=>!j.endedAt||(j.endedAt>cut));
    pwJobs=pwJobs.filter(j=>!j.endedAt||(j.endedAt>cut));
    renderQueue();
    const fsIdle=!fsJobs.some(j=>!j.endedAt)&&!pwJobs.some(j=>!j.endedAt);
    if(!jobs.some(j=>ACTIVE.has(j.state))&&!pumpRunning&&fsIdle&&!serverQueue.length&&!pwJobs.length){clearInterval(qTicker);qTicker=null;}
  },1000);
}

function fmtSecs(ms){const s=Math.max(0,Math.round(ms/1000));return s<60?s+'s':Math.floor(s/60)+'m '+(s%60)+'s';}
function scoreTxt(r){return r&&r.malicious!==undefined&&r.total!==undefined?r.malicious+'/'+r.total:'—';}
function stepIdx(j){
  if(j.state==='done') return 4;
  // For failed: return index of the step that failed so only prior steps show green
  if(j.state==='failed'){
    const idx={submit:1,processing:2,fetch:3}[j.step];
    return idx!==undefined?idx:4; // 4 = only the Done/Failed pill is marked bad
  }
  const s=j.state==='ratewait'?j.step:j.state;
  return {queued:0,submit:1,processing:2,fetch:3}[s]??0;
}

function jobMsg(j){
  const now=Date.now();
  switch(j.state){
    case 'queued':     return 'Waiting for a VT slot — #'+queuePos(j)+' in line ('+fmtSecs(now-j.createdAt)+')';
    case 'submit':     return 'Requesting re-analysis at VirusTotal...';
    case 'ratewait':   return 'VT rate limit (4/min) — retrying in '+fmtSecs(j.until-now);
    case 'processing': return 'VT is analysing ('+(j.vtState||'queued')+') — check '+(j.polls||0)+'/'+POLL_MAX;
    case 'fetch':      return 'Fetching the new report...';
    case 'done':
      if(j.kind==='cron') return 'Processed by cron at '+new Date(j.endedAt).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
      if(j.kind==='auto') return j.result&&j.result.status==='pending'
        ?'New to VirusTotal — submitted for a first scan, result follows later'
        :'Report fetched at '+new Date(j.endedAt).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
      return 'Finished at '+new Date(j.endedAt).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'})+' in '+fmtSecs(j.endedAt-(j.startedAt||j.createdAt));
    case 'failed':     return j.msg||'Failed';
  }
  return '';
}

function jobHTML(j){
  const fin=!ACTIVE.has(j.state);
  let icon;
  if(j.state==='done') icon='<div class="vt-q-icon ok">✓</div>';
  else if(j.state==='failed') icon='<div class="vt-q-icon bad">✕</div>';
  else if(j.state==='queued') icon='<div class="vt-q-icon">#'+queuePos(j)+'</div>';
  else icon='<div class="vt-q-icon"><span class="vt-spin"></span></div>';

  const si=stepIdx(j);
  const steps='<div class="vt-q-steps">'+STEPS.map((s,i)=>{
    let c='';
    if(i<si||(i===4&&j.state==='done')) c='done';
    else if(i===si&&!fin) c='on';
    else if((i===4||(i===si&&si<4))&&j.state==='failed') c='bad';
    return '<span class="'+c+'">'+(i===4&&j.state==='failed'?'Failed':s)+'</span>';
  }).join('')+'</div>';
  const auto=j.kind==='auto', cron=j.kind==='cron';
  const kindLabel=cron?'Cron':auto?'Auto':'Rescan';
  const pbar=j.state==='processing'?'<div class="vt-q-pbar"><div style="width:'+Math.round((j.polls||0)/POLL_MAX*100)+'%"></div></div>':'';

  let right;
  if(j.state==='done'&&j.result){
    const st=j.result.status, dc=DOT_CLS[st];
    right='<span class="vt-badge '+st+'">'+(dc?'<span class="vt-dot '+dc+'"></span>':'')+(LABELS[st]??st)+'</span>'
      +'<div>'+(j.prev&&j.prev.malicious!==undefined?scoreTxt(j.prev)+' → ':'')+'<strong>'+scoreTxt(j.result)+'</strong></div>';
  }else if(fin){
    right='<div>was '+scoreTxt(j.prev)+'</div>';
  }else{
    right='<div>'+fmtSecs(Date.now()-(j.startedAt||j.createdAt))+'</div><div>was '+scoreTxt(j.prev)+'</div>';
    if(j.state==='queued') right+='<button type="button" class="vt-row-btn vt-q-skip" title="Take this entry out of the queue" onclick="event.stopPropagation();vtQSkip('+j.id+')">Skip</button>';
  }

  return '<div class="vt-q-item '+j.state+'">'+icon
    +'<div class="vt-q-main"><div class="vt-q-dom">'+vtEsc(j.domain)+'<span class="vt-q-kind">'+kindLabel+'</span></div>'
    +'<div class="vt-q-msg">'+vtEsc(jobMsg(j))+'</div>'+(auto||cron?'':steps)+pbar+'</div>'
    +'<div class="vt-q-right">'+right+'</div></div>';
}

function liveHTML(d){
  return '<div class="vt-q-item live"><div class="vt-q-icon"><span class="vt-spin"></span></div>'
    +'<div class="vt-q-main"><div class="vt-q-dom">'+vtEsc(d)+'<span class="vt-q-kind">Auto</span></div>'
    +'<div class="vt-q-msg">Fetching the report from VirusTotal...</div></div>'
    +'<div class="vt-q-right"></div></div>';
}

// One line only: what is being checked right now, otherwise the latest result.
// Below it, an animated bar while waiting for VirusTotal's 4 requests/minute limit.
let queueCollapsed=localStorage.getItem('vt_q_collapsed')==='1';
window.vtQueueToggle=function(e){
  if(e&&e.target&&e.target.tagName==='BUTTON') return; // let button handle its own click
  queueCollapsed=!queueCollapsed;
  localStorage.setItem('vt_q_collapsed',queueCollapsed?'1':'0');
  applyQueueCollapse();
};
function applyQueueCollapse(){
  const box=document.getElementById('vt-queue');
  if(!box) return;
  box.classList.toggle('vt-q-collapsed',queueCollapsed);
  const t=document.getElementById('vt-q-toggle');
  if(t){t.textContent=queueCollapsed?'▼ Expand':'▲ Collapse';t.title=queueCollapsed?'Show Scan Monitor':'Hide Scan Monitor';}
}
// ── Server-side manual queue ───────────────────────────────────
// Domains pushed to the server on Rescan, so the cron can finish them if the
// browser navigates away before the in-browser job completes.
let serverQueue=[], serverQueueAt={}, serverQueuePoll=null, srvSkipped={};

function vtServerPost(action,domain){
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  fetch(BASE+'?action='+action,{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},
    body:new URLSearchParams({domain})}).catch(()=>{});
}

async function vtPollServerQueue(){
  try{
    // Heartbeat: rescans this page still runs or has waiting stay with this page, not with cron
    const mine=[...new Set(jobs.filter(j=>j.kind!=='auto'&&j.kind!=='cron'&&ACTIVE.has(j.state)).map(j=>j.domain))];
    if(mine.length){
      const fpToken=document.getElementById('forgery_protection_token')?.content||'';
      fetch(BASE+'?action=rescan-alive',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams({domains:mine.join(',')})}).catch(()=>{});
    }
    const data=await vtFetch('?action=queue-status');
    const inBrowser=new Set(jobs.filter(j=>ACTIVE.has(j.state)).map(j=>j.domain));
    const prev=serverQueue.slice();
    serverQueue=(data.pending||[]).filter(d=>!inBrowser.has(d)&&!(Date.now()-(srvSkipped[d]||0)<60000));
    serverQueueAt=data.queued_at||{};

    // Domains that cron processed: show them in the monitor as done jobs
    const cronDone=new Set(jobs.filter(j=>j.kind==='cron').map(j=>j.domain));
    for(const d of (data.completed||[])){
      if(!cronDone.has(d)&&!inBrowser.has(d)){
        const doneAt=(data.completed_at?.[d]||0)*1000||Date.now();
        jobs.push({id:++jobSeq,domain:d,kind:'cron',state:'done',
          msg:'',result:null,prev:null,createdAt:doneAt,startedAt:doneAt,endedAt:doneAt});
        startQTicker();
        // Fetch fresh result to update the table row
        vtFetch('?action=scan&domain='+encodeURIComponent(d)) // cron already saved the fresh result: no new VirusTotal call
          .then(r=>{results[d]=r;updateRow(d,r);updateCounts();})
          .catch(()=>{});
      }
    }
    // Also handle domains that left the pending list without appearing in completed
    // (e.g. dequeued by browser from another tab)
    for(const d of prev){
      if(!data.pending?.includes(d)&&!inBrowser.has(d)&&!cronDone.has(d)){
        vtFetch('?action=scan&domain='+encodeURIComponent(d)) // cron already saved the fresh result: no new VirusTotal call
          .then(r=>{results[d]=r;updateRow(d,r);updateCounts();})
          .catch(()=>{});
      }
    }
    renderQueue();
  }catch(e){}
}

function startServerQueuePoll(){
  if(serverQueuePoll) return;
  serverQueuePoll=setInterval(vtPollServerQueue,30000);
}

function serverJobHTML(domain){
  const qAt=serverQueueAt[domain]||0;
  const ago=qAt?fmtSecs(Date.now()-qAt*1000)+' ago':'';
  return '<div class="vt-q-item vt-q-srv queued">'
    +'<div class="vt-q-icon">⏳</div>'
    +'<div class="vt-q-main"><div class="vt-q-dom">'+vtEsc(domain)
    +'<span class="vt-q-kind srv">Server</span></div>'
    +'<div class="vt-q-msg">Queued on server'+(ago?' — '+ago:'')
    +' — cron will process this within 5 minutes</div></div>'
    +'<div class="vt-q-right">'+'<button type="button" class="vt-row-btn vt-q-skip" data-d="'+vtEsc(domain)+'" title="Take this entry out of the queue" onclick="event.stopPropagation();vtQSkipSrv(this.dataset.d)">Skip</button>'+'</div></div>';
}

// ── File-scanner jobs in the Scan Monitor ──────────────────────
let fsJobs=[];
function getFsJob(domain,id){return fsJobs.find(j=>j.domain===domain&&j.scanner===id&&!j.endedAt);}
function addFsJob(domain,id){
  fsJobs=fsJobs.filter(j=>!(j.domain===domain&&j.scanner===id)); // drop any old entry
  const j={id:'fs-'+(++jobSeq),domain,scanner:id,state:'running',startedAt:Date.now(),endedAt:null,result:null,msg:'',progress:null};
  fsJobs.push(j); startQTicker(); return j;
}
function updateFsJob(domain,id,state,result,msg,progress){
  const j=getFsJob(domain,id); if(!j) return;
  j.state=state; if(result) j.result=result; if(msg) j.msg=msg; if(progress!==undefined) j.progress=progress;
  if(state==='done'||state==='failed') j.endedAt=Date.now();
  renderQueue();
}
function fsJobHTML(j){
  let icon;
  if(j.state==='done')   icon='<div class="vt-q-icon ok">✓</div>';
  else if(j.state==='failed') icon='<div class="vt-q-icon bad">✕</div>';
  else if(j.state==='queued') icon='<div class="vt-q-icon">…</div>';
  else icon='<div class="vt-q-icon"><span class="vt-spin"></span></div>';

  const prog=j.state==='running'&&j.progress?fsProgress(j.progress):null;

  let msg=j.msg;
  if(!msg){
    if(j.state==='running'){
      if(prog){
        const imu=String(j.progress?.phase||'').startsWith('Imunify');
        msg=imu?(j.progress.phase+(prog.pct?' · '+prog.pct+'%':''))
               :(prog.files+(prog.left?' · '+prog.left:''));
      } else {
        msg='Scanning files…';
      }
    }
    else if(j.state==='queued')  msg='Waiting — another scan is running on the server';
    else if(j.state==='done')    msg=j.result?(j.result.infected?j.result.infected+' infected file(s) found in '+(j.result.files||0).toLocaleString()+' files':'No infected files in '+(j.result.files||0).toLocaleString()+' files'):'Scan complete';
    else                         msg='Scan failed';
  }

  let pbar='';
  if(j.state==='running'&&(j.pct!=null||j.indet)){
    pbar='<div class="vt-q-pbar'+(j.indet?' indet':'')+'"><div style="width:'+(j.indet?30:Math.max(2,Math.min(100,j.pct)))+'%"></div></div>';
  }else if(prog){
    pbar='<div class="vt-q-pbar"><div style="width:'+prog.pct+'%"></div></div>';
  }else if(j.state==='running'){
    const pct=Math.min(90,Math.round((Date.now()-j.startedAt)/300000*100));
    pbar='<div class="vt-q-pbar"><div style="width:'+pct+'%"></div></div>';
  }else if(j.state==='done'){
    pbar='<div class="vt-q-pbar"><div style="width:100%"></div></div>';
  }

  let right='';
  if(j.state==='done'&&j.result){
    const dur=(j.endedAt&&j.startedAt)?'<div>'+fmtSecs(j.endedAt-j.startedAt)+'</div>':'';
    right=dur+(j.result.infected
      ?'<span class="vt-badge infected"><span class="vt-dot dot-r"></span>'+j.result.infected+(j.label?' found':' infected')+'</span>'
      :'<span class="vt-badge clean"><span class="vt-dot dot-g"></span>Clean</span>');
  }else if(j.state==='running'){
    right='<div>'+fmtSecs(Date.now()-j.startedAt)+'</div>';
  }
  return '<div class="vt-q-item vt-q-fs '+j.state+'">'+icon
    +'<div class="vt-q-main"><div class="vt-q-dom">'+vtEsc(j.domain)
    +'<span class="vt-q-kind fs">'+vtEsc(j.label||fsName(j.scanner))+'</span></div>'
    +'<div class="vt-q-msg">'+vtEsc(msg)+'</div>'+pbar+(j.stats?'<div class="vt-q-stats">'+vtEsc(j.stats)+'</div>':'')+'</div>'
    +'<div class="vt-q-right">'+right+'</div></div>';
}

// ── Pwned? checks in the Scan Monitor ─────────────────────────
// One line per e-mail address that is sent to the breach service (XposedOrNot or Have I Been Pwned)
let pwJobs=[];
function pwJobStart(email){
  const j={id:'pw-'+(++jobSeq),pw:true,domain:email,state:'running',startedAt:Date.now(),endedAt:null,result:null,msg:'',until:0};
  pwJobs=pwJobs.filter(x=>!(x.domain===email&&!x.endedAt)); pwJobs.push(j);
  startQTicker(); renderQueue(); return j;
}
function pwJobWait(j,secs){j.state='queued'; j.until=Date.now()+secs*1000; renderQueue();}
// Wait, but stop early when the entry is skipped in the Scan Monitor
function pwJobDelay(j,ms){return new Promise(res=>{const t=setTimeout(res,ms); j.wake=()=>{clearTimeout(t); res();};});}
function pwJobEnd(j,state,result,msg){j.state=state; j.result=result||null; j.msg=msg||''; j.endedAt=Date.now(); renderQueue();}
function pwJobHTML(j){
  const src=pw?.config?.source_name||'breach service';
  let icon, msg=j.msg, right='';
  if(j.state==='done') icon='<div class="vt-q-icon ok">✓</div>';
  else if(j.state==='failed') icon='<div class="vt-q-icon bad">✕</div>';
  else if(j.state==='queued') icon='<div class="vt-q-icon">…</div>';
  else icon='<div class="vt-q-icon"><span class="vt-spin"></span></div>';
  if(!msg){
    if(j.state==='running') msg='Asking '+src+'…';
    else if(j.state==='queued') msg='Waiting for the request limit of '+src+' — next try in '+fmtSecs(Math.max(0,j.until-Date.now()));
    else if(j.state==='done') msg='Checked with '+src+' at '+new Date(j.endedAt).toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
    else msg='Check failed';
  }
  if(j.state==='done'&&j.result){
    const n=j.result.breaches?.length||0;
    right=n?'<span class="vt-badge infected"><span class="vt-dot dot-r"></span>Pwned: '+n+'</span>':'<span class="vt-badge clean"><span class="vt-dot dot-g"></span>Not pwned</span>';
  }else if(!j.endedAt) right='<div>'+fmtSecs(Date.now()-j.startedAt)+'</div>'+(j.state==='queued'?'<button type="button" class="vt-row-btn vt-q-skip" title="Take this entry out of the queue" onclick="event.stopPropagation();vtQSkip(\''+j.id+'\')">Skip</button>':'');
  return '<div class="vt-q-item vt-q-pw '+j.state+'">'+icon
    +'<div class="vt-q-main"><div class="vt-q-dom">'+vtEsc(j.domain)+'<span class="vt-q-kind pw">Pwned?</span></div>'
    +'<div class="vt-q-msg">'+vtEsc(msg)+'</div></div>'
    +'<div class="vt-q-right">'+right+'</div></div>';
}

function renderQueue(){
  const box=document.getElementById('vt-queue');
  if(!box) return;
  const pumpBusy=pumpRunning&&(pumpCurrent||scanQueue.length);
  if(!jobs.length&&!fsJobs.length&&!pwJobs.length&&!pumpBusy&&!serverQueue.length){box.style.display='none';return;}
  box.style.display='block';
  applyQueueCollapse();
  if(pumpBusy) startQTicker();

  const running=jobs.filter(j=>ACTIVE.has(j.state)&&j.state!=='queued');
  const waiting=jobs.filter(j=>j.state==='queued');
  const finished=jobs.filter(j=>!ACTIVE.has(j.state)).sort((a,b)=>b.endedAt-a.endedAt);
  const fsActive=fsJobs.filter(j=>j.state==='running'||j.state==='queued');
  const fsDone=fsJobs.filter(j=>j.state==='done'||j.state==='failed').sort((a,b)=>b.endedAt-a.endedAt);
  const pwActive=pwJobs.filter(j=>!j.endedAt);
  const pwDone=pwJobs.filter(j=>j.endedAt);
  const allFinished=[...finished,...fsDone,...pwDone].sort((a,b)=>b.endedAt-a.endedAt).slice(0,8);
  // Server-queue: domains pushed to server but not in any active in-browser job
  const inBrowserDomains=new Set([...jobs.filter(j=>ACTIVE.has(j.state)).map(j=>j.domain),...(pumpCurrent?[pumpCurrent]:[])]);
  const srvItems=serverQueue.filter(d=>!inBrowserDomains.has(d));
  const hasActive=pumpCurrent||running.length||waiting.length||fsActive.length||srvItems.length||pwActive.length;

  // Active queue first, then a divider, then recently completed
  let html='';
  if(pumpCurrent) html+=liveHTML(pumpCurrent);
  running.forEach(j=>{ html+=jobHTML(j); });
  fsActive.forEach(j=>{ html+=fsJobHTML(j); });
  pwActive.forEach(j=>{ html+=pwJobHTML(j); });
  waiting.slice(0,5).forEach(j=>{ html+=jobHTML(j); });
  srvItems.forEach(d=>{ html+=serverJobHTML(d); });
  if(allFinished.length&&hasActive) html+='<div class="vt-q-divider">Completed</div>';
  allFinished.forEach(j=>{ html+=(j.pw?pwJobHTML(j):j.scanner?fsJobHTML(j):jobHTML(j)); });
  document.getElementById('vt-q-list').innerHTML=html;

  // Pause bar
  const now=Date.now(), rw=running.find(j=>j.state==='ratewait');
  let from=0, until=0, limit=false;
  if(rw){ from=rw.waitFrom||now; until=rw.until; limit=true; }
  else if(pumpPauseUntil>now){ from=pumpPauseFrom; until=pumpPauseUntil; limit=pumpPauseLimit; }
  const bar=document.getElementById('vt-q-pause');
  if(until>now){
    bar.style.display='flex';
    const fill=document.getElementById('vt-q-pfill');
    fill.classList.toggle('limit',limit);
    fill.style.width=Math.min(100,Math.round((now-from)/Math.max(1,until-from)*100))+'%';
    vtSet('vt-q-ptext',(limit?'VirusTotal rate limit reached, waiting':'Pausing for VirusTotal\'s limit of 4 requests per minute')
      +' — next check in '+fmtSecs(until-now));
  }else{
    bar.style.display='none';
  }

  const left=waiting.length+scanQueue.length;
  const parts=[];
  if(running.length||pumpCurrent||fsActive.length||pwActive.length) parts.push('checking '+(running.length+fsActive.length+pwActive.length+(pumpCurrent?1:0)));
  if(left) parts.push(left+' waiting');
  if(srvItems.length) parts.push(srvItems.length+' on server');
  if(allFinished.length) parts.push(allFinished.length+' done');
  vtSet('vt-q-sum',parts.join(' · '));
  document.getElementById('vt-q-cancel').style.display=waiting.length?'':'none';
}

window.vtRefreshDomains=async function(){
  vtToast('Refreshing site list...','info');
  const data=await vtFetch('?action=refresh-domains').catch(()=>({}));
  if(data.domains){
    domains=data.domains; vtSet('vt-cnt-all',domains.length);
    // Orphan databases too (the server cache was just cleared, so a deleted database drops out)
    const all=await vtFetch('?action=all').catch(()=>null);
    if(all){
      related=all.related||[]; relSet=new Set(related); orphans=all.orphans||{}; owners=all.owners||{};
      external=all.external||[]; extSet=new Set(external.map(x=>x.domain)); vtRenderExternal();
      Object.assign(results,all.results||{});
      for(const d of related) if(!results[d]) results[d]={status:'unchecked',domain:d};
    }
    scanQueue=domains.filter(d=>!results[d]); renderTable(); updateCounts(); pump();
  }
};

// ── Settings ──────────────────────────────────────────────────
window.vtNotifyUi=function(){
  document.getElementById('vt-n-opts').classList.toggle('off',!document.getElementById('vt-n-enabled').checked);
};
window.vtTestNotify=async function(){
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const msg=document.getElementById('vt-n-msg'); msg.style.display='inline'; msg.className='vt-smsg'; msg.textContent='Sending...';
  const body=new URLSearchParams({email:document.getElementById('vt-n-email').value.trim()});
  const res=await fetch(BASE+'?action=test-notify',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body}).then(r=>r.json()).catch(()=>({error:'Network error'}));
  msg.className='vt-smsg '+(res.ok?'ok':'err');
  msg.textContent=res.ok?'Test e-mail sent to '+res.email:(res.error||'Could not send');
  setTimeout(()=>{msg.style.display='none';},6000);
};
let savedWpOnly=false;
function loadSettingsForm(cfg){
  const keyInput=document.getElementById('vt-s-apikey');
  const kd=document.getElementById('vt-key-display');
  if(cfg.api_key_readable){
    keyInput.placeholder='Current key: '+(cfg.api_key_readable.substring(0,8))+'...';
    document.getElementById('vt-key-value').textContent=cfg.api_key_readable;
    kd.style.display='block';
  }
  document.getElementById(cfg.wordpress_only?'vt-s-scope-wp':'vt-s-scope-all').checked=true;
  savedWpOnly=!!cfg.wordpress_only;
  document.getElementById('vt-s-rogue-scan').checked=cfg.wp_rogue_scan!==false;
  document.getElementById('vt-s-wp-delete').checked=!!cfg.wp_user_delete;
  if(cfg.role==='admin'){
  }
  // Notifications: only offer the recipients this role may use
  document.getElementById('vt-n-enabled').checked=!!cfg.notify_enabled;
  const evs=cfg.notify_events||['infected','suspicious'];
  document.querySelectorAll('input[name=vt-n-ev]').forEach(c=>c.checked=evs.includes(c.value));
  const em=document.getElementById('vt-n-email');
  em.value=cfg.notify_email||'';
  if(cfg.access){ document.getElementById('vt-set-access').style.display='';
    document.getElementById('vt-acc-res').checked=!!cfg.access.resellers; document.getElementById('vt-acc-cl').checked=!!cfg.access.clients; }
  if(cfg.panel){ document.getElementById('vt-pn-box').style.display=cfg.panel.available?'':'none';
    document.querySelectorAll('input[name=vt-pn]').forEach(c=>c.checked=(cfg.panel.kinds||[]).includes(c.value)); }
  document.getElementById('vt-rv-name').value=cfg.review_name||'';
  document.getElementById('vt-rv-company').value=cfg.review_company||'';
  document.getElementById('vt-rv-email').value=cfg.review_email||'';
  document.getElementById('vt-rv-email').placeholder=cfg.notify_email||cfg.my_email||'name@example.com';
  reviewFrom={name:cfg.review_name||'',company:cfg.review_company||''};
  if(cfg.review_email||cfg.notify_email) myEmail=cfg.review_email||cfg.notify_email;
  em.placeholder=cfg.my_email||'name@example.com';
  vtNotifyUi();
  if(cfg.daily_limit)       document.getElementById('vt-s-daily').value    =cfg.daily_limit;
  if(cfg.auto_scan_share)   document.getElementById('vt-s-share').value    =Math.round(cfg.auto_scan_share*100);
  vtQsRender();
  if(cfg.clean_ttl_days)    document.getElementById('vt-s-clean-ttl').value=cfg.clean_ttl_days;
  if(cfg.infected_ttl_days) document.getElementById('vt-s-inf-ttl').value  =cfg.infected_ttl_days;
  checkRates=cfg.check_rates||{};
  vtRenderScanners(cfg.scanners||[],cfg.role==='admin');
  document.getElementById('vt-av-card').style.display=cfg.role==='admin'?'':'none';
  document.getElementById('vt-gsb-card').style.display=cfg.role==='admin'?'':'none';
  document.querySelectorAll('input[name=vt-av]').forEach(r=>r.checked=(cfg.avast_products||[]).includes(+r.value));
  for(const id of [146,147]) vtSet('vt-av-calls-'+id,(cfg.avast_calls||{})[id]??0);
  // Green check when a key is accepted and in use, red cross with the reason when not
  const ks=(id,cls,text,title)=>{const e=document.getElementById(id); if(!e) return; e.className='vt-key-state'+(cls?' '+cls:''); e.textContent=text; e.title=title||'';};
  if(cfg.api_key_invalid) ks('vt-vt-keystate','bad','API key not accepted','VirusTotal rejected the stored key (HTTP 401)');
  else if(cfg.has_key) ks('vt-vt-keystate','ok','API key active','VirusTotal accepted the key');
  else ks('vt-vt-keystate','off','no API key');
  if(cfg.gsb){
    const g=cfg.gsb, last=g.last||{};
    if(!g.key) ks('vt-gsb-keystate','off','no API key');
    else if(last.ok===false) ks('vt-gsb-keystate','bad','API key problem',last.error||'');
    else if(!g.enabled) ks('vt-gsb-keystate','off','key stored, switched off');
    else ks('vt-gsb-keystate','ok','API key active',last.at?'Last answer from Google: '+new Date(last.at*1000).toLocaleString():'Key tested when it was saved');
    document.getElementById('vt-gsb-on').checked=!!cfg.gsb.enabled;
    vtSet('vt-gsb-calls',cfg.gsb.calls??0);
    vtSet('vt-gsb-stored',cfg.gsb.key?'stored key '+cfg.gsb.key:'no key stored');
    document.getElementById('vt-gsb-key').value='';
  }
  vtRenderQuarantine(cfg.quarantine||null);
  vtRenderPwCfg(cfg.pwned||null);
  vtRenderStats(cfg.stats||null);
  if(cfg.admin_watch){document.getElementById('vt-aw-trusted').value=cfg.admin_watch.trusted||''; document.getElementById('vt-aw-mail').checked=!!cfg.admin_watch.mail;}
  const ms=cfg.mail_sender;
  document.getElementById('vt-ms-card').style.display=ms?'':'none';
  if(ms){
    document.getElementById('vt-ms-from').value=ms.from||''; document.getElementById('vt-ms-name').value=ms.name||'';
    vtSet('vt-ms-default',ms.default?' ('+ms.default+')':'');
  }
  const lr=cfg.log_rotation;
  document.getElementById('vt-lr-card').style.display=lr?'':'none';
  if(lr){
    document.getElementById('vt-s-log-mb').value=lr.log_max_mb; document.getElementById('vt-s-log-keep').value=lr.log_keep; document.getElementById('vt-s-log-days').value=lr.log_max_days;
    const mb=b=>(b/1048576).toFixed(b<104858?2:1)+' MB';
    vtSet('vt-lr-info','Now: '+lr.logs+' log'+(lr.logs===1?'':'s')+' ('+mb(lr.logs_bytes)+'), '+lr.old+' old cop'+(lr.old===1?'y':'ies')+' ('+mb(lr.old_bytes)+').');
  }
  document.querySelectorAll('[data-check-rate]').forEach(input=>{input.value=cfg.check_rates?.[input.dataset.checkRate]||2;input.disabled=cfg.role!=='admin';});
  vtBuildToc();
}

// ── Contents at the top of Settings: one column per group, a link per visible section ──
function vtBuildToc(){
  const panel=document.getElementById('vtpanel-settings'), cols=[]; let col=null;
  for(const el of panel.children){
    if(el.dataset.tocGroup){ col={el,label:el.dataset.tocGroup,items:[]}; cols.push(col); continue; }
    if(!el.dataset.toc||!col) continue;
    if(el.style.display!=='none') col.items.push(el);
  }
  cols.forEach(c=>c.el.style.display=c.items.length?'':'none');
  // A way back to this index from every group heading and at the end of every section
  const back='<a class="vt-totop" href="#vt-toc" onclick="vtTocGo(event,\'vt-toc\')" title="Back to the index at the top of Settings">↑ Index</a>';
  for(const c of cols){
    if(!c.el.querySelector('.vt-totop')) c.el.insertAdjacentHTML('beforeend',back);
    for(const it of c.items) if(!it.querySelector(':scope>.vt-totop-row')) it.insertAdjacentHTML('beforeend','<div class="vt-totop-row">'+back+'</div>');
  }
  document.getElementById('vt-toc-cols').innerHTML=cols.filter(c=>c.items.length).map(c=>
    '<div class="vt-toc-col"><a class="vt-toc-grp" href="#'+c.el.id+'" onclick="vtTocGo(event,\''+c.el.id+'\')">'+vtEsc(c.label)+'</a>'
    +c.items.map(it=>'<a href="#'+it.id+'" onclick="vtTocGo(event,\''+it.id+'\')">'+it.dataset.toc+'</a>').join('')+'</div>').join('');
}
window.vtTocGo=function(ev,id){
  if(ev) ev.preventDefault();
  const el=document.getElementById(id); if(!el) return;
  el.scrollIntoView({behavior:'smooth',block:'start'});
  el.classList.remove('vt-toc-hit'); void el.offsetWidth; el.classList.add('vt-toc-hit');
};
// Pwned Admins tool, or (when switched off and hidden) its setting
window.vtOpenPwned=function(ev){
  if(ev) ev.preventDefault();
  if(document.getElementById('vtcard-pwned')?.style.display==='none') return vtGoSetting(null,'vt-pwcfg-card');
  vtShowTab('tools'); vtToolSelect('pwned');
};
// From another tab: open Settings, then go to the section
window.vtGoSetting=function(ev,id){ if(ev) ev.preventDefault(); vtShowTab('settings'); setTimeout(()=>vtTocGo(null,id),60); };

// ── Installation statistics (Settings, administrator): what would be sent, shown from this server only ──
function vtRenderStats(st){
  const card=document.getElementById('vt-stats-card'); card.style.display=st?'':'none'; if(!st) return;
  document.getElementById('vt-stats-share').checked=!!st.enabled;
  const d=ts=>ts?new Date(ts*1000).toLocaleString():'—';
  const row=(k,v)=>'<tr><td>'+k+'</td><td>'+v+'</td></tr>';
  let last=st.enabled?(st.last_ok?'last sent '+d(st.last_ok):'not sent yet')
    +(st.last_status==='failed'?' · last try failed ('+vtEsc(st.last_error||'no answer')+'), next try '+d(st.next_try)
     :st.last_status==='inventory'?' · waiting: the site count could not be read':st.next_try?' · next '+d(st.next_try):''):'sharing is off: nothing is sent';
  document.getElementById('vt-stats-info').innerHTML='<table class="vt-fs-tbl vt-stats-tbl"><tbody>'
    +row('Hostname',st.hostname?vtEsc(st.hostname):'<span class="hint">unknown (nothing would be sent)</span>')
    +row('Hosted websites',st.hosted_sites===null?'<span class="hint">could not be counted (nothing would be sent)</span>':st.hosted_sites)
    +row('Version',vtEsc(st.version||'—'))
    +row('Installation ID',st.has_id?'<span class="hint">random, stored on this server</span>':'<span class="hint">made when you switch sharing on</span>')
    +row('Status',vtEsc(last))+'</tbody></table>';
}

// ── E-mail sender (Settings, administrator) ───────────────────
window.vtMsCheck=async function(){
  const el=document.getElementById('vt-ms-result'); el.innerHTML='<span class="vt-spin"></span> Checking the DNS records of the sender domain…';
  const r=await vtFetch('?action=mail-check').catch(()=>({error:'Network error'}));
  if(r.error){el.innerHTML='<div class="vt-fa-q err">'+vtEsc(r.error)+'</div>'; return;}
  const ic={ok:'<span style="color:var(--green,#16a34a)">✓</span>',warn:'<span style="color:#d97706">!</span>',bad:'<span style="color:var(--red)">✕</span>'};
  el.innerHTML='<table class="vt-fs-tbl vt-ms-tbl"><thead><tr><th colspan="2">'+vtEsc(r.address)+'</th></tr></thead><tbody>'
    +r.checks.map(c=>'<tr><td><strong>'+ic[c.state]+' '+vtEsc(c.label)+'</strong></td><td>'+c.detail+'</td></tr>').join('')+'</tbody></table>';
};
window.vtMsTest=async function(){
  const to=document.getElementById('vt-ms-testto').value.trim(), el=document.getElementById('vt-ms-result'); if(!to) return;
  const r=await vtPostAct('mail-test',{to});
  el.innerHTML='<div class="vt-fa-q '+(r.ok?'ok':'err')+'">'+(r.ok?'Test sent from '+vtEsc(r.from)+' to '+vtEsc(r.to)+'. In the message source, <em>Authentication-Results</em> shows whether SPF, DKIM and DMARC passed.':vtEsc(r.error||'Failed'))+'</div>';
};

// ── Quarantine (Settings, administrator) ──────────────────────
let qInfo=null;
function vtQSize(b){return b<1024?b+' bytes':b<1048576?(b/1024).toFixed(1)+' KB':(b/1048576).toFixed(1)+' MB';}
window.vtQuarantineCancel=function(){vtRenderQuarantine(qInfo);};
function vtRenderQuarantine(q){
  qInfo=q;
  const card=document.getElementById('vt-q-card'); card.style.display=q?'':'none'; if(!q) return;
  document.getElementById('vt-s-q-days').value=q.days??30;
  const info=document.getElementById('vt-q-info'), del=document.getElementById('vt-q-del');
  if(q.error){info.innerHTML='<span style="color:var(--red)">'+vtEsc(q.error)+'</span>'; del.innerHTML=''; return;}
  info.innerHTML='<strong>'+q.count+' file'+(q.count===1?'':'s')+'</strong> in quarantine'
    +(q.count?' · '+vtQSize(q.bytes||0)+' · oldest from '+new Date(q.oldest*1000).toLocaleDateString():'');
  del.innerHTML=q.count?'<button type="button" class="vt-btn danger" onclick="vtQAsk()">Delete all quarantined files</button>':'';
}
window.vtQAsk=function(){
  const n=qInfo?.count||0;
  document.getElementById('vt-q-del').innerHTML='<div class="vt-fa-q err"><strong>Delete all '+n+' quarantined file'+(n===1?'':'s')+' permanently?</strong> '
    +'They cannot be restored afterwards, not even by Stingy Scanner.</div>'
    +'<button type="button" class="vt-btn danger" onclick="vtQDeleteAll()">Delete permanently</button> '
    +'<button type="button" class="vt-btn ghost" onclick="vtQuarantineCancel()">Cancel</button>';
};
window.vtQDeleteAll=async function(){
  const el=document.getElementById('vt-q-del'); el.innerHTML='<span class="vt-spin"></span> Deleting…';
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const r=await fetch(BASE+'?action=quarantine-delete-all',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken}}).then(x=>x.json()).catch(()=>({error:'Network error'}));
  if(r.quarantine) vtRenderQuarantine(r.quarantine);
  handled={}; // the per-site lists are loaded again when a site is opened
  el.insertAdjacentHTML('beforeend','<div class="vt-fa-q '+(r.ok?'ok':'err')+'">'+(r.ok?r.deleted+' file'+(r.deleted===1?'':'s')+' deleted for good.':vtEsc(r.error||'Failed'))+'</div>');
};

// ── File scanners on/off (server-wide, administrator) ─────────
let scIsAdmin=false, checkRates={};
// One scan engine only (see VtScanEngine): ClamAV when installed, else Maldet when "Maldet enabled" is on.
function vtRenderScanners(sc,isAdmin){
  scIsAdmin=isAdmin;
  const el=document.getElementById('vt-sc-list');
  document.getElementById('vt-sc-detect').style.display=isAdmin?'':'none';
  if(!sc||!sc.engines||sc.failed){el.innerHTML='<span class="hint">Could not ask the server which scanners are installed.</span>';return;}
  const c=sc.engines.clamav||{}, m=sc.engines.maldet||{}, a=sc.active||{}, i=sc.imunify||{};
  const rate=(id,name)=>'<label class="vt-rate" for="vt-rate-'+id+'"><input type="number" id="vt-rate-'+id+'" data-check-rate="'+id+'" min="1" max="5" step="1" value="'+(checkRates[id]||2)+'" '+(!isAdmin?'disabled ':'')+'aria-label="'+name+' scans per minute"> / minute</label>';
  const sw=(id,on,can,title)=>'<label class="vt-sw" title="'+title+'"><input type="checkbox" '+(on?'checked ':'')+(can&&isAdmin?'':'disabled ')+'onchange="vtToggleScanner(\''+id+'\',this.checked)"><span></span></label>';
  // How recent the newest signatures (definitions) are: orange after 3 days, red after 7, with how to update them
  const sig=(ts,fix)=>{
    if(!ts) return '<br>Latest definitions: <span class="hint">unknown</span>';
    const days=(Date.now()/1000-ts)/86400, col=days>7?'var(--red)':days>3?'var(--orange,#d97706)':'var(--green,#16a34a)';
    const full=new Date(ts*1000).toLocaleString('nl-NL',{day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit'});
    return '<br>Latest definitions: <strong style="color:'+col+'" title="'+full+'">'+vtAgo(ts)+'</strong> <span class="hint">('+full+')</span>'
      +(days>3&&fix?' · <span style="color:'+col+'">'+fix+'</span>':'');
  };
  let h='<div class="vt-sc-sub">Scan engine</div>';
  h+='<div class="vt-sc-row'+(c.installed?'':' missing')+'"><span class="vt-sc-name">'+vtBrandIco('clamav')+'ClamAV</span><span class="vt-sc-info">'
    +(c.installed?'<strong>Installed</strong>'+(c.version?' · version '+vtEsc(c.version):'')+' · daemon running: <strong>'+(c.daemon?'yes':'no')+'</strong>'+(sc.clamav_detail?' · '+vtEsc(sc.clamav_detail):'')
      +sig(c.sigdate,'check that <code>freshclam</code> runs (e.g. <code>systemctl status clamav-freshclam</code>)')
                 :'Not installed')+'</span>'+(c.installed?rate('clamav','ClamAV'):'')+'</div>';
  h+='<div class="vt-sc-row'+(m.installed?'':' missing')+'">'+sw('maldet',sc.maldet_enabled,m.installed,'Maldet enabled')
    +'<span class="vt-sc-name">'+vtBrandIco('maldet')+'Maldet</span><span class="vt-sc-info">'
    +(m.installed?'<strong>Installed</strong>'+(m.version?' · version '+vtEsc(m.version):'')+sig(m.sigdate,'run <code>maldet -u</code> on the server'):'Not installed')
    +' · Maldet enabled: <strong>'+(sc.maldet_enabled?'on':'off')+'</strong>'
    +(c.installed?'<br>Ignored while ClamAV is installed: ClamAV already scans with the Maldet signatures, so Maldet never runs.':'<br>Used only when ClamAV is not installed.')
    +'</span>'+(m.installed&&!c.installed?rate('maldet','Maldet'):'')+'</div>';
  if(c.installed&&m.installed){
    const r=c.rfxn||{}, miss=Object.keys(r).filter(k=>!r[k]);
    h+='<div class="vt-sc-row"><span class="vt-sc-name">Signatures</span><span class="vt-sc-info">Maldet signatures in ClamAV'+(c.sigdir?' (<code>'+vtEsc(c.sigdir)+'</code>)':'')+': '
      +Object.keys(r).map(k=>'<code>'+vtEsc(k)+'</code> '+(r[k]?'<span style="color:var(--green,#16a34a)">✓</span>':'<span style="color:var(--red)">missing</span>')).join(' · ')
      +(miss.length?'<br><span style="color:var(--red)">Run <code>maldet -u</code> on the server: it copies the Maldet signatures into ClamAV.</span>':'')+'</span></div>';
  }
  h+='<div class="vt-sc-row"><span class="vt-sc-name">Active engine</span><span class="vt-sc-info">'
    +(a.id?'<strong>'+vtEsc(a.name)+'</strong> · button in the site details: <strong>'+vtEsc(a.label)+'</strong>':'<strong style="color:var(--red)">None</strong> · '+vtEsc(a.message||''))+'</span></div>';
  if(i.installed){
    h+='<div class="vt-sc-sub">Other results</div><div class="vt-sc-row">'+sw('imunify',i.enabled,true,isAdmin?'Switch on or off':'Set by the administrator')
      +'<span class="vt-sc-name">'+vtBrandIco('imunify')+'Imunify</span><span class="vt-sc-info">Installed: '+vtEsc(i.detail||'')+' · shows the results of Imunify\'s own scans, starts no scan'+(i.enabled?'':' · <strong>switched off</strong>')+sig(i.sigdate,'Imunify updates itself: check its service')+'</span>'
      +rate('imunify','Imunify')+'</div>';
  }
  el.innerHTML=h+(isAdmin?'':'<div class="hint" style="margin-top:6px">Only the administrator can change these.</div>');
}
function vtScMsg(ok,text){
  const m=document.getElementById('vt-sc-msg');
  m.style.display='inline';m.className='vt-smsg '+(ok?'ok':'err');m.textContent=text;
  setTimeout(()=>{m.style.display='none';},4000);
}
function vtApplyScanners(sc){
  document.querySelectorAll('[data-check-rate]').forEach(input=>{checkRates[input.dataset.checkRate]=input.value;});
  scanners=sc.buttons||[];
  vtRenderScanners(sc,scIsAdmin);
  renderTable();
}
window.vtToggleScanner=async function(id,on){
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const res=await fetch(BASE+'?action=save-scanner',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},
    body:new URLSearchParams({scanner:id,enabled:on?'true':'false'})}).then(r=>r.json()).catch(()=>({error:'Network error'}));
  if(res.ok){vtApplyScanners(res.scanners);vtScMsg(true,'Saved');}
  else{vtScMsg(false,res.error||'Could not save');const cfg=await vtFetch('?action=get-settings').catch(()=>({}));vtRenderScanners(cfg.scanners||[],cfg.role==='admin');}
};
window.vtDetectScanners=async function(){
  const b=document.getElementById('vt-sc-detect');b.disabled=true;b.textContent='Detecting…';
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const res=await fetch(BASE+'?action=detect-scanners',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken}}).then(r=>r.json()).catch(()=>({error:'Network error'}));
  b.disabled=false;b.textContent='Re-detect engines';
  if(res.scanners&&!res.scanners.failed){vtApplyScanners(res.scanners);const a=res.scanners.active||{};vtScMsg(!!a.id,a.id?'Active engine: '+a.name:a.message);}
  else vtScMsg(false,res.error||'Could not detect');
};

// Feedback on every Save settings button (each section has one): Saving… → ✓ Saved / ✕ Not saved
function vtSaveBtns(state,text){
  document.querySelectorAll('button[onclick="vtSaveSettings()"]').forEach(b=>{
    if(!b.dataset.label) b.dataset.label=b.textContent;
    clearTimeout(b._t); b.classList.remove('vt-saved','vt-savefail');
    if(state==='busy'){b.disabled=true; b.innerHTML='<span class="vt-spin"></span> Saving…'; return;}
    b.disabled=false; b.textContent=text; b.classList.add(state==='ok'?'vt-saved':'vt-savefail');
    b._t=setTimeout(()=>{b.textContent=b.dataset.label; b.classList.remove('vt-saved','vt-savefail');},2500);
  });
}
window.vtSaveSettings=async function(){
  if(document.querySelector('button[onclick="vtSaveSettings()"][disabled]')) return; // already saving
  const key  =document.getElementById('vt-s-apikey').value.trim();
  const daily=parseInt(document.getElementById('vt-s-daily').value)||500;
  const share=(parseInt(document.getElementById('vt-s-share').value)||80)/100;
  const cttl =parseInt(document.getElementById('vt-s-clean-ttl').value)||30;
  const ittl =parseInt(document.getElementById('vt-s-inf-ttl').value)||1;
  const wpOnly=document.getElementById('vt-s-scope-wp').checked;
  const rogueScan=document.getElementById('vt-s-rogue-scan').checked;
  const checked=n=>[...document.querySelectorAll('input[name='+n+']:checked')].map(c=>c.value).join(',');
  const payload={wordpress_only:wpOnly?'true':'false',wp_rogue_scan:rogueScan?'true':'false',
    wp_user_delete:document.getElementById('vt-s-wp-delete').checked?'true':'false',
    notify_enabled:document.getElementById('vt-n-enabled').checked?'true':'false',
    notify_events:checked('vt-n-ev'),notify_email:document.getElementById('vt-n-email').value.trim(),
    ...(document.getElementById('vt-pn-box').style.display!=='none'?{panel_notify:[...document.querySelectorAll('input[name=vt-pn]:checked')].map(c=>c.value).join(',')||'none'}:{}),
    ...(document.getElementById('vt-set-access').style.display!=='none'?{show_resellers:document.getElementById('vt-acc-res').checked?'true':'false',show_clients:document.getElementById('vt-acc-cl').checked?'true':'false'}:{}),
    review_name:document.getElementById('vt-rv-name').value.trim(),review_company:document.getElementById('vt-rv-company').value.trim(),review_email:document.getElementById('vt-rv-email').value.trim(),daily_limit:daily,auto_scan_share:share,clean_ttl_days:cttl,infected_ttl_days:ittl};
  if(scIsAdmin){
    const rates={};
    for(const input of document.querySelectorAll('[data-check-rate]')){
      const n=Number(input.value);
      if(!Number.isInteger(n)||n<1||n>5){input.reportValidity();vtToast('Request limits must be whole numbers from 1 to 5 per minute','error');return;}
      rates[input.dataset.checkRate]=n;
    }
    payload.check_rates=JSON.stringify(rates);
    checkRates=rates;
  }
  if(key) payload.api_key=key;
  if(document.getElementById('vt-stats-card').style.display!=='none') payload.stats_share=document.getElementById('vt-stats-share').checked?'true':'false';
  if(scIsAdmin){
    payload.admin_trusted=document.getElementById('vt-aw-trusted').value;
    payload.admin_watch_mail=document.getElementById('vt-aw-mail').checked?'true':'false';
  }
  if(document.getElementById('vt-ms-card').style.display!=='none'){
    payload.mail_from=document.getElementById('vt-ms-from').value.trim();
    payload.mail_from_name=document.getElementById('vt-ms-name').value.trim();
  }
  if(document.getElementById('vt-q-card').style.display!=='none'){
    const qd=parseInt(document.getElementById('vt-s-q-days').value);
    payload.quarantine_days=isNaN(qd)?30:Math.max(0,Math.min(3650,qd));
    fileact.qdays=payload.quarantine_days;
  }
  if(document.getElementById('vt-lr-card').style.display!=='none'){
    payload.log_max_mb=parseInt(document.getElementById('vt-s-log-mb').value)||5;
    payload.log_keep=parseInt(document.getElementById('vt-s-log-keep').value)||5;
    payload.log_max_days=parseInt(document.getElementById('vt-s-log-days').value)||90;
  }
  if(document.getElementById('vt-gsb-card').style.display!=='none'){
    payload.gsb_enabled=document.getElementById('vt-gsb-on').checked?'true':'false';
    const gk=document.getElementById('vt-gsb-key').value.trim(); if(gk) payload.gsb_api_key=gk;
  }
  if(document.getElementById('vt-av-card').style.display!=='none') payload.avast_products=[...document.querySelectorAll('input[name=vt-av]:checked')].map(c=>c.value).join(',')||'0';

  const body=new URLSearchParams(payload);
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  vtSaveBtns('busy');
  const res=await fetch(BASE+'?action=save-settings',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body}).then(r=>r.json()).catch(()=>({error:'Network error'}));
  if(res.ok){vtSaveBtns('ok','✓ Saved'); vtToast('Settings saved'+(res.gsb_message?': '+res.gsb_message:''),'ok');}
  else{vtSaveBtns('err','✕ Not saved'); vtToast(res.error??'Error saving','err');}
  // Two save buttons (top and bottom of Settings): show the message next to both
  const msgs=['vt-smsg','vt-smsg2'].map(id=>document.getElementById(id)).filter(Boolean);
  const msg={set className(v){msgs.forEach(m=>m.className=v);},set textContent(v){msgs.forEach(m=>m.textContent=v);},
             style:{set display(v){msgs.forEach(m=>m.style.display=v);}}};
  msg.style.display='inline';
  if(res.ok){
    msg.className='vt-smsg ok'; msg.textContent='Saved!'+(res.gsb_message?' '+res.gsb_message:'');
    document.getElementById('vt-api-warning').style.display='none';
    document.getElementById('vt-s-apikey').value='';
    if(noKey&&key){setTimeout(()=>location.reload(),800);} // key added: start looking sites up
    const scopeChanged=wpOnly!==savedWpOnly;
    const cfg=await vtFetch('?action=get-settings').catch(()=>({}));
    loadSettingsForm(cfg);
    if(scopeChanged) vtRefreshDomains(); // reload the site list for the new scope
  }else{msg.className='vt-smsg err'; msg.textContent=res.error??'Error saving';}
  setTimeout(()=>{msg.style.display='none';},4000);
};

// ── External sites ────────────────────────────────────────────
function vtPostAct(action,params){
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  return fetch(BASE+'?action='+action,{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams(params)})
    .then(r=>r.json()).catch(()=>({error:'Network error'}));
}
function extNoteHTML(domain){
  if(!extSet.has(domain)) return '';
  const e=vtEsca(domain), x=external.find(x=>x.domain===domain)||{};
  return '<div class="vt-why-note"><strong>External site.</strong> Not hosted on this server'+(x.by?' · added by '+vtEsc(x.by):'')
    +(x.added?' on '+new Date(x.added*1000).toLocaleDateString():'')+'. Only the online reputation services check it; its files and accounts are not here. '
    +(extAsk===domain?'<strong>Remove it from the list?</strong> <a onclick="vtExtRemove(\''+e+'\')">Yes, remove</a> · <a onclick="vtExtAskRm(null,\''+e+'\')">No</a>'
                     :'<a onclick="vtExtAskRm(\''+e+'\',\''+e+'\')">Remove from the list</a>')+'</div>';
}
window.vtExtAskRm=function(d,domain){extAsk=d; if(fsOpen[domain]==='vt') vtFsRefresh(domain); vtRenderExternal();};
function vtRenderExternal(){
  const el=document.getElementById('vt-ext-list'); if(!el) return;
  if(!external.length){el.innerHTML='<div class="hint">No external sites yet.</div>'; return;}
  el.innerHTML='<table class="vt-fs-tbl"><thead><tr><th>Site</th><th>Reputation</th><th>Added</th><th></th></tr></thead><tbody>'
    +external.map(x=>{const e=vtEsca(x.domain), st=results[x.domain]?.status;
      return '<tr><td>'+vtEsc(x.domain)+'</td><td>'+vtEsc(st?(LABELS[st]??st):'not checked yet')+'</td><td>'+(x.added?new Date(x.added*1000).toLocaleDateString():'')+(x.by?' · '+vtEsc(x.by):'')+'</td><td class="vt-fa-cell">'
        +(extAsk===x.domain?'<strong>Remove?</strong> <a class="vt-fa-del" onclick="vtExtRemove(\''+e+'\')">Yes</a> · <a onclick="vtExtAskRm(null,\''+e+'\')">No</a>'
                           :'<a class="vt-fa-del" onclick="vtExtAskRm(\''+e+'\',\''+e+'\')">Remove</a>')+'</td></tr>';}).join('')+'</tbody></table>';
}
/** The site list again after adding or removing an external site; new sites are looked up */
async function vtReloadSites(){
  const all=await vtFetch('?action=all').catch(()=>null);
  if(!all) return;
  domains=all.domains||domains; vtSet('vt-cnt-all',domains.length);
  owners=all.owners||{}; panelUrl=all.panel||panelUrl; Object.assign(results,all.results||{});
  external=all.external||[]; extSet=new Set(external.map(x=>x.domain));
  renderTable(); updateCounts(); vtRenderExternal();
  if(!noKey){ for(const d of domains) if(!results[d]&&!scanQueue.includes(d)) scanQueue.push(d); pump(); }
}
window.vtExtAdd=async function(){
  const inp=document.getElementById('vt-ext-new'), msg=document.getElementById('vt-ext-msg'), v=inp.value.trim();
  if(!v) return;
  msg.textContent='Adding…';
  const r=await vtPostAct('external',{op:'add',domain:v});
  if(!r.ok){msg.innerHTML='<span style="color:var(--red)">'+vtEsc(r.error||'Failed')+'</span>'; return;}
  inp.value=''; msg.textContent=r.domain+' added. VirusTotal looks it up now.';
  external=r.external||external; extSet=new Set(external.map(x=>x.domain));
  await vtReloadSites();
};
window.vtExtRemove=async function(domain){
  const r=await vtPostAct('external',{op:'remove',domain});
  extAsk=null;
  if(!r.ok){vtToast(r.error||'Could not remove the site','error'); vtRenderExternal(); return;}
  vtToast(domain+' removed from the list','info');
  scanQueue=scanQueue.filter(d=>d!==domain);
  document.getElementById('vtfs-'+rid(domain))?.remove(); delete fsOpen[domain];
  await vtReloadSites();
};

// ── Pwned? (WordPress administrators in known data breaches) ──
let pw=null, pwRun=false, pwBusy=null, pwNote='', pwAsk=null, pwFilter='all';
let pwViewMode=localStorage.getItem('vt_pw_view')||'group', pwSortCol=localStorage.getItem('vt_pw_sort')||'email', pwSortDir=localStorage.getItem('vt_pw_dir')||'asc';
// Same red shield as in a site's WordPress admin accounts
const PW_SHIELD='<span class="vt-pw-shield" title="This address is in a known data breach"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg></span>';
/** Status of an address: bad (pwned), ok (not pwned) or new (not checked yet, or the check failed) */
function pwState(email){const r=pw.results?.[email]; return r?.state==='ok'?(r.breaches?.length?'bad':'ok'):'new';}
function pwEmailHTML(email){return pwState(email)==='bad'?'<span class="vt-pw-em bad">'+PW_SHIELD+vtEsc(email)+'</span>':vtEsc(email||'—');}
window.vtPwFilter=function(f){pwFilter=f; vtRenderPwned();};
window.vtPwView=function(v){pwViewMode=v; localStorage.setItem('vt_pw_view',v); vtRenderPwned();};
window.vtPwSort=function(col){
  if(pwSortCol===col) pwSortDir=pwSortDir==='asc'?'desc':'asc'; else {pwSortCol=col; pwSortDir=col==='email'?'asc':'desc';}
  localStorage.setItem('vt_pw_sort',pwSortCol); localStorage.setItem('vt_pw_dir',pwSortDir); vtRenderPwned();
};
window.vtLoadPwned=async function(fresh){
  if(fresh) document.getElementById('vt-pw-list').innerHTML='<span class="vt-spin"></span> Reading the WordPress accounts…';
  const r=await vtFetch('?action=pwned'+(fresh?'&fresh=1':'')).catch(()=>null);
  if(!r){document.getElementById('vt-pw-list').innerHTML='<span style="color:var(--red)">Could not load the accounts.</span>'; return;}
  pw=r; vtRenderPwned();
};
function pwEmails(){
  const set=new Set();
  for(const list of Object.values(pw.sites||{})) for(const a of list) if(a.email) set.add(a.email);
  for(const e of Object.keys(pw.custom||{})) set.add(e);
  return [...set];
}
function pwUnchecked(){
  const now=Date.now()/1000;
  return pwEmails().filter(e=>{const r=pw.results[e]; return !r||(r.state!=='ok'&&now-(r.checked_at||0)>3600);});
}
function pwStatusHTML(email){
  const r=pw.results?.[email], e=vtEsca(email);
  if(pwBusy===email) return '<span class="vt-spin"></span> checking…';
  const now=pw.config.source&&!pwRun?' · <a onclick="vtPwCheck(\''+e+'\')">check now</a>':'';
  if(!r) return '<span class="vt-pw-wait">not tested yet</span>'+now;
  if(r.state!=='ok') return '<span class="vt-pw-wait" title="'+vtEsc(r.error||'')+'">check failed ('+vtEsc(r.error||'error')+')</span>'+now;
  if(!r.breaches?.length) return '<span class="vt-pw-ok">✓ not in a known breach</span>';
  const n=r.breaches.length, fx=pw.fixed?.[email];
  const fix=!pw.config.admin||!pwIsAdminAddr(email)?''
    :fx?' · <span class="vt-pw-fixed" title="'+vtEsc((fx.kind==='reset'?'Password reset on ':'Warned about ')+fx.sites.join(', ')+(fx.failed?.length?'; failed on '+fx.failed.join(', '):'')+(fx.by?' · by '+fx.by:''))+'">✓ '+(fx.kind==='reset'?'reset':'warned')+' '+new Date(fx.at*1000).toLocaleDateString()+'</span> · <a onclick="vtPwFixOpen(\''+e+'\')">again…</a>'
    :' <a class="vt-pw-fixbtn" onclick="vtPwFixOpen(\''+e+'\')" title="Warn this administrator by e-mail, or reset the password in an emergency">🛠 Fix</a>';
  return '<span class="vt-pw-bad">Pwned: '+n+' breach'+(n===1?'':'es')+'</span>'+fix+'<div class="vt-pw-br">'
    +r.breaches.slice(0,8).map(b=>'<span title="'+vtEsc((b.data||[]).join(', '))+'">'+vtEsc(b.title||b.name)+(b.date?' ('+vtEsc(b.date.slice(0,4))+')':'')+'</span>').join(', ')
    +(n>8?' and '+(n-8)+' more':'')+'</div>';
}
/** Small label with the CMS of an account (WordPress is the default and gets none) */
function pwCmsHTML(cms,base){return (cms&&cms!=='WordPress'?' <span class="vt-pw-cms">'+vtEsc(cms)+'</span>':'')+(base?' <span class="vt-pw-cms" title="Installed in this folder of the site">'+vtEsc(base)+'</span>':'');}
function pwBad(email){return !!pw.results?.[email]?.breaches?.length;}
function vtRenderPwned(){
  if(!pw) return;
  const c=pw.config||{}, sites=pw.sites||{}, hosts=Object.keys(sites).sort();
  const accounts=hosts.reduce((t,h)=>t+sites[h].length,0), emails=pwEmails(), bad=emails.filter(pwBad).length, left=pwUnchecked().length;
  vtSet('vt-pw-sub',accounts+' administrator account'+(accounts===1?'':'s')+' on '+hosts.length+' site'+(hosts.length===1?'':'s')
    +' · '+bad+' pwned address'+(bad===1?'':'es')+(left?' · '+left+' not tested yet':''));
  // Actions
  let act='';
  if(c.source&&(left||pwRun)) act+='<button type="button" class="vt-btn'+(pwRun?' ghost':' primary')+'" onclick="vtPwRun()">'+(pwRun?'Stop':'Check '+left+' address'+(left===1?'':'es'))+'</button> ';
  if(c.admin) act+='<button type="button" class="vt-btn ghost" onclick="vtLoadPwned(1)" title="Read the administrator accounts from the WordPress databases again (they are read every 6 hours)">Read accounts again</button> ';
  document.getElementById('vt-pw-actions').innerHTML=act;
  // Source
  let src='';
  if(c.admin){
    const go='<a href="#vt-pwcfg-card" onclick="vtGoSetting(event,\'vt-pwcfg-card\')">Settings → Breached admin accounts</a>';
    src=c.source
      ?'<div class="vt-pw-src"><span>Breach data from <strong>'+vtEsc(c.source_name||c.source)+'</strong>'+(c.calls?' · '+c.calls+' request'+(c.calls===1?'':'s')+' today':'')+'</span><span class="hint">change in '+go+'</span></div>'
      :'<div class="vt-alert warn" style="display:block">Breach data is switched off, so the addresses are not tested. Choose a service in '+go+'.</div>';
  }else if(!c.source){
    src='<div class="vt-alert warn" style="display:block">The administrator has not chosen a breach data service yet, so the addresses are not tested.</div>';
  }
  document.getElementById('vt-pw-src').innerHTML=src;
  document.getElementById('vt-pw-note').innerHTML=pwNote?'<div class="vt-fs-note">'+pwNote+'</div>':'';
  // Filter buttons (counted per address) and search
  const cnt={all:emails.length,bad:0,ok:0,new:0}; for(const em of emails) cnt[pwState(em)]++;
  for(const k in cnt) vtSet('vt-pw-cnt-'+k,cnt[k]);
  document.querySelectorAll('[data-pwf]').forEach(b=>b.classList.toggle('active',b.dataset.pwf===pwFilter));
  document.querySelectorAll('#vt-pw-view button').forEach(b=>b.classList.toggle('on',b.dataset.v===pwViewMode));
  const q=(document.getElementById('vt-pw-search')?.value||'').trim().toLowerCase();
  const breachText=em=>(pw.results?.[em]?.breaches||[]).map(b=>(b.title||b.name)).join(' ').toLowerCase();
  const who=h=>{const o=pw.owners?.[h]; return o?(o.ct==='admin'?'Administrator':o.c):'';};
  const stOk=em=>pwFilter==='all'||pwState(em)===pwFilter;
  const filterNote=pwFilter==='bad'?'No pwned addresses':pwFilter==='ok'?'No addresses that were checked and found clean':pwFilter==='new'?'Every address has been tested':'Nothing';
  let html='';
  if(pwViewMode==='sort'){
    // One row per address: the sites it administers, sortable
    const by={};
    for(const h of hosts) for(const a of sites[h]) if(a.email) (by[a.email]=by[a.email]||{email:a.email,sites:[],custom:null}).sites.push({h,login:a.login,cms:a.cms,base:a.base});
    for(const [em,x] of Object.entries(pw.custom||{})) (by[em]=by[em]||{email:em,sites:[],custom:null}).custom=x;
    let list=Object.values(by).filter(x=>stOk(x.email)&&(!q||x.email.includes(q)||breachText(x.email).includes(q)
      ||x.sites.some(s=>s.h.includes(q)||s.login.toLowerCase().includes(q)||who(s.h).toLowerCase().includes(q))));
    const nB=em=>pw.results?.[em]?.state==='ok'?(pw.results[em].breaches?.length||0):-1, dir=pwSortDir==='asc'?1:-1;
    list.sort((a,b)=>(pwSortCol==='sites'?(a.sites.length-b.sites.length):pwSortCol==='breaches'?(nB(a.email)-nB(b.email)):0)*dir||(pwSortCol==='email'?dir:1)*a.email.localeCompare(b.email));
    const th=(col,label)=>'<th class="vt-sortable'+(pwSortCol===col?' vt-sort-'+pwSortDir:'')+'" onclick="vtPwSort(\''+col+'\')">'+label+'</th>';
    html=list.length?'<table class="vt-fs-tbl vt-pw-tbl"><thead><tr>'+th('email','E-mail address')+th('sites','Administrator of')+th('breaches','Data breaches')+'</tr></thead><tbody>'
      +list.map(x=>'<tr><td>'+pwEmailHTML(x.email)+'</td><td>'
        +x.sites.map(s=>'<div><strong>'+vtEsc(s.h+(s.base||''))+'</strong>'+pwCmsHTML(s.cms)+' <span class="vt-pw-br">as '+vtEsc(s.login)+(who(s.h)?' · '+vtEsc(who(s.h)):'')+'</span></div>').join('')
        +(x.custom?'<div class="vt-pw-br">added by hand'+(x.custom.by?' by '+vtEsc(x.custom.by):'')+'</div>':'')
        +'</td><td>'+pwStatusHTML(x.email)+'</td></tr>').join('')+'</tbody></table>'
      :'<div class="hint">'+(q?'No address matches this search.':filterNote+'.')+'</div>';
  }else{
    // One block per WordPress site
    let rows='';
    for(const h of hosts){
      const siteHit=!q||h.includes(q)||who(h).toLowerCase().includes(q);
      const list=sites[h].filter(a=>stOk(a.email)&&(siteHit||a.login.toLowerCase().includes(q)||(a.cms||'').toLowerCase().includes(q)||(a.base||'').toLowerCase().includes(q)||(a.email||'').includes(q)||breachText(a.email).includes(q)));
      if(!list.length) continue;
      rows+=list.map((a,i)=>'<tr>'+(i===0?'<td class="site" rowspan="'+list.length+'">'+vtEsc(h)+(who(h)?'<small>'+vtEsc(who(h))+'</small>':'')+'</td>':'')
        +'<td>'+vtEsc(a.login)+pwCmsHTML(a.cms,a.base)+(a.registered?'<div class="vt-pw-br">since '+new Date(a.registered*1000).toLocaleDateString()+'</div>':'')+'</td><td>'+pwEmailHTML(a.email)+'</td><td>'+(a.email?pwStatusHTML(a.email):'')+'</td></tr>').join('');
    }
    html=rows?'<table class="vt-fs-tbl vt-pw-tbl"><thead><tr><th>Site</th><th>Administrator</th><th>E-mail address</th><th>Data breaches</th></tr></thead><tbody>'+rows+'</tbody></table>'
      :'<div class="hint">'+(q?'No account matches this search.':hosts.length?filterNote+' among the site administrators.':'No sites with administrator accounts found.')+'</div>';
  }
  document.getElementById('vt-pw-list').innerHTML=html;
  // Addresses added by hand (same filter and search)
  const all=Object.entries(pw.custom||{}).sort((a,b)=>a[0].localeCompare(b[0]));
  const cl=all.filter(([em])=>stOk(em)&&(!q||em.includes(q)||breachText(em).includes(q)));
  document.getElementById('vt-pw-custom').innerHTML=cl.length?'<table class="vt-fs-tbl vt-pw-tbl"><thead><tr><th>E-mail address</th><th>Added</th><th>Data breaches</th><th></th></tr></thead><tbody>'
    +cl.map(([em,x])=>{const e=vtEsca(em); return '<tr><td>'+pwEmailHTML(em)+'</td><td>'+(x.added?new Date(x.added*1000).toLocaleDateString():'')+(x.by?' · '+vtEsc(x.by):'')+'</td><td>'+pwStatusHTML(em)+'</td><td class="vt-fa-cell">'
      +(pwAsk===em?'<strong>Remove?</strong> <a class="vt-fa-del" onclick="vtPwRemove(\''+e+'\')">Yes</a> · <a onclick="vtPwAskRm(null)">No</a>'
                  :'<a class="vt-fa-del" onclick="vtPwAskRm(\''+e+'\')">Remove</a>')+'</td></tr>';}).join('')+'</tbody></table>'
    :'<div class="hint">'+(all.length?'None of the added addresses matches.':'No addresses added.')+'</div>';
  document.getElementById('vt-pw-attr').innerHTML=c.source==='hibp'?'Breach data: <a href="https://haveibeenpwned.com" target="_blank" rel="noopener">Have I Been Pwned ↗</a> (CC BY 4.0)'
    :c.source==='xon'?'Breach data: <a href="https://xposedornot.com" target="_blank" rel="noopener">XposedOrNot ↗</a>':'';
}
window.vtPwAskRm=function(e){pwAsk=e; vtRenderPwned();};

// ── Fix a pwned address (administrator) ──
// Two options. Warn (default): an e-mail that changes nothing and asks the owner to check the account
// and change the password. Emergency: reset the WordPress password(s), log out, and an e-mail that says why.
// Both can be previewed and sent as a test to another address first.
let pwFix=null; // {email, kind: warn|reset, data, step: ''|'ask'|'busy', msg, ok, testTo}
function pwIsAdminAddr(email){return Object.values(pw.sites||{}).some(l=>l.some(a=>a.email===email));}
async function pwFixLoad(){
  const f=pwFix; if(!f) return;
  f.data=null; f.msg=''; f.step=''; vtPwFixRender();
  const r=await vtPostAct('pwned-fix',{email:f.email,kind:f.kind,mode:'preview'});
  if(pwFix!==f) return;
  if(r.error){f.msg=vtEsc(r.error); f.ok=false;} else f.data=r;
  vtPwFixRender();
}
window.vtPwFixOpen=function(email){
  pwFix={email,kind:'warn',data:null,step:'',msg:'',ok:false,testTo:pwFix?.testTo||''};
  pwFixLoad(); document.getElementById('vt-pw-fix').scrollIntoView({block:'start',behavior:'smooth'});
};
window.vtPwFixKind=function(k){if(pwFix&&pwFix.kind!==k){pwFix.kind=k; pwFixLoad();}};
window.vtPwFixClose=function(){pwFix=null; vtPwFixRender();};
window.vtPwFixAsk=function(v){if(pwFix){pwFix.step=v?'ask':''; vtPwFixRender();}};
function pwActTxt(a){
  if(!a) return '';
  const d=ts=>new Date(ts*1000).toLocaleString([], {day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'});
  const p=[];
  p.push(a.last_login?'last login '+d(a.last_login)+(a.last_ip?' from '+a.last_ip:''):'last login not recorded');
  if(a.sessions!==undefined) p.push(a.sessions+' active session'+(a.sessions===1?'':'s'));
  if(a.last_edit) p.push('last edit '+d(a.last_edit));
  return p.join(' · ');
}
function vtPwFixRender(){
  const el=document.getElementById('vt-pw-fix'); if(!el) return;
  if(!pwFix){el.innerHTML=''; return;}
  const f=pwFix, d=f.data, fx=pw?.fixed?.[f.email], reset=f.kind==='reset';
  let h='<div class="vt-pw-fixbox"><div class="vt-pw-fixhead"><strong>Fix pwned address '+PW_SHIELD+vtEsc(f.email)+'</strong><span class="sp"></span><a onclick="vtPwFixClose()">Close</a></div>'
    +'<div class="vt-pw-kinds">'
    +'<label class="'+(reset?'':'on')+'"><input type="radio" name="vt-pw-kind" '+(reset?'':'checked ')+'onchange="vtPwFixKind(\'warn\')"> <strong>Warn</strong> <span class="hint">(recommended) — e-mail only, nothing is changed: check the account and change the password</span></label>'
    +'<label class="'+(reset?'on danger':'')+'"><input type="radio" name="vt-pw-kind" '+(reset?'checked ':'')+'onchange="vtPwFixKind(\'reset\')"> <strong>Emergency: reset and warn</strong> <span class="hint">— reset the WordPress password now, log out everywhere, and an e-mail that explains why</span></label>'
    +'</div>'
    +(fx?'<div class="vt-fs-note">Already '+(fx.kind==='reset'?'reset':'warned')+' on '+new Date(fx.at*1000).toLocaleString()+(fx.by?' by '+vtEsc(fx.by):'')+'.</div>':'');
  if(!d&&!f.msg){el.innerHTML=h+'<span class="vt-spin"></span> Preparing the e-mail…</div>'; return;}
  if(d){
    const ready=d.sites.filter(s=>s.resettable);
    h+='<div class="vt-pw-steps"><strong>'+(reset?'Sites where the password is reset':'Sites in the e-mail')+'</strong>, with what is known about the account:<ul>'
      +d.sites.map(s=>{
        const skip=reset&&!s.resettable;
        return '<li'+(skip?' class="skip"':'')+'>'+vtEsc(s.site||s.host)+pwCmsHTML(s.cms)+' <span class="hint">as '+vtEsc(s.login)+' · '+vtEsc(pwActTxt(s.act))
          +(skip?' · '+(s.cms!=='WordPress'?vtEsc(s.cms)+' cannot be reset from here; send the warning':'WordPress install not found on disk')+', not in this e-mail':'')+'</span></li>';}).join('')+'</ul>'
      +'E-mail from <em>'+vtEsc(d.from[0])+' &lt;'+vtEsc(d.from[1])+'&gt;</em>, sent by the server <strong>'+vtEsc(d.server||'')+'</strong>.</div>';
    if(d.none){h+='<div class="vt-fa-q err">'+vtEsc(d.none)+'</div>';}
    else{
      h+='<div class="vt-pw-subj">Subject: <strong>'+vtEsc(d.subject)+'</strong> <span class="hint">· preview: the buttons are greyed out and do nothing here; in the real e-mail they are blue</span></div>'
        +'<iframe class="vt-pw-prev" sandbox="" title="Preview of the e-mail"></iframe>'
        +'<div class="vt-pw-add"><label class="hint" for="vt-pw-testto">Send a test of this e-mail to</label><input type="email" id="vt-pw-testto" placeholder="you@example.com" value="'+vtEsc(f.testTo||'')+'">'
        +'<button type="button" class="vt-btn" onclick="vtPwFixTest()"'+(f.step==='busy'?' disabled':'')+'>Send test</button><span class="hint">changes nothing; marked as a test</span></div>';
      if(f.step==='ask') h+=reset
        ?'<div class="vt-fa-q err"><strong>Emergency: reset the password of '+vtEsc(f.email)+' on '+ready.length+' WordPress site'+(ready.length===1?'':'s')+' and send the e-mail?</strong> '
          +'They are logged out right away and can only log in again after choosing a new password via the link in the e-mail.</div>'
          +'<button type="button" class="vt-btn danger" onclick="vtPwFixGo()">Yes, reset and send</button> <button type="button" class="vt-btn ghost" onclick="vtPwFixAsk(0)">Cancel</button>'
        :'<div class="vt-fa-q"><strong>Send the warning to '+vtEsc(f.email)+'?</strong> Nothing is changed on the sites.</div>'
          +'<button type="button" class="vt-btn primary" onclick="vtPwFixGo()">Yes, send the warning</button> <button type="button" class="vt-btn ghost" onclick="vtPwFixAsk(0)">Cancel</button>';
      else if(f.step==='busy') h+='<div><span class="vt-spin"></span> '+(reset?'Resetting passwords and sending the e-mail…':'Sending the warning…')+'</div>';
      else h+=reset
        ?'<button type="button" class="vt-btn danger" onclick="vtPwFixAsk(1)"'+(ready.length?'':' disabled')+'>Reset password'+(ready.length===1?'':'s')+' and send e-mail…</button>'
        :'<button type="button" class="vt-btn primary" onclick="vtPwFixAsk(1)">Send warning e-mail…</button>';
    }
  }
  if(f.msg) h+='<div class="vt-fa-q '+(f.ok?'ok':'err')+'">'+f.msg+'</div>';
  el.innerHTML=h+'</div>';
  // Preview only: the buttons and links are greyed out and cannot be clicked (they would open the customer's site)
  const PREVIEW_CSS='<style>a{pointer-events:none!important;cursor:not-allowed!important}'
    +'a[style*="background"]{background:#cbd5e1!important;color:#475569!important;border:1px dashed #94a3b8}</style>';
  const fr=el.querySelector('.vt-pw-prev'); if(fr&&d) fr.srcdoc=PREVIEW_CSS+d.html;
}
window.vtPwFixTest=async function(){
  const to=document.getElementById('vt-pw-testto').value.trim(); if(!to) return;
  pwFix.testTo=to; pwFix.msg='Sending the test…'; pwFix.ok=true; vtPwFixRender();
  const r=await vtPostAct('pwned-fix',{email:pwFix.email,kind:pwFix.kind,mode:'test',to});
  pwFix.msg=r.ok?'Test sent to '+vtEsc(r.sent_to)+'. Nothing was changed.':vtEsc(r.error||'Failed'); pwFix.ok=!!r.ok; vtPwFixRender();
};
window.vtPwFixGo=async function(){
  const f=pwFix, email=f.email, kind=f.kind; f.step='busy'; f.msg=''; vtPwFixRender();
  const r=await vtPostAct('pwned-fix',{email,kind,mode:'send'});
  f.step='';
  const fails=(r.failed||[]).map(x=>vtEsc(x.host)+': '+vtEsc(x.error)).join('<br>');
  if(r.ok){
    pw.fixed=pw.fixed||{}; pw.fixed[email]=r.fixed;
    f.ok=r.mailed&&!(r.failed||[]).length;
    f.msg=(kind==='reset'?'Password reset on '+r.sites.map(vtEsc).join(', ')+'. ':'')
      +(r.mailed?(kind==='reset'?'E-mail':'Warning')+' sent to '+vtEsc(email)+'.':'<strong>The e-mail could not be sent</strong>; tell them yourself.')
      +(fails?'<br>Not reset:<br>'+fails:'');
  }else{f.ok=false; f.msg=vtEsc(r.error||'Failed')+(fails?'<br>'+fails:'');}
  vtRenderPwned(); vtPwFixRender();
};
window.vtRenderPwned=vtRenderPwned; // the search box redraws the list on every key
// Settings → Breached admin accounts (administrator): which service tests the addresses of the Pwned Admins tab
function vtRenderPwCfg(c){
  const card=document.getElementById('vt-pwcfg-card'); card.style.display=c?'':'none'; if(!c) return;
  document.querySelectorAll('input[name=vt-pw-src]').forEach(r=>r.checked=r.value===(c.setting||''));
  document.getElementById('vt-pw-key').value='';
  vtSet('vt-pw-keyinfo',c.key?'Stored key '+c.key+'. Paste a new one to replace it; it is tested before it is saved.':'No key stored. It is tested before it is saved.');
  vtSet('vt-pw-srcmsg',c.source?'In use: '+(c.source_name||c.source)+(c.calls?' · '+c.calls+' request'+(c.calls===1?'':'s')+' today':''):'Switched off');
}
window.vtPwSaveSrc=async function(){
  const src=document.querySelector('input[name=vt-pw-src]:checked')?.value||'', key=document.getElementById('vt-pw-key').value.trim();
  const m=document.getElementById('vt-pw-srcmsg'); m.textContent=key?'Testing the key…':'Saving…';
  const r=await vtPostAct('pwned-settings',{source:src,key});
  if(!r.ok){m.innerHTML='<span style="color:var(--red)">'+vtEsc(r.error||'Failed')+'</span>'; return;}
  vtRenderPwCfg(r.config);
  if(r.message) m.textContent+=' · '+r.message;
  if(pw){pw.config=r.config; vtRenderPwned();}
  document.getElementById('vtcard-pwned').style.display=r.config.source?'':'none'; // off: hide Pwned Admins tool card
  document.getElementById('vtnav-pwned').style.display=r.config.source?'':'none';
  vtToast(src?'Breach data from '+(r.config.source_name||src):'Breached admin accounts switched off: the Pwned Admins tab is hidden','info');
};
/**
 * Check one address, shown in the Scan Monitor. Short waits for the service's request limit are
 * waited out; returns {ok, remaining} or {stop: message} (error, daily limit, or stopped).
 */
async function pwCheckOne(email,loop){
  const job=pwJobStart(email);
  pwBusy=email; vtRenderPwned();
  try{
    while(true){
      const r=await vtPostAct('pwned-check',{email});
      if(r.error){pwJobEnd(job,'failed',null,r.error); return {stop:vtEsc(r.error)};}
      if(r.result?.state==='wait'){
        const s=r.result.retry_after;
        if(s>180){
          const day=r.result.reason==='day', mins=Math.ceil(s/60);
          pwJobEnd(job,'failed',null,day?'Daily maximum reached':'The service asks to wait '+mins+' min');
          return {stop:(day?'Today\'s maximum for this service is reached.':'The service asks to wait '+mins+' minutes (its request limit).')
            +' The rest is tested in the background, a few addresses an hour; you don\'t need to keep this page open.'};
        }
        pwJobWait(job,s); await pwJobDelay(job,s*1000);
        if(job.skipped){pwJobEnd(job,'failed',null,'Skipped'); return {skipped:true};}
        if(loop&&!pwRun){pwJobEnd(job,'failed',null,'Stopped'); return {stop:'Stopped.'};}
        job.state='running'; renderQueue(); continue;
      }
      pw.results[r.email]=r.result;
      if(r.result?.state==='ok') pwJobEnd(job,'done',r.result);
      else pwJobEnd(job,'failed',null,'Check failed: '+(r.result?.error||'unknown error'));
      return {ok:true,remaining:r.remaining};
    }
  }finally{pwBusy=null; vtRenderPwned();}
}
window.vtPwCheck=async function(email){
  const r=await pwCheckOne(email,false);
  pwNote=r.stop&&r.stop!=='Stopped.'?r.stop:''; vtRenderPwned();
};
window.vtPwRun=async function(){
  if(pwRun){pwRun=false; pwNote='Stopped.'; vtRenderPwned(); return;}
  pwRun=true; pwNote=''; vtRenderPwned();
  const tried=new Set();
  while(pwRun){
    const next=pwUnchecked().find(e=>!tried.has(e)); if(!next) break;
    tried.add(next); // a failed check is not repeated in the same run
    const r=await pwCheckOne(next,true);
    if(r.stop){pwNote=r.stop; break;}
    if(r.skipped) continue; // skipped in the Scan Monitor: go on with the next address
    if(!r.remaining) break;
  }
  pwRun=false; vtRenderPwned();
};
window.vtPwAdd=async function(){
  const inp=document.getElementById('vt-pw-new'), m=document.getElementById('vt-pw-addmsg'), v=inp.value.trim();
  if(!v) return;
  const r=await vtPostAct('pwned-email',{op:'add',email:v});
  if(!r.ok){m.innerHTML='<span style="color:var(--red)">'+vtEsc(r.error||'Failed')+'</span>'; return;}
  inp.value=''; m.textContent=''; pw.custom=r.custom||pw.custom; vtRenderPwned();
  if(pw.config.source&&!pwRun) vtPwCheck(r.email);
};
window.vtPwRemove=async function(email){
  const r=await vtPostAct('pwned-email',{op:'remove',email});
  pwAsk=null;
  if(!r.ok) vtToast(r.error||'Could not remove the address','error');
  else pw.custom=r.custom||{};
  vtRenderPwned();
};

// ── Log ───────────────────────────────────────────────────────
window.vtLoadLog=async function(){
  const pre=document.getElementById('vt-log-pre');
  const meta=document.getElementById('vt-log-meta');
  pre.textContent='Loading...';
  const data=await vtFetch('?action=get-log').catch(()=>({log:'',size:0}));
  vtLogLines=data.log?data.log.split('\n'):[];
  if(!data.log){pre.textContent='(Log is empty — no cron runs yet)';meta.textContent='';return;}
  vtLogFilter();
  const kb=Math.round(data.size/1024*10)/10;
  meta.textContent='('+kb+' KB — last 200 lines, newest first)';
};
let vtLogLines=[];
window.vtLogFilter=function(){
  const pre=document.getElementById('vt-log-pre'); if(!pre||!vtLogLines.length) return;
  const words=(document.getElementById('vt-log-q')?.value||'').trim().toLowerCase().split(/\s+/).filter(Boolean);
  const lines=words.length?vtLogLines.filter(l=>{const x=l.toLowerCase(); return words.every(w=>x.includes(w));}):vtLogLines;
  const shown=document.getElementById('vt-log-shown');
  if(shown) shown.textContent=words.length?lines.length+' of '+vtLogLines.length+' lines':'';
  const re=words.length?new RegExp('('+words.map(w=>w.replace(/[.*+?^${}()|[\]\\]/g,'\\$&').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;')).join('|')+')','gi'):null;
  if(!lines.length){pre.textContent='(No lines match)';return;}
  pre.innerHTML=lines.map(l=>{
    let esc=l.replace(/[&<>"]/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]||c));
    if(re) esc=esc.replace(re,'<mark class="vt-hit">$1</mark>');
    if(/\[!\]|\[ERR\]|INFECTED/.test(l)) return '<span style="color:#dc2626;font-weight:600">'+esc+'</span>';
    if(/\[\?]|suspicious/.test(l))       return '<span style="color:#d97706;font-weight:600">'+esc+'</span>';
    if(/\[ok\]|\[manual\]/.test(l))      return '<span style="color:#16a34a">'+esc+'</span>';
    if(/Done —/.test(l))                 return '<span style="font-weight:600">'+esc+'</span>';
    return esc;
  }).join('\n');
};

window.vtClearLog=async function(){
  if(!confirm('Clear the scan log?')) return;
  await fetch(BASE+'?action=clear-log&confirm=1').then(r=>r.json()).catch(()=>{});
  vtLogLines=[]; document.getElementById('vt-log-pre').textContent='(Log cleared)';
  document.getElementById('vt-log-meta').textContent='';
  vtToast('Log cleared','ok');
};

// ── Utils ─────────────────────────────────────────────────────
// ── File scanners (ClamAV, maldet, …) ─────────────────────────
// Every site gets a bar with one button per scanner found on the server.
// A click opens a second line under the site: scan progress, then the result
// and the list of infected files. Scans run on demand, one at a time on the server.
function vtAgo(ts){
  if(!ts) return '';
  const s=Date.now()/1000-ts;
  if(s<90) return 'just now';
  if(s<3600) return Math.round(s/60)+' min ago';
  if(s<86400) return Math.round(s/3600)+' h ago';
  return new Date(ts*1000).toLocaleDateString();
}
let panelUrl={}; // site → its page in Plesk
const svgI=d=>'<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'+d+'</svg>';
const ICO={
  site: svgI('<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/>'),        // globe
  panel:svgI('<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M7 13h4M7 16h7"/>'),                          // control panel window
  copy: svgI('<rect x="9" y="9" width="11" height="11" rx="2"/><path d="M5 15V6a2 2 0 0 1 2-2h9"/>'),                       // two sheets
  ok:   svgI('<path d="M5 12.5l4.5 4.5L19 7"/>'),
};
// Copy within the click itself (works without window focus); the Clipboard API only as a fallback
window.vtCopyDomain=function(el){
  const name=el.dataset.copy, done=()=>{el.innerHTML=ICO.ok; el.classList.add('done'); el.title='Copied'; setTimeout(()=>{el.innerHTML=ICO.copy; el.classList.remove('done'); el.title='Copy the domain name';},1500);};
  if(vtCopyNow(name)) done();
  else navigator.clipboard?.writeText(name).then(done,()=>{el.title='Copy failed';});
  return false;
};
function vtCopyNow(text){
  const t=document.createElement('textarea'); t.value=text; t.setAttribute('readonly',''); t.style.position='fixed'; t.style.top='-1000px';
  document.body.appendChild(t); t.select(); let ok=false; try{ok=document.execCommand('copy');}catch(e){} t.remove(); return ok;
}
function fsGet(d,id){return scans[d]?.[id]||null;}
function fsBusy(d,id){return ['running','queued'].includes(fsGet(d,id)?.status);}
function fsName(id){return scanners.find(x=>x.id===id)?.name||id;}
/** Small mark on a site's Details button: a file scan is running, or found infected files */
function fsMarkHTML(domain){
  if(!scanners.length) return '';
  if(scanners.some(sc=>fsBusy(domain,sc.id))) return ' <span class="vt-spin"></span>';
  const n=scanners.reduce((t,sc)=>{const r=fsGet(domain,sc.id);return t+(r?.status==='done'?(r.infected||0):0);},0);
  return n?' <span class="vt-fs-n" title="Infected files found by the file scanners">'+n+'</span>':'';
}
function fsToolsHTML(domain){
  if(!scanners.length||relSet.has(domain)||extSet.has(domain)) return '';
  const off=scanners.find(sc=>sc.disabled);
  return '<div class="vt-fs-tools"><span>Check the files on the server <span class="hint">(for further investigation; starts only when you click)</span></span>'+fsBarHTML(domain)
    +(off?'<span class="hint">'+vtEsc(off.message||'')+'</span>':'')+'</div>';
}
function fsScanCollHTML(domain){
  if(!scanners.length||relSet.has(domain)||extSet.has(domain)) return '';
  const e=vtEsca(domain), isOpen=!!fsScanCollOpen[domain];
  const off=scanners.find(sc=>sc.disabled);
  return '<details class="vt-collapsible"'+(isOpen?' open':'')+' ontoggle="vtFsScanCollToggle(this,\''+e+'\')">'
    +'<summary>Check the files on the server</summary>'
    +'<div style="margin-top:6px"><span class="hint">For further investigation — each scan starts only when you click.</span> '
    +fsBarHTML(domain)
    +(off?' <span class="hint">'+vtEsc(off.message||'')+'</span>':'')
    +'</div>'
    +'</details>';
}
function fsBarHTML(domain){
  if(!scanners.length) return '';
  const e=vtEsca(domain);
  return '<span class="vt-scanbar">'+scanners.map(sc=>{
    if(sc.disabled) return '<button type="button" class="vt-sbtn" disabled title="'+vtEsc(sc.message||'')+'">'+vtEsc(sc.label||'Scan')+'</button>';
    const r=fsGet(domain,sc.id);
    let mark='';
    if(fsBusy(domain,sc.id)) mark='<span class="vt-spin"></span>';
    else if(r?.status==='done') mark=r.infected?'<span class="n">'+r.infected+'</span>':'<span class="ok">✓</span>';
    else if(r) mark='<span style="color:var(--red)">!</span>';
    const open=fsOpen[domain]===sc.id;
    return '<button type="button" class="vt-sbtn'+(open?' open':'')+'" title="'+(sc.instant?'Show the results of Imunify\'s own scans of this site':'Scan the files of this site with '+vtEsc(sc.name))+'" onclick="vtFsClick(\''+e+'\',\''+sc.id+'\')">'+vtEsc(sc.label||sc.name)+mark+'</button>';
  }).join('')+'</span>';
}
// ── Why flagged, and how to get delisted after cleaning ─────────
// Review / false-positive contacts per vendor, from VirusTotal's list:
// https://docs.virustotal.com/docs/false-positive-contacts
// Where a vendor has its own form for websites, that form is used instead (alphaMountain, Gridinsoft).
const VT_FP_LIST='https://docs.virustotal.com/docs/false-positive-contacts';
const VT_FP={
  abusix:'https://lookup.abusix.com/', adminus:'samples@adminus.net', rising:'fp@rising.com.cn', acronis:'virustotal-falsepositive@acronis.com', ailabs:'aicc@monitorapp.com',
  alibaba:'virustotal@list.alibaba-inc.com', alienvault:'otx-support@alienvault.com', alphamountain:'https://alphamountain.freshdesk.com/support/tickets/new',
  alphasoc:'virustotal@alphasoc.com', antiy:'avlsdk_support@antiy.cn', arcsight:'virustotalsupport@opentext.com',
  avira:'https://www.avira.com/en/analysis/submit-url', antivir:'https://www.avira.com/en/analysis/submit-url',
  avast:'DL-Virus@gendigital.com', avg:'https://www.avg.com/en-ww/report-false-positive', bitdefender:'https://www.bitdefender.com/submit',
  bfore:'https://portal.bfore.ai/knowledge-base/kb-tickets/new', blueliv:'klabs_services@outpost24.com', certego:'fp@certego.net', chainpatrol:'dispute@chainpatrol.io',
  chongluadao:'https://chongluadao.vn/en/report/reportmistake', cins:'http://cinsscore.com/#contact', cleanmx:'abuse@clean-mx.de', cluster25:'threatintel@cluster25.io',
  crdf:'https://threatcenter.crdf.fr/false_positive.html', criminalip:'support@aispera.com', crowdstrike:'VTscanner@crowdstrike.com',
  csis:'abuse-reporting@csis.com', cyble:'cyblevt_patnership@cyble.com', cyradar:'https://cyradar.com/reportfp/',
  desenmascara:'vt-falsepositives@desenmascara.me', dns8:'dns8@layer8.pt', drweb:'vms@drweb.com', elastic:'https://discuss.elastic.co/t/submitting-false-positives/232322',
  emsisoft:'fp@emsisoft.com', estsecurity:'esrc@estsecurity.com', alyac:'esrc@estsecurity.com', emergingthreats:'support@emergingthreats.net', ermes:'support-vt@ermes.company',
  eset:'https://support.eset.com/kb141/?page=content&id=SOLN141', forcepoint:'reviewmysite@forcepoint.com',
  fortinet:'https://www.fortiguard.com/faq/malurl', gdata:'https://submit.gdatasoftware.com/privacy',
  googlesafebrowsing:'https://safebrowsing.google.com/safebrowsing/report_error/?hl=en', greensnow:'https://greensnow.co/contact',
  gridinsoft:'https://portal.gridinsoft.com/false-positive', guardpot:'virustotal@guardpot.com', heimdal:'report-vt@heimdalsecurity.com', ikarus:'fp@ikarus.at',
  ipsum:'https://github.com/stamparm/ipsum', k7:'reportfp@labs.k7computing.com', kaspersky:'newvirus@kaspersky.com',
  lionic:'https://www.lionic.com/supports/report-false-positive/', lumu:'vt@lumu.io', malbeacon:'vtreport@malbeacon.com',
  malwarebytes:'https://forums.malwarebytes.com/forum/122-false-positives/', malwarepatrol:'fp@malwarepatrol.net', malwareurl:'team@malwareurl.com',
  mcafee:'https://www.mcafee.com/support/s/article/000001921', microsoft:'https://www.microsoft.com/en-us/wdsi/filesubmission',
  mimecast:'bep-soc@mimecast.com', netcraft:'https://report.netcraft.com/report/mistake', openphish:'support@openphish.com',
  paloalto:'vt-pan-false-positive@paloaltonetworks.com', panda:'falsepositives@pandasecurity.com',
  phishingdatabase:'https://github.com/phishing-Database/Phishing.Database/?tab=readme-ov-file#requests--support', phishlabs:'info@phishlabs.com',
  phishtank:'https://www.phishtank.com/contact.php', prebytes:'https://www.support.prebytes.com/helpcenter/removals/', quickheal:'viruslab@quickheal.com',
  quttera:'support@quttera.com', safetoopen:'virustotal@safetoopen.com', sansec:'virustotal@sansec.io', scantitan:'fp@scantitan.com',
  scumware:'https://www.scumware.org/removals.php', seclookup:'info@seclookup.com', securolytics:'https://tickets.securolytics.io/portal/en/kb/securolytics-1',
  sentinelone:'report@sentinelone.com', skyhigh:'gatewayantimalwarefpsubmission@skyhighsecurity.com', socradar:'vt@socradar.io',
  sophos:'https://support.sophos.com/support/s/filesubmission', spam404:'https://www.spam404.com/revision-request-domain.html', spamhaus:'https://www.spamhaus.org/dbl/removal/form/',
  stopforumspam:'https://www.stopforumspam.com/removal', sucuri:'soc@sucuri.net', symantec:'https://symsubmit.symantec.com',
  tencent:'TAVfp@tencent.com', trellix:'datasubmission@trellix.com', trendmicro:'https://www.trendmicro.com/en_us/about/legal/detection-reevaluation.html',
  trustwave:'https://support.trustwave.com/virustotal-detection-review/', levelblue:'LevelBlueVirusTotalEscalations@levelblue.com', urlhaus:'vt-fp@abuse.ch',
  urlquery:'contact@urlquery.net', viettel:'cyberthreat@viettel.com.vn', vipre:'https://helpdesk.vipre.com/hc/en-us/requests/new',
  virusdie:'partners@virusdie.com', webroot:'https://support.threatintel.opentext.com/tools/change-request.php', xcitium:'support@xcitium.com',
  comodo:'support@xcitium.com', yandexsafebrowsing:'sbapi@support.yandex.ru', yandex:'yandex-antivir@support.yandex.ru', zerofox:'ask@zerofox.com',
  zillya:'support@zillya.com', zonealarm:'zonealarm_VT_reports@checkpoint.com', zoner:'false@zonerantivirus.com'
};
// Short tips per vendor, from their own help pages and what site owners report
const VT_FP_TIP={
  gdata:'G Data\'s submission site first asks you to agree to its privacy terms and to pass an "I am human" check (do that yourself; it is not remembered for long). The form after it is made for file samples and takes no values from Stingy Scanner: choose "File has been incorrectly classified as malicious", put the site address under "Where did you get this file?", paste the copied text into Comment and add your e-mail. If it insists on a file, use G Data\'s contact form instead.',
  alphamountain:'Ticket form on alphaMountain\'s Freshdesk; log in or sign up first (your e-mail address is then filled in). The form cannot be filled from here: the text for the description is copied when you click. Subject: False positive: the domain name; Website: the site address. Takes up to 24 h to apply after approval.',
  gridinsoft:'Website form. It works without an account only for an e-mail address that has not been used there before; otherwise create a free Gridinsoft account first. Give the full address and proof the site was cleaned; no passwords or tokens in the URL.',
  sophos:'Choose "Web Address (URL)". No Sophos account needed; usually 24–72 h.',
  bitdefender:'Choose "False positive" and "URL". Mention you own the site and add the VirusTotal link.',
  fortinet:'Opens the Malicious URL Appeal form with the URL, your name, e-mail and company filled in (Settings → Review requests). The comment box cannot be filled from here: the text for it is copied when you click, so paste it there.',
  chongluadao:'Complaint form for mislabelled sites.',
  trustwave:'Form for VirusTotal detections.',
  bfore:'Ticket form.',
  googlesafebrowsing:'Site owners can also ask for a review in Google Search Console.',
  socradar:'No form; e-mail with the VirusTotal link. Site owners report this works.',
  crdf:'False positive form at threatcenter.crdf.fr — paste each URL on a separate line; multiple URLs in one submission are accepted.',
  cyradar:'Form at cyradar.com/reportfp — no separate domain field, put the domain in the Message box.',
  malwareurl:'No form; e-mail with the VirusTotal link.',
  spamhaus:'Check the domain first; removal needs the cause fixed.',
  avg:'Stingy Scanner opens AVG\'s form already filled in: Website, the site address, your e-mail address, the detection name, the alert ID and a description. You only tick the reCAPTCHA and click Send. The alert ID is on AVG Web Shield\'s block page: open the site in a browser with AVG and Web Shield on (it is blocked, which is safe), copy the ID and enter it in the Alert ID box here first.',
  avast:'Avast and AVG share the form (both are Gen Digital). If it asks for an alert ID: open the site with Avast Web Shield on, copy the ID from the block page, and mention the detection name shown here.'
};
// How to ask each vendor for a review. From vendors.json (the copy in the data folder, else the one in the package),
// sent with the page data; until then, or without that file, the built-in list above (addresses and advice only).
function vtBuiltinVendors(){
  const o={};
  for(const k in VT_FP){ const c=VT_FP[k]; o[k]={form:c,method:(c.includes('@')&&!/^https?:/i.test(c))?'email':'form',copy:'url'}; if(VT_FP_TIP[k]) o[k].advice=VT_FP_TIP[k]; }
  return o;
}
let VENDORS=vtBuiltinVendors(), vendorSrc='built-in';
function vtFpKey(vendor){
  const n=String(vendor).toLowerCase().replace(/[^a-z0-9]/g,'');
  let best='';
  for(const k in VENDORS){
    for(const m of [k,...(VENDORS[k].match||[])]) if(n.startsWith(m)&&m.length>best.length){ best=k; }
  }
  return best;
}
function vtFpContact(vendor){const k=vtFpKey(vendor);return k?VENDORS[k].form:'';}
function vtVendorOf(vendor){const k=vtFpKey(vendor);return k?Object.assign({key:k},VENDORS[k]):null;}
function vtRevDone(domain,vendor){
  const r=reviews[domain]?.[vendor]; if(!r) return '';
  const d=new Date(r.ts*1000), p=n=>String(n).padStart(2,'0');
  const reqDate=p(d.getDate())+'-'+p(d.getMonth()+1)+'-'+d.getFullYear()+' ('+p(d.getHours())+':'+p(d.getMinutes())+')';
  if(r.confirmed_at){
    const c=new Date(r.confirmed_at*1000);
    return '<div class="vt-rev-confirmed">'
      +'<span class="vt-rev-conf-pill">&#10003; Delisting confirmed '+p(c.getDate())+'-'+p(c.getMonth()+1)+'-'+c.getFullYear()
      +' · <a onclick="vtReviewConfirm(\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\',1)" title="Undo: the delisting was not actually confirmed">undo</a></span>'
      +(r.by?'<div class="vt-rev-actions">requested by '+vtEsc(r.by)+'</div>':'')
      +'</div>';
  }
  return '<div class="vt-rev-done">'
    +'<span class="vt-rev-pill">&#10003; Requested '+reqDate+(r.by?' by '+vtEsc(r.by):'')+'</span>'
    +'<div class="vt-rev-actions">'
    +'<a onclick="vtReviewConfirm(\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\')" title="The vendor confirmed the delisting: record this">&#10003; delisting confirmed</a>'
    +' · <a onclick="vtReviewDeny(this,\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\')" title="The vendor turned the request down">denied</a>'
    +' · <a onclick="vtReviewMark(\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\',1)" title="Clicked by mistake: forget this request">undo</a>'
    +'</div></div>';
}
window.vtReviewConfirm=async function(domain,vendor,undo){
  try{
    const r=await vtPostAct('review-confirm',{domain,vendor,remove:undo?'1':''});
    if(r&&r.ok){reviews[domain]=r.reviews; vtFsRefresh(domain); vtLoadSiteHist(domain); if(currentTool==='vendors') vtVendorsRender();}
    else vtToast(r?.error||'Could not save','error');
  }catch(e){vtToast('Could not save','error');}
};
window.vtReviewDeny=function(a,domain,vendor){
  const box=a.closest('.vt-rev-done');
  box.outerHTML='<div class="vt-rev-deny"><input type="text" maxlength="300" placeholder="Reason (optional), e.g. added less than a day ago">'
    +'<button class="vt-btn sm" onclick="vtReviewMark(\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\',1,\'\',\'\',this.previousElementSibling.value)">Save</button>'
    +'<a onclick="vtFsRefresh(\''+vtEsca(domain)+'\')">cancel</a></div>';
  const inp=document.querySelector('.vt-rev-deny input'); if(inp){inp.focus(); inp.onkeydown=ev=>{if(ev.key==='Enter')inp.nextElementSibling.click(); if(ev.key==='Escape')vtFsRefresh(domain);};}
};
window.vtCopyReviewUrl=function(url){
  const fallback=()=>{
    const input=document.createElement('textarea');
    input.value=url;
    input.setAttribute('readonly','');
    input.style.cssText='position:fixed;top:0;left:-9999px';
    const previous=document.activeElement;
    document.body.appendChild(input);
    input.select();
    let copied=false;
    try{copied=document.execCommand('copy');}catch(e){}
    input.remove();
    if(previous&&previous.focus) previous.focus({preventScroll:true});
    return copied;
  };
  const done=()=>vtToast('Site address copied: '+url,'ok');
  const failed=()=>vtToast('Could not copy automatically. Site address: '+url,'info');
  // First the old way, still inside the click: the clipboard API is often refused inside the Plesk frame,
  // and once it has refused, the click no longer counts and the old way fails too
  if(fallback()) return done();
  if(navigator.clipboard&&navigator.clipboard.writeText) navigator.clipboard.writeText(url).then(done,failed);
  else failed();
};
// Copy text without a message; true when it worked
function vtCopyText(text){
  const t=document.createElement('textarea'); t.value=text; t.setAttribute('readonly',''); t.style.cssText='position:fixed;top:0;left:-9999px';
  const prev=document.activeElement; document.body.appendChild(t); t.select();
  let ok=false; try{ok=document.execCommand('copy');}catch(e){} t.remove(); if(prev&&prev.focus) prev.focus({preventScroll:true});
  if(!ok&&navigator.clipboard?.writeText){ navigator.clipboard.writeText(text).catch(()=>{}); }
  return ok;
}
window.vtReviewMark=async function(domain,vendor,remove,via,to,deniedReason){
  const denied=typeof deniedReason==='string';
  if(!remove&&!denied) vtCopyReviewUrl('https://'+domain+'/');
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  if(!remove){ // show it at once; the server copy follows
    (reviews[domain]=reviews[domain]||{})[vendor]={ts:Math.floor(Date.now()/1000),by:''};
    setTimeout(()=>vtFsRefresh(domain),60); // after the browser has followed the link
  }
  try{
    const r=await fetch(BASE+'?action=review-mark',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},
      body:new URLSearchParams({domain,vendor,remove:remove?'1':'',via:via||'',to:to||'',denied:denied?'1':'',reason:denied?deniedReason:''})}).then(x=>x.json());
    if(r&&r.ok){reviews[domain]=r.reviews; if(Array.isArray(r.reviews)) reviews[domain]={};}
    else vtToast('Could not save the review request','error');
  }catch(e){vtToast('Could not save the review request','error');}
  vtFsRefresh(domain); vtLoadSiteHist(domain); if(currentTool==='vendors') vtVendorsRender();
};
// ── Ready-made texts for review requests ─────────────────────
// A vendor's form always has a free text box. 📋 text copies a polite, factual request to paste there; every click gives
// another wording. It says the site was checked and cleaned: only send it when that is true.
const RT_PICK=a=>a[Math.floor(Math.random()*a.length)];
const rvCompany=()=>reviewFrom.company||(String(myEmail).split('@')[1]||''); // Company in Settings, else the domain of your e-mail address
function vtVerdictOf(domain,vendor){
  const k=vtFpKey(vendor);
  if(k==='avg'||k==='avast'){
    const pid=k==='avg'?147:146, f=(avast.results?.[domain]?.[pid]?.findings||[])[0];
    if(f) return String(f.classification||'').replace(/^URL:/,'').toLowerCase()+(f.detection?' ('+f.detection+')':'');
  }
  const hit=(results[domain]?.flagged_by||[]).find(x=>String(x).toLowerCase().startsWith(String(vendor).toLowerCase()+':'));
  return hit?String(hit).slice(String(hit).indexOf(': ')+2):'malicious';
}
function vtReviewText(domain,vendor){
  const url='https://'+domain+'/', v=vendor, cls=vtVerdictOf(domain,vendor);
  const art=/^[aeiou]/i.test(cls)?'an':'a';
  const hello=RT_PICK(['Hello '+v+' team,','Dear '+v+' team,','Hello,','Dear Sir or Madam,']);
  const intro=RT_PICK([
    v+' currently lists '+url+' as '+cls+'. I manage this website'+(rvCompany()?' at '+rvCompany():'')+'.',
    'I am '+(rvCompany()?'with '+rvCompany()+', ':'')+'responsible for the website '+url+', which '+v+' classifies as '+cls+'.',
    'Our website '+url+' is flagged by '+v+' as '+art+' '+cls+' site.',
    'The website '+url+', which I look after'+(rvCompany()?' for '+rvCompany():'')+', is marked as '+cls+' by '+v+'.']);
  const steps=[
    'we checked the website files with a malware scanner and removed what was found',
    'the software of the site (CMS, plugins and theme) has been updated',
    'the passwords of all administrator accounts were changed and unknown admin accounts removed',
    'the server keeps checking the site for malware and for its reputation every day'];
  const pick=steps.sort(()=>Math.random()-.5).slice(0,RT_PICK([2,3]));
  const list=pick.slice(0,-1).join(', ')+' and '+pick[pick.length-1];
  const done=RT_PICK([
    'The site has been cleaned: '+list+'.',
    'We have cleaned and secured the site. In short: '+pick.join('; ')+'.',
    'Since the warning, '+list+'.']);
  const proof=RT_PICK(['VirusTotal report: https://www.virustotal.com/gui/domain/'+domain+'/detection',
    'You can see the current results on VirusTotal: https://www.virustotal.com/gui/domain/'+domain+'/detection']);
  const ask=RT_PICK([
    'Could you please review the site and remove the detection?',
    'We kindly ask you to re-evaluate the site and update its classification.',
    'Please review the domain and remove it from your list if you agree that it is safe.',
    'Would you be so kind as to check it again and lift the block?']);
  const bye=RT_PICK(['Thank you for your help.','Thanks in advance.','Many thanks for looking into this.']);
  const sign=[reviewFrom.name,rvCompany(),myEmail].filter(Boolean).join('\n');
  return hello+'\n\n'+intro+' '+done+'\n\n'+proof+'\n\n'+ask+' '+bye+(sign?'\n\nKind regards,\n'+sign:'');
}
window.vtCopyReviewText=function(domain,vendor){
  const ok=vtCopyText(vtReviewText(domain,vendor));
  vtToast(ok?'Text for the '+vendor+' form copied: paste it into the description box.':'Click 📋 text to see the text and copy it.',ok?'ok':'info');
};
window.vtReviewTextPanel=function(domain,vendor){
  document.getElementById('vt-rt-panel')?.remove();
  const d=document.createElement('div'); d.id='vt-rt-panel'; d.className='vt-rt-panel'; d.setAttribute('role','dialog'); d.setAttribute('aria-label','Text for the review request');
  d.innerHTML='<div class="vt-rt-box"><div class="vt-rt-head"><strong>Text for '+vtEsc(vendor)+'</strong> <span class="hint">'+vtEsc(domain)+'</span><span style="flex:1"></span><a class="vt-rt-x" title="Close">✕</a></div>'
    +'<div class="hint" style="margin:4px 0 8px">Paste this into the form\'s description or comment box. Check it first: it says the site was checked and cleaned. You can edit it here.</div>'
    +'<textarea class="vt-rt-txt" rows="12"></textarea>'
    +'<div class="vt-rt-acts"><button type="button" class="vt-btn primary vt-rt-copy">Copy text</button> <button type="button" class="vt-btn ghost vt-rt-new">Another wording</button> <span class="vt-rt-msg hint"></span></div></div>';
  document.body.appendChild(d);
  const ta=d.querySelector('textarea'), msg=d.querySelector('.vt-rt-msg');
  ta.value=vtReviewText(domain,vendor);
  const close=()=>d.remove();
  d.querySelector('.vt-rt-x').onclick=close;
  d.onclick=e=>{if(e.target===d) close();};
  d.querySelector('.vt-rt-new').onclick=()=>{ta.value=vtReviewText(domain,vendor); msg.textContent='';};
  d.querySelector('.vt-rt-copy').onclick=()=>{
    ta.focus(); ta.select();
    let ok=false; try{ok=document.execCommand('copy');}catch(e){}
    if(!ok&&navigator.clipboard?.writeText) navigator.clipboard.writeText(ta.value).then(()=>{msg.textContent='✓ Copied';},()=>{msg.textContent='Select the text and press Ctrl+C';});
    else msg.textContent=ok?'✓ Copied':'Select the text and press Ctrl+C';
  };
  document.addEventListener('keydown',function esc(e){if(e.key==='Escape'){close();document.removeEventListener('keydown',esc);}});
  ta.focus();
};
function vtTextBtn(domain,vendor){
  return ' <a class="vt-rt-btn" onclick="event.stopPropagation();vtReviewTextPanel(\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\')" title="Show a ready-made text for the form\'s description box, to copy or edit">📋 text</a>';
}
// Fortinet's appeal form fills URL, name, e-mail and company from the address (not the comment: that one comes from 📋)
// The vendor's form address; for a form that takes its fields from the address ("fill" in vendors.json) with those filled in
function vtDetectionOf(domain,key){
  const pid=key==='avg'?147:key==='avast'?146:0, f=pid?(avast.results?.[domain]?.[pid]?.findings||[])[0]:null;
  return f?String(f.detection||'').slice(0,30):'';
}
function vtVendorUrl(v,domain,vendor){
  if(!v.fill) return v.form;
  const vars={site:'https://'+domain+'/',domain,my_email:myEmail||'',my_name:reviewFrom.name||'',my_company:rvCompany(),
    detection:vtDetectionOf(domain,v.key),classification:vtVerdictOf(domain,vendor),alert_id:alertIds[domain]?.[v.key]||''};
  const q=new URLSearchParams();
  for(const [field,tpl] of Object.entries(v.fill)){
    const val=String(tpl).replace(/\{(\w+)\}/g,(m,x)=>x==='text'?vtReviewText(domain,vendor):(vars[x]??''));
    if(val.trim()) q.set(field,val);
  }
  const qs=q.toString();
  return qs?v.form+(v.form.includes('?')?'&':'?')+qs:v.form;
}
// AVG (the direct AVG check in a site's details) uses the same entry
function vtAvgFormUrl(domain){
  const v=vtVendorOf('AVG');
  return v?vtVendorUrl(v,domain,'AVG'):'https://www.avg.com/en-ww/report-false-positive';
}
function vtAlertIdHTML(domain){
  const v=alertIds[domain]?.avg||'';
  return '<span class="vt-alert-id"><label>Alert ID <input type="text" maxlength="20" value="'+vtEsc(v)+'" placeholder="from the block page" '
    +'onchange="vtSetAlertId(\''+vtEsca(domain)+'\',this)" onclick="event.stopPropagation()"></label>'+(v?' <span class="vt-alert-ok">✓ saved</span>':'')+'</span>';
}
window.vtPanelTest=async function(btn){
  btn.disabled=true;
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const r=await fetch(BASE+'?action=panel-notify-test',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken}}).then(x=>x.json()).catch(()=>({error:'Network error'}));
  btn.disabled=false;
  vtToast(r.ok?'Test notification sent: look at the bell at the top of Plesk (reload the page if it does not show yet)':(r.error||'Not sent'),r.ok?'ok':'err');
};
window.vtSetAlertId=async function(domain,inp){
  const v=inp.value.trim();
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const r=await fetch(BASE+'?action=alert-id',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams({domain,vendor:'avg',alert_id:v})})
    .then(x=>x.json()).catch(()=>({error:'Network error'}));
  if(!r.ok){ vtToast(r.error||'Could not save the alert ID','err'); return; }
  alertIds[domain]=r.alert_ids||{}; if(!Object.keys(alertIds[domain]).length) delete alertIds[domain];
  vtToast(v?'Alert ID saved: the AVG form opens with it filled in':'Alert ID removed','ok');
  if(fsOpen[domain]==='vt') vtFsRefresh(domain);
  if(currentTool==='vendors') vtVendorsRender();
};
function vtFpLink(vendor,domain,showTip=true){
  const v=vtVendorOf(vendor), tip=showTip&&v?.advice?'<div class="vt-why-tip">'+vtEsc(v.advice)+'</div>':'';
  const done=vtRevDone(domain,vendor);
  if(!v||!v.form) return '<a data-site-url="'+vtEsc('https://'+domain+'/')+'" onclick="vtCopyReviewUrl(this.dataset.siteUrl)" href="'+VT_FP_LIST+'" target="_blank" rel="noopener">find the contact</a>';
  const mark=(via,to)=>'vtReviewMark(\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\',0,\''+via+'\',\''+vtEsca(to)+'\')';
  if(v.method==='email') return '<a onclick="'+mark('email',v.form)+'" href="mailto:'+vtEsc(v.form)+'?subject='+encodeURIComponent('Review request: '+domain+' has been cleaned')
    +'&body='+encodeURIComponent(vtReviewText(domain,vendor))+'">'+vtEsc(v.form)+'</a>'+done+vtTextBtn(domain,vendor)+tip;
  // A form: opened (filled in when it allows that); the site address or the ready-made text goes on the clipboard
  const copyText=v.copy==='text'?';setTimeout(()=>vtCopyReviewText(\''+vtEsca(domain)+'\',\''+vtEsca(vendor)+'\'),80)':'';
  const title=v.method==='prefill'?'Opens the form with your details filled in'+(v.copy==='text'?'; the text for the description is copied':'')
    :v.copy==='text'?'Opens the vendor\'s form; the text for the description is copied':'Opens the vendor\'s form; the site address is copied';
  return '<a onclick="'+mark('form',v.form)+copyText+'" href="'+vtEsc(vtVendorUrl(v,domain,vendor))+'" target="_blank" rel="noopener" title="'+vtEsc(title)+'">request a review ↗</a>'
    +done+vtTextBtn(domain,vendor)+(v.alert_id?' '+vtAlertIdHTML(domain):'')+tip;
}
function vtWhyRowHTML(domain,st){
  const d=results[domain]||{}, e=vtEsca(domain);
  const list=(d.flagged_by||[]).map(s=>{const i=String(s).indexOf(': ');return i>0?[s.slice(0,i),s.slice(i+2)]:[s,''];});
  const close='<a onclick="vtFsClose(\''+e+'\')">Close</a>';
  let h='<div class="vt-fs-head"><strong>VirusTotal</strong>'
    +(list.length?'<span class="bad">flagged by '+list.length+' vendor'+(list.length===1?'':'s')+'</span>':'<span>'+vtEsc(LABELS[st]||st)+'</span>')
    +(d.last_scan?'<span>last checked '+vtEsc(d.last_scan)+'</span>':'')
    +(list.length?'<span>review requested at '+list.filter(([v])=>reviews[domain]?.[v]).length+' of '+list.length+'</span>':'')
    +'<span class="sp"></span><a href="https://www.virustotal.com/gui/domain/'+vtEsc(domain)+'/detection" target="_blank" rel="noopener">Full report ↗</a> · '+close+'</div>';
  h+=extNoteHTML(domain)+faHandledHTML(domain);
  // Only for a red or orange site: for a clean one the explanation is not needed
  if(['infected','suspicious'].includes(st)||list.length) h+='<div class="vt-why-note"><strong>Already cleaned the site, and it is still red or orange?</strong> That is normal for a while. '
    +'This status comes from VirusTotal, not from the files on the server. Each vendor below keeps its own blocklist and updates it on its own schedule: '
    +'some within hours, others only after days or weeks, and some only when you ask.</div>'
    +'<div class="vt-why-note"><strong>Turned red, or worse, while nothing changed on the site?</strong> The overall verdict is VirusTotal&rsquo;s, not Stingy Scanner&rsquo;s: '
    +'one vendor that calls the site <em>malicious</em> makes it <strong>infected</strong> (red); vendors that only call it <em>suspicious</em> make it orange. '
    +'VirusTotal regularly <strong>adds new vendors</strong>, and a newly added vendor that already had the site on its blocklist can turn it from suspicious to infected overnight, '
    +'without a new infection. Compare the vendors below with the site&rsquo;s history: a vendor that appears there for the first time may simply be new on VirusTotal. '
    +'Check the site anyway (file scan, admin accounts), and ask that vendor for a review if the site is clean.</div>';
  if(list.length||avast.products?.length||gsb.enabled){
    // First the vendors of VirusTotal, below them the extra services switched on in Settings
    const extra=vtGsbRow(domain)+vtAvastRow(domain), tot=d.total?' of '+d.total:'';
    h+='<div class="vt-why-howto"><strong>How asking for a review works:</strong> click <em>request a review ↗</em>. The vendor\'s form opens in a new tab '
      +'and the site address (<code>https://'+vtEsc(domain)+'/</code>) is <strong>copied to your clipboard</strong>: paste it into the form. '
      +'Stingy Scanner <strong>remembers every request</strong>: the vendor gets <em>✓ Requested</em> with the date and who asked, the count at the top goes up, '
      +'and it is added to the site\'s history, for everyone who manages this site. '
      +'When the vendor confirms the delisting (by e-mail or in their portal), click <em>✓ delisting confirmed</em> to record it — it turns green and is added to the history. '
      +'Turned down? Click <em>denied</em> (with the reason). Clicked by mistake? <em>undo</em>.</div>';
    h+='<table class="vt-fs-tbl vt-why-tbl"><thead><tr><th>Vendor</th><th>Verdict</th><th>Ask for a review</th></tr></thead><tbody>'
      +'<tr class="vt-why-grp"><td colspan="3">VirusTotal vendors <span>'+(list.length?list.length+tot+' flag this site':'none'+tot+' flags this site')+'</span></td></tr>'
      +(list.length?list.map(([v,r])=>'<tr'+(reviews[domain]?.[v]?' class="asked'+(reviews[domain][v].confirmed_at?' confirmed':'')+'\"':'')+'><td>'+vtEsc(v)+'</td><td>'+vtEsc(r)+'</td><td>'+vtFpLink(v,domain)+'</td></tr>').join('')
        :'<tr><td colspan="3" class="hint">No VirusTotal vendor flags this site'+(d.last_scan?' (report of '+vtEsc(d.last_scan)+')':'')+'.</td></tr>')
      +(extra?'<tr class="vt-why-grp"><td colspan="3">Extra services <span>switched on in Settings</span></td></tr>'+extra:'')
      +'</tbody></table>';
  }
  h+=fsScanCollHTML(domain);
  if(list.length){
    h+='<details class="vt-collapsible"'+(stepsOpen[domain]?' open':'')+' ontoggle="vtStepsToggle(this,\''+e+'\')">'
      +'<summary>How to clean up and remove VT Flag</summary>'
      +'<ol class="vt-why-steps">'
      +'<li><strong>Clean the site first.</strong> Use the file scanner section above to find infected files. Update WordPress, plugins and themes, remove plugins you don\'t use, change all passwords (admin, FTP/SFTP, database, hosting) and remove admin users you don\'t know. Otherwise the site is infected again soon and the vendors list it again.</li>'
      +'<li><strong>Click Rescan.</strong> VirusTotal then checks the site address again with all vendors (this uses one manual call). The score shown here comes from the VirusTotal report for the whole domain, which follows when the vendors update their own lists, so it does not always drop right away.</li>'
      +'<li><strong>Ask the vendors that still flag it for a review.</strong> Opening a review link copies the site URL to your clipboard. Paste it into the form and mention that it has been cleaned and what you did. Most answer within a few days.</li>'
      +'<li><strong>Google:</strong> if Chrome shows a red warning, the site owner can ask Google for a review in <a href="https://search.google.com/search-console/security-issues" target="_blank" rel="noopener">Search Console → Security issues</a>. Google usually handles this within a few days.</li>'
      +'<li><strong>Click Rescan again after a few days</strong> to see which vendors have removed the site from their list. Results of infected sites are refreshed every day by the background scan anyway. '
      +'When a vendor says it has removed the site but VirusTotal still shows it: VirusTotal keeps separate reports for <code>www.</code> and <code>http://</code> versions of the address; open them on virustotal.com and click <em>Reanalyze</em> on each.</li>'
      +'</ol><div class="vt-fs-note">Contacts from <a href="'+VT_FP_LIST+'" target="_blank" rel="noopener">VirusTotal\'s list of vendor contacts</a>. Stingy Scanner never changes anything on the site; cleaning is up to you.</div>'
      +'</details>';
  }
  h+='<details class="vt-collapsible"'+(histOpen[domain]?' open':'')+' ontoggle="vtHistToggle(this,\''+e+'\')">'
    +'<summary>History of this site <span style="font-weight:400;color:var(--muted)">(newest first)</span></summary>'
    +'<div id="vtsh-'+rid(domain)+'">'+vtSiteHistHTML(domain)+'</div>'
    +'</details>';
  h+=vtWpUsersHTML(domain);
  if(!list.length) return '<tr class="vt-fs-row" id="vtfs-'+rid(domain)+'" data-domain="'+vtEsc(domain)+'" data-status="'+st+'"><td colspan="5"><div class="vt-fs">'+h+'</div></td></tr>';
  return '<tr class="vt-fs-row" id="vtfs-'+rid(domain)+'" data-domain="'+vtEsc(domain)+'" data-status="'+st+'"'+(inQueue(domain)?' data-job="1"':'')+'><td colspan="5"><div class="vt-fs">'+h+'</div></td></tr>';
}
// A click anywhere on a site's row (not on a button, link or field) opens or closes its details
document.addEventListener('click',ev=>{
  const tr=ev.target.closest('#vt-tbody tr[data-domain]');
  if(!tr||tr.classList.contains('vt-fs-row')) return;
  if(ev.target.closest('a,button,input,select,textarea,label,summary')) return;
  if(window.getSelection&&String(window.getSelection())) return; // selecting text, not clicking
  if(tr.querySelector('.vt-why-btn')) vtWhyClick(tr.dataset.domain);
});
window.vtWhyClick=function(domain){
  if(fsOpen[domain]==='vt'){vtFsClose(domain);return;}
  fsOpen[domain]='vt'; vtFsRefresh(domain); vtLoadSiteHist(domain); vtAvastLive(domain); vtGsbLive(domain); vtFaLoad(domain);
  if(scIsAdmin) vtWpUsersLoad(domain);
};
window.vtLoadSiteHist=async function(domain){
  const r=await vtFetch('?action=site-history&domain='+encodeURIComponent(domain)).catch(()=>null);
  if(r&&Array.isArray(r.history)){siteHist[domain]=r.history; if(r.history.length) histSites.add(domain);}
  const el=document.getElementById('vtsh-'+rid(domain));
  if(el) el.innerHTML=vtSiteHistHTML(domain);
};
let avChecking={};
/** Google Safe Browsing as its own vendor row in the details: official API, checked live and every night */
let gsbChecking={};
function vtGsbRow(domain){
  if(!gsb.enabled) return '';
  const r=gsb.results?.[domain], p=x=>String(x).padStart(2,'0'), name='Google Safe Browsing';
  let verdict, action='—';
  if(gsbChecking[domain]) verdict='<span class="vt-spin"></span> '+(gsbChecking[domain]==='waiting'?'queued for request limit':'checking Google…');
  else if(!r) verdict='<span class="hint">not checked yet</span>';
  else{
    const d=new Date(r.checked_at*1000), stale=Date.now()/1000-r.checked_at>(gsb.fresh||1800);
    const meta='<div class="vt-why-tip">'+(stale?'<strong>last known</strong> · ':'')+p(d.getDate())+'-'+p(d.getMonth()+1)+'-'+d.getFullYear()+' ('+p(d.getHours())+':'+p(d.getMinutes())+')'
      +' · <a onclick="vtGsbLive(\''+vtEsca(domain)+'\',1)">check again</a></div>';
    if(r.state!=='ok') verdict='<span class="vt-sh-pill warn">Check failed</span> '+vtEsc(r.error||'')+meta;
    else if(!r.threats?.length) verdict='<span class="vt-sh-pill good">Not listed</span>'+meta;
    else{
      verdict=r.threats.map(t=>'<span class="vt-sh-pill bad">'+vtEsc(t)+'</span>').join(' ')+meta;
      const url=gsb.review||'https://search.google.com/search-console/security-issues';
      action='<a onclick="vtReviewMark(\''+vtEsca(domain)+'\',\''+name+'\',0,\'form\',\''+vtEsca(url)+'\')" href="'+vtEsc(url)+'" target="_blank" rel="noopener">request a review in Search Console ↗</a>'
        +vtRevDone(domain,name)+'<div class="vt-why-tip">The site owner adds the site to Google Search Console, fixes what is listed under <strong>Security issues</strong>, ticks <em>I have fixed these issues</em> and clicks <strong>Request review</strong>. Phishing reviews usually take a day, malware reviews a few days.</div>';
    }
  }
  return '<tr class="vt-av-row'+(reviews[domain]?.[name]?' asked':'')+'"><td>'+vtBrandIco('google')+' '+name+' <span class="hint" title="Asked directly from Google\'s official Safe Browsing API, not via VirusTotal.">(direct)</span></td><td>'+verdict+'</td><td>'+action+'</td></tr>';
}
/** Ask Google now (force = also when a result of the last 30 minutes exists) */
window.vtGsbLive=async function(domain,force){
  if(!gsb.enabled||gsbChecking[domain]) return;
  gsbChecking[domain]=true; if(fsOpen[domain]==='vt') vtFsRefresh(domain);
  let r;
  for(;;){
    r=await vtFetch('?action=gsb-live&domain='+encodeURIComponent(domain)+(force?'&force=1':'')).catch(()=>null);
    if(r?.result?.state!=='rate_limited') break;
    gsbChecking[domain]='waiting'; if(fsOpen[domain]==='vt') vtFsRefresh(domain);
    await delay(Math.max(1,r.result.retry_after||60)*1000);
    if(fsOpen[domain]!=='vt'){delete gsbChecking[domain];return;}
    gsbChecking[domain]=true;
  }
  delete gsbChecking[domain];
  gsb.results=gsb.results||{};
  if(r?.result) gsb.results[domain]=r.result;
  else gsb.results[domain]={checked_at:Math.floor(Date.now()/1000),state:'failed',threats:[],error:r?.error||'Network error'};
  vtFsRefresh(domain); if(typeof updateRow==='function'&&results[domain]) updateRow(domain,results[domain]);
  if(fsOpen[domain]==='vt') vtLoadSiteHist(domain);
};
/** Avast / AVG as their own vendor rows in the details: checked live, not via VirusTotal */
function vtAvastRow(domain){
  return (avast.products||[]).map(pr=>vtAvastRow1(domain,pr)).join('');
}
function vtAvastRow1(domain,pr){
  const r=avast.results?.[domain]?.[pr.id], n=vtEsc(pr.name), p=x=>String(x).padStart(2,'0');
  let verdict, action='—';
  if(avChecking[domain+'|'+pr.id]) verdict='<span class="vt-spin"></span> '+(avChecking[domain+'|'+pr.id]==='waiting'?'queued for request limit':('checking '+n+'…'));
  else if(!r) verdict='<span class="hint">not checked yet</span>';
  else{
    const d=new Date(r.checked_at*1000);
    const meta='<div class="vt-why-tip">'+vtEsc(r.url)+' · '+p(d.getDate())+'-'+p(d.getMonth()+1)+'-'+d.getFullYear()+' ('+p(d.getHours())+':'+p(d.getMinutes())+') · HTTP '+(r.http||'–')
      +' · <a onclick="vtAvastLive(\''+vtEsca(domain)+'\',1)">check again</a></div>';
    if(r.state!=='ok') verdict='<span class="vt-sh-pill warn">Check failed</span> '+vtEsc(r.error||'')+meta;
    else if(!r.findings?.length) verdict='<span class="vt-sh-pill good">No classification received</span>'+meta;
    else{
      verdict=r.findings.map(f=>'<span class="vt-sh-pill bad">'+vtEsc(f.classification)+'</span> <code>'+vtEsc(f.detection||f.raw)+'</code>').join('<br>')+meta;
      action=pr.id===147
        ?'<a onclick="vtReviewMark(\''+vtEsca(domain)+'\',\''+vtEsca(pr.name)+'\',0,\'form\',\''+vtEsca(pr.form)+'\')" href="'+vtEsc(vtAvgFormUrl(domain))+'" target="_blank" rel="noopener" title="Opens AVG\'s form filled in; tick the reCAPTCHA and click Send">report a false positive ↗</a>'
          +vtRevDone(domain,pr.name)+' '+vtAlertIdHTML(domain)
          +'<div class="vt-why-tip">Opens AVG\'s form <strong>already filled in</strong>: Website, the site address, your e-mail address, the detection name'
          +(alertIds[domain]?.avg?', the alert ID':'')+' and a description. Only tick the reCAPTCHA and click <strong>Send</strong>. '
          +(alertIds[domain]?.avg?'':'Enter the <strong>Alert ID</strong> first: it is on AVG Web Shield\'s block page when you open the site on a computer with AVG (blocked, so safe). ')+'</div>'
        :'<a onclick="vtReviewMark(\''+vtEsca(domain)+'\',\''+vtEsca(pr.name)+'\',0,\'form\',\''+vtEsca(pr.form)+'\')" href="'+vtEsc(pr.form)+'" target="_blank" rel="noopener">report a false positive ↗</a>'
        +vtRevDone(domain,pr.name)+'<div class="vt-why-tip">Official '+n+' form; choose <strong>URL</strong> and enter the site address. '
        +'The form asks for an <strong>Alert ID</strong>: that is not the code above, it only appears in the warning popup of the '+n+' app on a computer that blocks the site. '
        +'Leave it empty if the form allows it, or open the site on a PC with '+n+' installed and copy the Alert ID from the popup. '
        +'Mention the classification (<code>'+vtEsc(r.findings.map(f=>f.classification).join(', '))+'</code>) in the description.</div>';
    }
  }
  return '<tr class="vt-av-row'+(reviews[domain]?.[pr.name]?' asked':'')+'"><td>'+vtBrandIco(pr.id)+' '+n+' <span class="hint" title="Asked directly from '+n+'\'s URL reputation service, not via VirusTotal. Unofficial, may stop working.">(direct)</span></td><td>'+verdict+'</td><td>'+action+'</td></tr>';
}
/** Ask Avast and/or AVG now, one after the other (force = also when a result of the last 5 minutes exists) */
window.vtAvastLive=async function(domain,force){
  for(const pr of (avast.products||[])){
    const k=domain+'|'+pr.id;
    if(avChecking[k]) continue;
    avChecking[k]=true; if(fsOpen[domain]==='vt') vtFsRefresh(domain);
    let r;
    for(;;){
      r=await vtFetch('?action=avast-live&domain='+encodeURIComponent(domain)+'&product='+pr.id+(force?'&force=1':'')).catch(()=>null);
      if(r?.result?.state!=='rate_limited') break;
      avChecking[k]='waiting'; if(fsOpen[domain]==='vt') vtFsRefresh(domain);
      await delay(Math.max(1,r.result.retry_after||60)*1000);
      if(fsOpen[domain]!=='vt'){delete avChecking[k];return;}
      avChecking[k]=true;
    }
    delete avChecking[k];
    const res=avast.results=avast.results||{}; res[domain]=res[domain]||{};
    if(r?.result){res[domain][pr.id]=r.result; if(r.result.state==='ok') histSites.add(domain);}
    else res[domain][pr.id]={url:'https://'+domain+'/',checked_at:Math.floor(Date.now()/1000),http:0,state:'failed',findings:[],error:r?.error||'Network error'};
    vtFsRefresh(domain);
  }
  if(fsOpen[domain]==='vt') vtLoadSiteHist(domain);
  if(document.getElementById('vtpanel-trend')?.classList.contains('active')) vtLoadTrend();
};
function vtSiteHistHTML(domain){
  const list=siteHist[domain];
  if(!list) return '<span class="hint">Loading history…</span>';
  if(!list.length) return '<span class="hint">Nothing recorded yet for this site.</span>';
  const p=n=>String(n).padStart(2,'0');
  const LBL={infected:'Infected',suspicious:'Suspicious',clean:'Clean',gone:'Left the list'};
  const badge=st=>'<span class="vt-badge '+(LBL[st]?st:'unchecked')+'">'+vtEsc(LBL[st]||st||'unknown')+'</span>';
  const pill=(cls,t)=>'<span class="vt-sh-pill '+cls+'">'+t+'</span>';
  return list.map(e=>{
    const d=new Date(e.ts*1000);
    const when=p(d.getDate())+'-'+p(d.getMonth()+1)+'-'+d.getFullYear()+' <small>('+(e.approx?'last seen ':'')+p(d.getHours())+':'+p(d.getMinutes())+')</small>';
    let what='', text='';
    if(e.type==='status'){what=badge(e.from)+'<span class="vt-sh-arr">&rarr;</span>'+badge(e.to);}
    else if(e.type==='detected'){what=pill('bad','Detected');text='<strong>'+vtEsc(e.score||'')+'</strong>'+(e.vendors?.length?' by '+vtEsc(e.vendors.join(', '))+(e.partial?' and others':''):'');}
    else if(e.type==='flag'){what=pill('bad','Flagged');text='<strong>'+vtEsc(e.vendor)+'</strong>'+(e.verdict?': '+vtEsc(e.verdict):'');}
    else if(e.type==='unflag'){what=pill('good','Delisted');text='<strong>'+vtEsc(e.vendor)+'</strong> no longer flags the site';}
    else if(e.type==='review'){what=pill('info','Review asked');text='<strong>'+vtEsc(e.vendor)+'</strong> '+(e.via==='email'?'by e-mail'+(e.to?' to '+vtEsc(e.to):''):'via website form'+(e.to?' ('+(/^https?:\/\//i.test(e.to)?'<a href="'+vtEsc(e.to)+'" target="_blank" rel="noopener">'+vtEsc(e.to.replace(/^https?:\/\//i,'').slice(0,50))+'</a>':vtEsc(e.to.slice(0,50)))+')':''))+(e.by?' · by '+vtEsc(e.by):'');}
    else if(e.type==='denied'){what=pill('warn','Review denied');text='<strong>'+vtEsc(e.vendor)+'</strong>'+(e.reason?': '+vtEsc(e.reason):'')+(e.by?' · by '+vtEsc(e.by):'');}
    else if(e.type==='av'){what=e.to?pill('bad',vtEsc(e.product)+': '+vtEsc(e.to.replace(/^URL:/,''))):pill('good',vtEsc(e.product)+': none');
      text=e.to?vtEsc(e.product)+' classifies the site as <strong>'+vtEsc(e.to)+'</strong>'+(e.detection?' (<code>'+vtEsc(e.detection)+'</code>)':'')+(e.from?', was '+vtEsc(e.from):'')
               :vtEsc(e.product)+(e.observed?' check returned no classification':' no longer classifies the site')+(e.from?' (was '+vtEsc(e.from)+')':'');}
    else if(e.type==='file'){const L={clean:['good','Cleaned'],unclean:['warn','Cleanup undone'],quarantine:['good','Quarantined'],unquarantine:['warn','Restored'],qdelete:['','Deleted']}[e.action]||['',vtEsc(e.action)];
      what=pill(L[0],L[1]);text='<code>'+vtEsc(e.file)+'</code>'+(e.detail?' · '+vtEsc(e.detail):'')+(e.by?' · by '+vtEsc(e.by):'');}
    else if(e.type==='dbscan'){const tgt='<code>'+vtEsc(e.db)+'</code>'+(e.prefix?' (tables <code>'+vtEsc(e.prefix)+'*</code>)':'');
      what=e.error?pill('warn','DB scan failed'):e.clean?pill('good','DB scan: clean'):pill('bad','DB scan: found');
      text='ClamAV scan of '+tgt+(e.error?': '+vtEsc(e.error):e.clean?': nothing found':': '+vtEsc((e.found||[]).join(', ')))+(e.size?' · '+vtBytes(e.size)+' dump, deleted':'')+(e.by?' · by '+vtEsc(e.by):'');}
    else if(e.type==='unreview'){what=pill('','Undone');text='review request for <strong>'+vtEsc(e.vendor)+'</strong> undone'+(e.by?' · by '+vtEsc(e.by):'');}
    else if(e.type==='confirmed'){what=pill('good','Delisting confirmed');text='<strong>'+vtEsc(e.vendor)+'</strong> confirmed the delisting'+(e.by?' · by '+vtEsc(e.by):'');}
    else if(e.type==='unconfirmed'){what=pill('','Undone');text='delisting confirmation for <strong>'+vtEsc(e.vendor)+'</strong> undone'+(e.by?' · by '+vtEsc(e.by):'');}
    return '<div class="vt-sh-row"><div class="vt-sh-time">'+when+'</div><div class="vt-sh-what">'+what+'</div><div class="vt-sh-text">'+text+'</div></div>';
  }).join('');
}
// ── Clean (Imunify) and quarantine, administrator only ─────────
// Clean: Imunify removes the malicious code and keeps the original (Undo puts it back).
// Quarantine: the file moves to a root-only folder on the server (Restore puts it back exactly).
// Every action is one click plus a confirmation; a scan never cleans anything by itself.
let fileact={admin:false,imunify:false}, handled={}, faState={}, faNote={}, faBulk={};
function faKey(d,f){return d+'|'+f;}
function faFile(domain,id,i){return fsFull[domain+'|'+id]?.found?.[i]?.file;}
function faHandledOf(domain,file){return (handled[domain]||[]).find(h=>h.file===file);}
async function faPost(params){
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  return fetch(BASE+'?action=file-act',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams(params)})
    .then(r=>r.json()).catch(()=>({error:'Network error'}));
}
window.vtFaLoad=async function(domain){
  if(!fileact.admin) return;
  const r=await vtFetch('?action=file-handled&domain='+encodeURIComponent(domain)).catch(()=>null);
  if(r&&Array.isArray(r.handled)){handled[domain]=r.handled; vtFsRefresh(domain);}
};
function faCellHTML(domain,id,i,f){
  const e=vtEsca(domain), hd=faHandledOf(domain,f.file), st=faState[faKey(domain,f.file)];
  const a=(fn,label)=>'<a onclick="'+fn+'(\''+e+'\',\''+id+'\','+i+')">'+label+'</a>';
  if(st?.busy) return '<span class="vt-spin"></span> '+vtEsc(st.busy);
  if(!hd&&f.action==='deleted') return '<span class="vt-fa-done">Deleted from quarantine</span>';
  if(!hd&&f.action) return '<span class="vt-fa-done">'+(f.action==='cleaned'?'Cleaned':'In quarantine')+'</span>';
  if(hd){const j=handled[domain].indexOf(hd);
    return hd.action==='cleaned'?'<span class="vt-fa-done">Cleaned by Imunify</span> · <a onclick="vtFaAskH(\''+e+'\','+j+')">Undo</a>'
                                :'<span class="vt-fa-done">In quarantine</span> · <a onclick="vtFaAskH(\''+e+'\','+j+')">Restore</a>';}
  return (fileact.imunify?a('vtFaClean','Clean')+' · ':'')+a('vtFaQuar','Quarantine');
}
function faDiffHTML(diff){
  return '<pre class="vt-fa-diff">'+diff.split('\n').filter(l=>!/^(---|\+\+\+) ?$/.test(l)).map(l=>{
    const c=l.startsWith('-')?'del':l.startsWith('+')?'add':l.startsWith('@@')?'hunk':'';
    return '<span'+(c?' class="'+c+'"':'')+'>'+vtEsc(l)+'</span>';}).join('\n')+'</pre>';
}
/** Does the cleanup remove the whole file? (only removed lines, nothing kept or added) */
function faWhole(diff){
  const body=String(diff||'').split('\n').filter(l=>l!==''&&!/^(---|\+\+\+|@@)/.test(l));
  return body.length>0&&body.every(l=>l.startsWith('-'));
}
function faPanelHTML(domain,id,i,f){
  const st=faState[faKey(domain,f.file)]; if(!st||st.busy) return '';
  const e=vtEsca(domain), b=(fn,label,cls)=>'<button type="button" class="vt-btn '+(cls||'ghost')+'" onclick="'+fn+'(\''+e+'\',\''+id+'\','+i+')">'+label+'</button>';
  let h;
  if(st.stage==='diff'){
    h='<strong>What Imunify will change</strong>'+(st.type?' <span class="hint">('+vtEsc(st.type)+')</span>':'')+faDiffHTML(st.diff||'')
     +'<div class="vt-fa-q">Lines marked <span class="del">−</span> are removed'+(faWhole(st.diff)?' (here: everything, so the file will be empty)':'')
     +'. Imunify keeps the original, so <strong>Undo</strong> puts it back. Check the site afterwards.</div>'
     +b('vtFaCleanGo','Clean this file','primary')+' '+b('vtFaCancel','Cancel');
  }else if(st.stage==='confirmQ'){
    h='<div class="vt-fa-q"><strong>Move this file to quarantine?</strong> It is removed from the site and kept in a folder only root can open. '
     +'<strong>Restore</strong> puts it back exactly (same place, permissions and date). If the site needs this file, the site may break until you restore it.</div>'
     +b('vtFaQuarGo','Move to quarantine','primary')+' '+b('vtFaCancel','Cancel');
  }else{
    h='<div class="vt-fa-q'+(st.ok?' ok':' err')+'">'+vtEsc(st.msg||'')+'</div>'+b('vtFaCancel','OK');
  }
  return '<tr class="vt-fa-row"><td colspan="3">'+h+'</td></tr>';
}
function faSet(domain,file,s){const k=faKey(domain,file); if(s) faState[k]=s; else delete faState[k]; vtFsRefresh(domain);}
window.vtFaCancel=function(domain,id,i){faSet(domain,faFile(domain,id,i),null);};
window.vtFaQuar=function(domain,id,i){faSet(domain,faFile(domain,id,i),{stage:'confirmQ'});};
window.vtFaClean=async function(domain,id,i){
  const file=faFile(domain,id,i); if(!file) return;
  faSet(domain,file,{busy:'Checking with Imunify…'});
  let r=await faPost({op:'check',domain,file});
  if(r.pending) return faSet(domain,file,{msg:'Imunify is busy with another scan. Try again in a minute.'});
  if(r.error||r.item?.status!=='found') return faSet(domain,file,{msg:r.error||r.note||'Imunify does not recognise this file as malware, so it cannot clean it. Check the file yourself, or use Quarantine.'});
  faSet(domain,file,{busy:'Loading what Imunify will change…'});
  r=await faPost({op:'diff',domain,file});
  faSet(domain,file,r.error?{msg:r.error}:{stage:'diff',diff:r.diff||'',type:r.item?.type||'',size:r.size});
};
window.vtFaCleanGo=async function(domain,id,i){
  const file=faFile(domain,id,i); if(!file) return;
  faSet(domain,file,{busy:'Imunify is cleaning…'});
  const r=await faPost({op:'clean',domain,file});
  if(r.handled) handled[domain]=r.handled;
  if(r.ok) faReloadResults(domain);
  faSet(domain,file,r.ok?{ok:true,msg:(String(r.status||'').startsWith('cleanup_removed')?'Imunify removed the malicious content; the file is now empty.':'Imunify cleaned the file.')+' Undo puts the original back. Check the site, then scan again.'}:{msg:r.error||'Cleaning failed'});
};
window.vtFaQuarGo=async function(domain,id,i){
  const file=faFile(domain,id,i); if(!file) return;
  faSet(domain,file,{busy:'Moving to quarantine…'});
  const r=await faPost({op:'quarantine',domain,file});
  if(r.handled) handled[domain]=r.handled;
  if(r.ok) faReloadResults(domain);
  faSet(domain,file,r.ok?{ok:true,msg:'The file is in quarantine'+(fileact.qdays>0?' (deleted automatically after '+fileact.qdays+' days)':'')+'. Restore puts it back. Check the site, then scan again.'}:{msg:r.error||'Could not move the file'});
};
// Undo a cleanup / restore from quarantine: puts the infected file back, so it asks first
window.vtFaAskH=function(domain,j){const hd=handled[domain]?.[j]; if(!hd) return; faNote[domain]={ask:j,file:hd.file,action:hd.action}; vtFsRefresh(domain);};
window.vtFaNoteClose=function(domain){delete faNote[domain]; vtFsRefresh(domain);};
window.vtFaAskD=function(domain,j){const hd=handled[domain]?.[j]; if(!hd) return; faNote[domain]={ask:j,file:hd.file,action:'qdelete'}; vtFsRefresh(domain);};
window.vtFaGoH=async function(domain,j,del){
  const hd=handled[domain]?.[j]; if(!hd) return;
  faNote[domain]={busy:del?'Deleting…':hd.action==='cleaned'?'Imunify is restoring the original…':'Putting the file back…'}; vtFsRefresh(domain);
  const r=await faPost(del?{op:'qdelete',domain,qid:hd.qid}:hd.action==='cleaned'?{op:'restore',domain,file:hd.file}:{op:'unquarantine',domain,qid:hd.qid});
  if(r.handled) handled[domain]=r.handled;
  delete faState[faKey(domain,hd.file)];
  faNote[domain]=r.ok?{ok:true,msg:hd.file+(del?': deleted for good.':hd.action==='cleaned'?': Imunify put the original back.':': the file is back in place.')+(r.note?' '+r.note:'')}:{msg:r.error||'Failed'};
  vtFsRefresh(domain); faReloadResults(domain);
};
/** After cleaning, quarantine or restore: fetch the stored scan results again, so the infected counts follow */
async function faReloadResults(domain){
  for(const id of Object.keys(scans[domain]||{})){
    const r=await vtFetch('?action=file-result&scanner='+id+'&domain='+encodeURIComponent(domain)).catch(()=>null);
    if(!r?.result) continue;
    scans[domain][id]=r.result; if(fsFull[domain+'|'+id]) fsFull[domain+'|'+id]=r.result;
  }
  vtFsRefresh(domain);
}
function faNoteHTML(domain){
  const n=faNote[domain]; if(!n) return '';
  const e=vtEsca(domain);
  if(n.busy) return '<div class="vt-fa-q"><span class="vt-spin"></span> '+vtEsc(n.busy)+'</div>';
  if(n.ask!==undefined&&n.action==='qdelete') return '<div class="vt-fa-q err"><strong>Delete <code>'+vtEsc(n.file)+'</code> from quarantine for good?</strong> '
    +'It cannot be restored afterwards.</div><button type="button" class="vt-btn danger" onclick="vtFaGoH(\''+e+'\','+n.ask+',1)">Delete permanently</button> '
    +'<button type="button" class="vt-btn ghost" onclick="vtFaNoteClose(\''+e+'\')">Cancel</button>';
  if(n.ask!==undefined) return '<div class="vt-fa-q"><strong>'+(n.action==='cleaned'?'Undo the cleanup of':'Restore')+' <code>'+vtEsc(n.file)+'</code>?</strong> '
    +'This puts the infected file back on the site.</div><button type="button" class="vt-btn primary" onclick="vtFaGoH(\''+e+'\','+n.ask+')">'+(n.action==='cleaned'?'Undo cleanup':'Restore file')+'</button> '
    +'<button type="button" class="vt-btn ghost" onclick="vtFaNoteClose(\''+e+'\')">Cancel</button>';
  return '<div class="vt-fa-q '+(n.ok?'ok':'err')+'">'+vtEsc(n.msg||'')+' <a onclick="vtFaNoteClose(\''+e+'\')">OK</a></div>';
}
/** Cleaned and quarantined files of a site, with Undo / Restore */
function faHandledHTML(domain){
  if(!fileact.admin) return '';
  const list=handled[domain]||[], e=vtEsca(domain);
  if(!list.length&&!faNote[domain]) return '';
  let h='<div class="vt-fa-handled"><div class="vt-tr-title" style="margin-top:12px">Cleaned and quarantined files</div>'+faNoteHTML(domain);
  if(list.length) h+='<table class="vt-fs-tbl"><thead><tr><th>File</th><th>What happened</th><th></th></tr></thead><tbody>'
    +list.map((hd,j)=>'<tr><td>'+vtEsc(hd.file)+'</td><td class="vt-fa-cell">'+(hd.action==='cleaned'?'Cleaned by Imunify':'In quarantine')
      +' · '+vtAgo(hd.at)+(hd.by?' · by '+vtEsc(hd.by):'')
      +(hd.action==='quarantined'&&fileact.qdays>0?' · <span class="hint">deleted automatically on '+new Date((hd.at+fileact.qdays*86400)*1000).toLocaleDateString()+'</span>':'')
      +'</td><td class="vt-fa-cell"><a onclick="vtFaAskH(\''+e+'\','+j+')">'+(hd.action==='cleaned'?'Undo':'Restore')+'</a>'
      +(hd.action==='quarantined'?' · <a class="vt-fa-del" onclick="vtFaAskD(\''+e+'\','+j+')">Delete</a>':'')+'</td></tr>').join('')+'</tbody></table>';
  return h+'</div>';
}
// Clean all / quarantine all files in a result, one by one
function faBulkHTML(domain,id,found){
  if(!fileact.admin) return '';
  const e=vtEsca(domain), b=faBulk[domain];
  const open=found.filter(f=>!faHandledOf(domain,f.file)&&!f.handled).length;
  if(b?.busy) return '<div class="vt-fa-bulk"><span class="vt-spin"></span> '+vtEsc(b.busy)+'</div>';
  if(b?.msg) return '<div class="vt-fa-bulk"><span class="vt-fa-q '+(b.ok?'ok':'err')+'">'+vtEsc(b.msg)+'</span> <a onclick="vtFaBulkClose(\''+e+'\')">OK</a></div>';
  if(b?.ask) return '<div class="vt-fa-bulk"><span class="vt-fa-q"><strong>'+(b.ask==='clean'?'Let Imunify clean':'Move to quarantine')+' all '+open+' file'+(open===1?'':'s')+'?</strong> '
    +(b.ask==='clean'?'Files Imunify does not recognise are skipped. Imunify keeps every original (Undo).':'Each file can be restored (Restore).')+' Check the site afterwards.</span> '
    +'<button type="button" class="vt-btn primary" onclick="vtFaBulkGo(\''+e+'\',\''+id+'\')">'+(b.ask==='clean'?'Clean all':'Quarantine all')+'</button> '
    +'<button type="button" class="vt-btn ghost" onclick="vtFaBulkClose(\''+e+'\')">Cancel</button></div>';
  if(open<2) return '';
  return '<div class="vt-fa-bulk">'+(fileact.imunify?'<a onclick="vtFaBulkAsk(\''+e+'\',\'clean\')">Clean all with Imunify</a> · ':'')
    +'<a onclick="vtFaBulkAsk(\''+e+'\',\'quar\')">Quarantine all</a></div>';
}
window.vtFaBulkAsk=function(domain,what){faBulk[domain]={ask:what}; vtFsRefresh(domain);};
window.vtFaBulkClose=function(domain){delete faBulk[domain]; vtFsRefresh(domain);};
window.vtFaBulkGo=async function(domain,id){
  const what=faBulk[domain]?.ask, found=fsFull[domain+'|'+id]?.found||[];
  const todo=found.filter(f=>!faHandledOf(domain,f.file)&&!f.handled).map(f=>f.file);
  let done=0, skipped=0; const fails=[];
  for(let n=0;n<todo.length;n++){
    const file=todo[n];
    faBulk[domain]={busy:(what==='clean'?'Cleaning':'Moving')+' '+(n+1)+' of '+todo.length+': '+file}; vtFsRefresh(domain);
    let r;
    if(what==='clean'){
      const c=await faPost({op:'check',domain,file});
      if(c.item?.status!=='found'){skipped++; continue;}
      r=await faPost({op:'clean',domain,file});
    }else r=await faPost({op:'quarantine',domain,file});
    if(r.handled) handled[domain]=r.handled;
    if(r.ok) done++; else fails.push(file+': '+(r.error||'failed'));
  }
  faReloadResults(domain);
  faBulk[domain]={ok:!fails.length,msg:(what==='clean'?'Cleaned ':'Quarantined ')+done+' of '+todo.length+'.'
    +(skipped?' '+skipped+' not recognised by Imunify (use Quarantine for those).':'')
    +(fails.length?' Not done: '+fails.join(' · ')+'.':'')+' Check the site, then scan again.'};
  vtFsRefresh(domain);
};
function fsRowHTML(domain,st){
  const id=fsOpen[domain]; if(!id) return '';
  if(id==='vt') return vtWhyRowHTML(domain,st);
  const r=fsGet(domain,id), full=fsFull[domain+'|'+id], name=vtEsc(fsGet(domain,id)?.name||fsName(id)), e=vtEsca(domain);
  const close='<a onclick="vtWhyClick(\''+e+'\')">&larr; Details</a> · <a onclick="vtFsClose(\''+e+'\')">Close</a>';
  let h;
  if(!r){
    h='<div class="vt-fs-head"><span class="vt-spin"></span> <strong>'+name+'</strong> starting…<span class="sp"></span>'+close+'</div><div class="vt-fs-bar"></div>';
  }else if(r.status==='queued'){
    h='<div class="vt-fs-head"><strong>'+name+'</strong> waiting: another scan is running on the server; this one starts right after it.<span class="sp"></span>'+close+'</div><div class="vt-fs-bar wait"></div>';
  }else if(r.status==='running'){
    const pr=fsProgress(r);
    h='<div class="vt-fs-head"><span class="vt-spin"></span> <strong>'+name+'</strong> '+(r.phase?vtEsc(r.phase):'is scanning the files in <code>'+vtEsc(r.root||'')+'</code>')+' · started '+vtAgo(r.started)+'<span class="sp"></span>'+close+'</div>'
     +(pr?'<div class="vt-fs-prog" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="'+pr.pct+'"><div style="width:'+pr.pct+'%"></div></div>'
          +'<div class="vt-fs-note"><strong>'+pr.pct+'%</strong>'+(pr.files?' · '+pr.files:'')+(pr.left?' · '+pr.left:'')+'</div>'
        :'<div class="vt-fs-bar"></div>')
     +'<div class="vt-fs-note">You can leave this page; the scan keeps running.</div>';
  }else if(r.status==='done'){
    const inst=scanners.find(x=>x.id===id)?.instant;
    const again='<a onclick="vtFsScan(\''+e+'\',\''+id+'\')">'+(inst?'Refresh':'Scan again')+'</a>';
    h='<div class="vt-fs-head"><strong>'+name+'</strong>'
     +(r.infected?'<span class="bad">'+r.infected+' infected file'+(r.infected===1?'':'s')+'</span>':'<span class="good">no infected files</span>')
     +'<span>in '+(r.files||0).toLocaleString()+' files · '+vtAgo(r.finished)+(r.errors?' · '+r.errors+' file(s) could not be read':'')+'</span>'
     +'<span class="sp"></span>'+again+' · '+close+'</div>';
    const found=full?.found;
    if(r.note) h+='<div class="vt-fs-note">'+vtEsc(r.note)+'</div>';
    if((r.infected||r.listed)&&!found) h+='<div class="vt-fs-note"><span class="vt-spin"></span> Loading the file list…</div>';
    if(found&&found.length){
      const act=fileact.admin;
      h+=faBulkHTML(domain,id,found)
        +'<table class="vt-fs-tbl"><thead><tr><th>File (in <code>'+vtEsc(r.root||'')+'</code>)</th><th>Signature</th>'+(act?'<th>Action</th>':'')+'</tr></thead><tbody>'
        +found.map((f,i)=>'<tr'+(f.handled||f.action||(act&&faHandledOf(domain,f.file))?' class="handled"':'')+'><td>'+vtEsc(f.file)+'</td><td class="vt-fa-sig">'+vtEsc(f.signature)+'</td>'
          +(act?'<td class="vt-fa-cell">'+(f.handled?'':faCellHTML(domain,id,i,f))+'</td></tr>'+faPanelHTML(domain,id,i,f):'</tr>')).join('')+'</tbody></table>';
      if((r.listed||r.infected)>found.length) h+='<div class="vt-fs-note">Showing the first '+found.length+' of '+(r.listed||r.infected)+'.</div>';
      h+='<div class="vt-fs-note">'+(act
          ?'<strong>Clean</strong> lets Imunify remove the malicious code; it keeps the original, so <strong>Undo</strong> puts it back. '
           +'<strong>Quarantine</strong> moves the file to a folder only root can open; <strong>Restore</strong> puts it back. Nothing happens without your click. '
           +'Check each file first, check the site afterwards, then scan again. '
          :(inst?'':'Nothing was changed or removed. ')+'Check each file, clean or delete it (or restore a backup), then scan again. ')
        +'Signatures starting with <code>PUA.</code> or <code>Heuristics.</code> are often false alarms.</div>';
    }
    h+=faHandledHTML(domain);
  }else{
    h='<div class="vt-fs-head"><strong>'+name+'</strong><span class="bad">'+vtEsc(r.message||r.status)+'</span><span class="sp"></span>'
     +'<a onclick="vtFsScan(\''+e+'\',\''+id+'\')">Try again</a> · '+close+'</div>';
  }
  return '<tr class="vt-fs-row" id="vtfs-'+rid(domain)+'" data-domain="'+vtEsc(domain)+'" data-status="'+st+'"'+(inQueue(domain)?' data-job="1"':'')+'><td colspan="5"><div class="vt-fs">'+fsToolsHTML(domain)+h+'</div></td></tr>';
}
/** Progress of a running file scan: {pct, files, left} or null when the scanner does not report it */
function fsProgress(r){
  const total=+r.total||0, done=Math.min(+r.done||0,total);
  if(!total) return null;
  const pct=Math.min(99,Math.floor(done/total*100));
  const imu=String(r.phase||'').startsWith('Imunify');   // Imunify reports a percentage, not files
  const files=imu?'':done.toLocaleString()+' of '+total.toLocaleString()+' files';
  // Time left from the speed so far, once there is enough to go on
  const el=Date.now()/1000-(+r.started||0);
  let left='';
  if(done>0&&el>=6&&done/total>=0.03){
    const s=Math.max(0,Math.round((total-done)*el/done));
    left=s<60?'less than a minute left':s<5400?'about '+Math.round(s/60)+' min left':'about '+(s/3600).toFixed(1)+' h left';
  }
  return {pct,files,left};
}
function vtFsRefresh(domain){updateRow(domain,results[domain]||null);}
window.vtFsRefresh=vtFsRefresh;
window.vtFsClose=function(domain){delete fsOpen[domain];vtFsRefresh(domain);};
window.vtFsClick=function(domain,id){
  if(fsOpen[domain]===id){vtWhyClick(domain);return;}  // click again: back to the details
  fsOpen[domain]=id; vtFaLoad(domain);
  const r=fsGet(domain,id);
  if(!r) return vtFsScan(domain,id);                   // never scanned: start
  vtFsRefresh(domain);
  if(fsBusy(domain,id)) vtFsPoll(domain,id);
  else if(r.status==='done'&&(r.infected||r.listed)) vtFsLoad(domain,id);
};
async function vtFsLoad(domain,id){
  const r=await vtFetch('?action=file-result&scanner='+id+'&domain='+encodeURIComponent(domain)).catch(()=>null);
  if(!r?.result) return;
  (scans[domain]=scans[domain]||{})[id]=r.result; fsFull[domain+'|'+id]=r.result; vtFsRefresh(domain);
}
window.vtFsScan=async function(domain,id){
  fsOpen[domain]=id; delete fsFull[domain+'|'+id];
  (scans[domain]=scans[domain]||{})[id]={status:'running',started:Date.now()/1000};
  addFsJob(domain,id);
  vtFsRefresh(domain);
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  const res=await fetch(BASE+'?action=file-scan',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},body:new URLSearchParams({domain,scanner:id})})
    .then(r=>r.json()).catch(()=>({error:'Network error'}));
  if(res.error){
    vtToast(res.error,'error');
    updateFsJob(domain,id,'failed',null,res.error);
    if(res.result&&!['running','queued'].includes(res.result.status)) scans[domain][id]=res.result; else delete scans[domain][id];
    vtFsRefresh(domain); return;
  }
  if(res.result){
    scans[domain][id]=res.result;
    if(res.result.status==='queued') updateFsJob(domain,id,'queued',null,'');
  }
  vtFsRefresh(domain); vtFsPoll(domain,id);
};
const fsPolling=new Set();
async function vtFsPoll(domain,id){
  const key=domain+'|'+id;
  if(fsPolling.has(key)) return;
  fsPolling.add(key);
  try{
    for(;;){
      await delay(scans[domain]?.[id]?.status==='running'?3000:5000);
      const r=await vtFetch('?action=file-result&scanner='+id+'&domain='+encodeURIComponent(domain)).catch(()=>null);
      if(!r?.result) continue;
      const prev=scans[domain]?.[id]?.status, prevDone=scans[domain]?.[id]?.done;
      (scans[domain]=scans[domain]||{})[id]=r.result;
      if(r.result.status==='running') updateFsJob(domain,id,'running',null,'',r.result);
      else if(r.result.status==='queued') updateFsJob(domain,id,'queued',null,'',null);
      else if(r.result.status==='done') updateFsJob(domain,id,'done',r.result,'',null);
      else updateFsJob(domain,id,'failed',null,r.result.message||r.result.status||'Error',null);
      if(['running','queued'].includes(r.result.status)){ if(prev!==r.result.status||prevDone!==r.result.done) vtFsRefresh(domain); continue; }
      fsFull[key]=r.result; vtFsRefresh(domain);
      if(fsOpen[domain]!==id){ // panel closed meanwhile: tell the user
        if(r.result.status==='done') vtToast(fsName(id)+' '+domain+': '+(r.result.infected?r.result.infected+' infected file(s) found':'no infected files'),r.result.infected?'error':'success');
        else vtToast(fsName(id)+' '+domain+': '+(r.result.message||r.result.status),'error');
      }
      break;
    }
  }finally{fsPolling.delete(key);}
}

function vtFetch(url){
  return fetch(BASE+url).then(r=>{
    // Plesk redirects to its login page when the session expires
    if(r.redirected&&!r.url.startsWith(location.origin+BASE)){
      vtToast('Session expired — reloading...','info');
      setTimeout(()=>window.location.reload(),1200);
      throw new Error('session');
    }
    if(!r.ok)throw new Error(r.status);
    return r.json();
  });
}
function vtSet(id,v){const e=document.getElementById(id);if(e)e.textContent=v;}
function vtEsc(s){return String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]||c));}
function vtEsca(s){return s.replace(/'/g,"\\'");}
function delay(ms){return new Promise(r=>setTimeout(r,ms));}
function vtToast(msg,type){
  const c=document.getElementById('vt-toasts');
  const t=document.createElement('div');
  t.className='vt-toast '+type; t.textContent=msg; c.prepend(t);
  setTimeout(()=>t.remove(),5000);
}

// ── WordPress rogue admin user detection ─────────────────────
let wpUsersData={}; // {domain: 'loading' | {users, error, wp_path} | null}
let wpUsersPwd={}; // {domain+'|'+id: newPassword} — temporary after reset
let wpUsersOpen={}; // {domain: bool} — tracks open/closed state across re-renders
let histOpen={};        // {domain: bool} — history collapsible state
let stepsOpen={};       // {domain: bool} — cleanup steps collapsible state
let fsScanCollOpen={};    // {domain: bool} — file scanner collapsible state
let wpUserAct={};         // {'domain|id': 'loading'|{logins,posts,stream}|{error}} — activity cache
let wpUserActOpen={};     // {'domain|id': bool} — activity row open state

window.vtHistToggle=function(el,domain){histOpen[domain]=el.open;};
window.vtStepsToggle=function(el,domain){stepsOpen[domain]=el.open;};
window.vtFsScanCollToggle=function(el,domain){fsScanCollOpen[domain]=el.open;};
window.vtWpUsersToggle=function(el,domain){
  wpUsersOpen[domain]=el.open;
  if(el.open) vtWpUsersLoad(domain);
};

function vtWpUsersRefresh(domain){
  // Auto-open the collapsible when suspicious users are found (first time only)
  const data=wpUsersData[domain];
  if(data&&data!=='loading'&&!data.error&&wpUsersOpen[domain]===undefined){
    const nSus=(data.users||[]).filter(u=>u.flags?.length).length;
    if(nSus) wpUsersOpen[domain]=true;
  }
  if(fsOpen[domain]==='vt') updateRow(domain,results[domain]||null);
}

window.vtWpUsersLoad=(...a)=>vtWpUsersLoad(...a);
async function vtWpUsersLoad(domain,force){
  if(!scIsAdmin||extSet.has(domain)) return;
  if(!force&&wpUsersData[domain]&&wpUsersData[domain]!=='loading') return;
  wpUsersData[domain]='loading'; vtWpUsersRefresh(domain);
  const r=await vtFetch('?action=wp-users&domain='+encodeURIComponent(domain)).catch(()=>null);
  wpUsersData[domain]=r||{error:'Request failed',users:[]};
  vtWpUsersRefresh(domain);
}

let wpUserDelArm={};       // {'domain|id': timer}: Delete clicked once, waiting for the second click
window.vtWpUserAction=async function(domain,userId,act){
  if(act==='delete'){
    const k=domain+'|'+userId, b=document.querySelector('[data-wu-act="delete-'+userId+'"]');
    if(!wpUserDelArm[k]){
      if(b) b.textContent='Click again to delete';
      wpUserDelArm[k]=setTimeout(()=>{delete wpUserDelArm[k];if(b&&b.isConnected) b.textContent='Delete';},4000);
      return;
    }
    clearTimeout(wpUserDelArm[k]); delete wpUserDelArm[k];
  }
  const fpToken=document.getElementById('forgery_protection_token')?.content||'';
  // Disable both buttons on this row while the request is in flight
  document.querySelectorAll('[data-wu-act^="delete-'+userId+'"],[data-wu-act^="reset-'+userId+'"]')
    .forEach(b=>{b.disabled=true;});
  const btn=document.querySelector('[data-wu-act="'+act+'-'+userId+'"]');
  if(btn) btn.textContent=act==='delete'?'Deleting…':'Resetting…';
  const r=await fetch(BASE+'?action=wp-user-action',{method:'POST',headers:{'X-Forgery-Protection-Token':fpToken},
    body:new URLSearchParams({domain,user_id:userId,act})}).then(x=>x.json()).catch(()=>({error:'Network error'}));
  if(r.error){
    vtToast(r.error,'error');
    document.querySelectorAll('[data-wu-act^="delete-'+userId+'"],[data-wu-act^="reset-'+userId+'"]')
      .forEach(b=>{b.disabled=false;});
    if(btn) btn.textContent=act==='delete'?'Delete':'Reset pwd';
    return;
  }
  if(r.new_password) wpUsersPwd[domain+'|'+userId]=r.new_password;
  if(r.users){ const d=(wpUsersData[domain]=wpUsersData[domain]||{}); d.users=r.users; d.can_delete=!!r.can_delete; }
  vtToast(act==='delete'?'User deleted':'Password reset — copy the new password now','ok');
  vtWpUsersRefresh(domain);
};

window.vtWpUserActToggle=async function(domain,userId){
  const key=domain+'|'+userId;
  wpUserActOpen[key]=!wpUserActOpen[key];
  if(wpUserActOpen[key]&&!wpUserAct[key]){
    wpUserAct[key]='loading';
    vtWpUsersRefresh(domain);
    const r=await vtFetch('?action=wp-user-activity&domain='+encodeURIComponent(domain)+'&user_id='+userId).catch(()=>null);
    wpUserAct[key]=r&&r.ok?r:{error:(r&&r.error)||'Failed to load'};
  }
  vtWpUsersRefresh(domain);
};

function vtWpUserActHTML(domain,userId){
  const key=domain+'|'+userId, d=wpUserAct[key];
  let h='<div style="padding:6px 8px 10px;font-size:12px">';
  if(!d||d==='loading'){return h+'<span class="vt-spin"></span> Loading activity…</div>';}
  if(d.error){return h+'<span style="color:var(--red)">'+vtEsc(d.error)+'</span></div>';}

  // Stream plugin entries (most detailed — covers logins, edits, password changes)
  if(d.stream&&d.stream.length){
    h+='<div style="font-weight:600;margin-bottom:4px">Activity log <span class="hint" style="font-weight:400">(Stream plugin)</span></div>';
    h+=d.stream.map(e=>{
      const dt=new Date(e.ts*1000).toLocaleString();
      const icon=e.action==='login'?'🔑':e.action==='password_reset'||e.action==='updated'&&e.type==='users'?'🔒':e.action==='created'?'➕':e.action==='deleted'?'🗑️':'✏️';
      const label=vtEsc(e.summary||e.action+' '+e.context);
      return '<div class="vt-sh-row"><div class="vt-sh-time">'+vtEsc(dt)+'</div><div class="vt-sh-text">'+icon+' '+label+'</div></div>';
    }).join('');
  } else {
    // Fallback: logins from session tokens
    h+='<div style="font-weight:600;margin-bottom:4px">Recent logins <span class="hint" style="font-weight:400">(active sessions)</span></div>';
    if(!d.logins||!d.logins.length){
      h+='<div class="hint" style="padding:3px 0">No active sessions recorded.</div>';
    } else {
      h+=d.logins.map(l=>{
        const dt=new Date(l.ts*1000).toLocaleString();
        return '<div class="vt-sh-row"><div class="vt-sh-time">'+vtEsc(dt)+'</div><div class="vt-sh-text">🔑 Login'+(l.ip?' <span class="hint">from '+vtEsc(l.ip)+'</span>':'')+'</div></div>';
      }).join('');
    }
  }

  // Posts/pages
  if(d.posts&&d.posts.length){
    h+='<div style="font-weight:600;margin:8px 0 4px">Recent content activity</div>';
    h+=d.posts.map(p=>{
      const isEdited=p.created!==p.modified;
      const dt=p.modified.substring(0,16).replace('T',' ');
      return '<div class="vt-sh-row"><div class="vt-sh-time">'+vtEsc(dt)+'</div><div class="vt-sh-text">'+(isEdited?'✏️ Edited':'📝 Created')+' <strong>'+vtEsc(p.title||'(no title)')+'</strong> <span class="hint">'+vtEsc(p.type)+' · '+vtEsc(p.status)+'</span></div></div>';
    }).join('');
  } else if(!d.stream||!d.stream.length){
    h+='<div class="hint" style="margin-top:6px">No post or page activity found for this user.</div>';
  }

  h+='</div>';
  return h;
}

// Strong signals (a change in admin rights, a breach, a new account) make an account "to review"; the rest are hints
const WU_HINTS=new Set(['suspicious_name','free_email','foreign_email','aw_cross']);
function wuStrong(f){return f.code.startsWith('aw_')?(f.strong!==false&&f.code!=='aw_cross'):!WU_HINTS.has(f.code);}
function wuSuspect(u){return (u.flags||[]).some(wuStrong);}
function wuPillCls(f){
  if(f.code==='hibp_breach') return 'bad';
  if(f.code.startsWith('aw_')) return f.strong===false?(f.approved?'info':'hintpill'):'bad';
  return f.code==='new_account'?'warn':'hintpill';
}
function vtWpUsersHTML(domain){
  if(!scIsAdmin||extSet.has(domain)) return '';
  const data=wpUsersData[domain];
  const e=vtEsca(domain);
  const isOpen=!!wpUsersOpen[domain];

  // Build the summary label
  let tail='';
  if(data==='loading') tail=' <span class="vt-spin" style="margin-left:4px"></span>';
  else if(data&&!data.error){
    const users=data.users||[];
    const nSus=users.filter(wuSuspect).length;
    if(nSus) tail=' · <span style="color:var(--red);font-weight:700">'+nSus+' to review</span>';
    else if(users.length) tail=' <span class="hint">· '+users.length+' admin'+(users.length===1?'':'s')+', no flags</span>';
    else tail=' <span class="hint">· no WP install</span>';
  }else if(data&&data.error) tail=' <span style="color:var(--red);font-size:11px">· error</span>';

  let inner='';
  if(!data){
    inner='<div class="vt-fs-note hint" style="padding:6px 0">Opens on first click.</div>';
  }else if(data==='loading'){
    inner='<div class="vt-fs-note"><span class="vt-spin"></span> Checking admin accounts…</div>';
  }else if(data.error){
    inner='<div class="vt-fs-note"><span style="color:var(--red)">'+vtEsc(data.error)+'</span>'+(data.disabled?'':' · <a onclick="vtWpUsersLoad(\''+e+'\',true)">Retry</a>')+'</div>';
  }else{
    const users=data.users||[];
    if(!users.length){
      inner+='<div class="vt-fs-note">No WordPress admin accounts found.</div>';
    }else{
      const nSus=users.filter(wuSuspect).length;
      if(nSus) inner+='<div class="vt-fs-note" style="color:var(--red);font-weight:600">'+nSus+' account'+(nSus===1?'':'s')+' to review — hover a badge for the reason. Red = a change or a breach; grey = only a hint.</div>';
      inner+='<table class="vt-wu-tbl"><thead><tr><th>Username</th><th>Email</th><th>Since</th><th>Flags <span class="hint" style="text-transform:none;font-weight:400">(hover for detail)</span></th><th style="text-align:right">Actions</th></tr></thead><tbody>';
      const shieldSVG='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-6px;margin-right:4px"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>';
      const canDelete=!!(wpUsersData[domain]&&wpUsersData[domain].can_delete);
      for(const u of users){
        const flags=u.flags||[];
        const isSus=wuSuspect(u);
        const hasBreach=flags.some(f=>f.code==='hibp_breach');
        const pwd=wpUsersPwd[domain+'|'+u.id];
        const w=u.watch||{};
        const sinceTxt=w.since?'admin since '+new Date(w.since*1000).toLocaleDateString():w.baseline?'admin since before '+new Date(w.baseline*1000).toLocaleDateString()+' (first scan)':'';
        const flagsHTML=(flags.length
          ? flags.map(f=>'<span class="vt-wu-pill '+wuPillCls(f)+'" title="'+vtEsc(f.detail)+'">'+(f.code==='hibp_breach'?shieldSVG:'')+vtEsc(f.label)+'</span>'
              +(f.event&&f.strong?' <a class="vt-wu-approve" onclick="vtAwApprove(\''+vtEsca(f.event)+'\')" title="You or the site owner made this change">Approve</a>':'')).join('')
          : '<span style="color:var(--green);font-size:11px">✓ clean</span>')
          +(w.trusted?' <span class="vt-wu-pill hintpill" title="This address is on the Trusted admin addresses list in Settings">trusted</span>':'')
          +(sinceTxt?'<div class="hint" style="font-size:11px;margin-top:2px">'+vtEsc(sinceTxt)+(w.via&&w.via!=='role administrator'?' · '+vtEsc(w.via):'')+'</div>':'');
        const otherAdmin=users.find(x=>x.id!==u.id);
        const delTitle=otherAdmin?'Posts and pages are reassigned to '+otherAdmin.login:'No other admin — posts will be unassigned. Consider resetting the password instead.';
        const actKey=domain+'|'+u.id, actIsOpen=!!wpUserActOpen[actKey];
        const actHTML='<div class="vt-wu-actions">'
          +'<button type="button" class="vt-btn ghost" style="font-size:11px;padding:2px 8px" title="Show login and content activity for this user" onclick="vtWpUserActToggle(\''+e+'\','+u.id+')">'+(actIsOpen?'▼':'▶')+' Log</button>'
          +(canDelete?'<button type="button" class="vt-btn danger" style="font-size:11px;padding:2px 8px" title="'+vtEsc(delTitle)+' Click twice to confirm." data-wu-act="delete-'+u.id+'" onclick="vtWpUserAction(\''+e+'\','+u.id+',\'delete\')">Delete</button>':'')
          +(hasBreach&&u.email
            ?'<button type="button" class="vt-btn danger" style="font-size:11px;padding:2px 8px" title="Pwned address: warn this administrator by e-mail, or reset the password in an emergency (opens the Fix panel)" onclick="vtWpFix(\''+vtEsca(u.email)+'\')">🛠 Fix</button>'
            :'<button type="button" class="vt-btn ghost" style="font-size:11px;padding:2px 8px" title="Generates a strong random password — copy it immediately" data-wu-act="reset-'+u.id+'" onclick="vtWpUserAction(\''+e+'\','+u.id+',\'reset\')">Reset pwd</button>')
          +'</div>';
        const login=vtEsc(u.login)+(u.display&&u.display!==u.login?' <span class="hint">'+vtEsc(u.display)+'</span>':'');
        const regDate=u.registered?u.registered.substring(0,10):'—';
        inner+='<tr'+(isSus?' style="background:rgba(239,68,68,.04)"':'')+'>'
          +'<td><strong>'+(hasBreach?'<span style="color:#dc2626;vertical-align:middle">'+shieldSVG+'</span> ':'')+login+'</strong></td>'
          +'<td style="color:'+(hasBreach?'#dc2626':'var(--muted)')+'">'+vtEsc(u.email)+'</td>'
          +'<td>'+vtEsc(regDate)+'</td>'
          +'<td class="wrap">'+flagsHTML+'</td>'
          +'<td>'+actHTML+'</td>'
          +'</tr>';
        if(actIsOpen) inner+='<tr><td colspan="5" style="padding:0;border-bottom:1px solid var(--border)">'+vtWpUserActHTML(domain,u.id)+'</td></tr>';
        if(pwd) inner+='<tr><td colspan="5"><div class="vt-wu-new-pass">New password: <strong>'+vtEsc(pwd)+'</strong> — copy now, shown only once.</div></td></tr>';
      }
      inner+='</tbody></table>';
      inner+='<div class="vt-fs-note" style="margin-top:6px">Hover a badge for the full reason. <strong>Red</strong> badges are strong signals: admin rights that appeared or changed since the scan before, or a breached address. '
        +'<strong>Grey</strong> badges are only hints (a generic name, a free or unrelated e-mail domain): many real admins have them. '+(canDelete?'Hover <strong>Delete</strong> to see where posts are reassigned. ':'The <strong>Delete</strong> button can be switched on in Settings → WordPress admin accounts. ')
        +'<strong>🛠 Fix</strong> (pwned address) warns the administrator or resets the password in an emergency; <strong>Reset pwd</strong> generates a strong random password — copy it immediately.</div>';
    }
  }
  return '<details class="vt-wu-collapsible"'+(isOpen?' open':'')+' ontoggle="vtWpUsersToggle(this,\''+e+'\')">'
    +'<summary>WordPress admin accounts'+tail+' <a onclick="event.stopPropagation();vtWpUsersLoad(\''+e+'\',true)" title="Reload" style="margin-left:auto;font-weight:400;font-size:11px;color:var(--blue)">↺</a></summary>'
    +inner
    +'</details>';
}


// ── Admin changes: admin rights compared with the last scan, see VtAdminWatch ──
let aw=null, awSearch='', awFilter='all', awExplain={};
async function vtAwLoad(){
  const r=await vtFetch('?action=admin-watch').catch(()=>null);
  if(!r||r.error) return;
  aw=r; vtAwRender();
}
function awTime(ts){return ts?new Date(ts*1000).toLocaleString([],{day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'}):'—';}
function awEventHTML(ev,grouped){
  const id=vtEsca(ev.id),open=ev.approved?'':' open';
  const ex=awExplain[ev.id];
  let h='<div class="vt-aw-ev'+open+(ev.type==='removed'?' info':'')+'">'
    +'<div class="vt-aw-head"><strong>'+vtEsc(ev.label)+'</strong>'
    +(grouped?'':' on <a onclick="vtAwSite(\''+vtEsca(ev.host)+'\')">'+vtEsc(ev.host)+'</a>')
    +(ev.cms&&ev.cms!=='WordPress'?' <span class="vt-pw-cms">'+vtEsc(ev.cms)+'</span>':'')
    +'<span class="vt-aw-when">'+awTime(ev.from)+'&ndash;'+awTime(ev.to)+'</span></div>'
    +'<div class="vt-aw-body">'
    +(ev.login?'Account <strong>'+vtEsc(ev.login)+'</strong> &lt;'+vtEsc(ev.email)+'&gt;':'')
    +(ev.detail?(ev.login?' · ':'')+vtEsc(ev.detail):'')
    +(ev.prev?' · <span class="hint">before: '+vtEsc(ev.prev)+'</span>':'')
    +(ev.registered&&ev.type==='promoted'?' · <span class="hint">account created '+awTime(ev.registered)+'</span>':'')
    +'</div><div class="vt-aw-act">'
    +(ev.approved?'<span class="vt-aw-ok">✓ approved'+(ev.approved.by==='trusted list'?' (trusted address)':' by '+vtEsc(ev.approved.by))+' '+awTime(ev.approved.at)+'</span>'
      :(ev.type!=='removed'?'<button type="button" class="vt-btn" onclick="vtAwApprove(\''+id+'\')" title="You or the site owner made this change">Approve</button>':''))
    +' <button type="button" class="vt-btn ghost" onclick="vtAwExplain(\''+id+'\')">'+(ex?'Hide explanation':'Explain')+'</button>'
    +'</div>';
  if(ex) h+='<div class="vt-aw-explain">'+awExplainHTML(ex,ev)+'</div>';
  return h+'</div>';
}
function awExplainHTML(x,ev){
  if(x==='loading') return '<span class="vt-spin"></span> Reading the access logs and the audit log…';
  if(x.error) return '<span style="color:var(--red)">'+vtEsc(x.error)+'</span>';
  const t=ts=>new Date(ts*1000).toLocaleString();
  let h='<div class="hint">Everything between '+t(x.from-300)+' and '+t(x.to+60)+' (the change happened in this period).</div>';
  h+='<div class="vt-aw-sub">Requests that can change accounts <span class="hint">(access logs of '+vtEsc(ev.host)+')</span></div>';
  if(x.log_error) h+='<div class="hint">'+vtEsc(x.log_error)+'</div>';
  else if(!x.log.length) h+='<div class="hint">None found. The change may have been made directly in the database, through FTP/SSH (a script), or the logs of that period are already rotated.</div>';
  else h+='<table class="vt-fs-tbl vt-aw-tbl"><thead><tr><th>Time</th><th>IP address</th><th>Request</th><th>Status</th></tr></thead><tbody>'
    +x.log.map(l=>'<tr><td>'+vtEsc(t(l.t))+'</td><td>'+vtEsc(l.ip)+'</td><td title="'+vtEsc(l.ua)+'">'+vtEsc(l.req)+'</td><td>'+l.status+'</td></tr>').join('')+'</tbody></table>';
  if(!String(ev.key||'').startsWith('cms:')){
    h+='<div class="vt-aw-sub">WordPress audit log <span class="hint">(Stream plugin)</span></div>';
    h+=x.stream_missing?'<div class="hint">The Stream plugin is not installed on this site. With it, WordPress itself records who changed which account.</div>'
      :!x.stream.length?'<div class="hint">No user changes recorded in this period.</div>'
      :x.stream.map(s=>'<div class="vt-sh-row"><div class="vt-sh-time">'+vtEsc(t(s.t))+'</div><div class="vt-sh-text">'+vtEsc(s.summary||s.action)+(s.ip?' <span class="hint">from '+vtEsc(s.ip)+'</span>':'')+'</div></div>').join('');
    if(ev.uid){
      h+='<div class="vt-aw-sub">Logins of this account <span class="hint">(sessions that are still stored)</span></div>';
      h+=!x.logins.length?'<div class="hint">No stored sessions.</div>'
        :x.logins.slice(0,8).map(s=>'<div class="vt-sh-row"><div class="vt-sh-time">'+vtEsc(t(s.t))+'</div><div class="vt-sh-text">🔑 Login'+(s.ip?' from '+vtEsc(s.ip):'')+(s.ua?' <span class="hint">'+vtEsc(s.ua)+'</span>':'')+'</div></div>').join('');
    }
  }
  return h;
}
// The search box is drawn again on every keystroke: keep the cursor in it
window.vtAwSetSearch=function(v){
  awSearch=v; vtAwRender();
  const i=document.querySelector('#vt-aw-box .vt-aw-search'); if(i){i.focus(); i.setSelectionRange(v.length,v.length);}
};
window.vtAwSetFilter=function(v){awFilter=v; vtAwRender();};
function vtAwRender(){
  const box=document.getElementById('vt-aw-box');
  if(!aw){
    if(box) box.style.display='none';
    const al=document.getElementById('vt-aw-alert'); if(al) al.style.display='none';
    const ab=document.getElementById('vttb-adminwatch'); if(ab) ab.style.display='none';
    const anb=document.getElementById('vtnb-adminwatch'); if(anb) anb.style.display='none';
    document.getElementById('vtcard-adminwatch')?.classList.remove('alert');
    vtToolsBadge(); return;
  }
  const evs=aw.events||[], open=evs.filter(e=>!e.approved&&e.type!=='removed'), cross=Object.entries(aw.cross||{});
  // Dashboard alert and tool card badge
  const alertEl=document.getElementById('vt-aw-alert'),alertTxt=document.getElementById('vt-aw-alert-text');
  if(alertEl&&alertTxt){
    if(open.length){alertTxt.textContent=open.length+' admin change'+(open.length===1?'':'s')+' to review';alertEl.style.display='flex';}
    else alertEl.style.display='none';
  }
  const awBadge=document.getElementById('vttb-adminwatch'),awCard=document.getElementById('vtcard-adminwatch');
  const awNavBadge=document.getElementById('vtnb-adminwatch');
  if(awBadge){awBadge.textContent=open.length;awBadge.style.display=open.length?'':'none';}
  if(awNavBadge){awNavBadge.textContent=open.length;awNavBadge.style.display=open.length?'':'none';}
  if(awCard) awCard.classList.toggle('alert',open.length>0);
  vtToolsBadge();
  if(!evs.length&&!cross.length){if(box) box.style.display='none';return;}
  box.style.display='';
  // Apply search + status filters
  const q=(awSearch||'').toLowerCase().trim();
  let shown=q?evs.filter(e=>(e.host||'').toLowerCase().includes(q)||(e.login||'').toLowerCase().includes(q)||(e.email||'').toLowerCase().includes(q)||(e.detail||'').toLowerCase().includes(q)):evs;
  if(awFilter==='pending') shown=shown.filter(e=>!e.approved&&e.type!=='removed');
  else if(awFilter==='approved') shown=shown.filter(e=>e.approved||e.type==='removed');
  // Group by domain, domains with pending changes first
  const groups={};
  shown.forEach(e=>{if(!groups[e.host])groups[e.host]={host:e.host,evs:[]};groups[e.host].evs.push(e);});
  const sorted=Object.values(groups).sort((a,b)=>
    b.evs.filter(e=>!e.approved&&e.type!=='removed').length-a.evs.filter(e=>!e.approved&&e.type!=='removed').length
  );
  // Toolbar
  let h='<div class="vt-aw-toolbar">'
    +'<input class="vt-aw-search" type="search" placeholder="Search domain, account\u2026" value="'+vtEsc(awSearch)+'" oninput="vtAwSetSearch(this.value)">'
    +'<div style="display:flex;gap:4px">'
    +['all','pending','approved'].map(v=>'<button type="button" class="vt-btn'+(awFilter===v?' active':' ghost')+'" style="font-size:12px;padding:3px 8px" onclick="vtAwSetFilter(\''+v+'\')">'+v.charAt(0).toUpperCase()+v.slice(1)+'</button>').join('')
    +'</div>'
    +(aw.can_scan?'<button type="button" class="vt-btn ghost" onclick="vtAwScan(this)">Scan now</button>':'')
    +'<span class="hint" style="margin-left:auto">Last scan: '+awTime(aw.last)+'</span>'
    +'</div>';
  // Summary line
  if(open.length) h+='<div class="vt-aw-summary"><strong>'+open.length+' change'+(open.length===1?' needs':'s need')+' review</strong> on '
    +[...new Set(open.map(e=>e.host))].length+' site'+([...new Set(open.map(e=>e.host))].length===1?'':'s')
    +'. Approve what you or the site owner did; investigate anything unexpected.</div>';
  else if(evs.length) h+='<div class="vt-aw-summary" style="color:var(--green,#16a34a)">All '+evs.length+' recorded change'+(evs.length===1?'':'s')+' approved \u2014 no pending issues.</div>';
  // Domain groups
  if(sorted.length){
    sorted.forEach(g=>{
      const pend=g.evs.filter(e=>!e.approved&&e.type!=='removed').length;
      h+='<div class="vt-aw-domain-group">'
        +'<div class="vt-aw-domain-header"><a onclick="vtAwSite(\''+vtEsca(g.host)+'\')">'+vtEsc(g.host)+'</a>'
        +(pend?'<span class="vt-aw-domain-pend">'+pend+' to review</span>':'')
        +'</div>'
        +g.evs.map(e=>awEventHTML(e,true)).join('')
        +'</div>';
    });
  } else if(q){
    h+='<div class="hint" style="padding:16px 0">No results for \u201c'+vtEsc(q)+'\u201d.</div>';
  }
  // Cross-site admins (admin only, not filtered)
  if(cross.length&&!q){
    h+='<div class="vt-aw-sub" style="margin-top:16px">Same address, admin on sites of different customers'
      +' <span class="hint">(normal for a web agency or maintainer: add to Trusted admin addresses in Settings)</span></div>'
      +'<table class="vt-fs-tbl vt-aw-tbl vt-aw-cross"><colgroup><col style="width:300px"><col></colgroup><tbody>'
      +cross.map(([em,l])=>'<tr><td><strong>'+vtEsc(em)+'</strong></td><td>'+l.map(x=>vtEsc(x.host)+(x.owner?' <span class="hint">('+vtEsc(x.owner)+')</span>':'')).join(', ')+'</td></tr>').join('')
      +'</tbody></table>';
  }
  box.innerHTML=h;
}
window.vtAwSite=function(host){
  const s=document.getElementById('vt-search'); if(s){s.value=host; s.dispatchEvent(new Event('input'));}
  vtShowTab('dashboard'); document.getElementById('vt-tbody')?.scrollIntoView({behavior:'smooth',block:'start'});
};
window.vtAwApprove=async function(id){
  const r=await vtPostAct('admin-watch-approve',{id});
  if(!r.ok){vtToast(r.error||'Failed','error'); return;}
  vtToast('Change approved','ok'); await vtAwLoad();
  for(const d in wpUsersData) if(wpUsersData[d]&&wpUsersData[d]!=='loading') vtWpUsersLoad(d,true);
};
window.vtAwExplain=async function(id){
  if(awExplain[id]){delete awExplain[id]; vtAwRender(); return;}
  awExplain[id]='loading'; vtAwRender();
  const r=await vtFetch('?action=admin-watch-explain&id='+encodeURIComponent(id)).catch(()=>({error:'Request failed'}));
  awExplain[id]=r; vtAwRender();
};
window.vtAwScan=async function(btn){
  btn.disabled=true; btn.textContent='Scanning…';
  const r=await vtPostAct('admin-watch-scan',{});
  vtToast(r.ok?(r.new?r.new+' change'+(r.new===1?'':'s')+' found':'No changes since the last scan'):(r.error||'Failed'),r.ok?'info':'error');
  await vtAwLoad();
};
// Fix a pwned admin address from a site's admin list: the same panel as in Pwned Admins
window.vtWpFix=async function(email){
  vtShowTab('tools'); vtToolSelect('pwned');
  vtPwFixOpen(email);
};

init().then(()=>vtCheckUpdate());
})();
</script>
