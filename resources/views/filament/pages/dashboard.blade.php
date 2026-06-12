<x-filament-panels::page>
    <div style="text-align:center;padding:60px 20px">
        <img src="{{ asset('images/logo.png') }}" style="width:80px;height:80px;border-radius:16px;object-fit:cover;margin-bottom:20px">
        <h2 style="font-size:24px;font-weight:700;color:#111827;margin-bottom:8px">Selamat Datang, {{ auth()->user()->name }}!</h2>
        <p style="font-size:14px;color:#6b7280;margin-bottom:32px">Sistem HR Rekruitmen — PT Arisamandiri Pratama</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a href="/" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#f97316;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none">
                📊 Dashboard Analitik
            </a>
            <a href="/reminder-kontrak" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#111827;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none">
                🔔 Reminder Kontrak
            </a>
            <a href="/import" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#0369a1;color:#fff;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none">
                📥 Import Excel
            </a>
        </div>
    </div>
</x-filament-panels::page>
