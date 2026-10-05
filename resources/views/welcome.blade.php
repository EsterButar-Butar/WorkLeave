<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkLeave - Backend Starter API</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background: #0f172a; color: #f8fafc; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 32px; max-width: 640px; width: 100%; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .badge { display: inline-block; padding: 4px 10px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #22c55e20; color: #4ade80; border: 1px solid #22c55e40; border-radius: 9999px; margin-bottom: 16px; }
        h1 { font-size: 26px; font-weight: 800; margin-bottom: 8px; color: #ffffff; }
        p { color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 24px; }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 24px; }
        .box { background: #0f172a80; border: 1px solid #334155; border-radius: 10px; padding: 12px 16px; }
        .box-title { font-size: 11px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 4px; }
        .box-val { font-size: 14px; font-weight: 700; color: #e2e8f0; }
        .endpoints { background: #0f172a; border-radius: 10px; padding: 16px; font-size: 12px; font-family: ui-monospace, SFMono-Regular, Menlo, monospace; color: #cbd5e1; }
        .endpoint-line { padding: 4px 0; border-bottom: 1px solid #1e293b; display: flex; justify-content: space-between; }
        .method { color: #60a5fa; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 12px; color: #64748b; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">● Backend Starter Ready</span>
        <h1>WorkLeave API</h1>
        <p>Sistem Informasi Manajemen Cuti Mitra Kerja — Lingkungan backend dan database siap digunakan untuk integrasi frontend.</p>

        <div class="grid">
            <div class="box">
                <div class="box-title">Framework</div>
                <div class="box-val">Laravel 12 / PHP 8.2</div>
            </div>
            <div class="box">
                <div class="box-title">Database</div>
                <div class="box-val">PostgreSQL (workleave_db)</div>
            </div>
            <div class="box">
                <div class="box-title">Status Auth</div>
                <div class="box-val">Session & Sanctum Ready</div>
            </div>
            <div class="box">
                <div class="box-title">Modul Siap</div>
                <div class="box-val">Leave, Quota, Approval, Recap</div>
            </div>
        </div>

        <div class="endpoints">
            <div style="font-weight: bold; margin-bottom: 8px; color: #38bdf8;">Contoh Endpoint Backend:</div>
            <div class="endpoint-line"><span><span class="method">POST</span> /api/login</span> <span>Autentikasi Akun</span></div>
            <div class="endpoint-line"><span><span class="method">GET</span> /api/dashboard</span> <span>Ringkasan Kuota & Cuti</span></div>
            <div class="endpoint-line"><span><span class="method">GET</span> /api/leave-requests</span> <span>Daftar Pengajuan Cuti</span></div>
            <div class="endpoint-line"><span><span class="method">POST</span> /api/leave-requests</span> <span>Kirim Permohonan Cuti</span></div>
            <div class="endpoint-line"><span><span class="method">POST</span> /api/approvals/{id}/approve</span> <span>Persetujuan Admin</span></div>
            <div class="endpoint-line" style="border: none;"><span><span class="method">GET</span> /api/leave-balances</span> <span>Monitoring Kuota Mitra</span></div>
        </div>

        <div class="footer">
            WorkLeave &copy; {{ date('Y') }} • Project MBKM
        </div>
    </div>
</body>
</html>
