@php
    $activePage = $stateId; // or 'inventory', 'dashboard', etc.
@endphp
@extends('layouts.app')

@section('content')
    <section id="" class=""
        style="width: -webkit-fill-available;background: #fff;padding: 25px;border-radius: 10px;margin: 1px 13px 37px 11px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
        <div class="state-header">
            <h3>{{$state->name}} Operations</h3>
            <!-- <div class="actions">
                                            <button class="btn-secondary">
                                                <i class="fas fa-download"></i> Export Data
                                            </button>
                                            <button class="btn">
                                                <i class="fas fa-plus"></i> Add Supplier
                                            </button>
                                        </div> -->
        </div>

        <!-- State Metrics -->
        <div class="metrics-container">
            <div class="metric-card">
                <div class="metric-icon"><i class="fas fa-tint"></i></div>
                <div class="metric-info">
                    <h4>Milk Collection</h4>
                    <div class="metric-value">{{ $totalMilk }} L</div>
                    <div class="metric-change {{ $milkPercentage >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas {{ $milkPercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        {{ abs(round($milkPercentage, 1)) }}% from last month
                    </div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon"><i class="fas fa-cheese"></i></div>
                <div class="metric-info">
                    <h4>Cheese Production</h4>
                    <div class="metric-value">{{ $totalCheese }} kg</div>
                    <div class="metric-change {{ $cheesePercentage >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas {{ $cheesePercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        {{ abs(round($cheesePercentage, 1)) }}% from last month
                    </div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon"><i class="fas fa-users"></i></div>
                <div class="metric-info">
                    <h4>Active Suppliers</h4>
                    <div class="metric-value">{{$totalFarms}} farms</div>
                    <div class="metric-change {{ $farmPercentage >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas {{ $farmPercentage >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                        {{ abs(round($farmPercentage, 1)) }}% from last month
                    </div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon"><i class="fas fa-dollar-sign"></i></div>
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

        <!-- NSW Data -->
        <div class="data-container">
            <div class="data-card">
                <h4>Supplier Breakdown</h4>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Farm Name</th>
                                <th>Location</th>
                                <th>Daily Supply</th>
                                <th>Quantity</th>
                                <th>Last Delivery</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($FarmInventoryData->isNotEmpty())
                                @foreach ($FarmInventoryData as $inventory)
                                    <tr>
                                        <td>{{ $inventory->farm->name ?? 'N/A' }}</td>
                                        <td>{{ $inventory->state->name ?? 'N/A' }}</td>
                                        <td>{{ $inventory->item->name ?? 'N/A' }}</td>
                                        <td>{{ $inventory->quantity }} {{ $inventory->unit }}</td>
                                        <td>{{ $inventory->collected_on }}</td>
                                        <td>
                                            <a href="{{ route('farm-inventory.edit', $inventory->id) }}" class="btn-icon"><i
                                                    class="fas fa-edit"></i></a>
                                            <form action="{{ route('farm-inventory.destroy', $inventory->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon delete-button"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- NSW Charts -->
        <div class="chart-container">
            <div class="chart-card">
                <h4>Daily Collection (Last Week)</h4>
                <div class="chart-wrapper">
                    <canvas id="nswDailyCollectionLastWeakChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h4>Product Distribution</h4>
                <div class="chart-wrapper">
                    <canvas id="nswProductDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- NSW Additional Data -->
        <div class="chart-container">
            <div class="chart-card">
                <h4>Regional Milk Sourcing</h4>
                <div class="data-table-sm">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Region</th>
                                <th>Volume (L/day)</th>
                                <th>Farms</th>
                                <th>Avg. Quality</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hunter Valley</td>
                                <td>8,500 L</td>
                                <td>8</td>
                                <td>A+</td>
                            </tr>
                            <tr>
                                <td>Southern Highlands</td>
                                <td>6,200 L</td>
                                <td>5</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>Northern Rivers</td>
                                <td>7,800 L</td>
                                <td>6</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>Central Coast</td>
                                <td>5,800 L</td>
                                <td>4</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>Blue Mountains</td>
                                <td>3,850 L</td>
                                <td>5</td>
                                <td>B+</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="chart-card">
                <h4>Processing Facilities</h4>
                <div class="data-table-sm">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Facility</th>
                                <th>Location</th>
                                <th>Daily Capacity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sydney Processing Plant</td>
                                <td>Western Sydney</td>
                                <td>25,000 L</td>
                                <td><span class="badge-success">Operational</span></td>
                            </tr>
                            <tr>
                                <td>Hunter Valley Cheese</td>
                                <td>Maitland</td>
                                <td>18,000 L</td>
                                <td><span class="badge-success">Operational</span></td>
                            </tr>
                            <tr>
                                <td>Northern Rivers Plant</td>
                                <td>Lismore</td>
                                <td>15,000 L</td>
                                <td><span class="badge-warning">Maintenance</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Embed JSON data safely -->
    <script id="dailyMilkData" type="application/json">
        {!! json_encode($dailyMilk) !!}
    </script>
    <script id="productDistributionData" type="application/json">
        {!! json_encode($productDistribution) !!}
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dailyMilk = JSON.parse(document.getElementById('dailyMilkData').textContent);
            const productDistribution = JSON.parse(document.getElementById('productDistributionData').textContent);

            // Daily Milk Collection (Line Chart)
            new Chart(document.getElementById('nswDailyCollectionLastWeakChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: dailyMilk.labels,
                    datasets: [{
                        label: 'Milk Collection (Liters)',
                        data: dailyMilk.data,
                        borderColor: '#36A2EB',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Liters'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });

            // Product Distribution (Donut Chart)
            new Chart(document.getElementById('nswProductDistributionChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: productDistribution.labels,
                    datasets: [{
                        data: productDistribution.data,
                        backgroundColor: productDistribution.labels.map(() =>
                            `hsl(${Math.floor(Math.random() * 360)}, 60%, 65%)`
                        ),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>


@endsection