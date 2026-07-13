import React, { useEffect, useMemo, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { ArrowLeft, Menu, Search, X } from 'lucide-react';
import MaterialIcon from './material-icon.jsx';
import './settings.css';

const number = new Intl.NumberFormat('en-US');

function SettingsApp() {
  const [data, setData] = useState(null);
  const [error, setError] = useState(false);
  const [query, setQuery] = useState('');
  const [activeBlock, setActiveBlock] = useState(null);
  const [sidebar, setSidebar] = useState(false);

  useEffect(() => {
    fetch('index.php?module=Vtiger&parent=Settings&action=ReactData', { credentials: 'same-origin', headers: { Accept: 'application/json' } })
      .then(response => response.ok ? response.json() : Promise.reject())
      .then(payload => {
        if (!payload.result) throw new Error('Invalid settings response');
        setData(payload.result);
        setActiveBlock(payload.result.menus?.[0]?.id || null);
      })
      .catch(() => setError(true));
  }, []);

  const filteredMenus = useMemo(() => {
    if (!data?.menus) return [];
    const term = query.trim().toLowerCase();
    if (!term) return data.menus;
    return data.menus.map(menu => ({
      ...menu,
      items: menu.items.filter(item => `${item.name} ${item.description} ${menu.label}`.toLowerCase().includes(term))
    })).filter(menu => menu.items.length);
  }, [data, query]);

  const activeMenu = useMemo(
    () => filteredMenus.find(menu => menu.id === activeBlock) || filteredMenus[0],
    [filteredMenus, activeBlock]
  );

  if (error) return <div className="settings-state"><h1>Settings unavailable</h1><p>Please refresh or sign in as an administrator.</p><a href="index.php?module=Vtiger&view=ReactDashboard">Return to dashboard</a></div>;
  if (!data) return <div className="settings-state loading"><span/><p>Loading settings…</p></div>;

  const metrics = [
    ['Active users', data.metrics.activeUsers, 'manage_accounts', data.legacyUsersUrl],
    ['Workflows', data.metrics.activeWorkflows, 'account_tree', 'index.php?module=Workflows&parent=Settings&view=List'],
    ['Modules', data.metrics.activeModules, 'extension', 'index.php?module=ModuleManager&parent=Settings&view=List'],
    ['Settings', data.metrics.settingItems, 'tune', data.settingsUrl]
  ];

  return <div className="settings-shell">
    <aside className={`settings-main-sidebar ${sidebar ? 'open' : ''}`}>
      <div className="settings-brand"><span><MaterialIcon name="settings" size={23}/></span><div><strong>EGAR</strong><small>System settings</small></div><button onClick={() => setSidebar(false)}><X size={19}/></button></div>
      <nav><small>Workspace</small>{data.modules.map(module => <a href={module.url} key={module.name}><MaterialIcon name={module.icon || 'apps'} size={20}/>{module.label}</a>)}<small>Management</small><a className="active" href={data.settingsUrl}><MaterialIcon name="settings" size={20}/>Settings</a></nav>
    </aside>
    {sidebar && <button className="settings-scrim" onClick={() => setSidebar(false)}/>}

    <main className="settings-main">
      <header className="settings-topbar">
        <button className="settings-menu-button" onClick={() => setSidebar(true)}><Menu size={20}/></button>
        <a href="index.php?module=Vtiger&view=ReactDashboard"><ArrowLeft size={16}/>Dashboard</a>
        <div className="settings-search"><Search size={18}/><input value={query} onChange={event => setQuery(event.target.value)} placeholder="Search settings..."/>{query && <button onClick={() => setQuery('')}><X size={16}/></button>}</div>
      </header>

      <div className="settings-layout">
        <aside className="settings-local-sidebar">
          <div className="settings-local-title"><MaterialIcon name="tune" size={20}/><strong>Settings menu</strong></div>
          <nav>{filteredMenus.map(menu => <button className={activeMenu?.id === menu.id ? 'active' : ''} onClick={() => setActiveBlock(menu.id)} key={menu.id}><span>{menu.label}</span><em>{menu.items.length}</em></button>)}</nav>
          <a className="extension-link" href={data.extensionStoreUrl}><MaterialIcon name="add_circle" size={18}/>Extension store</a>
        </aside>

        <section className="settings-content">
          <div className="settings-heading"><span>Administration</span><h1>Settings</h1><p>All vtiger configuration areas are available here with the same permissions and original actions.</p></div>

          <section className="settings-metrics">{metrics.map(([label, value, icon, url]) => <a href={url} key={label}><MaterialIcon name={icon} size={24}/><small>{label}</small><strong>{number.format(value || 0)}</strong></a>)}</section>

          {data.shortcuts.length > 0 && <section className="settings-shortcuts"><header><h2>Pinned shortcuts</h2><p>Your old settings shortcuts, redesigned.</p></header><div>{data.shortcuts.map(item => <a href={item.url} key={item.id}><MaterialIcon name={item.icon} size={22}/><strong>{item.name}</strong><span>{item.description}</span></a>)}</div></section>}

          <section className="settings-panel">
            <header><div><h2>{activeMenu?.label || 'Settings'}</h2><p>{activeMenu?.items?.length || 0} configuration areas</p></div></header>
            <div className="settings-grid">{activeMenu?.items?.map(item => <a href={item.url} key={item.id}><span><MaterialIcon name={item.icon} size={24}/></span><div><strong>{item.name}</strong><p>{item.description}</p></div>{item.pinned && <em>Pinned</em>}</a>)}</div>
          </section>
        </section>
      </div>
    </main>
  </div>;
}

createRoot(document.getElementById('egar-react-settings')).render(<SettingsApp/>);
