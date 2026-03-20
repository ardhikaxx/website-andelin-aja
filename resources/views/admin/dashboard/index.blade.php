@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Admin')

@push('styles')
<style>
    .metric-card {
        position: relative;
        height: 100%;
        padding: 1.35rem;
        border-radius: 24px;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(248, 250, 255, 0.98));
        border: 1px solid rgba(229, 231, 235, 0.95);
        box-shadow: 0 20px 36px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }
    .metric-card::after {
        content: '';
        position: absolute;
        inset: auto -14px -20px auto;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: rgba(59, 130, 246, 0.06);
    }
    .metric-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        position: relative;
        z-index: 1;
    }
    .metric-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.18rem;
        box-shadow: 0 14px 28px rgba(59, 130, 246, 0.18);
    }
    .metric-icon.blue { background: linear-gradient(135deg, #2563EB, #3B82F6); }
    .metric-icon.orange { background: linear-gradient(135deg, #F59E0B, #F97316); }
    .metric-icon.indigo { background: linear-gradient(135deg, #4F46E5, #6366F1); }
    .metric-icon.green { background: linear-gradient(135deg, #16A34A, #22C55E); }
    .metric-tag {
        display: inline-flex;
        align-items: center;
        padding: .36rem .64rem;
        border-radius: 999px;
        background: rgba(59, 130, 246, 0.08);
        color: #2563EB;
        font-size: .7rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }
    .metric-value {
        margin: 1.15rem 0 .35rem;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(1.7rem, 1.35rem + .6vw, 2.25rem);
        font-weight: 800;
        line-height: 1;
        letter-spacing: -.04em;
        position: relative;
        z-index: 1;
    }
    .metric-title {
        margin: 0;
        color: var(--color-text-primary);
        font-size: 1rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    .metric-text {
        margin: .45rem 0 0;
        color: var(--color-text-secondary);
        line-height: 1.7;
        font-size: .84rem;
        position: relative;
        z-index: 1;
    }
    .dashboard-panel {
        height: auto;
        padding: 1.45rem;
        border-radius: 26px;
        background: rgba(255, 255, 255, 0.97);
        border: 1px solid rgba(229, 231, 235, 0.95);
        box-shadow: 0 20px 36px rgba(15, 23, 42, 0.06);
    }
    .panel-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.2rem;
    }
    .panel-title {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 800;
        letter-spacing: -.02em;
    }
    .panel-subtitle {
        margin: .28rem 0 0;
        color: var(--color-text-secondary);
        font-size: .85rem;
        line-height: 1.7;
    }
    .panel-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .44rem .72rem;
        border-radius: 999px;
        background: rgba(59, 130, 246, 0.08);
        color: #2563EB;
        font-size: .72rem;
        font-weight: 800;
        white-space: nowrap;
    }
    .task-name {
        font-weight: 700;
        color: var(--color-text-primary);
    }
    .task-meta {
        display: block;
        margin-top: .28rem;
        color: var(--color-text-muted);
        font-size: .78rem;
    }
    .owner-list {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
    }
    .owner-pill {
        display: inline-flex;
        align-items: center;
        gap: .38rem;
        padding: .36rem .6rem;
        border-radius: 999px;
        background: rgba(59, 130, 246, 0.08);
        color: #2563EB;
        font-size: .74rem;
        font-weight: 700;
    }
    .deadline-box {
        display: inline-flex;
        flex-direction: column;
        gap: .18rem;
    }
    .deadline-date {
        color: var(--color-text-primary);
        font-weight: 700;
        font-size: .88rem;
    }
    .deadline-note {
        color: var(--color-text-muted);
        font-size: .76rem;
    }
    .status-chip {
        display: inline-flex;
        align-items: center;
        gap: .42rem;
        padding: .42rem .72rem;
        border-radius: 999px;
        font-size: .74rem;
        font-weight: 800;
    }
    .status-chip.pending {
        background: rgba(245, 158, 11, 0.12);
        color: #B45309;
    }
    .status-chip.progress {
        background: rgba(14, 165, 233, 0.12);
        color: #0369A1;
    }
    .status-chip.done {
        background: rgba(34, 197, 94, 0.12);
        color: #15803D;
    }
    .chart-wrap {
        position: relative;
        height: 260px;
        max-height: 260px;
    }
    .chart-center-note {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -.4rem;
        color: var(--color-text-secondary);
        font-size: .82rem;
    }
    .performance-list {
        display: grid;
        gap: .75rem;
        margin-top: 1.15rem;
    }
    .performance-item {
        display: flex;
        align-items: center;
        gap: .8rem;
        padding: .85rem .95rem;
        border-radius: 18px;
        background: #F8FAFC;
        border: 1px solid rgba(226, 232, 240, 0.95);
    }
    .performance-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .performance-content {
        min-width: 0;
        flex: 1;
    }
    .performance-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin: 0;
        color: var(--color-text-primary);
        font-size: .88rem;
        font-weight: 700;
    }
    .performance-desc {
        margin: .22rem 0 0;
        color: var(--color-text-secondary);
        font-size: .78rem;
        line-height: 1.6;
    }
    .quick-actions {
        display: grid;
        gap: .85rem;
        margin-top: 1.15rem;
    }
    .quick-action {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: 1rem;
        border-radius: 20px;
        background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);
        border: 1px solid rgba(226, 232, 240, 0.95);
        color: var(--color-text-primary);
        transition: all .2s ease;
    }
    .quick-action:hover {
        transform: translateY(-1px);
        border-color: rgba(96, 165, 250, 0.55);
        box-shadow: 0 14px 26px rgba(59, 130, 246, 0.08);
        color: var(--color-primary);
    }
    .quick-action-icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 14px 22px rgba(59, 130, 246, 0.14);
    }
    .quick-action-icon.blue { background: linear-gradient(135deg, #2563EB, #3B82F6); }
    .quick-action-icon.green { background: linear-gradient(135deg, #16A34A, #22C55E); }
    .quick-action-icon.dark { background: linear-gradient(135deg, #0F172A, #334155); }
    .quick-action-title {
        margin: 0;
        font-size: .92rem;
        font-weight: 800;
    }
    .quick-action-text {
        display: block;
        margin: .25rem 0 0;
        color: var(--color-text-secondary);
        font-size: .79rem;
        line-height: 1.6;
    }
    .panel-footer-link {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        margin-top: 1.2rem;
        color: #2563EB;
        font-weight: 700;
    }
    @media (max-width: 991.98px) {
        .dashboard-panel,
        .metric-card {
            border-radius: 22px;
        }
        .chart-wrap {
            height: 240px;
        }
    }
    @media (max-width: 575.98px) {
        .dashboard-panel,
        .metric-card {
            padding: 1.15rem;
        }
        .quick-actions {
            grid-template-columns: 1fr;
        }
        .quick-action {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-icon blue"><i class="fas fa-users"></i></span>
                <span class="metric-tag">Metrik Utama</span>
            </div>
            <div class="metric-value">{{ number_format($stats['employees']) }} <small style="font-size: .44em; color: var(--color-text-muted); font-weight: 700;">orang</small></div>
            <p class="metric-title">Total Karyawan</p>
            <p class="metric-text">Jumlah seluruh karyawan aktif yang terdaftar di sistem operasional.</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-icon orange"><i class="fas fa-list-check"></i></span>
                <span class="metric-tag">Tugas Aktif</span>
            </div>
            <div class="metric-value">{{ number_format($stats['active_tasks']) }} <small style="font-size: .44em; color: var(--color-text-muted); font-weight: 700;">tugas</small></div>
            <p class="metric-title">Tugas Aktif</p>
            <p class="metric-text">Akumulasi tugas berstatus tertunda dan sedang berjalan yang masih dipantau.</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-icon indigo"><i class="fas fa-microchip"></i></span>
                <span class="metric-tag">Greedy</span>
            </div>
            <div class="metric-value">{{ number_format($stats['greedy_schedules']) }} <small style="font-size: .44em; color: var(--color-text-muted); font-weight: 700;">tugas</small></div>
            <p class="metric-title">Tugas Terjadwal Otomatis</p>
            <p class="metric-text">Jumlah tugas yang berhasil dijadwalkan otomatis oleh sistem Greedy.</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="metric-card">
            <div class="metric-top">
                <span class="metric-icon green"><i class="fas fa-star"></i></span>
                <span class="metric-tag">Keahlian</span>
            </div>
            <div class="metric-value">{{ number_format($stats['specializations']) }} <small style="font-size: .44em; color: var(--color-text-muted); font-weight: 700;">jenis</small></div>
            <p class="metric-title">Total Keahlian</p>
            <p class="metric-text">Jenis keahlian yang sudah terdokumentasi untuk mendukung penugasan tim.</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Daftar Tugas Terbaru</h2>
                    <p class="panel-subtitle">Memantau nama tugas, penanggung jawab, tenggat waktu, dan status secara ringkas.</p>
                </div>
                <span class="panel-badge"><i class="fas fa-clock-rotate-left"></i> {{ $recentTasks->count() }} Tugas</span>
            </div>
            <div class="table-responsive">
                <table class="table table-andelin align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Tugas</th>
                            <th>Penanggung Jawab</th>
                            <th>Tenggat Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTasks as $task)
                        <tr>
                            <td>
                                <span class="task-name">{{ \Illuminate\Support\Str::limit($task->title, 46) }}</span>
                                <span class="task-meta">Dibuat {{ $task->created_at->translatedFormat('d M Y') }}</span>
                            </td>
                            <td>
                                <div class="owner-list">
                                    @forelse($task->employees->take(2) as $employee)
                                        <span class="owner-pill"><i class="fas fa-user"></i> {{ $employee->user?->name ?? '-' }}</span>
                                    @empty
                                        <span class="owner-pill"><i class="fas fa-user-slash"></i> Belum ada PIC</span>
                                    @endforelse
                                    @if($task->employees->count() > 2)
                                        <span class="owner-pill">+{{ $task->employees->count() - 2 }} lainnya</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="deadline-box">
                                    <span class="deadline-date">{{ optional($task->deadline)->translatedFormat('d M Y') ?? '-' }}</span>
                                    <span class="deadline-note">Batas akhir tugas</span>
                                </span>
                            </td>
                            <td>
                                @if($task->status === 'pending')
                                    <span class="status-chip pending"><i class="fas fa-hourglass-half"></i> Tertunda</span>
                                @elseif($task->status === 'in_progress')
                                    <span class="status-chip progress"><i class="fas fa-spinner"></i> Berjalan</span>
                                @else
                                    <span class="status-chip done"><i class="fas fa-circle-check"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block" style="color: #CBD5E1;"></i>
                                    Belum ada tugas terbaru yang bisa ditampilkan.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('admin.tasks.index') }}" class="panel-footer-link"><i class="fas fa-arrow-right"></i> Lihat semua tugas</a>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="dashboard-panel mb-4">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Visualisasi Performa</h2>
                    <p class="panel-subtitle">Ringkasan performa karyawan berdasarkan status tugas yang sedang mereka tangani.</p>
                </div>
                <span class="panel-badge"><i class="fas fa-chart-pie"></i> Donut Chart</span>
            </div>
            <div class="chart-wrap">
                <canvas id="performanceChart"></canvas>
            </div>
            <div class="chart-center-note">Distribusi tugas selesai, berjalan, dan tertunda.</div>
            <div class="performance-list">
                @foreach($performanceSummary as $item)
                <div class="performance-item">
                    <span class="performance-dot" style="background: {{ $item['color'] }};"></span>
                    <div class="performance-content">
                        <p class="performance-label">
                            <span>{{ $item['label'] }}</span>
                            <span>{{ number_format($item['value']) }}</span>
                        </p>
                        <p class="performance-desc">{{ $item['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h2 class="panel-title">Tindakan Cepat</h2>
                    <p class="panel-subtitle">Pintasan langsung untuk aksi operasional yang paling sering dibutuhkan admin.</p>
                </div>
                <span class="panel-badge"><i class="fas fa-bolt"></i> Shortcut</span>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.employees.create') }}" class="quick-action">
                    <span class="quick-action-icon blue"><i class="fas fa-user-plus"></i></span>
                    <span>
                        <span class="quick-action-title">Tambah Karyawan Baru</span>
                        <span class="quick-action-text">Daftarkan personel baru agar langsung masuk ke data operasional.</span>
                    </span>
                </a>
                <a href="{{ route('admin.tasks.create') }}" class="quick-action">
                    <span class="quick-action-icon green"><i class="fas fa-square-plus"></i></span>
                    <span>
                        <span class="quick-action-title">Buat Tugas Baru</span>
                        <span class="quick-action-text">Susun tugas baru lalu lanjutkan ke proses penugasan atau penjadwalan.</span>
                    </span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="quick-action">
                    <span class="quick-action-icon dark"><i class="fas fa-chart-column"></i></span>
                    <span>
                        <span class="quick-action-title">Lihat Laporan</span>
                        <span class="quick-action-text">Buka rekap operasional dan laporan performa secara langsung.</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    const performanceChartContext = document.getElementById('performanceChart');

    if (performanceChartContext) {
        new Chart(performanceChartContext, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($performanceChart['labels']) !!},
                datasets: [{
                    data: {!! json_encode($performanceChart['values']) !!},
                    backgroundColor: {!! json_encode($performanceChart['colors']) !!},
                    borderColor: '#FFFFFF',
                    borderWidth: 6,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleColor: '#FFFFFF',
                        bodyColor: '#E2E8F0',
                        padding: 12,
                        displayColors: true
                    }
                }
            }
        });
    }
</script>
@endpush