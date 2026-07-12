import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import { ArrowRight, Building2, Check, Eye, EyeOff, LockKeyhole, UserRound, Wifi, WifiOff } from 'lucide-react';
import './styles.css';

function LoginApp() {
  const mount = document.getElementById('egar-react-login');
  const [showPassword, setShowPassword] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [status, setStatus] = useState({ state: 'loading', label: 'Connecting securely…' });
  const hasError = mount?.dataset.loginError === '1';

  useEffect(() => {
    const controller = new AbortController();
    fetch('index.php?module=Users&action=LoginBootstrap', {
      credentials: 'same-origin',
      headers: { Accept: 'application/json' },
      signal: controller.signal
    })
      .then((response) => response.ok ? response.json() : Promise.reject())
      .then((payload) => setStatus(payload.success && payload.result?.success
        ? { state: 'online', label: 'Workspace online' }
        : { state: 'offline', label: 'Service unavailable' }))
      .catch(() => setStatus({ state: 'offline', label: 'Service unavailable' }));
    return () => controller.abort();
  }, []);

  return (
    <main className="login-shell">
      <section className="story-panel" aria-label="EGAR real estate workspace">
        <div className="brand-lockup">
          <span className="brand-mark"><Building2 size={24} strokeWidth={1.8} /></span>
          <span><strong>EGAR</strong><small>Real Estate Intelligence</small></span>
        </div>
        <div className="story-copy">
          <span className="eyebrow">Property operations, unified</span>
          <h1>Move every opportunity<br />closer to home.</h1>
          <p>Inventory, relationships and follow-ups—one focused workspace for your entire real-estate team.</p>
          <div className="trust-row">
            <span><Check size={15} /> Live inventory</span>
            <span><Check size={15} /> Secure access</span>
            <span><Check size={15} /> Team insights</span>
          </div>
        </div>
        <footer>EGAR CRM <span>•</span> Cairo</footer>
      </section>

      <section className="form-panel">
        <div className="form-wrap">
          <div className={`system-status ${status.state}`}>
            {status.state === 'offline' ? <WifiOff size={14} /> : <Wifi size={14} />}
            {status.label}
          </div>
          <header>
            <span className="mobile-brand"><Building2 size={19} /> EGAR</span>
            <h2>Welcome back</h2>
            <p>Sign in to continue to your workspace.</p>
          </header>

          {hasError && <div className="login-alert" role="alert">The username or password is incorrect. Please try again.</div>}

          <div className="field-group">
            <label htmlFor="username">Username</label>
            <div className="input-wrap">
              <UserRound size={18} aria-hidden="true" />
              <input id="username" name="username" type="text" autoComplete="username" placeholder="Enter your username" required autoFocus />
            </div>
          </div>

          <div className="field-group">
            <div className="label-row"><label htmlFor="password">Password</label><a href="forgotPassword.php">Forgot password?</a></div>
            <div className="input-wrap">
              <LockKeyhole size={18} aria-hidden="true" />
              <input id="password" name="password" type={showPassword ? 'text' : 'password'} autoComplete="current-password" placeholder="Enter your password" required />
              <button className="reveal" type="button" onClick={() => setShowPassword(!showPassword)} aria-label={showPassword ? 'Hide password' : 'Show password'}>
                {showPassword ? <EyeOff size={18} /> : <Eye size={18} />}
              </button>
            </div>
          </div>

          <button className="submit-button" type="submit" disabled={submitting} onClick={() => setSubmitting(true)}>
            <span>{submitting ? 'Signing in…' : 'Sign in to workspace'}</span><ArrowRight size={18} />
          </button>
          <p className="security-note">Protected by your organization’s secure CRM access.</p>
        </div>
      </section>
    </main>
  );
}

createRoot(document.getElementById('egar-react-login')).render(<LoginApp />);
