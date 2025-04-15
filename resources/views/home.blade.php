@extends('layouts.app')

@section('content')
<div class="dashboard-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>Australian<span>Dairy</span></h1>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li class="active" data-section="overview">
                        <a href="#overview">
                            <i class="fas fa-home"></i>
                            <span>Overview</span>
                        </a>
                    </li>
                    <li data-section="nsw">
                        <a href="#nsw">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>New South Wales</span>
                        </a>
                    </li>
                    <li data-section="queensland">
                        <a href="#queensland">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Queensland</span>
                        </a>
                    </li>
                    <li data-section="wa">
                        <a href="#wa">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Western Australia</span>
                        </a>
                    </li>
                    <li data-section="victoria">
                        <a href="#victoria">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Victoria</span>
                        </a>
                    </li>
                    <li data-section="reports">
                        <a href="#reports">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li data-section="settings">
                        <a href="#settings">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <a href="login.html" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
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
                                <div class="metric-value">128,450 L</div>
                                <div class="metric-change positive">
                                    <i class="fas fa-arrow-up"></i> 5.2% from last month
                                </div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon">
                                <i class="fas fa-cheese"></i>
                            </div>
                            <div class="metric-info">
                                <h4>Cheese Production</h4>
                                <div class="metric-value">18,320 kg</div>
                                <div class="metric-change positive">
                                    <i class="fas fa-arrow-up"></i> 3.7% from last month
                                </div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="metric-info">
                                <h4>Supplier Network</h4>
                                <div class="metric-value">124 farms</div>
                                <div class="metric-change positive">
                                    <i class="fas fa-arrow-up"></i> 2 new this month
                                </div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="metric-info">
                                <h4>Monthly Revenue</h4>
                                <div class="metric-value">$1.24M</div>
                                <div class="metric-change positive">
                                    <i class="fas fa-arrow-up"></i> 4.5% from last month
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="chart-container">
                        <div class="chart-card">
                            <h4>Milk Collection by Region</h4>
                            <div class="chart-wrapper">
                                <canvas id="regionCollectionChart"></canvas>
                            </div>
                        </div>
                        <div class="chart-card">
                            <h4>Monthly Production Trend</h4>
                            <div class="chart-wrapper">
                                <canvas id="productionTrendChart"></canvas>
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

                <!-- NSW Section -->
                <section id="nsw" class="content-section">
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

                <!-- Queensland Section -->
                <section id="queensland" class="content-section">
                    <div class="state-header">
                        <h3>Queensland Operations</h3>
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
                                <div class="metric-value">35,200 L</div>
                                <div class="metric-change up">4.3% from last month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-cheese"></i></div>
                            <div class="metric-info">
                                <h4>Cheese Production</h4>
                                <div class="metric-value">4,720 kg</div>
                                <div class="metric-change up">3.1% from last month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-users"></i></div>
                            <div class="metric-info">
                                <h4>Active Suppliers</h4>
                                <div class="metric-value">22 farms</div>
                                <div class="metric-change neutral">No change</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-industry"></i></div>
                            <div class="metric-info">
                                <h4>Processing Capacity</h4>
                                <div class="metric-value">78% utilized</div>
                                <div class="metric-change up">3% this month</div>
                            </div>
                        </div>
                    </div>

                    <!-- Queensland Data -->
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
                                            <td>Darling Downs Co-op</td>
                                            <td>Toowoomba</td>
                                            <td>2,100 L</td>
                                            <td><span class="badge-success">A</span></td>
                                            <td>Today</td>
                                            <td>
                                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>South Burnett Dairy</td>
                                            <td>Kingaroy</td>
                                            <td>1,950 L</td>
                                            <td><span class="badge-success">A+</span></td>
                                            <td>Yesterday</td>
                                            <td>
                                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sunshine Coast Farms</td>
                                            <td>Maleny</td>
                                            <td>1,800 L</td>
                                            <td><span class="badge-success">A</span></td>
                                            <td>Today</td>
                                            <td>
                                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Atherton Tablelands</td>
                                            <td>Malanda</td>
                                            <td>2,350 L</td>
                                            <td><span class="badge-success">A+</span></td>
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

                    <!-- Queensland Charts -->
                    <div class="chart-container">
                        <div class="chart-card">
                            <h4>Daily Collection (Last Week)</h4>
                            <div class="chart-wrapper">
                                <canvas id="qldDailyCollectionChart"></canvas>
                            </div>
                        </div>
                        <div class="chart-card">
                            <h4>Product Distribution</h4>
                            <div class="chart-wrapper">
                                <canvas id="qldProductDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Queensland Additional Data -->
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
                                            <td>Darling Downs</td>
                                            <td>7,500 L</td>
                                            <td>6</td>
                                            <td>A</td>
                                        </tr>
                                        <tr>
                                            <td>South Burnett</td>
                                            <td>6,800 L</td>
                                            <td>5</td>
                                            <td>A+</td>
                                        </tr>
                                        <tr>
                                            <td>Sunshine Coast</td>
                                            <td>6,200 L</td>
                                            <td>4</td>
                                            <td>A</td>
                                        </tr>
                                        <tr>
                                            <td>Atherton Tablelands</td>
                                            <td>7,700 L</td>
                                            <td>7</td>
                                            <td>A+</td>
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
                                            <td>Brisbane Processing</td>
                                            <td>Brisbane</td>
                                            <td>22,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                        <tr>
                                            <td>Toowoomba Dairy</td>
                                            <td>Toowoomba</td>
                                            <td>15,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                        <tr>
                                            <td>Malanda Plant</td>
                                            <td>Far North Queensland</td>
                                            <td>12,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Western Australia Section -->
                <section id="wa" class="content-section">
                    <div class="state-header">
                        <h3>Western Australia Operations</h3>
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
                                <div class="metric-value">24,800 L</div>
                                <div class="metric-change up">2.8% from last month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-cheese"></i></div>
                            <div class="metric-info">
                                <h4>Cheese Production</h4>
                                <div class="metric-value">3,110 kg</div>
                                <div class="metric-change up">2.2% from last month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-users"></i></div>
                            <div class="metric-info">
                                <h4>Active Suppliers</h4>
                                <div class="metric-value">15 farms</div>
                                <div class="metric-change up">1 new this month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-industry"></i></div>
                            <div class="metric-info">
                                <h4>Processing Capacity</h4>
                                <div class="metric-value">65% utilized</div>
                                <div class="metric-change down">2% this month</div>
                            </div>
                        </div>
                    </div>

                    <!-- Western Australia Data -->
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
                                            <td>Harvey Fresh</td>
                                            <td>Harvey</td>
                                            <td>1,850 L</td>
                                            <td><span class="badge-success">A+</span></td>
                                            <td>Today</td>
                                            <td>
                                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bunbury Dairy</td>
                                            <td>Bunbury</td>
                                            <td>1,650 L</td>
                                            <td><span class="badge-success">A</span></td>
                                            <td>Yesterday</td>
                                            <td>
                                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Margaret River Co-op</td>
                                            <td>Margaret River</td>
                                            <td>1,720 L</td>
                                            <td><span class="badge-success">A+</span></td>
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

                    <!-- Western Australia Charts -->
                    <div class="chart-container">
                        <div class="chart-card">
                            <h4>Daily Collection (Last Week)</h4>
                            <div class="chart-wrapper">
                                <canvas id="waDailyCollectionChart"></canvas>
                            </div>
                        </div>
                        <div class="chart-card">
                            <h4>Product Distribution</h4>
                            <div class="chart-wrapper">
                                <canvas id="waProductDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Western Australia Additional Data -->
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
                                            <td>Harvey</td>
                                            <td>6,500 L</td>
                                            <td>5</td>
                                            <td>A+</td>
                                        </tr>
                                        <tr>
                                            <td>Bunbury</td>
                                            <td>5,800 L</td>
                                            <td>4</td>
                                            <td>A</td>
                                        </tr>
                                        <tr>
                                            <td>Margaret River</td>
                                            <td>6,000 L</td>
                                            <td>4</td>
                                            <td>A+</td>
                                        </tr>
                                        <tr>
                                            <td>Other Southwest</td>
                                            <td>3,500 L</td>
                                            <td>2</td>
                                            <td>A</td>
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
                                            <td>Perth Processing</td>
                                            <td>Perth</td>
                                            <td>20,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                        <tr>
                                            <td>Harvey Plant</td>
                                            <td>Harvey</td>
                                            <td>15,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                        <tr>
                                            <td>Bunbury Facility</td>
                                            <td>Bunbury</td>
                                            <td>10,000 L</td>
                                            <td><span class="badge-warning">Maintenance</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Victoria Section -->
                <section id="victoria" class="content-section">
                    <div class="state-header">
                        <h3>Victoria Operations</h3>
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
                                <div class="metric-value">26,300 L</div>
                                <div class="metric-change up">3.5% from last month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-cheese"></i></div>
                            <div class="metric-info">
                                <h4>Cheese Production</h4>
                                <div class="metric-value">4,650 kg</div>
                                <div class="metric-change up">4.8% from last month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-users"></i></div>
                            <div class="metric-info">
                                <h4>Active Suppliers</h4>
                                <div class="metric-value">19 farms</div>
                                <div class="metric-change down">1 less this month</div>
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-icon"><i class="fas fa-industry"></i></div>
                            <div class="metric-info">
                                <h4>Processing Capacity</h4>
                                <div class="metric-value">72% utilized</div>
                                <div class="metric-change neutral">No change</div>
                            </div>
                        </div>
                    </div>

                    <!-- Victoria Data -->
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
                                            <td>Gippsland Dairy</td>
                                            <td>Gippsland</td>
                                            <td>2,250 L</td>
                                            <td><span class="badge-success">A+</span></td>
                                            <td>Today</td>
                                            <td>
                                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Murray Region Farms</td>
                                            <td>Murray Region</td>
                                            <td>2,150 L</td>
                                            <td><span class="badge-success">A</span></td>
                                            <td>Today</td>
                                            <td>
                                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Western Districts Co-op</td>
                                            <td>Warrnambool</td>
                                            <td>1,950 L</td>
                                            <td><span class="badge-success">A</span></td>
                                            <td>Yesterday</td>
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

                    <!-- Victoria Charts -->
                    <div class="chart-container">
                        <div class="chart-card">
                            <h4>Daily Collection (Last Week)</h4>
                            <div class="chart-wrapper">
                                <canvas id="vicDailyCollectionChart"></canvas>
                            </div>
                        </div>
                        <div class="chart-card">
                            <h4>Product Distribution</h4>
                            <div class="chart-wrapper">
                                <canvas id="vicProductDistributionChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Victoria Additional Data -->
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
                                            <td>Gippsland</td>
                                            <td>7,500 L</td>
                                            <td>7</td>
                                            <td>A+</td>
                                        </tr>
                                        <tr>
                                            <td>Murray Region</td>
                                            <td>7,200 L</td>
                                            <td>6</td>
                                            <td>A</td>
                                        </tr>
                                        <tr>
                                            <td>Western Districts</td>
                                            <td>6,800 L</td>
                                            <td>4</td>
                                            <td>A</td>
                                        </tr>
                                        <tr>
                                            <td>Other Regions</td>
                                            <td>2,800 L</td>
                                            <td>2</td>
                                            <td>A-</td>
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
                                            <td>Melbourne Processing</td>
                                            <td>Melbourne</td>
                                            <td>18,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                        <tr>
                                            <td>Gippsland Plant</td>
                                            <td>Morwell</td>
                                            <td>12,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                        <tr>
                                            <td>Warrnambool Facility</td>
                                            <td>Warrnambool</td>
                                            <td>10,000 L</td>
                                            <td><span class="badge-success">Operational</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

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
                                                <button class="btn-icon" onclick="exportToExcel('all', 'production')"><i class="fas fa-download"></i></button>
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
                                                <button class="btn-icon" onclick="exportToExcel('all', 'financial')"><i class="fas fa-download"></i></button>
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
                                                <button class="btn-icon" onclick="exportToExcel('nsw', 'suppliers')"><i class="fas fa-download"></i></button>
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
                                                <button class="btn-icon" onclick="exportToExcel('victoria', 'quality')"><i class="fas fa-download"></i></button>
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
                            <p>This dashboard utilizes Excel data managed through our Laravel backend. Data is refreshed every 24 hours from our central Excel repository.</p>
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

                <!-- Settings Section -->
                <section id="settings" class="content-section">
                    <div class="state-header">
                        <h3>System Settings</h3>
                        <div class="actions">
                            <button class="btn">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>

                    <!-- Settings Categories -->
                    <div class="settings-container">
                        <div class="settings-sidebar">
                            <ul class="settings-menu">
                                <li class="active" data-settings="account"><i class="fas fa-user-circle"></i> Account Settings</li>
                                <li data-settings="notifications"><i class="fas fa-bell"></i> Notifications</li>
                                <li data-settings="security"><i class="fas fa-shield-alt"></i> Security</li>
                                <li data-settings="appearance"><i class="fas fa-paint-brush"></i> Appearance</li>
                                <li data-settings="users"><i class="fas fa-users-cog"></i> User Management</li>
                                <li data-settings="system"><i class="fas fa-cogs"></i> System Settings</li>
                            </ul>
                        </div>
                        
                        <div class="settings-content">
                            <div class="settings-panel active" id="account-settings">
                                <h4>Account Settings</h4>
                                <form class="settings-form">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" value="Administrator User" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" value="admin@australiandairy.com" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control">
                                            <option selected>Administrator</option>
                                            <option>Regional Manager</option>
                                            <option>Data Analyst</option>
                                            <option>Supplier Manager</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Default Region</label>
                                        <select class="form-control">
                                            <option selected>All Regions</option>
                                            <option>New South Wales</option>
                                            <option>Queensland</option>
                                            <option>Western Australia</option>
                                            <option>Victoria</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
@endsection
