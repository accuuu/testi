<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Yle Vaalit – Vaalikone 2026</title>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,400;0,600;0,700;1,400&family=IBM+Plex+Mono:wght@400;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --yle-purple: #3d1f8f;
    --yle-purple-mid: #5a2fc2;
    --yle-purple-bg: #2a1466;
    --yle-accent: #a78bfa;
    --yle-gray: #1a1a2e;
    --yle-gray2: #252540;
    --yle-text-muted: #a0a0c0;
  }
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }

  .yle-header { color: #ffffff; }
  .header-top-bar {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1rem 2rem;
    background: #1f2123;
  }
  .header-logo {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: var(--text-color);
    font-weight: bold;
    gap: 0.5rem;
  }
  .header-logo svg { width: 40px; height: 40px; fill: #000; }
  .current-topics { display: flex; gap: 1.5rem; align-items: center; }
  .topic-link { color: #ffffff; text-decoration: none; font-weight: 500; white-space: nowrap; font-size: 14px; }
  .topic-link:hover { text-decoration: underline; }
  .header-actions { display: flex; align-items: center; gap: 1.5rem; }
  .login-button, .search-button {
    background: none; border: none; color: #ffffff; font-weight: 500;
    cursor: pointer; display: flex; align-items: center; gap: 0.5rem;
    padding: 0.5rem; text-decoration: none; font-size: 14px; font-family: inherit;
  }

  .hero {
    background: linear-gradient(135deg, var(--yle-purple-bg) 0%, var(--yle-purple) 40%, var(--yle-purple-mid) 100%);
    background-image: url('https://vaalit.yle.fi/vaalikone/alue-ja-kuntavaalit2025/tausta_vaaka-DNTUhrVz.svg');
    background-size: cover;
    background-position: center right;
    background-repeat: no-repeat;
    padding: 4rem 2rem 5rem;
    position: relative;
    overflow: hidden;
    min-height: 420px;
    display: flex;
    align-items: center;
    justify-content: center; /* Keskitetään vaakatasossa */
    color: #fff;
  }
  .hero-inner {
    max-width: 640px;
    width: 100%;
    position: relative;
    z-index: 1;
    flex-direction: column;
    align-items: center; /* Lapset keskelle */
  }
  .hero h1 { font-size: clamp(1.6rem, 3.5vw, 2.4rem); font-weight: 700; line-height: 1.15; margin-bottom: 1.2rem; }
  .hero p { font-size: 1rem; line-height: 1.65; opacity: 0.88; margin-bottom: 0.75rem; }
  .hero p.italic-note {
    font-style: italic; font-size: 0.9rem; opacity: 0.75; margin-bottom: 2.5rem;
    border-left: 3px solid var(--yle-accent); padding-left: 12px;
    text-align: left; /* Italic-viesti vasemmalle sen reunaviivan takia */
  }

  .selector-box {
    background: rgba(255,255,255,0.06); backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.15); border-radius: 16px;
    padding: 1.8rem;
    width: 100%;
    text-align: left; /* Boksin sisältö vasemmalle */
  }
  .selector-label { font-size: 0.95rem; font-weight: 600; margin-bottom: 0.75rem; }
  .select-wrap { position: relative; margin-bottom: 1.2rem; }
  .select-wrap select {
    width: 100%; padding: 14px 44px 14px 16px; background: #0f0f1a;
    border: 1.5px solid rgba(255,255,255,0.2); border-radius: 10px;
    color: white; font-size: 1rem; font-family: inherit; appearance: none; cursor: pointer;
  }
  .select-wrap select:focus { outline: none; border-color: var(--yle-accent); }
  .select-wrap::after {
    content: '▾'; position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
    color: var(--yle-accent); pointer-events: none;
  }
  .btn-row { display: flex; gap: 1rem; flex-wrap: wrap; }
  .vaali-btn {
    flex: 1; min-width: 130px; padding: 13px 16px; border-radius: 40px; border: none;
    font-size: 0.9rem; font-weight: 600; font-family: inherit; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    transition: all 0.2s; background: rgba(255,255,255,0.12); color: rgba(255,255,255,0.45);
    pointer-events: none;
  }
  .vaali-btn.active { background: #fff; color: var(--yle-purple-bg); pointer-events: all; }
  .vaali-btn.active:hover { background: var(--yle-accent); color: #fff; transform: translateY(-1px); }
  .vaali-btn.eduskunta-always {
    background: rgba(255,255,255,0.18); color: rgba(255,255,255,0.65); pointer-events: all;
    border: 1px solid rgba(255,255,255,0.25);
  }
  .vaali-btn.eduskunta-always:hover { background: var(--yle-accent); color: white; }

  .vaalipiiri-wrap { margin-bottom: 1.2rem; display: none; }
  .vaalipiiri-wrap.show { display: block; }

  .info-section { background: #0f0f1a; padding: 3rem 2rem; color: #fff; }
  .info-inner { max-width: 860px; margin: 0 auto; }
  .info-section h2 { font-size: 1.4rem; font-weight: 700; margin-bottom: 1.5rem; }
  .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; }
  .info-card {
    background: var(--yle-gray2); border-radius: 12px; padding: 1.5rem;
    border: 1px solid rgba(255,255,255,0.06);
  }
  .info-card .icon { font-size: 1.6rem; margin-bottom: 0.75rem; }
  .info-card h3 { font-size: 1rem; font-weight: 600; margin-bottom: 0.5rem; }
  .info-card p { font-size: 0.88rem; color: var(--yle-text-muted); line-height: 1.6; }

  .footer {
    background: #0a0a15; padding: 2rem; text-align: center;
    border-top: 1px solid rgba(255,255,255,0.06); color: var(--yle-text-muted);
  }
  .footer p { font-size: 0.82rem; }
  .footer a { color: var(--yle-accent); text-decoration: none; }

  @media (max-width: 768px) {
    .current-topics { display: none; }
    .header-top-bar { padding: 1rem; }
  }
</style>
</head>
<body>

<header class="yle-header">
  <div class="header-top-bar">
    <a href="#" class="header-logo">
      <svg viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg">
        <path d="M-1003.267 296.362h434.757a20.576 20.576 0 0 1 20.621 20.621v434.758a20.576 20.576 0 0 1-20.62 20.621h-434.758a20.576 20.576 0 0 1-20.622-20.621V316.983a20.576 20.576 0 0 1 20.622-20.62z" style="fill:#ffffff;fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(643.657 -185.66) scale(.62815)"></path>
        <g>
          <path style="fill:#131415;stroke:none" d="M37.964 641.294c0-8.087 5.797-8.218 8.554-8.218 7.809 0 14.417 1.875 24.821 1.875 21.744 0 22.293-10.908 27.679-35.625h-10.09c-25.155 0-26.952-20.405-30.714-33.571l-21.339-76.518s-1.964-6.99-1.964-11.696c0-8.49 5.881-10.179 11.25-10.179h6.428c7.611 0 9.286 2.381 13.125 15.625l20.447 78.125c2.747 9.265 1.393 13.75 17.678 13.75l22.679-98.036c1.289-5.428 4.17-9.464 11.16-9.464h7.947c6.357 0 9.643 3.72 9.643 10 0 5.059-3.125 17.857-3.125 17.857l-34.107 137.947c-1.537 3.97-7.422 27.678-44.018 27.678-21.468 0-36.054-1.704-36.054-11.535zM188.52 589.775V425.69h-6.44c-6.355 0-12.122-2.579-12.122-8.965v-9.976c0-4.968 3.888-8.396 10.48-8.396h23.423c12.544 0 12.817 12.45 12.817 21.781v169.58c0 4.223-.932 10.922-10.923 10.922h-6.629c-6.517 0-10.606-2.525-10.606-10.86z" transform="translate(25.626 -185.66) scale(.62815)"></path>
        </g>
        <path d="M-675.781 463.688c-33.754 0-59.094 14.934-59.094 66.375v11.468c0 46.227 23.746 60.938 55.688 60.938h14.937c22.932 0 37.375-5.418 37.375-12.25v-8.094c0-4.597-2.949-8.188-7.75-8.188-6.63 0-13.77 3.47-32.406 3.47-27.84 0-39.125-3.295-39.125-34.532h66.718c8.479 0 18.25-3.368 18.25-16.5v-6.125c0-36.879-18.578-56.563-54.593-56.563zm.437 21.593c21.465 0 28.407 15.407 28.407 34.594h-58.657c0-18.426 7.183-34.594 30.25-34.594z" style="fill:#131415;stroke:none" transform="translate(643.657 -185.66) scale(.62815)"></path>
      </svg>
      <div>Etusivu</div>
    </a>
    <nav class="current-topics">
      <a href="#" class="topic-link">Onnettomuudet</a>
      <a href="#" class="topic-link">Livelähetykset</a>
      <a href="#" class="topic-link">Areena</a>
    </nav>
    <div class="header-actions">
      <a href="#" class="login-button">
        <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
          <path fill="currentColor" fill-rule="evenodd" d="M12 2a5 5 0 1 0 0 10 5 5 0 0 0 0-10M9 7a3 3 0 1 1 6 0 3 3 0 0 1-6 0m-2 7a5 5 0 0 0-5 5v2a1 1 0 1 0 2 0v-2a3 3 0 0 1 3-3h10a3 3 0 0 1 3 3v2a1 1 0 1 0 2 0v-2a5 5 0 0 0-5-5z" clip-rule="evenodd"></path>
        </svg>
        <span>Kirjaudu</span>
      </a>
    </div>
  </div>
</header>

<section class="hero">
    <div class="hero-inner">
        <img 
            src="https://vaalit.yle.fi/vaalikone/alue-ja-kuntavaalit2025/vaalilogo_vaaka_fi_darkmode-BDmLbAti.svg" 
            alt="Yle Vaalit logo" 
            style="height: 28px; margin-bottom: 1.5rem; display: block;"
        >
        <h1>Tervetuloa alue- ja kuntavaalien sekä eduskuntavaalien vaalikoneeseen!</h1>
        <p>Yhdistetyt alue- ja kuntavaalit sekä Eduskuntavaalit järjestetään 28. kesäkuuta 2026. Löydä sopivin ehdokas valitsemalla kotikuntasi ja haluamasi vaalikone.</p>
        <p class="italic-note">Voit seurata vaalien tilannetta Ylen alue- ja kuntavaalien 2026 tulospalvelusta ja oman alueen uutisista.</p>

        <div class="selector-box">
            <div class="selector-label">Valitse kotikunta (ei tarvita eduskuntavaaleissa)</div>
            <div class="select-wrap">
                <select id="kotikunta-select">
                    <option value="">Esim. Kuopio</option>
                    <?php
                    require_once 'db.php';
                    $kunnat = $pdo->query("SELECT DISTINCT TRIM(kotikunta) as kotikunta FROM ehdokkaat WHERE kotikunta != '' ORDER BY kotikunta")->fetchAll();
                    foreach ($kunnat as $k) {
                        echo '<option value="'.htmlspecialchars($k['kotikunta']).'">'.htmlspecialchars($k['kotikunta']).'</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Vaalipiiri eduskuntavaaleille -->
            <div class="vaalipiiri-wrap" id="vaalipiiriWrap">
                <div class="selector-label">Vaalipiiri (eduskuntavaalit)</div>
                <div class="select-wrap">
                    <select id="vaalipiiri-select">
                        <option value="Uudenmaan vaalipiiri">Uudenmaan vaalipiiri</option>
                        <option value="Varsinais-Suomen vaalipiiri">Varsinais-Suomen vaalipiiri</option>
                        <option value="Satakunnan vaalipiiri">Satakunnan vaalipiiri</option>
                        <option value="Hämeen vaalipiiri">Hämeen vaalipiiri</option>
                        <option value="Pirkanmaan vaalipiiri">Pirkanmaan vaalipiiri</option>
                        <option value="Kaakkois-Suomen vaalipiiri">Kaakkois-Suomen vaalipiiri</option>
                        <option value="Savo-Karjalan vaalipiiri">Savo-Karjalan vaalipiiri</option>
                        <option value="Vaasan vaalipiiri">Vaasan vaalipiiri</option>
                        <option value="Keski-Suomen vaalipiiri">Keski-Suomen vaalipiiri</option>
                        <option value="Oulun vaalipiiri">Oulun vaalipiiri</option>
                        <option value="Lapin vaalipiiri">Lapin vaalipiiri</option>
                        <option value="Ahvenanmaan vaalipiiri">Ahvenanmaan vaalipiiri</option>
                        <option value="Helsingin vaalipiiri">Helsingin vaalipiiri</option>
                        <option value="Kaikki alueet">Kaikki alueet</option>
                    </select>
                </div>
            </div>

            <div class="btn-row">
                <button class="vaali-btn" id="btn-alue" onclick="goToVaalikone('alue')">
                    Aluevaalikone <span>›</span>
                </button>
                <button class="vaali-btn" id="btn-kunta" onclick="goToVaalikone('kunta')">
                    Kuntavaalikone <span>›</span>
                </button>
                <button class="vaali-btn eduskunta-always" id="btn-eduskunta" onclick="goToVaalikone('eduskunta')">
                    Eduskuntavaalit <span>›</span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="info-section">
    <div class="info-inner">
        <h2>Mikä on vaalikone?</h2>
        <div class="info-grid">
            <div class="info-card">
                <div class="icon">🗳️</div>
                <h3>Löydä sopiva ehdokas</h3>
                <p>Vaalikone auttaa löytämään sinulle sopivimman ehdokkaan vertailemalla vastauksia tärkeisiin kysymyksiin.</p>
            </div>
            <div class="info-card">
                <div class="icon">🏛️</div>
                <h3>Kolme vaalia</h3>
                <p>Kuntavaalit, aluevaalit ja eduskuntavaalit – löydä ehdokkaat kaikista vaaleista samasta paikasta.</p>
            </div>
            <div class="info-card">
                <div class="icon">📍</div>
                <h3>Paikalliset ehdokkaat</h3>
                <p>Näe kaikki kuntasi ehdokkaat, heidän taustansa, lupauksensa ja sijaintinsa poliittisella kartalla.</p>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <p>© 2026 Yle Vaalit · <a href="admin.php">Hallintapaneeli</a></p>
</footer>

<script>
const sel = document.getElementById('kotikunta-select');
const btns = {
    alue: document.getElementById('btn-alue'),
    kunta: document.getElementById('btn-kunta'),
};
const vaalipiiriWrap = document.getElementById('vaalipiiriWrap');
const vaalipiiriSel = document.getElementById('vaalipiiri-select');

sel.addEventListener('change', function() {
    const hasVal = this.value !== '';
    Object.values(btns).forEach(b => {
        b.classList.toggle('active', hasVal);
    });
});

vaalipiiriWrap.classList.add('show');

function goToVaalikone(tyyppi) {
    if (tyyppi === 'eduskunta') {
        const vaalipiiri = vaalipiiriSel.value;
if (vaalipiiri === 'Kaikki alueet') {
    window.location.href = 'vaalikone.php?tyyppi=eduskunta';
} else {
            window.location.href = `vaalikone.php?vaalipiiri=${encodeURIComponent(vaalipiiri)}&tyyppi=eduskunta`;
        }
        return;
    }
    const kunta = sel.value;
    if (!kunta) return;
    window.location.href = `vaalikone.php?kunta=${encodeURIComponent(kunta)}&tyyppi=${tyyppi}`;
}
</script>
</body>
</html>
