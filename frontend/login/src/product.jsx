import React, { useEffect, useMemo, useState } from 'react';
import { createRoot } from 'react-dom/client';
import {
  ArrowDown, ArrowLeft, ArrowUp, BarChart3, Building2, CalendarDays, ChevronDown,
  ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight, Columns3, FileText, Filter,
  Home, LayoutDashboard, Megaphone, Menu, MoreHorizontal, Pencil, Plus, RefreshCw,
  Search, SlidersHorizontal, Sparkles, TrendingUp, Upload, Download, X
} from 'lucide-react';
import './product.css';
import MaterialIcon from './material-icon.jsx';

const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
const number = new Intl.NumberFormat('en-US');
const moduleIcons = {
  Products: Building2, Leads: SlidersHorizontal, Contacts: Home, Potentials: BarChart3,
  Project: Columns3, Calendar: CalendarDays, Documents: FileText, Reports: TrendingUp,
  Campaigns: Megaphone
};
const filterStorageKey = 'egar.lastFilter.Products';
const getInitialFilter = () => {
  const params = new URLSearchParams(location.search);
  return Number(params.get('filter')) || Number(localStorage.getItem(filterStorageKey)) || 0;
};
const saveFilterPreference = filterId => {
  if (!filterId) return;
  localStorage.setItem(filterStorageKey, String(filterId));
  const body = new URLSearchParams({ module: 'Vtiger', action: 'ReactFilterPreference', source_module: 'Products', filter: String(filterId) });
  if (window.csrfMagicName && window.csrfMagicToken) body.set(window.csrfMagicName, window.csrfMagicToken);
  fetch('index.php', { method: 'POST', credentials: 'same-origin', headers: { Accept: 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' }, body })
    .catch(() => {});
};

function ProductList() {
  const [filter, setFilter] = useState(getInitialFilter);
  const [page, setPage] = useState(1);
  const [limit, setLimit] = useState(25);
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
  const [advanced, setAdvanced] = useState(true);
  const [columnFilters, setColumnFilters] = useState({});

  useEffect(() => {
    const timer = setTimeout(() => { setPage(1); setDebouncedSearch(search); }, 350);
    return () => clearTimeout(timer);
  }, [search]);

  const load = () => {
    setLoading(true);
    setError(false);
    const query = new URLSearchParams({ module: 'Products', action: 'ReactListData', page, limit, sortOrder });
    if (filter) query.set('filter', filter);
    if (debouncedSearch) query.set('search', debouncedSearch);
    if (selectedAlphabet) query.set('alphabet', selectedAlphabet);
    if (sortBy) query.set('sortBy', sortBy);
    fetch(`index.php?${query}`, { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(response => response.ok ? response.json() : Promise.reject())
      .then(payload => {
        if (!payload.result) throw new Error('Invalid response');
        setData(payload.result);
        if (!filter || !payload.result.filters.some(item => item.id === filter)) setFilter(payload.result.activeFilter);
        setLoading(false);
      })
      .catch(() => { setError(true); setLoading(false); });
  };

  useEffect(load, [filter, page, limit, debouncedSearch, selectedAlphabet, sortBy, sortOrder]);

  useEffect(() => {
    saveFilterPreference(filter);
  }, [filter]);

  const activeName = useMemo(
    () => data?.filters?.find(item => item.id === data.activeFilter)?.name || 'All Properties',
    [data]
  );

  const visibleRows = useMemo(() => {
    if (!data?.rows) return [];
    return data.rows.filter(row => Object.entries(columnFilters).every(([field, value]) => {
      if (!value.trim()) return true;
      return String(row.values[field] || '').toLowerCase().includes(value.toLowerCase());
    }));
  }, [data, columnFilters]);

  const pages = useMemo(() => {
    const total = data?.pageCount || 1;
    const values = [];
    const start = Math.max(1, Math.min(page - 2, total - 4));
    const end = Math.min(total, start + 4);
    for (let value = start; value <= end; value += 1) values.push(value);
    return values;
  }, [data, page]);

  const changeSort = name => {
    setPage(1);
    if (sortBy === name) setSortOrder(current => current === 'ASC' ? 'DESC' : 'ASC');
    else { setSortBy(name); setSortOrder('ASC'); }
  };

  const clearAll = () => {
    setSearch('');
    setSelectedAlphabet('');
    setSortBy('');
    setSortOrder('ASC');
    setColumnFilters({});
    setPage(1);
  };

  const openRow = row => {
    window.location.href = row.detailUrl;
  };

  const stopRowOpen = event => {
    event.stopPropagation();
  };

  const metrics = [
    { label: 'Total Properties', value: data?.metrics?.total || 0, note: 'All time', icon: Building2 },
    { label: 'Current Filter', value: data?.metrics?.filtered || 0, note: activeName, icon: Filter },
    { label: 'Visible Now', value: visibleRows.length, note: `${limit} per page`, icon: Columns3 },
    { label: 'This Month', value: data?.metrics?.addedThisMonth || 0, note: 'New properties', icon: Sparkles }
  ];

  return <div className="property-app" onClick={() => openAction && setOpenAction(null)}>
    <aside className={`property-sidebar ${sidebar ? 'open' : ''}`}>
      <div className="property-brand"><span><MaterialIcon name="apartment" size={23}/></span><div><strong>EGAR</strong><small>Real Estate CRM</small></div><button onClick={() => setSidebar(false)}><X size={19}/></button></div>
      <nav><small>Workspace</small>{data?.modules?.map(module => <a className={module.active ? 'active' : ''} href={module.url} key={module.name}><MaterialIcon name={module.icon || 'apps'} size={20}/>{module.label}</a>)}{data?.settingsUrl && <><small>Management</small><a href={data.settingsUrl}><MaterialIcon name="settings" size={20}/>Settings</a></>}</nav>
      <div className="inventory-note"><Columns3 size={18}/><strong>Inventory workspace</strong><p>Saved Vtiger filters, permissions, sorting and paging are applied directly.</p></div>
    </aside>

    {sidebar && <button className="property-scrim" onClick={() => setSidebar(false)}/>}

    <main className="property-main">
      <header className="property-topbar"><button className="mobile-menu" onClick={() => setSidebar(true)}><Menu size={20}/></button><div className="breadcrumbs"><a href="index.php?module=Vtiger&view=ReactDashboard">Workspace</a><span>/</span><strong>Property</strong></div><a className="back-dashboard" href="index.php?module=Vtiger&view=ReactDashboard"><ArrowLeft size={16}/>Dashboard</a></header>

      <div className="property-content">
        <section className="property-heading"><div><span className="heading-label">Real estate inventory</span><div className="title-line"><h1>Properties</h1><span className="live-pill"><i/>Live data</span></div><p>Manage every property, apply accurate filters and move through large inventories quickly.</p></div><div className="heading-actions">{data?.canCreate && <a className="add-property" href={data.createUrl}><Plus size={18}/>Add property</a>}<div className="secondary-actions">{data?.canImport && <a href={data.importUrl}><MaterialIcon name="upload_file" size={18}/>Import</a>}{data?.canExport && <a href={data.exportUrl}><MaterialIcon name="download" size={18}/>Export</a>}<a href={data?.createFilterUrl || 'index.php?module=CustomView&view=ReactEdit&source_module=Products'}>Create filter</a><a href={data?.legacyUrl || 'index.php?module=Products&view=List&legacy=1'}>Legacy list</a></div></div></section>

        <section className="property-toolbar">
          <div className="filter-select"><Filter size={17}/><select value={filter || ''} onChange={event => { setFilter(Number(event.target.value)); setPage(1); }}>{data?.filters?.map(item => <option key={item.id} value={item.id}>{item.name}</option>)}</select><ChevronDown size={15}/></div>
          <div className="property-search"><Search size={18}/><input value={search} onChange={event => { setSearch(event.target.value); setSelectedAlphabet(''); }} placeholder="Search by property name..."/>{search && <button onClick={() => setSearch('')}><X size={16}/></button>}</div>
          <button className={`advanced-toggle ${advanced ? 'active' : ''}`} onClick={() => setAdvanced(value => !value)}><SlidersHorizontal size={16}/>Advanced filters</button>
          <button className="refresh" onClick={load} title="Refresh"><RefreshCw size={17}/></button>
        </section>

        <section className="metric-strip">{metrics.map(({ label, value, note, icon: Icon }) => <article key={label}><div><small>{label}</small><strong>{number.format(value)}</strong><span>{note}</span></div><b><Icon size={22}/></b></article>)}</section>

        <section className="alphabet-filter" aria-label="Filter properties by first letter"><button className={!selectedAlphabet ? 'active' : ''} onClick={() => { setSelectedAlphabet(''); setPage(1); }}>All</button>{alphabet.map(letter => <button className={selectedAlphabet === letter ? 'active' : ''} key={letter} onClick={() => { setSelectedAlphabet(letter); setSearch(''); setPage(1); }}>{letter}</button>)}<button className="clear-all" onClick={clearAll}><X size={14}/>Clear all</button></section>

        <section className="list-card">
          <div className="table-scroll">
            <table><thead><tr><th className="check-col"><input type="checkbox" aria-label="Select all visible records"/></th>{data?.headers?.map(header => <th key={header.name}><button className="sort-header" onClick={() => changeSort(header.name)}>{header.label}{sortBy === header.name ? (sortOrder === 'ASC' ? <ArrowUp size={13}/> : <ArrowDown size={13}/>) : <span className="sort-hint">↕</span>}</button></th>)}<th className="actions-col">Actions</th></tr>{advanced && <tr className="column-search-row"><th></th>{data?.headers?.map(header => <th key={header.name}><input value={columnFilters[header.name] || ''} onChange={event => setColumnFilters(current => ({ ...current, [header.name]: event.target.value }))} placeholder={`Filter ${header.label}`}/></th>)}<th><button onClick={() => setColumnFilters({})}>Clear</button></th></tr>}</thead>
              <tbody>{loading ? Array.from({ length: 8 }).map((_, index) => <tr className="skeleton-row" key={index}><td colSpan={(data?.headers?.length || 4) + 2}><span/></td></tr>) : error ? <tr><td className="empty-state" colSpan={(data?.headers?.length || 4) + 2}>Unable to load properties. <button onClick={load}>Try again</button></td></tr> : visibleRows.length === 0 ? <tr><td className="empty-state" colSpan={data.headers.length + 2}><Building2 size={28}/><strong>No properties found</strong><span>Try another saved filter, letter or column search.</span></td></tr> : visibleRows.map(row => <tr className="clickable-row" key={row.id} onClick={() => openRow(row)} tabIndex="0" onKeyDown={event => { if (event.key === 'Enter') openRow(row); }}><td className="check-col" onClick={stopRowOpen}><input type="checkbox" aria-label={`Select record ${row.id}`}/></td>{data.headers.map((header, index) => <td key={header.name} className={index === 0 ? 'primary-cell' : ''}>{index === 0 ? <a href={row.detailUrl} onClick={stopRowOpen}>{row.values[header.name] || '—'}</a> : <span>{row.values[header.name] || '—'}</span>}</td>)}<td className="row-actions" onClick={stopRowOpen}><div className="action-menu"><button title="Actions" onClick={event => { event.stopPropagation(); setOpenAction(openAction === row.id ? null : row.id); }}><MoreHorizontal size={17}/></button>{openAction === row.id && <div onClick={event => event.stopPropagation()}><a href={row.detailUrl}>Open record</a>{row.canEdit && <a href={row.editUrl}><Pencil size={14}/>Edit</a>}</div>}</div></td></tr>)}</tbody>
            </table>
          </div>

          <footer className="premium-pagination"><div className="result-summary">Showing <strong>{data ? ((page - 1) * limit) + 1 : 0}</strong> to <strong>{data ? Math.min(page * limit, data.filteredCount) : 0}</strong> of <strong>{number.format(data?.filteredCount || 0)}</strong> records</div><div className="page-size"><select value={limit} onChange={event => { setLimit(Number(event.target.value)); setPage(1); }}><option value="10">10 per page</option><option value="25">25 per page</option><option value="50">50 per page</option><option value="100">100 per page</option></select></div><div className="page-controls"><button disabled={page === 1 || loading} onClick={() => setPage(1)}><ChevronsLeft size={16}/></button><button disabled={page === 1 || loading} onClick={() => setPage(value => Math.max(1, value - 1))}><ChevronLeft size={16}/></button>{pages.map(value => <button className={value === page ? 'active' : ''} key={value} onClick={() => setPage(value)}>{value}</button>)}{data?.pageCount > 5 && page < data.pageCount - 2 && <span>…</span>}<button disabled={!data?.hasNext || loading} onClick={() => setPage(value => value + 1)}><ChevronRight size={16}/></button><button disabled={!data?.hasNext || loading} onClick={() => setPage(data.pageCount)}><ChevronsRight size={16}/></button></div><form className="go-page" onSubmit={event => { event.preventDefault(); const value = Number(new FormData(event.currentTarget).get('page')); if (value >= 1 && value <= (data?.pageCount || 1)) setPage(value); }}><span>Go to page</span><input name="page" type="number" min="1" max={data?.pageCount || 1}/><button>Go</button></form></footer>
        </section>
      </div>
    </main>
  </div>;
}

createRoot(document.getElementById('egar-react-product')).render(<ProductList/>);
