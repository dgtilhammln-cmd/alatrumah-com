<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Website Sedang Dalam Pembaruan</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body {
      min-height: 100%;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #F0F4FF;
      color: #1E293B;
    }

    /* Animated gradient bg */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background: linear-gradient(135deg, #EFF6FF 0%, #F0F4FF 40%, #EDE9FE 100%);
      z-index: 0;
    }

    .page {
      position: relative;
      z-index: 1;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1.25rem;
    }

    .card {
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255,255,255,0.9);
      border-radius: 28px;
      padding: 3rem 2.5rem;
      max-width: 520px;
      width: 100%;
      text-align: center;
      box-shadow: 0 20px 60px rgba(59,130,246,0.1), 0 4px 16px rgba(0,0,0,0.06);
    }

    /* Icon */
    .icon-wrap {
      width: 88px;
      height: 88px;
      background: linear-gradient(135deg, #3B82F6, #6366F1);
      border-radius: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.75rem;
      box-shadow: 0 8px 24px rgba(99,102,241,0.3);
      animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    /* Badge */
    .badge {
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      background: #FEF9C3;
      border: 1.5px solid #FDE047;
      color: #854D0E;
      font-size: .7rem;
      font-weight: 800;
      padding: .3rem .875rem;
      border-radius: 100px;
      letter-spacing: .05em;
      text-transform: uppercase;
      margin-bottom: 1.25rem;
    }
    .badge-dot {
      width: 6px; height: 6px;
      background: #EAB308;
      border-radius: 50%;
      animation: pulse-dot 1.2s infinite;
    }
    @keyframes pulse-dot {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: .5; transform: scale(.7); }
    }

    h1 {
      font-size: 1.625rem;
      font-weight: 900;
      color: #0F172A;
      line-height: 1.25;
      margin-bottom: .75rem;
      letter-spacing: -.03em;
    }

    .desc {
      font-size: .925rem;
      color: #64748B;
      line-height: 1.7;
      margin-bottom: 2rem;
    }
    .desc strong { color: #334155; font-weight: 700; }

    /* Divider */
    .divider {
      border: none;
      border-top: 1.5px dashed #E2E8F0;
      margin: 0 0 1.75rem;
    }

    /* Contact CTA */
    .contact-label {
      font-size: .75rem;
      font-weight: 700;
      color: #94A3B8;
      text-transform: uppercase;
      letter-spacing: .07em;
      margin-bottom: 1rem;
    }

    .contact-card {
      display: flex;
      align-items: center;
      gap: 1rem;
      background: #F8FAFC;
      border: 1.5px solid #E2E8F0;
      border-radius: 16px;
      padding: 1.125rem 1.25rem;
      text-decoration: none;
      color: inherit;
      transition: all .25s;
      margin-bottom: .75rem;
    }
    .contact-card:hover {
      border-color: #3B82F6;
      background: #EFF6FF;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(59,130,246,0.12);
    }
    .contact-icon {
      width: 44px; height: 44px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .contact-text-label { font-size: .7rem; color: #94A3B8; font-weight: 600; text-align: left; }
    .contact-text-value { font-size: .95rem; font-weight: 800; color: #0F172A; text-align: left; }

    .wa-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: .625rem;
      width: 100%;
      padding: .875rem;
      background: linear-gradient(135deg, #25D366, #128C7E);
      color: #fff;
      font-size: 1rem;
      font-weight: 800;
      border: none;
      border-radius: 14px;
      text-decoration: none;
      transition: all .25s;
      box-shadow: 0 4px 16px rgba(37,211,102,0.25);
      cursor: pointer;
    }
    .wa-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(37,211,102,0.35);
    }

    /* Footer */
    .footer-note {
      font-size: .72rem;
      color: #CBD5E1;
      margin-top: 2rem;
    }
    .footer-note a { color: #93C5FD; text-decoration: none; }

    /* Responsive */
    @media (max-width: 480px) {
      .card { padding: 2rem 1.5rem; border-radius: 20px; }
      h1 { font-size: 1.375rem; }
      .icon-wrap { width: 72px; height: 72px; border-radius: 20px; }
    }
  </style>
</head>
<body>
<div class="page">
  <div class="card">

    <div class="icon-wrap">
      <svg width="40" height="40" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
        <path d="M7 11V7a5 5 0 0110 0v4"/>
      </svg>
    </div>

    <div class="badge">
      <span class="badge-dot"></span>
      Pembaruan Layanan
    </div>

    <h1>Website Sedang Dalam Proses Pembaruan</h1>

    <p class="desc">
      Halo! Website Anda saat ini sedang kami <strong>perbarui dan tingkatkan</strong>.<br>
      Untuk melanjutkan layanan, silakan hubungi tim kami di <strong>HVM Digital</strong> — kami siap membantu Anda dengan cepat dan ramah. 🙏
    </p>

    <hr class="divider">

    <div class="contact-label">Hubungi Kami Sekarang</div>

    <a href="https://wa.me/6285179982373?text=Halo+HVM+Digital%2C+saya+ingin+menanyakan+perpanjangan+layanan+website+saya." class="wa-btn" target="_blank">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="white">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
      </svg>
      Hubungi HVM Digital via WhatsApp
    </a>

    <div class="footer-note">
      Powered by <a href="https://hvmdigital.id" target="_blank">HVM Digital</a> &mdash; Jasa Pembuatan Website Profesional
    </div>

  </div>
</div>
</body>
</html>
