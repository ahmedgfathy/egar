import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { ArrowLeft, Building2, ChevronLeft, ChevronRight, Command, Eye, LayoutDashboard, Menu, Pencil, Rows3, Users, X } from 'lucide-react';
import './product-detail.css';

const icons = { Products: Building2, Leads: Users };
const buildStats = blocks => {
  const fields = blocks.flatMap(block => block.fields);
  const filled = fields.filter(field => field.value && field.value !== '—');
  return [
    { label: 'Sections', value: blocks.length },
    { label: 'Visible fields', value: fields.length },
    { label: 'Completed', value: filled.length }
  ];
};

function LeadDetail() {
  const mount = document.getElementById('egar-react-lead-detail');
  const record = Number(mount.dataset.record);
  const [data, setData] = useState(null);
  const [error, setError] = useState(false);
  const [sidebar, setSidebar] = useState(false);

  useEffect(() => {
    fetch(`index.php?module=Leads&action=ReactDetailData&record=${record}`, { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(response => response.ok ? response.json() : Promise.reject())
      .then(payload => payload.success === false ? Promise.reject() : setData(payload.result))
      .catch(() => setError(true));
  }, [record]);

  if (error) return <div className="detail-state"><h1>Lead unavailable</h1><p>The record could not be loaded or you do not have access.</p><a href="index.php?module=Leads&view=ReactList">Return to Leads</a></div>;
  if (!data) return <div className="detail-state loading"><span/><p>Loading lead details…</p></div>;
  const stats = buildStats(data.blocks);

  return <div className="detail-app">
    <aside className={`detail-sidebar ${sidebar ? 'open' : ''}`}>
      <div className="detail-brand"><span><Users size={22}/></span><div><strong>EGAR</strong><small>Real Estate CRM</small></div><button onClick={() => setSidebar(false)}><X size={19}/></button></div>
      <nav><small>Workspace</small><a href="index.php?module=Vtiger&view=ReactDashboard"><LayoutDashboard size={18}/>Overview</a>{data.modules.map(module => { const Icon = icons[module.name] || Command; return <a className={module.name === 'Leads' ? 'active' : ''} href={module.url} key={module.name}><Icon size={18}/>{module.label}</a>; })}</nav>
    </aside>
    {sidebar && <button className="detail-scrim" onClick={() => setSidebar(false)}/>}
    <main className="detail-main">
      <header className="detail-topbar"><button className="mobile-menu" onClick={() => setSidebar(true)}><Menu size={20}/></button><a className="back-link" href={data.listUrl}><ArrowLeft size={16}/>Leads</a><div className="record-nav"><a className={!data.previousUrl ? 'disabled' : ''} href={data.previousUrl || '#'}><ChevronLeft size={17}/>Previous</a><a className={!data.nextUrl ? 'disabled' : ''} href={data.nextUrl || '#'}>Next<ChevronRight size={17}/></a></div></header>
      <div className="detail-content">
        <section className="detail-hero"><div><span className="eyebrow">Lead record</span><h1>{data.name || 'Untitled lead'}</h1><p>{data.number || `Record #${data.id}`}</p></div><div className="hero-actions">{data.canEdit && <a className="primary" href={data.editUrl}><Pencil size={16}/>Edit lead</a>}{data.legacyDetailUrl && <a className="secondary" href={data.legacyDetailUrl}><Eye size={16}/>Full detail</a>}</div></section>
        <section className="detail-summary">{stats.map(item => <article key={item.label}><Rows3 size={18}/><span>{item.label}</span><strong>{item.value}</strong></article>)}</section>
        <section className="detail-grid">{data.blocks.map(block => <article className="detail-card" key={block.label}><header><h2>{block.label}</h2></header><div className="field-grid">{block.fields.map(field => <div className="field" key={field.name}><span>{field.label}</span><strong>{field.value || '—'}</strong></div>)}</div></article>)}</section>
      </div>
    </main>
  </div>;
}

createRoot(document.getElementById('egar-react-lead-detail')).render(<LeadDetail/>);
