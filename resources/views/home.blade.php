@extends('layouts.app')

@section('content')
    <!-- Top Header -->
    <header class="top-header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h2 id="section-title">Overview</h2>
        </div>
        <div class="header-right">
            <div class="search-box">
                <input type="text" placeholder="Search...">
                <i class="fas fa-search"></i>
            </div>
            <div class="notification">
                <i class="fas fa-bell"></i>
                <span class="badge">3</span>
            </div>
            <div class="user-profile">
                <img src="public/images/user-avatar.webp" alt="User Profile">
                <div class="user-info">
                    <span class="name">Admin User</span>
                    <span class="role">Administrator</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Content Sections -->
    <div class="content-wrapper">
        <!-- Overview Section -->
        <section id="overview" class="content-section active">
            <div class="overview-header">
                <h3>National Dairy Production</h3>
                <div class="date-picker">
                    <input type="date" value="2025-03-25">
                </div>
            </div>
            <!-- Key Metrics -->
            <div class="metric-cards">
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="metric-info">
                        <h4>Total Milk Collection</h4>
                        <div class="metric-value">{{$totalMilk}} L</div>
                        <div class="metric-change {{ $milkPercentage >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas {{ $milkPercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ abs(round($milkPercentage, 1)) }}% from last month
                        </div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-cheese"></i>
                    </div>
                    <div class="metric-info">
                        <h4>Cheese Production</h4>
                        <div class="metric-value">{{$totalCheese}} kg</div>
                        <div class="metric-change {{ $cheesePercentage >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas {{ $cheesePercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ abs(round($cheesePercentage, 1)) }}% from last month
                        </div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="metric-info">
                        <h4>Supplier Network</h4>
                        <div class="metric-value">{{$totalFarms}} farms</div>
                        <div class="metric-change {{ $farmPercentage >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas {{ $farmPercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ abs(round($farmPercentage, 1)) }}% from last month
                        </div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="metric-info">
                        <h4>Monthly Revenue</h4>
                        <div class="metric-value">${{ $totalPrice }}</div>
                        <div class="metric-change {{ $pricePercentage >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas {{ $pricePercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                            {{ abs(round($pricePercentage, 1)) }}% from last month
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="chart-container">
                <div class="chart-card">
                    <h4>Milk Collection by Region</h4>
                    <div class="chart-wrapper">
                        <canvas id="milkBarChart"></canvas>
                    </div>
                </div>
                <div class="chart-card">
                    <h4>Monthly Production Trend</h4>
                    <div class="chart-wrapper">
                        <canvas id="cheeseLineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="activity-container">
                <h4>Recent Activity</h4>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <div class="activity-details">
                            <h5>New Shipment Received</h5>
                            <p>NSW facility received 5,200 L of milk from Hunter Valley farms</p>
                            <small>Today, 09:45 AM</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="activity-details">
                            <h5>Production Target Reached</h5>
                            <p>Queensland facility reached monthly cheese production target</p>
                            <small>Yesterday, 05:30 PM</small>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="activity-details">
                            <h5>Quality Alert</h5>
                            <p>Victoria facility reported quality issues with milk batch #V23451</p>
                            <small>Yesterday, 11:15 AM</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <script>
        const milkByProvince = {!! json_encode($milkByProvince) !!};
        const cheeseByProvince = {!! json_encode($cheeseByProvince) !!};
        const monthlyProduction = {!! json_encode($monthlyProduction) !!};
        console.log("milkByProvince", milkByProvince);

    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // MILK COLLECTION BAR CHART BY REGION
            const regionLabels = Object.values(milkByProvince).map(item => item.name);
            const milkData = Object.values(milkByProvince).map(item => item.milkCollection);

            new Chart(document.getElementById('milkBarChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: regionLabels,
                    datasets: [{
                        label: 'Milk Collection (Liters)',
                        data: milkData,
                        backgroundColor: regionLabels.map(() =>
                            `hsl(${Math.floor(Math.random() * 360)}, 70%, 60%)`
                        ),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // MONTHLY TREND LINE CHART (MILK & CHEESE)
            new Chart(document.getElementById('cheeseLineChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: monthlyProduction.months,
                    datasets: [
                        {
                            label: 'Milk Production (Liters)',
                            data: monthlyProduction.milk,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: 'Cheese Production (Kg)',
                            data: monthlyProduction.cheese,
                            borderColor: 'rgba(255, 206, 86, 1)',
                            backgroundColor: 'rgba(255, 206, 86, 0.1)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>




@endsection