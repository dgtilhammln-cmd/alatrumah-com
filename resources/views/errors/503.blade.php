<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Website Sedang Dalam Pembaruan — HVM Digital</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --blue-50:  #EFF6FF;
      --blue-100: #DBEAFE;
      --blue-400: #60A5FA;
      --blue-500: #3B82F6;
      --blue-600: #2563EB;
      --blue-700: #1D4ED8;
      --blue-900: #1E3A8A;
      --slate-50:  #F8FAFC;
      --slate-100: #F1F5F9;
      --slate-200: #E2E8F0;
      --slate-300: #CBD5E1;
      --slate-400: #94A3B8;
      --slate-500: #64748B;
      --slate-700: #334155;
      --slate-900: #0F172A;
    }

    html, body {
      height: 100%;
      font-family: 'Montserrat', sans-serif;
      font-weight: 300;
      background: var(--slate-900);
      color: var(--slate-900);
      overflow: hidden;
    }

    /* ─── FULL-SCREEN TWO-COLUMN LAYOUT ─── */
    .layout {
      display: grid;
      grid-template-columns: 1fr 1fr;
      height: 100vh;
      width: 100vw;
    }

    /* ─── LEFT PANEL — dark blue brand side ─── */
    .panel-left {
      position: relative;
      background: linear-gradient(155deg, #0F172A 0%, #1E3A8A 60%, #1D4ED8 100%);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3.5rem 4rem;
      overflow: hidden;
    }

    /* Decorative circles */
    .panel-left::before {
      content: '';
      position: absolute;
      width: 500px; height: 500px;
      border-radius: 50%;
      border: 1px solid rgba(96,165,250,0.12);
      top: -120px; right: -120px;
    }
    .panel-left::after {
      content: '';
      position: absolute;
      width: 340px; height: 340px;
      border-radius: 50%;
      border: 1px solid rgba(96,165,250,0.08);
      bottom: -80px; left: -80px;
    }
    .deco-ring {
      position: absolute;
      width: 220px; height: 220px;
      border-radius: 50%;
      border: 1px solid rgba(96,165,250,0.06);
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
    }

    /* Brand logo top */
    .brand {
      position: relative;
      z-index: 2;
      display: flex;
      align-items: center;
      gap: .75rem;
    }
    .brand-icon {
      width: 36px; height: 36px;
      background: rgba(96,165,250,0.15);
      border: 1px solid rgba(96,165,250,0.3);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
    }
    .brand-name {
      font-size: .8rem;
      font-weight: 500;
      color: rgba(255,255,255,0.6);
      letter-spacing: .1em;
      text-transform: uppercase;
    }

    /* Main left content */
    .left-main {
      position: relative;
      z-index: 2;
    }

    /* Status badge */
    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      background: rgba(96,165,250,0.1);
      border: 1px solid rgba(96,165,250,0.25);
      border-radius: 100px;
      padding: .375rem 1rem;
      margin-bottom: 2rem;
    }
    .status-dot {
      width: 6px; height: 6px;
      background: #FCD34D;
      border-radius: 50%;
      animation: pulse-y 1.5s ease-in-out infinite;
    }
    @keyframes pulse-y {
      0%, 100% { opacity: 1; }
      50% { opacity: .3; }
    }
    .status-text {
      font-size: .65rem;
      font-weight: 500;
      color: rgba(255,255,255,0.55);
      letter-spacing: .1em;
      text-transform: uppercase;
    }

    /* Headline */
    .headline {
      font-size: clamp(2rem, 3.5vw, 3.25rem);
      font-weight: 200;
      color: #fff;
      line-height: 1.15;
      letter-spacing: -.03em;
      margin-bottom: 1.5rem;
    }
    .headline strong {
      font-weight: 600;
      color: var(--blue-400);
    }

    /* Subtext */
    .subtext {
      font-size: .875rem;
      font-weight: 300;
      color: rgba(255,255,255,0.45);
      line-height: 1.8;
      max-width: 380px;
    }

    /* Left footer */
    .left-footer {
      position: relative;
      z-index: 2;
    }
    .lic-info {
      display: flex;
      align-items: center;
      gap: .625rem;
      border-top: 1px solid rgba(255,255,255,0.07);
      padding-top: 1.5rem;
    }
    .lic-info-text {
      font-size: .72rem;
      font-weight: 300;
      color: rgba(255,255,255,0.3);
      line-height: 1.6;
    }

    /* ─── RIGHT PANEL — light action side ─── */
    .panel-right {
      background: var(--slate-50);
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 4rem 4.5rem;
      position: relative;
    }

    /* Grid pattern overlay */
    .panel-right::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image:
        linear-gradient(rgba(59,130,246,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(59,130,246,0.04) 1px, transparent 1px);
      background-size: 32px 32px;
      pointer-events: none;
    }

    .right-inner { position: relative; z-index: 1; }

    /* Step indicator */
    .step-label {
      font-size: .65rem;
      font-weight: 500;
      color: var(--blue-500);
      letter-spacing: .12em;
      text-transform: uppercase;
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      gap: .5rem;
    }
    .step-label::before {
      content: '';
      display: block;
      width: 24px; height: 1px;
      background: var(--blue-400);
    }

    /* Right headline */
    .right-h2 {
      font-size: clamp(1.25rem, 2.2vw, 1.875rem);
      font-weight: 300;
      color: var(--slate-900);
      line-height: 1.3;
      letter-spacing: -.025em;
      margin-bottom: .875rem;
    }
    .right-h2 span { font-weight: 600; color: var(--blue-600); }

    .right-desc {
      font-size: .825rem;
      font-weight: 300;
      color: var(--slate-500);
      line-height: 1.75;
      margin-bottom: 2.5rem;
      max-width: 400px;
    }

    /* Contact block */
    .contact-block {
      background: #fff;
      border: 1px solid var(--slate-200);
      border-radius: 16px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1.25rem;
    }
    .contact-avatar {
      width: 48px; height: 48px;
      background: var(--blue-50);
      border: 1px solid var(--blue-100);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .contact-info-label {
      font-size: .65rem;
      font-weight: 500;
      color: var(--slate-400);
      letter-spacing: .07em;
      text-transform: uppercase;
      margin-bottom: .2rem;
    }
    .contact-info-val {
      font-size: .925rem;
      font-weight: 600;
      color: var(--slate-900);
      letter-spacing: -.01em;
    }
    .contact-info-sub {
      font-size: .75rem;
      font-weight: 300;
      color: var(--slate-400);
      margin-top: .15rem;
    }

    /* WA Button */
    .wa-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .75rem;
      width: 100%;
      padding: 1rem 1.5rem;
      background: linear-gradient(135deg, #22C55E, #16A34A);
      color: #fff;
      font-family: 'Montserrat', sans-serif;
      font-size: .875rem;
      font-weight: 500;
      letter-spacing: .02em;
      border: none;
      border-radius: 12px;
      text-decoration: none;
      cursor: pointer;
      transition: all .25s cubic-bezier(.4,0,.2,1);
      box-shadow: 0 4px 20px rgba(34,197,94,0.2);
    }
    .wa-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(34,197,94,0.3);
    }
    .wa-btn svg { flex-shrink: 0; }

    /* Divider */
    .or-divider {
      display: flex;
      align-items: center;
      gap: .75rem;
      margin: 1rem 0;
    }
    .or-divider::before, .or-divider::after {
      content: ''; flex: 1;
      height: 1px; background: var(--slate-200);
    }
    .or-divider span {
      font-size: .7rem;
      font-weight: 400;
      color: var(--slate-400);
      letter-spacing: .05em;
    }

    /* Phone CTA */
    .phone-cta {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .625rem;
      width: 100%;
      padding: .875rem;
      background: transparent;
      border: 1px solid var(--slate-200);
      border-radius: 12px;
      text-decoration: none;
      font-family: 'Montserrat', sans-serif;
      font-size: .825rem;
      font-weight: 400;
      color: var(--slate-700);
      transition: all .2s;
    }
    .phone-cta:hover {
      border-color: var(--blue-400);
      color: var(--blue-600);
      background: var(--blue-50);
    }

    /* Footer */
    .right-footer {
      margin-top: 2.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--slate-200);
      font-size: .7rem;
      font-weight: 300;
      color: var(--slate-400);
    }
    .right-footer a { color: var(--blue-500); text-decoration: none; font-weight: 400; }
    .right-footer a:hover { text-decoration: underline; }

    /* ─── MOBILE ─── */
    @media (max-width: 768px) {
      html, body { overflow: auto; }

      .layout {
        grid-template-columns: 1fr;
        height: auto;
        min-height: 100vh;
      }

      .panel-left {
        padding: 2.5rem 2rem;
        min-height: 45vh;
      }

      .headline { font-size: 2rem; }

      .panel-right {
        padding: 2.5rem 1.75rem;
      }

      .right-h2 { font-size: 1.375rem; }
    }
  </style>
