  /* ── STARS ── */
  (function createStars() {
    const container = document.getElementById('stars');
    for (let i = 0; i < 120; i++) {
      const s = document.createElement('div');
      s.className = 'star';
      const size = Math.random() * 2.5 + 0.5;
      s.style.cssText = `
        width:${size}px; height:${size}px;
        top:${Math.random()*100}%;
        left:${Math.random()*100}%;
        --dur:${(Math.random()*4+2).toFixed(1)}s;
        --min-op:${(Math.random()*0.3+0.1).toFixed(2)};
        animation-delay:${(Math.random()*6).toFixed(1)}s;
      `;
      container.appendChild(s);
    }
  })();

  /* ── EMOJI MAP ── */
  function getEmoji(code) {
    if (code >= 200 && code < 300) return '⛈';
    if (code >= 300 && code < 400) return '🌦';
    if (code >= 500 && code < 600) return '🌧';
    if (code >= 600 && code < 700) return '❄️';
    if (code >= 700 && code < 800) return '🌫';
    if (code === 800) return '☀️';
    if (code === 801) return '🌤';
    if (code === 802) return '⛅';
    if (code >= 803) return '☁️';
    return '🌈';
  }

  /* ── BANNER GRADIENT by condition ── */
  function getBannerGradient(code) {
    if (code >= 200 && code < 300) return 'linear-gradient(135deg,#1a1a3a,#2a1a4a)'; // storm
    if (code >= 500 && code < 600) return 'linear-gradient(135deg,#1a2a3a,#0a1a2a)'; // rain
    if (code >= 600 && code < 700) return 'linear-gradient(135deg,#1e2a3a,#2a3a4a)'; // snow
    if (code === 800)               return 'linear-gradient(135deg,#1e3a5f,#0d2a4a)'; // clear
    return 'linear-gradient(135deg,#1a2a3a,#0a1a2a)';                               // default
  }

  /* ── HELPERS ── */
  const fmtTime = ts => new Date(ts * 1000).toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });
  const fmtNow  = ()  => new Date().toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

  /* ── DOM refs ── */
  const searchInput  = document.getElementById('searchInput');
  const searchBtn    = document.getElementById('searchBtn');
  const apiKeyInput  = document.getElementById('apiKeyInput');
  const errorMsg     = document.getElementById('errorMsg');
  const loader       = document.getElementById('loader');
  const weatherCard  = document.getElementById('weatherCard');

  function showError(msg) {
    errorMsg.textContent = msg;
    errorMsg.classList.add('show');
    setTimeout(() => errorMsg.classList.remove('show'), 4000);
  }

  function setLoading(on) {
    loader.classList.toggle('show', on);
    searchBtn.style.opacity = on ? '0.5' : '1';
    searchBtn.disabled = on;
  }

  /* ── FETCH WEATHER ── */
  async function fetchWeather(city) {
    const apiKey = apiKeyInput.value.trim();
    if (!apiKey) { showError('⚠ Inserisci prima la tua API key OpenWeatherMap'); return; }
    if (!city.trim()) { showError('Scrivi il nome di una città'); return; }

    setLoading(true);
    weatherCard.classList.remove('show');

    try {
      const url = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(city)}&appid=${apiKey}&units=metric&lang=it`;
      const res = await fetch(url);
      const data = await res.json();

      if (!res.ok) {
        if (res.status === 401) throw new Error('API key non valida. Verifica su openweathermap.org');
        if (res.status === 404) throw new Error(`Città "${city}" non trovata`);
        throw new Error(data.message || 'Errore sconosciuto');
      }

      renderWeather(data);
    } catch (err) {
      showError(err.message);
    } finally {
      setLoading(false);
    }
  }

  /* ── RENDER ── */
  function renderWeather(d) {
    const code = d.weather[0].id;

    document.getElementById('cityName').textContent    = d.name;
    document.getElementById('cityMeta').textContent    = `${d.sys.country} · ${d.coord.lat.toFixed(2)}°N ${d.coord.lon.toFixed(2)}°E`;
    document.getElementById('weatherIcon').textContent = getEmoji(code);
    document.getElementById('tempBig').textContent     = Math.round(d.main.temp);
    document.getElementById('description').textContent = d.weather[0].description;
    document.getElementById('feelsLike').textContent   = `Percepita: ${Math.round(d.main.feels_like)}°C`;
    document.getElementById('humidity').textContent    = d.main.humidity + '%';
    document.getElementById('wind').textContent        = (d.wind.speed * 3.6).toFixed(1) + ' km/h';
    document.getElementById('visibility').textContent  = d.visibility ? (d.visibility/1000).toFixed(1) + ' km' : 'N/D';
    document.getElementById('pressure').textContent    = d.main.pressure + ' hPa';
    document.getElementById('sunrise').textContent     = fmtTime(d.sys.sunrise);
    document.getElementById('sunset').textContent      = fmtTime(d.sys.sunset);
    document.getElementById('lastUpdated').textContent = 'Aggiornato: ' + fmtNow();

    // Dynamic banner gradient
    document.getElementById('cardBanner').style.setProperty('--banner-bg', getBannerGradient(code));

    weatherCard.classList.add('show');
  }

  /* ── EVENTS ── */
  searchBtn.addEventListener('click', () => fetchWeather(searchInput.value));
  searchInput.addEventListener('keydown', e => e.key === 'Enter' && fetchWeather(searchInput.value));

  document.querySelectorAll('.quick-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      searchInput.value = btn.dataset.city;
      fetchWeather(btn.dataset.city);
    });
  });

  // Save API key in sessionStorage for convenience
  apiKeyInput.addEventListener('input', () => {
    sessionStorage.setItem('owm_key', apiKeyInput.value);
  });
  const saved = sessionStorage.getItem('owm_key');
  if (saved) apiKeyInput.value = saved;