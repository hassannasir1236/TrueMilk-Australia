@php
    $activePage = $stateId; // or 'inventory', 'dashboard', etc.
@endphp
@extends('layouts.app')

@section('content')
    <section id="" class="" style="width: -webkit-fill-available;background: #fff;padding: 25px;border-radius: 10px;margin: 1px 13px 37px 11px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
            <div class="state-header">
                <h3>New South Wales Operations</h3>
                <div class="actions">
                    <button class="btn-secondary">
                        <i class="fas fa-download"></i> Export Data
                    </button>
                    <button class="btn">
                        <i class="fas fa-plus"></i> Add Supplier
                    </button>
                </div>
            </div>

            <!-- State Metrics -->
            <div class="metrics-container">
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-tint"></i></div>
                    <div class="metric-info">
                        <h4>Milk Collection</h4>
                        <div class="metric-value">42,150 L</div>
                        <div class="metric-change up">6.8% from last month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-cheese"></i></div>
                    <div class="metric-info">
                        <h4>Cheese Production</h4>
                        <div class="metric-value">5,840 kg</div>
                        <div class="metric-change up">4.2% from last month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-users"></i></div>
                    <div class="metric-info">
                        <h4>Active Suppliers</h4>
                        <div class="metric-value">28 farms</div>
                        <div class="metric-change up">2 new this month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-industry"></i></div>
                    <div class="metric-info">
                        <h4>Processing Capacity</h4>
                        <div class="metric-value">85% utilized</div>
                        <div class="metric-change neutral">No change</div>
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
                                    <th>Quality Rating</th>
                                    <th>Last Delivery</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Hunter Valley Dairy</td>
                                    <td>Hunter Region</td>
                                    <td>2,450 L</td>
                                    <td><span class="badge-success">A+</span></td>
                                    <td>Today</td>
                                    <td>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Southern Highlands Farm</td>
                                    <td>Bowral</td>
                                    <td>1,850 L</td>
                                    <td><span class="badge-success">A</span></td>
                                    <td>Yesterday</td>
                                    <td>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Central Coast Dairy</td>
                                    <td>Gosford</td>
                                    <td>1,720 L</td>
                                    <td><span class="badge-success">A</span></td>
                                    <td>Today</td>
                                    <td>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Northern Rivers Cooperative</td>
                                    <td>Lismore</td>
                                    <td>2,100 L</td>
                                    <td><span class="badge-success">A+</span></td>
                                    <td>2 days ago</td>
                                    <td>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Blue Mountains Dairy</td>
                                    <td>Katoomba</td>
                                    <td>1,550 L</td>
                                    <td><span class="badge-warning">B+</span></td>
                                    <td>Today</td>
                                    <td>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
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
                        <canvas id="nswDailyCollectionChart"></canvas>
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
@endsection