</head>
<body>

<div class="layout">

  <!-- ═══ LEFT PANEL ═══ -->
  <div class="panel-left">
    <div class="deco-ring"></div>

    <!-- Brand -->
    <div class="brand">
      <div class="brand-icon">
        <svg width="18" height="18" fill="none" stroke="rgba(96,165,250,0.9)" stroke-width="1.5" viewBox="0 0 24 24">
          <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
        </svg>
      </div>
      <span class="brand-name">HVM Digital</span>
    </div>

    <!-- Main content -->
    <div class="left-main">
      <div class="status-pill">
        <span class="status-dot"></span>
        <span class="status-text">Pembaruan Layanan</span>
      </div>

      <h1 class="headline">
        Layanan<br>
        sedang dalam<br>
        <strong>pembaruan.</strong>
      </h1>

      <p class="subtext">
        Website Anda saat ini dalam proses pembaruan untuk memberikan pengalaman yang lebih baik.
        Tim kami siap membantu Anda melanjutkan layanan.
      </p>
    </div>

    <!-- Left footer -->
    <div class="left-footer">
      <div class="lic-info">
        <svg width="14" height="14" fill="none" stroke="rgba(255,255,255,0.25)" stroke-width="1.5" viewBox="0 0 24 24">
          <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
        </svg>
        <span class="lic-info-text">
          Layanan beroperasi normal setelah perpanjangan dikonfirmasi oleh tim kami.
        </span>
      </div>
    </div>
  </div>

  <!-- ═══ RIGHT PANEL ═══ -->
  <div class="panel-right">
    <div class="right-inner">

      <div class="step-label">Langkah berikutnya</div>

      <h2 class="right-h2">
        Hubungi kami untuk<br>
        <span>melanjutkan layanan</span>
      </h2>

      <p class="right-desc">
        Proses perpanjangan berlangsung cepat. Setelah konfirmasi pembayaran,
        website Anda akan aktif kembali dalam waktu singkat.
      </p>

      <!-- Contact Info -->
      <div class="contact-block">
        <div class="contact-avatar">
          <svg width="22" height="22" fill="none" stroke="var(--blue-500)" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
        </div>
        <div>
          <div class="contact-info-label">Hubungi Tim Kami</div>
          <div class="contact-info-val">HVM Digital</div>
          <div class="contact-info-sub">Layanan Perpanjangan Website Profesional</div>
        </div>
      </div>

      <!-- WhatsApp Button -->
      <a href="https://wa.me/6285179982373?text=Halo+HVM+Digital%2C+saya+ingin+menanyakan+perpanjangan+layanan+website+saya."
         class="wa-btn" target="_blank" rel="noopener">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        Chat WhatsApp — 0851 7998 2373
      </a>

      <div class="or-divider"><span>atau</span></div>

      <!-- Phone -->
      <a href="tel:+6285179982373" class="phone-cta">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.41 11a19.79 19.79 0 01-3.07-8.67A2 2 0 012.32 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 9.91a16 16 0 006.06 6.06l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
        </svg>
        Telepon: +62 851-7998-2373
      </a>

      <!-- Footer -->
      <div class="right-footer">
        Powered by <a href="https://hvmdigital.id" target="_blank" rel="noopener">HVM Digital</a>
        &mdash; Jasa Pembuatan & Perawatan Website Profesional
        <span style="margin: 0 .375rem; color: var(--slate-300);">·</span>
        <span style="color: var(--blue-400);">503 Service Unavailable</span>
      </div>

    </div>
  </div>

</div>

</body>
</html>
