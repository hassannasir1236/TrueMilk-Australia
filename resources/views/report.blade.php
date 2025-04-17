@php
    $activePage = 'inventory'; // or 'inventory', 'dashboard', etc.
@endphp
@extends('layouts.app')

@section('content')
   <!-- Reports Section -->
   <section id="reports" class="content-section">
            <div class="state-header">
                <h3>Reports & Analytics</h3>
                <div class="actions">
                    <button class="btn-secondary export-btn" onclick="exportToExcel('all', 'production')">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </button>
                    <button class="btn">
                        <i class="fas fa-plus"></i> Generate New Report
                    </button>
                </div>
            </div>

            <!-- Reports Metrics -->
            <div class="metrics-container">
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="metric-info">
                        <h4>Production Efficiency</h4>
                        <div class="metric-value">92.4%</div>
                        <div class="metric-change up">3.2% from last month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="metric-info">
                        <h4>Total Revenue</h4>
                        <div class="metric-value">$5.28M</div>
                        <div class="metric-change up">4.7% from last month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="metric-info">
                        <h4>Generated Reports</h4>
                        <div class="metric-value">28</div>
                        <div class="metric-change up">5 more this month</div>
                    </div>
                </div>
                <div class="metric-card">
                    <div class="metric-icon"><i class="fas fa-tasks"></i></div>
                    <div class="metric-info">
                        <h4>KPI Achievement</h4>
                        <div class="metric-value">86%</div>
                        <div class="metric-change up">4% this quarter</div>
                    </div>
                </div>
            </div>

            <!-- Available Reports -->
            <div class="data-container">
                <div class="data-card">
                    <h4>Available Reports</h4>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Report Name</th>
                                    <th>Type</th>
                                    <th>Generated Date</th>
                                    <th>Region</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Monthly Production Summary</td>
                                    <td>Production</td>
                                    <td>Mar 15, 2025</td>
                                    <td>All Regions</td>
                                    <td><span class="badge-success">Completed</span></td>
                                    <td>
                                        <button class="btn-icon" onclick="exportToExcel('all', 'production')"><i
                                                class="fas fa-download"></i></button>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quarterly Financial Analysis</td>
                                    <td>Financial</td>
                                    <td>Mar 10, 2025</td>
                                    <td>All Regions</td>
                                    <td><span class="badge-success">Completed</span></td>
                                    <td>
                                        <button class="btn-icon" onclick="exportToExcel('all', 'financial')"><i
                                                class="fas fa-download"></i></button>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supplier Performance Review</td>
                                    <td>Suppliers</td>
                                    <td>Mar 5, 2025</td>
                                    <td>NSW</td>
                                    <td><span class="badge-success">Completed</span></td>
                                    <td>
                                        <button class="btn-icon" onclick="exportToExcel('nsw', 'suppliers')"><i
                                                class="fas fa-download"></i></button>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quality Control Analysis</td>
                                    <td>Quality</td>
                                    <td>Mar 3, 2025</td>
                                    <td>Victoria</td>
                                    <td><span class="badge-success">Completed</span></td>
                                    <td>
                                        <button class="btn-icon" onclick="exportToExcel('victoria', 'quality')"><i
                                                class="fas fa-download"></i></button>
                                        <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Annual Production Report</td>
                                    <td>Production</td>
                                    <td>In Progress</td>
                                    <td>All Regions</td>
                                    <td><span class="badge-warning">Generating</span></td>
                                    <td>
                                        <button class="btn-icon" disabled><i class="fas fa-download"></i></button>
                                        <button class="btn-icon" disabled><i class="fas fa-eye"></i></button>
                                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Data Source Information -->
            <div class="data-source-info">
                <div class="source-header">
                    <h4><i class="fas fa-database"></i> Data Sources</h4>
                </div>
                <div class="source-content">
                    <p>This dashboard utilizes Excel data managed through our Laravel backend. Data is refreshed
                        every 24 hours from our central Excel repository.</p>
                    <div class="source-details">
                        <div class="source-item">
                            <span class="source-label">Last Update:</span>
                            <span class="source-value">Mar 15, 2025 09:15 AM</span>
                        </div>
                        <div class="source-item">
                            <span class="source-label">Data Source:</span>
                            <span class="source-value">MilkProduction_2025.xlsx</span>
                        </div>
                        <div class="source-item">
                            <span class="source-label">Storage Location:</span>
                            <span class="source-value">Excel Database / Q1_2025</span>
                        </div>
                    </div>
                    <!-- Quick Export Options -->
                    <div style="margin-top: 20px;">
                        <h5>Quick Export Options</h5>
                        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;">
                            <button class="btn-secondary" onclick="exportToExcel('all', 'production')">
                                <i class="fas fa-file-excel"></i> Production Report
                            </button>
                            <button class="btn-secondary" onclick="exportToExcel('all', 'suppliers')">
                                <i class="fas fa-file-excel"></i> Supplier Report
                            </button>
                            <button class="btn-secondary" onclick="exportToExcel('all', 'financial')">
                                <i class="fas fa-file-excel"></i> Financial Report
                            </button>
                            <button class="btn-secondary" onclick="exportToExcel('all', 'quality')">
                                <i class="fas fa-file-excel"></i> Quality Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection