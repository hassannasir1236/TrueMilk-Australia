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
      
    </div>

@endsection