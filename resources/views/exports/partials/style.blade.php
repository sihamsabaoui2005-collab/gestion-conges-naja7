<style>
  :root{ --o1:#FF7A1A; --o4:#E85D04; --o5:#C2440C; --ink:#111; --line:#e6e2dc; }
  .report-doc{color:var(--ink); font-family:'Segoe UI',Helvetica,Arial,sans-serif; font-size:12px; line-height:1.5;}
  .report-doc *{box-sizing:border-box;}
  .report-doc .sheet{background:#fff; padding:14mm 4mm; page-break-after:always; margin:0 auto 18px; max-width:210mm; border-radius:4px; box-shadow:0 4px 18px rgba(0,0,0,.25);}
  .report-doc .sheet:last-child{page-break-after:auto; margin-bottom:0;}
  .report-doc .pagefoot{margin-top:24px; display:table; width:100%; font-size:9.5px; color:#999; border-top:1px solid var(--line); padding-top:8px;}
  .report-doc .pagefoot .l{display:table-cell;} .report-doc .pagefoot .r{display:table-cell; text-align:right;}
  .report-doc .logo-mark{width:40px; height:40px; border-radius:9px; display:inline-block; vertical-align:middle; object-fit:contain;}
  .report-doc .logo-word{display:inline-block; vertical-align:middle; margin-left:8px;}
  .report-doc .logo-word b{font-size:15px; display:block;}
  .report-doc .logo-word span{font-size:9px; text-transform:uppercase; letter-spacing:.12em; color:#777;}

  .report-doc .cover-topbar{height:6px; background:linear-gradient(90deg,var(--o1),var(--o5)); border-radius:3px; margin-bottom:36px;}
  .report-doc .cover-eyebrow{margin-top:60px; text-transform:uppercase; letter-spacing:.16em; font-size:11px; color:var(--o4); font-weight:700;}
  .report-doc .cover h1{font-size:32px; margin:8px 0 6px;}
  .report-doc .cover .subtitle{font-size:13.5px; color:#555; max-width:420px;}
  .report-doc .cover-infobox{margin-top:60px; border-top:2px solid var(--ink); padding-top:12px; font-size:11px; color:#444; display:table; width:100%;}
  .report-doc .cover-infobox .cell{display:table-cell; width:25%;}
  .report-doc .cover-infobox strong{color:var(--ink); display:block; font-size:12px; margin-bottom:2px;}

  .report-doc .titlepage{text-align:center; padding-top:90px;}
  .report-doc .titlepage h1{font-size:21px; margin:16px 0 4px;}
  .report-doc .titlepage .subtitle{font-size:12.5px; color:#666;}
  .report-doc .titlepage .credit{margin-top:50px; border-top:1px solid var(--line); padding-top:18px; font-size:12px; color:#333; display:inline-block; text-align:left;}
  .report-doc .titlepage .credit .lbl{text-transform:uppercase; letter-spacing:.1em; font-size:9px; color:#999;}
  .report-doc .titlepage .credit .val{font-size:13px; font-weight:600; margin-bottom:10px;}

  .report-doc h2.section-title{font-size:14.5px; text-transform:uppercase; letter-spacing:.05em; border-left:4px solid var(--o1); padding-left:9px; margin:0 0 15px;}
  .report-doc .pageheader{display:table; width:100%; border-bottom:1px solid var(--line); padding-bottom:8px; margin-bottom:20px; font-size:10px; color:#888; text-transform:uppercase; letter-spacing:.05em;}
  .report-doc .pageheader .l{display:table-cell;} .report-doc .pageheader .r{display:table-cell; text-align:right;}

  .report-doc .kpi-table{width:100%; border-collapse:separate; border-spacing:6px 0; margin-bottom:18px;}
  .report-doc .kpi-table td{border:1px solid var(--line); border-top:3px solid var(--o1); padding:12px; border-radius:5px; width:25%; text-align:center;}
  .report-doc .kpi-num{font-size:22px; font-weight:800; color:var(--o5); display:block;}
  .report-doc .kpi-lbl{font-size:10.5px; color:#555; margin-top:3px;}

  .report-doc table.data{width:100%; border-collapse:collapse; font-size:11px;}
  .report-doc table.data th, .report-doc table.data td{text-align:left; padding:7px 8px; border-bottom:1px solid var(--line);}
  .report-doc table.data th{background:#fbf7f2; font-size:9.5px; text-transform:uppercase; letter-spacing:.03em; color:#555;}
  .report-doc table.data td.num, .report-doc table.data th.num{text-align:right;}
  .report-doc .tag{display:inline-block; width:9px; height:9px; border-radius:2px; margin-right:5px;}
  .report-doc .medal{font-weight:700; color:var(--o4);}

  .report-doc .chart-box{border:1px solid var(--line); border-radius:7px; padding:14px; margin-bottom:16px;}
  .report-doc .chart-box h3{font-size:11.5px; margin:0 0 8px;}
  .report-doc .segbar{display:table; width:100%; height:16px; border-radius:8px; overflow:hidden; margin-bottom:8px;}
  .report-doc .segbar .seg{display:table-cell;}
  .report-doc .legend-item{display:table; width:100%; font-size:10.5px; padding:2px 0;}
  .report-doc .legend-item .l{display:table-cell;} .report-doc .legend-item .v{display:table-cell; text-align:right; color:#666;}
  .report-doc .legend-dot{display:inline-block; width:8px; height:8px; border-radius:2px; margin-right:6px;}
  .report-doc .caption{font-size:10.5px; color:#666; margin:6px 0 0;}

  .report-doc .bar-col-table{width:100%; border-collapse:collapse;}
  .report-doc .bar-col-table td{text-align:center; vertical-align:bottom; height:90px; width:16%;}
  .report-doc .bar-fill-col{background:var(--o1); border-radius:3px 3px 0 0; margin:0 auto;}
  .report-doc .bar-col-lbl{font-size:9px; color:#666; margin-top:4px;}

  .report-doc .bar-row{margin-bottom:7px;}
  .report-doc .bar-label{font-size:10px; color:#333; display:table; width:100%;}
  .report-doc .bar-label .l{display:table-cell;} .report-doc .bar-label .v{display:table-cell; text-align:right;}
  .report-doc .bar-track{background:#eee; border-radius:3px; height:9px;}
  .report-doc .bar-fill{background:var(--o4); height:9px; border-radius:3px;}

  .report-doc .two-col{display:table; width:100%;}
  .report-doc .two-col .col{display:table-cell; width:50%; vertical-align:top; padding-right:10px;}
  .report-doc .insight-list{list-style:none; margin:0; padding:0;}
  .report-doc .insight-list li{padding:9px 0; border-bottom:1px solid var(--line); font-size:12px;}
  .report-doc .reco{background:#fff8f1; border:1px solid #ffdcb3; border-left:4px solid var(--o4); padding:12px 14px; border-radius:5px; font-size:12px; margin-bottom:12px;}
  .report-doc .reco strong{display:block; margin-bottom:4px; color:var(--o5); text-transform:uppercase; font-size:10px; letter-spacing:.04em;}

  .report-doc .toc-list{list-style:none; margin:0; padding:0;}
  .report-doc .toc-list li{display:table; width:100%; padding:9px 0; border-bottom:1px dotted var(--line); font-size:12.5px;}
  .report-doc .toc-list .txt{display:table-cell;} .report-doc .toc-list .pg{display:table-cell; text-align:right; color:#999; font-size:11px;}
  .report-doc .toc-list .num{color:var(--o4); font-weight:700; margin-right:8px;}
  .report-doc .callout{background:#fff8f1; border:1px solid #ffdcb3; border-left:4px solid var(--o4); padding:11px 13px; border-radius:5px; font-size:11.5px; margin-bottom:12px;}
  .report-doc .callout strong{display:block; text-transform:uppercase; font-size:9.5px; letter-spacing:.05em; color:var(--o5); margin-bottom:4px;}
  .report-doc .glossary dt{font-weight:700; font-size:12px; margin-top:9px;}
  .report-doc .glossary dd{margin:2px 0 0; font-size:11.5px; color:#444;}

  .report-doc p.body-text{font-size:12px; margin:0 0 10px; color:#222;}
  .report-doc ul.body-list{margin:0 0 10px; padding-left:16px; font-size:12px;}
  .report-doc ul.body-list li{margin-bottom:6px;}
</style>