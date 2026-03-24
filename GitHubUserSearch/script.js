  /* ── LANG COLORS fallback map ── */
  const LANG_COLORS = {
    JavaScript:'#f1e05a', TypeScript:'#3178c6', Python:'#3572A5',
    Go:'#00ADD8', Rust:'#dea584', 'C++':'#f34b7d', CSS:'#563d7c',
    HTML:'#e34c26', Ruby:'#701516', Java:'#b07219', Shell:'#89e051', PHP:'#4F5D95'
  };

  /* ── DOM refs ── */
  const searchInput = document.getElementById('searchInput');
  const searchBtn   = document.getElementById('searchBtn');
  const errorMsg    = document.getElementById('errorMsg');
  const loader      = document.getElementById('loader');
  const profileCard = document.getElementById('profileCard');

  let currentRepos = [];
  let currentSort  = 'stars';

  /* ── HELPERS ── */
  function fmtNum(n) {
    if (n >= 1000) return (n/1000).toFixed(1) + 'k';
    return String(n);
  }
  function fmtDate(iso) {
    return new Date(iso).toLocaleDateString('it-IT', { year:'numeric', month:'short', day:'numeric' });
  }

  function showError(msg) {
    errorMsg.textContent = msg;
    errorMsg.classList.add('show');
    setTimeout(() => errorMsg.classList.remove('show'), 4000);
  }

  function setLoading(on) {
    loader.classList.toggle('show', on);
    searchBtn.disabled = on;
    searchBtn.style.opacity = on ? '0.5' : '1';
  }

  /* ── BADGES ── */
  function makeBadge(icon, text) {
    if (!text) return '';
    return `<span class="badge">
      ${icon} <span>${text}</span>
    </span>`;
  }

  /* ── REPOS RENDER ── */
  function renderRepos() {
    const sorted = [...currentRepos].sort((a, b) =>
      currentSort === 'stars'
        ? b.stargazers_count - a.stargazers_count
        : new Date(b.updated_at) - new Date(a.updated_at)
    );
    const top6 = sorted.slice(0, 6);
    const grid = document.getElementById('reposGrid');
    grid.innerHTML = top6.map(r => {
      const color = LANG_COLORS[r.language] || '#8b949e';
      const desc  = r.description ? r.description.slice(0, 80) + (r.description.length > 80 ? '…' : '') : '';
      return `<a class="repo-card" href="${r.html_url}" target="_blank">
        <div class="repo-name">${r.name}</div>
        ${desc ? `<div class="repo-desc">${desc}</div>` : ''}
        <div class="repo-meta">
          ${r.language ? `<span class="repo-lang"><span class="lang-dot" style="background:${color}"></span>${r.language}</span>` : ''}
          ${r.stargazers_count ? `<span class="repo-stars">★ ${fmtNum(r.stargazers_count)}</span>` : ''}
        </div>
      </a>`;
    }).join('');
  }

  /* ── MAIN FETCH ── */
  async function searchUser(username) {
    username = username.trim().replace(/^@/, '');
    if (!username) { showError('Inserisci un username GitHub'); return; }

    setLoading(true);
    profileCard.classList.remove('show');

    try {
      const [userRes, reposRes] = await Promise.all([
        fetch(`https://api.github.com/users/${username}`),
        fetch(`https://api.github.com/users/${username}/repos?per_page=100&sort=pushed`)
      ]);

      if (userRes.status === 404) throw new Error(`Utente "${username}" non trovato su GitHub`);
      if (userRes.status === 403) throw new Error('Rate limit GitHub raggiunto. Riprova tra un minuto.');
      if (!userRes.ok) throw new Error('Errore API GitHub');

      const user  = await userRes.json();
      const repos = reposRes.ok ? await reposRes.json() : [];

      renderProfile(user, repos);
    } catch (err) {
      showError(err.message);
    } finally {
      setLoading(false);
    }
  }

  /* ── RENDER PROFILE ── */
  function renderProfile(u, repos) {
    document.getElementById('avatar').src          = u.avatar_url;
    document.getElementById('profileName').textContent = u.name || u.login;
    document.getElementById('profileLogin').textContent = '@' + u.login;
    document.getElementById('profileLogin').href    = u.html_url;
    document.getElementById('profileBio').textContent  = u.bio || '';

    // Badges
    const badges = [
      u.company  ? makeBadge('🏢', u.company.replace('@','')) : '',
      u.location ? makeBadge('📍', u.location) : '',
      u.blog     ? `<span class="badge">🔗 <a href="${u.blog.startsWith('http') ? u.blog : 'https://'+u.blog}" target="_blank" style="color:inherit;text-decoration:none">${u.blog.replace(/https?:\/\//,'').slice(0,30)}</a></span>` : '',
      u.twitter_username ? makeBadge('🐦', '@' + u.twitter_username) : '',
    ].filter(Boolean).join('');
    document.getElementById('badgeRow').innerHTML = badges;

    // Stats
    document.getElementById('statRepos').textContent     = fmtNum(u.public_repos);
    document.getElementById('statFollowers').textContent  = fmtNum(u.followers);
    document.getElementById('statFollowing').textContent  = fmtNum(u.following);
    document.getElementById('statGists').textContent      = fmtNum(u.public_gists);

    // Repos
    currentRepos = Array.isArray(repos) ? repos.filter(r => !r.fork) : [];
    renderRepos();

    // "See all" link
    document.getElementById('reposMore').innerHTML = u.public_repos > 6
      ? `<a href="${u.html_url}?tab=repositories" target="_blank">Vedi tutti i ${u.public_repos} repository →</a>`
      : '';

    document.getElementById('joinedAt').textContent = 'Iscritto: ' + fmtDate(u.created_at);

    profileCard.classList.add('show');
  }

  /* ── FILTER BUTTONS ── */
  document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentSort = btn.dataset.sort;
      if (currentRepos.length) renderRepos();
    });
  });

  /* ── EVENTS ── */
  searchBtn.addEventListener('click', () => searchUser(searchInput.value));
  searchInput.addEventListener('keydown', e => e.key === 'Enter' && searchUser(searchInput.value));
  document.querySelectorAll('.sug-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      searchInput.value = btn.dataset.user;
      searchUser(btn.dataset.user);
    });
  });