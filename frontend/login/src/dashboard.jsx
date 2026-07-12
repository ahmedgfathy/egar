import React, { useEffect, useMemo, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { BarChart3, Bell, Building2, CalendarDays, ChevronDown, CircleUserRound, Command, FileText, Home, LayoutDashboard, LogOut, Menu, Search, Settings, Sparkles, Users, X } from 'lucide-react';
import './dashboard.css';

const icons = { Products: Building2, Leads: Sparkles, Contacts: Users, Potentials: BarChart3, Project: Command, Calendar: CalendarDays, Documents: FileText, Reports: BarChart3 };
const number = new Intl.NumberFormat('en-US');

function Dashboard() {
  const [data, setData] = useState(null);
  const [error, setError] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);
  const [profileOpen, setProfileOpen] = useState(false);
  const [query, setQuery] = useState('');

  useEffect(() => {
    fetch('index.php?module=Vtiger&action=ReactBootstrap', { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(r => r.ok ? r.json() : Promise.reject())
      .then(payload => setData(payload.result))
      .catch(() => setError(true));
  }, []);

  const filteredModules = useMemo(() => data?.modules?.filter(module => module.label.toLowerCase().includes(query.toLowerCase())) ?? [], [data, query]);
  if (error) return <div className="dash-state"><h1>Workspace unavailable</h1><p>Please refresh or sign in again.</p><a href="index.php">Return to sign in</a></div>;
  if (!data) return <div className="dash-state loading"><span></span><p>Preparing your workspace…</p></div>;

  const initials = data.user.name.split(' ').map(part => part[0]).slice(0, 2).join('').toUpperCase();
  const groups = Object.groupBy ? Object.groupBy(filteredModules, item => item.group) : filteredModules.reduce((all, item) => ((all[item.group] ||= []).push(item), all), {});

  return <div className="crm-shell">
    <aside className={`sidebar ${menuOpen ? 'open' : ''}`}>
      <div className="sidebar-brand"><span><Building2 size={22}/></span><div><strong>EGAR</strong><small>Real Estate CRM</small></div><button onClick={() => setMenuOpen(false)}><X size={20}/></button></div>
      <nav>
        <p>Workspace</p>
        <a className="active" href="index.php?module=Vtiger&view=ReactDashboard"><LayoutDashboard size={18}/> Overview</a>
        {data.modules.slice(0, 6).map(module => { const Icon = icons[module.name] || Command; return <a href={module.url} key={module.name}><Icon size={18}/>{module.label}</a>; })}
        <p>Management</p>
        {data.user.admin && <a href={data.legacySettingsUrl}><Settings size={18}/>Settings <em>Legacy</em></a>}
      </nav>
      <div className="sidebar-insight"><Sparkles size={17}/><strong>12,002 properties</strong><span>Your inventory is ready for the next React module.</span></div>
    </aside>
    {menuOpen && <button className="scrim" onClick={() => setMenuOpen(false)} aria-label="Close navigation"/>}

    <div className="workspace">
      <header className="topbar">
        <button className="menu-button" onClick={() => setMenuOpen(true)}><Menu size={21}/></button>
        <div className="search"><Search size={18}/><input value={query} onChange={e => setQuery(e.target.value)} placeholder="Search modules and workspace…"/></div>
        <div className="top-actions"><button className="icon-button"><Bell size={19}/><i/></button><div className="profile"><button onClick={() => setProfileOpen(!profileOpen)}><span>{initials}</span><div><strong>{data.user.name}</strong><small>{data.user.admin ? 'Administrator' : 'Team member'}</small></div><ChevronDown size={16}/></button>{profileOpen && <div className="profile-menu"><a href="index.php?module=Users&view=PreferenceDetail"><CircleUserRound size={17}/>My profile</a><a href="index.php?module=Users&action=Logout"><LogOut size={17}/>Sign out</a></div>}</div></div>
      </header>

      <main>
        <section className="welcome"><div><span className="kicker"><Home size={14}/> Sunday workspace</span><h1>Good day, {data.user.name.split(' ')[0]}.</h1><p>Here’s what’s happening across your real-estate operation.</p></div><a className="primary-action" href="index.php?module=Products&view=Edit"><span>+</span> Add property</a></section>
        {query && <section className="module-results"><h2>Modules</h2><div>{Object.entries(groups).map(([group, modules]) => <div key={group}><small>{group}</small>{modules.map(module => {const Icon=icons[module.name]||Command; return <a href={module.url} key={module.name}><Icon size={18}/>{module.label}</a>})}</div>)}</div></section>}
        <section className="metrics">
          <article><span className="metric-icon green"><Building2 size={21}/></span><div><small>Total properties</small><strong>{number.format(data.metrics.properties)}</strong><em>Live inventory</em></div></article>
          <article><span className="metric-icon amber"><Sparkles size={21}/></span><div><small>Active leads</small><strong>{number.format(data.metrics.leads)}</strong><em>All lead records</em></div></article>
          <article><span className="metric-icon blue"><Users size={21}/></span><div><small>Contacts</small><strong>{number.format(data.metrics.contacts)}</strong><em>Relationship network</em></div></article>
        </section>
        <section className="content-grid">
          <article className="panel recent"><header><div><h2>Recently updated properties</h2><p>Latest movement in your inventory</p></div><a href="index.php?module=Products&view=List">View all</a></header><div className="property-list">{data.recentProperties.map((property, index) => <a href={property.url} key={property.id}><span className="property-rank">{String(index+1).padStart(2,'0')}</span><div><strong>{property.name || 'Untitled property'}</strong><small>{property.number || `Property #${property.id}`}</small></div><time>{property.modified?.slice(0,10)}</time></a>)}</div></article>
          <aside className="panel quick"><header><h2>Quick access</h2><p>Your essential tools</p></header><div>{data.modules.slice(0,6).map(module => {const Icon=icons[module.name]||Command; return <a href={module.url} key={module.name}><span><Icon size={19}/></span><div><strong>{module.label}</strong><small>Open module</small></div></a>})}</div></aside>
        </section>
      </main>
    </div>
  </div>;
}

createRoot(document.getElementById('egar-react-dashboard')).render(<Dashboard/>);
