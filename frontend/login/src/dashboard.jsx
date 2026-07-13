import React, { useEffect, useMemo, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { BarChart3, Bell, Building2, CalendarDays, ChevronDown, CircleUserRound, Command, FileText, Home, LayoutDashboard, LogOut, Menu, Search, Settings, Sparkles, Users, X } from 'lucide-react';
import './dashboard.css';
import './dashboard-system.css';

const icons = { Products: Building2, Leads: Sparkles, Contacts: Users, Potentials: BarChart3, Project: Command, Calendar: CalendarDays, Documents: FileText, Reports: BarChart3 };
const number = new Intl.NumberFormat('en-US');
const metricDefinitions = [
  ['properties', 'Properties', Building2, 'Live inventory'],
  ['leads', 'Leads', Sparkles, 'Sales pipeline'],
  ['contacts', 'Contacts', Users, 'Relationship network'],
  ['opportunities', 'Opportunities', BarChart3, 'Open and historical deals'],
  ['project', 'Projects', Command, 'Delivery workload'],
  ['documents', 'Documents', FileText, 'Shared files']
];

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
  const visibleMetrics = metricDefinitions.filter(([key]) => data.metrics[key] !== undefined);
  const maxLeadStatus = Math.max(1, ...data.leadStatus.map(item => item.count));

  return <div className="crm-shell">
    <aside className={`sidebar ${menuOpen ? 'open' : ''}`}>
      <div className="sidebar-brand"><span><Building2 size={22}/></span><div><strong>EGAR</strong><small>Real Estate CRM</small></div><button onClick={() => setMenuOpen(false)}><X size={20}/></button></div>
      <nav><p>Workspace</p><a className="active" href="index.php?module=Vtiger&view=ReactDashboard"><LayoutDashboard size={18}/> Overview</a>{data.modules.map(module => { const Icon = icons[module.name] || Command; return <a href={module.url} key={module.name}><Icon size={18}/>{module.label}</a>; })}<p>Management</p>{data.user.admin && <a href={data.legacySettingsUrl}><Settings size={18}/>Settings <em>Legacy</em></a>}</nav>
      <div className="sidebar-insight"><Sparkles size={17}/><strong>{number.format(data.recentRecords.length)} recent system updates</strong><span>The dashboard now summarizes all permitted CRM modules.</span></div>
    </aside>
    {menuOpen && <button className="scrim" onClick={() => setMenuOpen(false)} aria-label="Close navigation"/>}

    <div className="workspace">
      <header className="topbar"><button className="menu-button" onClick={() => setMenuOpen(true)}><Menu size={21}/></button><div className="search"><Search size={18}/><input value={query} onChange={e => setQuery(e.target.value)} placeholder="Search modules and workspace…"/></div><div className="top-actions"><button className="icon-button"><Bell size={19}/><i/></button><div className="profile"><button onClick={() => setProfileOpen(!profileOpen)}><span>{initials}</span><div><strong>{data.user.name}</strong><small>{data.user.admin ? 'Administrator' : 'Team member'}</small></div><ChevronDown size={16}/></button>{profileOpen && <div className="profile-menu"><a href="index.php?module=Users&view=PreferenceDetail"><CircleUserRound size={17}/>My profile</a><a href="index.php?module=Users&action=Logout"><LogOut size={17}/>Sign out</a></div>}</div></div></header>

      <main>
        <section className="welcome"><div><span className="kicker"><Home size={14}/> Full system workspace</span><h1>Good day, {data.user.name.split(' ')[0]}.</h1><p>Here is the latest activity across every CRM module you are allowed to access.</p></div><a className="primary-action" href="index.php?module=Products&view=Edit"><span>+</span> Add property</a></section>
        {query && <section className="module-results"><h2>Modules</h2><div>{Object.entries(groups).map(([group, modules]) => <div key={group}><small>{group}</small>{modules.map(module => {const Icon=icons[module.name]||Command; return <a href={module.url} key={module.name}><Icon size={18}/>{module.label}</a>})}</div>)}</div></section>}

        <section className="metrics system-metrics">{visibleMetrics.map(([key, label, Icon, note], index) => <article key={key}><span className={`metric-icon ${index % 3 === 0 ? 'green' : index % 3 === 1 ? 'amber' : 'blue'}`}><Icon size={21}/></span><div><small>{label}</small><strong>{number.format(data.metrics[key] || 0)}</strong><em>{note}</em></div></article>)}</section>

        <section className="content-grid dashboard-grid">
          <article className="panel recent"><header><div><h2>Recent system activity</h2><p>Latest updates from properties, leads, contacts, opportunities, projects, calendar and documents</p></div></header><div className="property-list">{data.recentRecords.map((record, index) => <a href={record.url} key={`${record.module}-${record.id}`}><span className="property-rank">{String(index+1).padStart(2,'0')}</span><div><strong>{record.label || `${record.module} #${record.id}`}</strong><small>{record.module} · updated {record.modified?.slice(0,10)}</small></div><time>{record.modified?.slice(11,16)}</time></a>)}</div></article>

          <aside className="panel quick"><header><h2>Upcoming activities</h2><p>Tasks, calls and events</p></header><div className="activity-list">{data.upcomingActivities.length ? data.upcomingActivities.map(activity => <a href={activity.url} key={activity.id}><span><CalendarDays size={19}/></span><div><strong>{activity.subject || activity.type}</strong><small>{activity.date} {activity.time?.slice(0,5)} · {activity.status || 'Planned'}</small></div></a>) : <p className="empty-panel">No upcoming activities.</p>}</div></aside>
        </section>

        <section className="content-grid lower-grid">
          <article className="panel lead-summary"><header><div><h2>Lead status overview</h2><p>Distribution of all permitted lead records</p></div><a href="index.php?module=Leads&view=List">View leads</a></header><div className="status-bars">{data.leadStatus.length ? data.leadStatus.map(item => <div key={item.label}><span><strong>{item.label}</strong><em>{number.format(item.count)}</em></span><i><b style={{width: `${(item.count / maxLeadStatus) * 100}%`}}/></i></div>) : <p className="empty-panel">No lead data available.</p>}</div></article>
          <aside className="panel quick"><header><h2>Quick access</h2><p>All permitted modules</p></header><div>{data.modules.map(module => {const Icon=icons[module.name]||Command; return <a href={module.url} key={module.name}><span><Icon size={19}/></span><div><strong>{module.label}</strong><small>Open module</small></div></a>})}</div></aside>
        </section>
      </main>
    </div>
  </div>;
}

createRoot(document.getElementById('egar-react-dashboard')).render(<Dashboard/>);
