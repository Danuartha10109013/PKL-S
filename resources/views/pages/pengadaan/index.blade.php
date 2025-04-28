@extends('layout.produksi.main')

@section('title')
    Dashboard || Bagian Pengadaan
@endsection

@section('pages')
    Dashboard
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="container ml-2">
        <p class="fs-4">Hello, Selamat Datang <span class="fw-bold">{{ Auth::user()->name }}</span>!</p>

        <div class="row g-4">
            <!-- Total Jobcards -->
            <div class="col-md-6">
                <div class="card text-white bg-primary">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clipboard-list fa-3x"></i>
                        </div>
                        <div>
                            <p class="fs-5 fw-bold">Total Jobcards</p>
                            <p class="fs-3 fw-bold">{{ $totalJobcards }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revisions -->
            <div class="col-md-6">
                <div class="card text-white bg-success">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-boxes fa-3x"></i>
                        </div>
                        <div>
                            <p class="fs-5 fw-bold">Total Material</p>
                            <p class="fs-3 fw-bold">{{ $totalRevisions }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <p class="fw-bold mb-0">Monthly Jobcard Overview</p>
                    </div>
                    <div class="card-body">
                        <canvas id="jobcardChart" width="800" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('jobcardChart').getContext('2d');
    const jobcardChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyJobcardLabels) !!},
            datasets: [{
                label: 'Total Jobcards',
                data: {!! json_encode($monthlyJobcardData) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
            }
        }
    });
</script>

<!-- Font Awesome Script -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
