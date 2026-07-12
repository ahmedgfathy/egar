import React, { useEffect, useMemo, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { ArrowDown, ArrowLeft, ArrowUp, Building2, ChevronDown, ChevronLeft, ChevronRight, Columns3, ExternalLink, FileText, Filter, Home, LayoutDashboard, Menu, MoreHorizontal, Pencil, Plus, RefreshCw, Search, SlidersHorizontal, X } from 'lucide-react';
import './product.css';

const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
const moduleIcons = { Products: Building2, Leads: SlidersHorizontal, Contacts: Home, Documents: FileText };

function ProductList() {
  const params = new URLSearchParams(location.search);
  const [filter, setFilter] = useState(Number(params.get('filter')) || 0);
  const [page, setPage] = useState(1);
  const [search, setSearch] = useState('');
  const [debouncedSearch, setDebouncedSearch] = useState('');
  const [selectedAlphabet, setSelectedAlphabet] = useState('');
  const [sortBy, setSortBy] = useState('');
  const [sortOrder, setSortOrder] = useState('ASC');
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(false);
  const [sidebar, setSidebar] = useState(false);
  const [openAction, setOpenAction] = useState(null);

  useEffect(() => { const timer = setTimeout(() => { setPage(1); setDebouncedSearch(search); }, 350); return () => clearTimeout(timer); }, [search]);
  const load = () => {
    setLoading(true); setError(false);
    const query = new URLSearchParams({ module: 'Products', action: 'ReactListData', page, limit: 25, sortOrder });
    if (filter) query.set('filter', filter);
    if (debouncedSearch) query.set('search', debouncedSearch);
    if (selectedAlphabet) query.set('alphabet', selectedAlphabet);
    if (sortBy) query.set('sortBy', sortBy);
    fetch(`index.php?${query}`, { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(r => r.ok ? r.json() : Promise.reject())
      .then(payload => { setData(payload.result); if (!filter) setFilter(payload.result.activeFilter); setLoading(false); })
      .catch(() => { setError(true); setLoading(false); });
  };
  useEffect(load, [filter, page, debouncedSearch, selectedAlphabet, sortBy, sortOrder]);

  const activeName = useMemo(() => data?.filters?.find(item => item.id === data.activeFilter)?.name || 'Properties', [data]);
  const changeSort = name => {
    setPage(1);
    if (sortBy === name) setSortOrder(order => order === 'ASC' ? 'DESC' : 'ASC');
    else { setSortBy(name); setSortOrder('ASC'); }
  };
  const clearFilters = () => { setSearch(''); setSelectedAlphabet(''); setSortBy(''); setSortOrder('ASC'); setPage(1); };

  return <div className="property-app" onClick={() => openAction && setOpenAction(null)}>
    <aside className={`property-sidebar ${sidebar ? 'open' : ''}`}>
      <div className="property-brand"><span><Building2 size={22}/></span><div><strong>EGAR</strong><small>Real Estate CRM</small></div><button onClick={() => setSidebar(false)}><X size={19}/></button></div>
      <nav><small>Workspace</small><a href="index.php?module=Vtiger&view=ReactDashboard"><LayoutDashboard size={18}/>Overview</a>{data?.modules?.map(module => { const Icon = moduleIcons[module.name] || Columns3; return <a className={module.name === 'Products' ? 'active' : ''} href={module.url} key={module.name}><Icon size={18}/>{module.label}</a>; })}</nav>
      <div className="inventory-note"><Columns3 size={18}/><strong>Inventory workspace</strong><p>Saved Vtiger filters, permissions, sorting and paging are applied directly.</p></div>
    </aside>
    {sidebar && <button className="property-scrim" onClick={() => setSidebar(false)}/>}
    <main className="property-main">
      <header className="property-topbar"><button className="mobile-menu" onClick={() => setSidebar(true)}><Menu size={20}/></button><div className="breadcrumbs"><a href="index.php?module=Vtiger&view=ReactDashboard">Workspace</a><span>/</span><strong>Property</strong></div><a className="back-dashboard" href="index.php?module=Vtiger&view=ReactDashboard"><ArrowLeft size={16}/> Dashboard</a></header>
      <div className="property-content">
        <section className="property-heading"><div><span className="heading-label">Real-estate inventory</span><h1>Properties</h1><p>Legacy list behavior preserved in the new React workspace.</p></div>{data?.canCreate && <a className="add-property" href={data.createUrl}><Plus size={18}/>Add property</a>}</section>
        <section className="property-toolbar">
          <div className="filter-select"><Filter size={17}/><select value={filter || ''} onChange={e => { setFilter(Number(e.target.value)); setPage(1); }}>{data?.filters?.map(item => <option key={item.id} value={item.id}>{item.name}</option>)}</select><ChevronDown size={15}/></div>
          <div className="property-search"><Search size={18}/><input value={search} onChange={e => { setSearch(e.target.value); setSelectedAlphabet(''); }} placeholder="Search by property name…"/>{search && <button onClick={() => setSearch('')}><X size={16}/></button>}</div>
          <button className="refresh" onClick={load} title="Refresh"><RefreshCw size={17}/></button>
          {(search || selectedAlphabet || sortBy) && <button className="clear-filters" onClick={clearFilters}>Clear</button>}
          {data && <a className="legacy-link" href={data.legacyUrl}><ExternalLink size={15}/>Compare legacy list</a>}
        </section>
        <section className="alphabet-filter" aria-label="Filter properties by first letter"><button className={!selectedAlphabet ? 'active' : ''} onClick={() => { setSelectedAlphabet(''); setPage(1); }}>All</button>{alphabet.map(letter => <button className={selectedAlphabet === letter ? 'active' : ''} key={letter} onClick={() => { setSelectedAlphabet(letter); setSearch(''); setPage(1); }}>{letter}</button>)}</section>
        <section className="list-card">
          <header><div><h2>{activeName}</h2><p>Page {page} · up to 25 records{sortBy ? ` · sorted ${sortOrder.toLowerCase()}` : ''}</p></div><span className="live-pill"><i/>Live data</span></header>
          <div className="table-scroll">
            <table><thead><tr><th className="record-col">Record</th>{data?.headers?.map(header => <th key={header.name}><button className="sort-header" onClick={() => changeSort(header.name)}>{header.label}{sortBy === header.name && (sortOrder === 'ASC' ? <ArrowUp size={13}/> : <ArrowDown size={13}/>)}</button></th>)}<th className="actions-col">Actions</th></tr></thead>
              <tbody>{loading ? Array.from({length:8}).map((_,i)=><tr className="skeleton-row" key={i}><td colSpan={(data?.headers?.length||4)+2}><span/></td></tr>) : error ? <tr><td className="empty-state" colSpan={(data?.headers?.length||4)+2}>Unable to load Properties. <button onClick={load}>Try again</button></td></tr> : data.rows.length === 0 ? <tr><td className="empty-state" colSpan={data.headers.length+2}><Building2 size={28}/><strong>No properties found</strong><span>Try another saved filter, letter or search.</span></td></tr> : data.rows.map((row,index)=><tr key={row.id}><td className="record-col"><span className="record-index">{String((page-1)*25+index+1).padStart(2,'0')}</span></td>{data.headers.map((header,cellIndex)=><td key={header.name} className={cellIndex===0?'primary-cell':''}>{cellIndex===0?<a href={row.detailUrl}>{row.values[header.name]||'—'}</a>:<span>{row.values[header.name]||'—'}</span>}</td>)}<td className="row-actions"><div className="action-menu"><button title="Actions" onClick={event => { event.stopPropagation(); setOpenAction(openAction === row.id ? null : row.id); }}><MoreHorizontal size={17}/></button>{openAction === row.id && <div onClick={event => event.stopPropagation()}><a href={row.detailUrl}>Open record</a><a href={row.fullDetailUrl}>Complete details</a>{row.canEdit && <a href={row.editUrl}><Pencil size={14}/>Edit</a>}</div>}</div></td></tr>)}</tbody>
            </table>
          </div>
          <footer><span>{loading?'Loading records…':`${data?.rows?.length||0} records on this page`}</span><div><button disabled={!data?.hasPrevious||loading} onClick={()=>setPage(p=>Math.max(1,p-1))}><ChevronLeft size={17}/>Previous</button><b>{page}</b><button disabled={!data?.hasNext||loading} onClick={()=>setPage(p=>p+1)}>Next<ChevronRight size={17}/></button></div></footer>
        </section>
      </div>
    </main>
  </div>;
}
createRoot(document.getElementById('egar-react-product')).render(<ProductList/>);
