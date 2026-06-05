@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h2 class="fw-bold text-white mb-1">System Overview</h2>
        <p class="text-secondary small">Real-time music metrics & application reporting</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 d-flex">
            <div class="custom-dashboard-card flex-fill d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary text-uppercase small fw-bold tracking-wider" style="font-size: 0.8rem;">Platform Users</span>
                    <h1 class="fw-bold text-white mt-2 mb-0 display-4">{{ $userCount }}</h1>
                </div>
                <div class="card-icon-round">
                    <i class="fa-solid fa-users-line fa-lg"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex">
            <div class="custom-dashboard-card flex-fill d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary text-uppercase small fw-bold tracking-wider" style="font-size: 0.8rem;">Total Track Records</span>
                    <h1 class="fw-bold text-white mt-2 mb-0 display-4">{{ $songCount }}</h1>
                </div>
                <div class="card-icon-round">
                    <i class="fa-solid fa-music fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-dashboard-card">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold text-pink mb-0">
                <i class="fa-solid fa-chart-line me-2"></i> System Growth Reports
            </h5>
            <span style="border: 1px solid #ff4da6; color: #ff4da6; font-size: 0.8rem; padding: 0.35rem 1.25rem; border-radius: 6px; font-weight: 500;">
                Live Report
            </span>
        </div>
        <div style="height: 340px; position: relative;">
            <canvas id="growthReportChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('growthReportChart').getContext('2d');
        const liveUserCount = parseInt("{{ $userCount }}") || 0;
        const liveSongCount = parseInt("{{ $songCount }}") || 0;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Current'],
                datasets: [
                    {
                        label: 'Registered Users',
                        data: [1, 2, 5, 8, 12, liveUserCount],
                        borderColor: '#ff4da6',
                        backgroundColor: 'rgba(255, 77, 166, 0.05)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ff4da6',
                        pointBorderColor: '#ff4da6'
                    },
                    {
                        label: 'Music Track Records',
                        data: [0, 5, 14, 22, 35, liveSongCount],
                        borderColor: '#00f0ff',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.4,
                        pointBackgroundColor: '#00f0ff',
                        pointBorderColor: '#00f0ff'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { color: '#ffffff', font: { family: 'Segoe UI', size: 12 } }
                    }
                },
                scales: {
                    x: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#8c8c8c' } },
                    y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#8c8c8c' }, suggestedMax: Math.max(liveUserCount, liveSongCount) + 10 }
                }
            }
        });
    });
</script>
@endsection