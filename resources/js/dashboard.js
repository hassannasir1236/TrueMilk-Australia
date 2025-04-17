// Dashboard JavaScript for Superior Dairy

document.addEventListener('DOMContentLoaded', function() {
    // Get region selected from login if available
    const urlParams = new URLSearchParams(window.location.search);
    const region = urlParams.get('region') || localStorage.getItem('selectedRegion') || 'all';
    
    // If region is specified, activate that tab
    if (region !== 'all') {
        activateRegion(region);
    }

    // Setup dashboard functionality
    setupNavigation();
    setupMobileResponsiveness();
    setupDropdowns();
    setupSettingsNavigation();
    
    // Initialize the dashboard data
    loadDashboardData(region);
    
    // Refresh data every 5 minutes
    setInterval(() => loadDashboardData(region), 300000);
    
    // Setup date picker functionality
    const datePicker = document.querySelector('.date-picker input');
    if (datePicker) {
        datePicker.addEventListener('change', function() {
            loadDashboardData(region, this.value);
        });
    }
});

/**
 * Activate a specific region tab
 */
// function activateRegion(region) {
//     const regionTab = document.querySelector(`.sidebar-menu li[data-section="${region}"]`);
    
//     if (regionTab) {
//         // Store the selection in localStorage
//         localStorage.setItem('selectedRegion', region);
        
//         // Simulate a click on the tab
//         const regionLink = regionTab.querySelector('a');
//         if (regionLink) {
//             regionLink.click();
//         }
//     }
// }

// /**
//  * Setup navigation between dashboard sections
//  */
// function setupNavigation() {
//     const navLinks = document.querySelectorAll('.sidebar-menu a');
//     const contentSections = document.querySelectorAll('.content-section');
    
//     navLinks.forEach(link => {
//         link.addEventListener('click', function(e) {
//             e.preventDefault();
            
//             // Remove active class from all links and add to clicked link
//             navLinks.forEach(link => link.parentElement.classList.remove('active'));
//             this.parentElement.classList.add('active');
            
//             // Get target section id from href attribute
//             const targetId = this.getAttribute('href').substring(1);
            
//             // Hide all content sections and show target section
//             contentSections.forEach(section => {
//                 section.classList.remove('active');
//                 if (section.id === targetId) {
//                     section.classList.add('active');
//                     // Update header title
//                     document.querySelector('#section-title').textContent = this.querySelector('span').textContent;
                    
//                     // Save the selected region if applicable
//                     const region = this.parentElement.dataset.section;
//                     if (['nsw', 'queensland', 'wa', 'victoria'].includes(region)) {
//                         localStorage.setItem('selectedRegion', region);
//                     }
//                 }
//             });
//         });
//     });
// }

/**
 * Setup mobile responsiveness for sidebar
 */
function setupMobileResponsiveness() {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('sidebar-open');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        // Only apply this for mobile screens
        if (window.innerWidth <= 768) {
            // Check if click is outside sidebar and menu toggle
            if (!sidebar.contains(e.target) && e.target !== menuToggle && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('open');
                mainContent.classList.remove('sidebar-open');
            }
        }
    });
}

/**
 * Setup dropdown functionality
 */
function setupDropdowns() {
    const userProfile = document.querySelector('.user-profile');
    
    if (userProfile) {
        userProfile.addEventListener('click', function() {
            const dropdown = document.querySelector('.user-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('show');
            }
        });
        
        // Close dropdown when clicking elsewhere
        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target)) {
                const dropdown = document.querySelector('.user-dropdown');
                if (dropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            }
        });
    }
}

/**
 * Setup settings panel navigation
 */
function setupSettingsNavigation() {
    const settingsItems = document.querySelectorAll('.settings-menu li');
    const settingsPanels = document.querySelectorAll('.settings-panel');
    
    if (settingsItems.length > 0) {
        settingsItems.forEach(item => {
            item.addEventListener('click', () => {
                // Get the target panel
                const targetPanel = item.getAttribute('data-settings');
                
                // Update active menu item
                settingsItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                
                // Show the target panel
                settingsPanels.forEach(panel => {
                    if (panel.id === targetPanel + '-settings') {
                        panel.classList.add('active');
                    } else {
                        panel.classList.remove('active');
                    }
                });
            });
        });
    }
}

/**
 * Backend API integration for Excel/Laravel
 * These functions would connect to a Laravel backend that manages Excel data
 */

// API base URL - would point to Laravel API in production
const API_BASE_URL = 'http://localhost:8000/api';

/**
 * Fetch data from Laravel API with Excel backend
 * @param {string} region - Region to fetch data for
 * @param {string} date - Date to fetch data for
 * @returns {Promise} - Promise resolving to dashboard data
 */
async function fetchDataFromAPI(region = 'all', date = null) {
    try {
        // Get auth token from localStorage (set during login)
        const token = localStorage.getItem('authToken');
        
        if (!token) {
            console.error('No authentication token found');
            return null;
        }
        
        // Build query parameters
        const params = new URLSearchParams();
        if (region !== 'all') params.append('region', region);
        if (date) params.append('date', date);
        
        // Make API request
        const response = await fetch(
            `${API_BASE_URL}/dashboard/data?${params.toString()}`,
            {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }
        );
        
        if (!response.ok) {
            throw new Error('API request failed');
        }
        
        return await response.json();
        
    } catch (error) {
        console.error('Error fetching data from API:', error);
        
        // For demo purposes, fall back to mock data
        // In production, would show error message
        return fetchDashboardData(region, date);
    }
}

/**
 * Export dashboard data to Excel via Laravel backend or client-side generation
 * @param {string} region - Region to export
 * @param {string} reportType - Type of report to export
 */
async function exportToExcel(region = 'all', reportType = 'production') {
    try {
        // Show loading indicator
        const exportBtn = document.querySelector('.export-btn');
        if (exportBtn) {
            const originalText = exportBtn.innerHTML;
            exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            exportBtn.disabled = true;
        }
        
        // Get auth token from localStorage
        const token = localStorage.getItem('authToken');
        
        // Try using Laravel backend API if token exists
        if (token) {
            try {
                // Make API request to generate Excel file
                const response = await fetch(
                    `${API_BASE_URL}/reports/export`,
                    {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ region, reportType })
                    }
                );
                
                if (!response.ok) {
                    throw new Error('Backend export request failed');
                }
                
                const data = await response.json();
                
                // Download the file from backend
                if (data.fileUrl) {
                    const link = document.createElement('a');
                    link.href = data.fileUrl;
                    link.download = data.fileName || 'export.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    // Reset button state
                    if (exportBtn) {
                        exportBtn.innerHTML = originalText;
                        exportBtn.disabled = false;
                    }
                    return;
                }
            } catch (error) {
                console.warn('Backend export failed, falling back to client-side export:', error);
                // Continue to client-side export if API fails
            }
        }
        
        // Client-side Excel generation (fallback)
        // Generate data based on region and report type
        const fileName = generateExcelFileName(region, reportType);
        const data = prepareExcelData(region, reportType);
        
        // Convert data to Excel sheet using SheetJS
        generateAndDownloadExcel(data, fileName);
        
        // Reset button state
        if (exportBtn) {
            exportBtn.innerHTML = originalText;
            exportBtn.disabled = false;
        }
        
    } catch (error) {
        console.error('Error exporting to Excel:', error);
        alert('Failed to export data. Please try again later.');
        
        // Reset button state
        const exportBtn = document.querySelector('.export-btn');
        if (exportBtn) {
            exportBtn.innerHTML = '<i class="fas fa-file-excel"></i> Export to Excel';
            exportBtn.disabled = false;
        }
    }
}

/**
 * Generate appropriate Excel filename based on region and report type
 */
function generateExcelFileName(region, reportType) {
    const date = new Date().toISOString().split('T')[0];
    const regionName = getRegionName(region);
    const reportName = getReportTypeName(reportType);
    
    return `AustralianDairy_${regionName}_${reportName}_${date}.xls`;
}

/**
 * Get readable region name
 */
function getRegionName(region) {
    switch(region) {
        case 'nsw': return 'NSW';
        case 'queensland': return 'Queensland';
        case 'wa': return 'WesternAustralia';
        case 'victoria': return 'Victoria';
        default: return 'AllRegions';
    }
}

/**
 * Get readable report type name
 */
function getReportTypeName(reportType) {
    switch(reportType) {
        case 'production': return 'Production';
        case 'financial': return 'Financial';
        case 'suppliers': return 'Suppliers';
        case 'quality': return 'Quality';
        default: return 'Report';
    }
}

/**
 * Prepare data for Excel export based on region and report type
 */
function prepareExcelData(region, reportType) {
    // Get dashboard data
    const dashboardData = fetchDashboardData(region);
    
    // Structure for Excel data - each sheet is an array of arrays
    const excelData = {
        sheets: {}
    };
    
    // Add metadata sheet
    excelData.sheets['Report Info'] = [
        ['Australian Dairy Group - Data Export'],
        ['Generated on', new Date().toLocaleString()],
        ['Region', getRegionName(region)],
        ['Report Type', getReportTypeName(reportType)],
        ['']
    ];
    
    // Build sheets based on report type
    if (reportType === 'production' || reportType === 'all') {
        excelData.sheets['Production Summary'] = getProductionSummaryData(dashboardData, region);
    }
    
    if (reportType === 'suppliers' || reportType === 'all') {
        excelData.sheets['Supplier Data'] = getSupplierData(dashboardData, region);
    }
    
    if (reportType === 'financial' || reportType === 'all') {
        excelData.sheets['Financial Data'] = getFinancialData(dashboardData, region);
    }
    
    if (reportType === 'quality' || reportType === 'all') {
        excelData.sheets['Quality Analysis'] = getQualityData(dashboardData, region);
    }
    
    return excelData;
}

/**
 * Get production summary data formatted for Excel
 */
function getProductionSummaryData(data, region) {
    const excelRows = [
        ['Australian Dairy Group - Production Summary'],
        [''],
        ['Region', 'Milk Collection (L)', 'Cheese Production (kg)', 'Processing Capacity', 'Active Suppliers']
    ];
    
    // If all regions, include all in the table
    if (region === 'all') {
        const regions = ['nsw', 'queensland', 'wa', 'victoria'];
        regions.forEach(r => {
            if (data[r]) {
                excelRows.push([
                    getRegionName(r),
                    data[r].milkCollection,
                    data[r].cheeseProduction,
                    data[r].processingCapacity + '%',
                    data[r].supplierCount
                ]);
            }
        });
        
        // Add total row
        const totals = {
            milkCollection: regions.reduce((sum, r) => sum + (data[r]?.milkCollection || 0), 0),
            cheeseProduction: regions.reduce((sum, r) => sum + (data[r]?.cheeseProduction || 0), 0),
            avgCapacity: regions.reduce((sum, r) => sum + (data[r]?.processingCapacity || 0), 0) / regions.length,
            totalSuppliers: regions.reduce((sum, r) => sum + (data[r]?.supplierCount || 0), 0)
        };
        
        excelRows.push([]);
        excelRows.push([
            'TOTAL',
            totals.milkCollection,
            totals.cheeseProduction,
            totals.avgCapacity.toFixed(1) + '%',
            totals.totalSuppliers
        ]);
    } else {
        // Just include the requested region
        if (data[region]) {
            excelRows.push([
                getRegionName(region),
                data[region].milkCollection,
                data[region].cheeseProduction,
                data[region].processingCapacity + '%',
                data[region].supplierCount
            ]);
        }
    }
    
    // Add daily collection data
    excelRows.push([]);
    excelRows.push(['Daily Collection']);
    
    if (region === 'all') {
        // Header row with all regions
        const headerRow = ['Day'];
        ['NSW', 'Queensland', 'WA', 'Victoria'].forEach(r => {
            headerRow.push(r);
        });
        excelRows.push(headerRow);
        
        // For each day, add data from all regions
        if (data.nsw && data.nsw.dailyCollection) {
            const days = data.nsw.dailyCollection.days;
            days.forEach((day, index) => {
                const rowData = [day];
                ['nsw', 'queensland', 'wa', 'victoria'].forEach(r => {
                    if (data[r] && data[r].dailyCollection) {
                        rowData.push(data[r].dailyCollection.values[index]);
                    } else {
                        rowData.push('N/A');
                    }
                });
                excelRows.push(rowData);
            });
        }
    } else {
        // Just include the data for the selected region
        if (data[region] && data[region].dailyCollection) {
            excelRows.push(['Day', 'Collection (L)']);
            data[region].dailyCollection.days.forEach((day, index) => {
                excelRows.push([day, data[region].dailyCollection.values[index]]);
            });
        }
    }
    
    return excelRows;
}

/**
 * Get supplier data formatted for Excel
 */
function getSupplierData(data, region) {
    const excelRows = [
        ['Australian Dairy Group - Supplier Data'],
        [''],
        ['Farm Name', 'Location', 'Region', 'Daily Supply (L)', 'Quality Rating', 'Last Delivery']
    ];
    
    // Add suppliers based on region
    if (region === 'all') {
        // Include all suppliers from all regions
        ['nsw', 'queensland', 'wa', 'victoria'].forEach(r => {
            if (data[r] && data[r].suppliers) {
                data[r].suppliers.forEach(supplier => {
                    excelRows.push([
                        supplier.name,
                        supplier.location,
                        getRegionName(r),
                        supplier.dailySupply,
                        supplier.qualityRating || 'N/A',
                        supplier.lastDelivery
                    ]);
                });
            }
        });
    } else {
        // Just suppliers from the selected region
        if (data[region] && data[region].suppliers) {
            data[region].suppliers.forEach(supplier => {
                excelRows.push([
                    supplier.name,
                    supplier.location,
                    getRegionName(region),
                    supplier.dailySupply,
                    supplier.qualityRating || 'N/A',
                    supplier.lastDelivery
                ]);
            });
        }
    }
    
    return excelRows;
}

/**
 * Get financial data formatted for Excel
 */
function getFinancialData(data, region) {
    // Sample financial data since the mock data doesn't include detailed financials
    const excelRows = [
        ['Australian Dairy Group - Financial Data'],
        [''],
        ['Region', 'Revenue ($)', 'Cost of Goods ($)', 'Operational Expenses ($)', 'Profit ($)', 'Profit Margin (%)']
    ];
    
    // Financial data (simulated)
    const financialData = {
        nsw: {
            revenue: 2450000,
            cogs: 1568000,
            opex: 420000,
            profit: 462000,
            margin: 18.9
        },
        queensland: {
            revenue: 1980000,
            cogs: 1245000,
            opex: 325000,
            profit: 410000,
            margin: 20.7
        },
        wa: {
            revenue: 1240000,
            cogs: 818000,
            opex: 215000,
            profit: 207000,
            margin: 16.7
        },
        victoria: {
            revenue: 1560000,
            cogs: 1025000,
            opex: 245000,
            profit: 290000,
            margin: 18.6
        }
    };
    
    if (region === 'all') {
        // Include all regions
        Object.keys(financialData).forEach(r => {
            const finance = financialData[r];
            excelRows.push([
                getRegionName(r),
                finance.revenue,
                finance.cogs,
                finance.opex,
                finance.profit,
                finance.margin.toFixed(1) + '%'
            ]);
        });
        
        // Add total row
        const totals = {
            revenue: Object.values(financialData).reduce((sum, f) => sum + f.revenue, 0),
            cogs: Object.values(financialData).reduce((sum, f) => sum + f.cogs, 0),
            opex: Object.values(financialData).reduce((sum, f) => sum + f.opex, 0),
            profit: Object.values(financialData).reduce((sum, f) => sum + f.profit, 0),
        };
        const totalMargin = (totals.profit / totals.revenue * 100).toFixed(1);
        
        excelRows.push([]);
        excelRows.push([
            'TOTAL',
            totals.revenue,
            totals.cogs,
            totals.opex,
            totals.profit,
            totalMargin + '%'
        ]);
    } else {
        // Just the selected region
        if (financialData[region]) {
            const finance = financialData[region];
            excelRows.push([
                getRegionName(region),
                finance.revenue,
                finance.cogs,
                finance.opex,
                finance.profit,
                finance.margin.toFixed(1) + '%'
            ]);
        }
    }
    
    // Add monthly trend
    excelRows.push([]);
    excelRows.push(['Monthly Revenue Trend']);
    excelRows.push(['Month', 'Revenue ($)']);
    
    // Sample monthly data
    const months = ['January', 'February', 'March', 'April', 'May', 'June'];
    if (region === 'all') {
        const monthlyRevenue = [1150000, 1210000, 1180000, 1260000, 1320000, 1240000];
        months.forEach((month, index) => {
            excelRows.push([month, monthlyRevenue[index]]);
        });
    } else {
        // Simulate regional monthly data
        const baseValue = financialData[region]?.revenue / 6 || 0;
        months.forEach((month, index) => {
            // Create some variance in the monthly data
            const variance = 0.9 + (Math.random() * 0.2);
            excelRows.push([month, Math.round(baseValue * variance)]);
        });
    }
    
    return excelRows;
}

/**
 * Get quality analysis data formatted for Excel
 */
function getQualityData(data, region) {
    const excelRows = [
        ['Australian Dairy Group - Quality Analysis'],
        [''],
        ['Region', 'A+ Rating (%)', 'A Rating (%)', 'B+ Rating (%)', 'B Rating (%)', 'Average Rating']
    ];
    
    // Quality metrics (simulated)
    const qualityData = {
        nsw: {
            aPlus: 45,
            a: 35,
            bPlus: 15,
            b: 5,
            average: 'A'
        },
        queensland: {
            aPlus: 52,
            a: 32,
            bPlus: 12,
            b: 4,
            average: 'A'
        },
        wa: {
            aPlus: 48,
            a: 36,
            bPlus: 10,
            b: 6,
            average: 'A'
        },
        victoria: {
            aPlus: 50,
            a: 35,
            bPlus: 10,
            b: 5,
            average: 'A'
        }
    };
    
    if (region === 'all') {
        // Include all regions
        Object.keys(qualityData).forEach(r => {
            const quality = qualityData[r];
            excelRows.push([
                getRegionName(r),
                quality.aPlus + '%',
                quality.a + '%',
                quality.bPlus + '%',
                quality.b + '%',
                quality.average
            ]);
        });
        
        // Add averages
        const avgQuality = {
            aPlus: Object.values(qualityData).reduce((sum, q) => sum + q.aPlus, 0) / Object.keys(qualityData).length,
            a: Object.values(qualityData).reduce((sum, q) => sum + q.a, 0) / Object.keys(qualityData).length,
            bPlus: Object.values(qualityData).reduce((sum, q) => sum + q.bPlus, 0) / Object.keys(qualityData).length,
            b: Object.values(qualityData).reduce((sum, q) => sum + q.b, 0) / Object.keys(qualityData).length,
        };
        
        excelRows.push([]);
        excelRows.push([
            'AVERAGE',
            avgQuality.aPlus.toFixed(1) + '%',
            avgQuality.a.toFixed(1) + '%',
            avgQuality.bPlus.toFixed(1) + '%',
            avgQuality.b.toFixed(1) + '%',
            'A'
        ]);
    } else {
        // Just the selected region
        if (qualityData[region]) {
            const quality = qualityData[region];
            excelRows.push([
                getRegionName(region),
                quality.aPlus + '%',
                quality.a + '%',
                quality.bPlus + '%',
                quality.b + '%',
                quality.average
            ]);
        }
    }
    
    // Add quality issues log
    excelRows.push([]);
    excelRows.push(['Recent Quality Issues']);
    excelRows.push(['Date', 'Region', 'Farm', 'Issue', 'Resolution Status']);
    
    // Sample quality issues
    const qualityIssues = [
        {date: '2025-03-12', region: 'victoria', farm: 'Gippsland Dairy', issue: 'Bacterial count above threshold', status: 'Resolved'},
        {date: '2025-03-08', region: 'nsw', farm: 'Hunter Valley Dairy', issue: 'Temperature deviation during transport', status: 'Resolved'},
        {date: '2025-03-05', region: 'queensland', farm: 'Darling Downs Co-op', issue: 'Foreign particulate matter', status: 'Monitoring'},
        {date: '2025-02-28', region: 'wa', farm: 'Harvey Fresh', issue: 'Test sample contamination', status: 'Resolved'},
        {date: '2025-02-20', region: 'victoria', farm: 'Murray Region Farms', issue: 'Antibiotic residue detection', status: 'Resolved'}
    ];
    
    // Filter by region if needed
    const filteredIssues = region === 'all' ? qualityIssues : qualityIssues.filter(issue => issue.region === region);
    
    filteredIssues.forEach(issue => {
        excelRows.push([
            issue.date,
            getRegionName(issue.region),
            issue.farm,
            issue.issue,
            issue.status
        ]);
    });
    
    return excelRows;
}

/**
 * Generate and download Excel file with the prepared data
 */
function generateAndDownloadExcel(data, fileName) {
    // Create workbook
    const workbook = XLSX.utils.book_new();
    
    // Add each sheet to the workbook
    Object.keys(data.sheets).forEach(sheetName => {
        const worksheet = XLSX.utils.aoa_to_sheet(data.sheets[sheetName]);
        XLSX.utils.book_append_sheet(workbook, worksheet, sheetName);
    });
    
    // Convert to binary and trigger download
    const excelBinary = XLSX.write(workbook, { bookType: 'xls', type: 'binary' });
    
    // Convert binary to Blob and download
    const blob = new Blob([s2ab(excelBinary)], { type: 'application/vnd.ms-excel' });
    
    // Create download link and trigger it
    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(blob);
    downloadLink.download = fileName;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

/**
 * Convert string to ArrayBuffer for binary Excel data
 */
function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i < s.length; i++) {
        view[i] = s.charCodeAt(i) & 0xFF;
    }
    return buf;
}

/**
 * Loads dashboard data, preferring the API but falling back to mock data
 */
function loadDashboardData(region = 'all', date = null) {
    // Update the date picker with current date if not specified
    if (!date) {
        const today = new Date();
        date = today.toISOString().substr(0, 10);
        const datePicker = document.querySelector('.date-picker input');
        if (datePicker) {
            datePicker.value = date;
        }
    }
    
    // Show loading indicators for all sections
    document.querySelectorAll('.metric-value').forEach(el => {
        el.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    });
    
    // Add loading state to charts
    document.querySelectorAll('.chart-card').forEach(card => {
        card.classList.add('loading');
    });
    
    // Try to fetch from API, fall back to mock data if needed
    fetchDataFromAPI(region, date)
        .then(data => {
            if (data) {
                // Update all dashboard sections with the data
                updateDashboard(data, 'all');
                
                // Initialize charts for all sections
                initializeCharts(data, 'all');
                
                // Now activate the requested region if specified
                if (region !== 'all') {
                    activateRegion(region);
                }
            } else {
                // If API returned null, show error message
                showConnectionError();
            }
        })
        .catch(error => {
            console.error('Error loading dashboard data:', error);
            showConnectionError();
        })
        .finally(() => {
            // Remove loading state from charts
            document.querySelectorAll('.chart-card').forEach(card => {
                card.classList.remove('loading');
            });
        });
}

/**
 * Display connection error when API fails
 */
function showConnectionError() {
    // Display error message at top of dashboard
    const dashboardContent = document.querySelector('.dashboard-content');
    if (dashboardContent) {
        const errorElement = document.createElement('div');
        errorElement.className = 'api-error-message';
        errorElement.innerHTML = `
            <i class="fas fa-exclamation-triangle"></i>
            <span>Could not connect to server. Showing offline data.</span>
            <button class="retry-btn">Retry</button>
        `;
        
        // Insert at the top of dashboard
        dashboardContent.insertBefore(errorElement, dashboardContent.firstChild);
        
        // Add retry button functionality
        errorElement.querySelector('.retry-btn').addEventListener('click', function() {
            errorElement.remove();
            loadDashboardData();
        });
    }
}

/**
 * Load dashboard data for all regions or a specific region
 */
function loadDashboardData(region = 'all', date = null) {
    // Update the date picker with current date if not specified
    if (!date) {
        const today = new Date();
        date = today.toISOString().substr(0, 10);
        const datePicker = document.querySelector('.date-picker input');
        if (datePicker) {
            datePicker.value = date;
        }
    }
    
    // Show loading indicators for all sections, not just the active one
    document.querySelectorAll('.metric-value').forEach(el => {
        el.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    });
    
    // In a real application, this would be an API call
    // For this demo, we'll simulate the data fetch
    setTimeout(() => {
        // Always fetch all data regardless of the selected region
        const data = fetchDashboardData('all', date);
        
        // Update all sections with their respective data
        updateDashboard(data, 'all');
        
        // Initialize charts for all sections
        initializeCharts(data, 'all');
        
        // Now activate the requested region if specified
        if (region !== 'all') {
            activateRegion(region);
        }
    }, 800);
}

/**
 * Simulated data fetch (this would be an API call in production)
 */
function fetchDashboardData(region, date) {
    const allData = {
        overview: {
            totalMilkCollection: 128450,
            cheeseProduction: 18320,
            supplierCount: 124,
            revenue: 1240000,
            milkDistribution: {
                nsw: 42150,
                queensland: 35200,
                wa: 24800,
                victoria: 26300
            },
            productionTrend: {
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                milk: [110000, 115000, 118000, 125000, 122000, 128450],
                cheese: [15000, 16000, 16500, 17000, 17500, 18320]
            },
            recentActivity: [
                {
                    type: 'delivery',
                    title: 'New Shipment Received',
                    description: 'NSW facility received 5,200 L of milk from Hunter Valley farms',
                    time: 'Today, 09:45 AM'
                },
                {
                    type: 'target',
                    title: 'Production Target Reached',
                    description: 'Queensland facility reached monthly cheese production target',
                    time: 'Yesterday, 05:30 PM'
                },
                {
                    type: 'alert',
                    title: 'Quality Alert',
                    description: 'Victoria facility reported quality issues with milk batch #V23451',
                    time: 'Yesterday, 11:15 AM'
                }
            ]
        },
        nsw: {
            milkCollection: 42150,
            cheeseProduction: 5840,
            supplierCount: 28,
            processingCapacity: 85,
            dailyCollection: {
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                values: [41200, 42500, 40800, 43100, 42700, 41900, 40800]
            },
            productDistribution: {
                categories: ['Whole Milk', 'Cheese', 'Yogurt', 'Cream', 'Other'],
                values: [45, 25, 15, 10, 5]
            },
            suppliers: [
                {
                    name: 'Hunter Valley Dairy',
                    location: 'Hunter Region',
                    dailySupply: 2450,
                    qualityRating: 'A+',
                    lastDelivery: 'Today'
                },
                {
                    name: 'Southern Highlands Farm',
                    location: 'Bowral',
                    dailySupply: 1850,
                    qualityRating: 'A',
                    lastDelivery: 'Yesterday'
                },
                {
                    name: 'Central Coast Dairy',
                    location: 'Gosford',
                    dailySupply: 1720,
                    qualityRating: 'A',
                    lastDelivery: 'Today'
                },
                {
                    name: 'Northern Rivers Cooperative',
                    location: 'Lismore',
                    dailySupply: 2100,
                    qualityRating: 'A+',
                    lastDelivery: '2 days ago'
                },
                {
                    name: 'Blue Mountains Dairy',
                    location: 'Katoomba',
                    dailySupply: 1550,
                    qualityRating: 'B+',
                    lastDelivery: 'Today'
                }
            ],
            sourceBreakdown: {
                regions: ['Hunter', 'Southern Highlands', 'Northern Rivers', 'Central Coast', 'Blue Mountains'],
                volumes: [8500, 6200, 7800, 5800, 3850]
            }
        },
        queensland: {
            milkCollection: 35200,
            cheeseProduction: 4720,
            supplierCount: 22,
            processingCapacity: 78,
            dailyCollection: {
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                values: [34800, 35600, 34900, 36200, 35800, 34500, 33600]
            },
            productDistribution: {
                categories: ['Whole Milk', 'Cheese', 'Yogurt', 'Cream', 'Other'],
                values: [40, 20, 25, 10, 5]
            },
            suppliers: [
                {
                    name: 'Darling Downs Co-op',
                    location: 'Toowoomba',
                    dailySupply: 2100,
                    qualityRating: 'A',
                    lastDelivery: 'Today'
                },
                {
                    name: 'South Burnett Dairy',
                    location: 'Kingaroy',
                    dailySupply: 1950,
                    qualityRating: 'A+',
                    lastDelivery: 'Yesterday'
                },
                {
                    name: 'Sunshine Coast Farms',
                    location: 'Maleny',
                    dailySupply: 1800,
                    qualityRating: 'A',
                    lastDelivery: 'Today'
                },
                {
                    name: 'Atherton Tablelands',
                    location: 'Malanda',
                    dailySupply: 2350,
                    qualityRating: 'A+',
                    lastDelivery: 'Today'
                }
            ],
            sourceBreakdown: {
                regions: ['Darling Downs', 'South Burnett', 'Sunshine Coast', 'Atherton Tablelands'],
                volumes: [7500, 6800, 6200, 7700]
            }
        },
        wa: {
            milkCollection: 24800,
            cheeseProduction: 3110,
            supplierCount: 15,
            processingCapacity: 65,
            dailyCollection: {
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                values: [24300, 25100, 24600, 25400, 24900, 23800, 22600]
            },
            productDistribution: {
                categories: ['Whole Milk', 'Cheese', 'Yogurt', 'Cream', 'Other'],
                values: [50, 15, 10, 20, 5]
            },
            suppliers: [
                {
                    name: 'Harvey Fresh',
                    location: 'Harvey',
                    dailySupply: 1850,
                    qualityRating: 'A+',
                    lastDelivery: 'Today'
                },
                {
                    name: 'Bunbury Dairy',
                    location: 'Bunbury',
                    dailySupply: 1650,
                    qualityRating: 'A',
                    lastDelivery: 'Yesterday'
                },
                {
                    name: 'Margaret River Co-op',
                    location: 'Margaret River',
                    dailySupply: 1720,
                    qualityRating: 'A+',
                    lastDelivery: 'Today'
                }
            ],
            sourceBreakdown: {
                regions: ['Harvey', 'Bunbury', 'Margaret River', 'Other Southwest'],
                volumes: [6500, 5800, 6000, 3500]
            }
        },
        victoria: {
            milkCollection: 26300,
            cheeseProduction: 4650,
            supplierCount: 19,
            processingCapacity: 72,
            dailyCollection: {
                days: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                values: [26100, 26800, 26400, 27200, 27000, 25800, 24800]
            },
            productDistribution: {
                categories: ['Whole Milk', 'Cheese', 'Yogurt', 'Cream', 'Other'],
                values: [35, 30, 15, 10, 10]
            },
            suppliers: [
                {
                    name: 'Gippsland Dairy',
                    location: 'Gippsland',
                    dailySupply: 2250,
                    qualityRating: 'A+',
                    lastDelivery: 'Today'
                },
                {
                    name: 'Murray Region Farms',
                    location: 'Murray Region',
                    dailySupply: 2150,
                    qualityRating: 'A',
                    lastDelivery: 'Today'
                },
                {
                    name: 'Western Districts Co-op',
                    location: 'Warrnambool',
                    dailySupply: 1950,
                    qualityRating: 'A',
                    lastDelivery: 'Yesterday'
                }
            ],
            sourceBreakdown: {
                regions: ['Gippsland', 'Murray Region', 'Western Districts', 'Other'],
                volumes: [7500, 7200, 6800, 2800]
            }
        }
    };
    
    // Return data based on selected region
    if (region === 'all') {
        return allData;
    } else if (allData[region]) {
        return { [region]: allData[region], overview: allData.overview };
    }
    
    // Fallback to all data
    return allData;
}

/**
 * Update dashboard with fetched data
 */
function updateDashboard(data, region) {
    // Update overview metrics
    if (data.overview) {
        document.querySelectorAll('#overview .metric-value').forEach(el => {
            const metricType = el.closest('.metric-card').querySelector('h4').textContent.toLowerCase();
            
            if (metricType.includes('milk collection')) {
                el.textContent = formatNumber(data.overview.totalMilkCollection) + ' L';
            } else if (metricType.includes('cheese production')) {
                el.textContent = formatNumber(data.overview.cheeseProduction) + ' kg';
            } else if (metricType.includes('supplier')) {
                el.textContent = formatNumber(data.overview.supplierCount) + ' farms';
            } else if (metricType.includes('revenue')) {
                el.textContent = '$' + (data.overview.revenue/1000000).toFixed(2) + 'M';
            }
        });
    }
    
    // Update region-specific metrics
    const regions = ['nsw', 'queensland', 'wa', 'victoria'];
    regions.forEach(r => {
        if (data[r]) {
            document.querySelectorAll(`#${r} .metric-value`).forEach(el => {
                const metricCard = el.closest('.metric-card');
                const metricType = metricCard.querySelector('h4').textContent.toLowerCase();
                
                if (metricType.includes('milk collection')) {
                    el.textContent = formatNumber(data[r].milkCollection) + ' L';
                } else if (metricType.includes('cheese production')) {
                    el.textContent = formatNumber(data[r].cheeseProduction) + ' kg';
                } else if (metricType.includes('active suppliers')) {
                    el.textContent = formatNumber(data[r].supplierCount) + ' farms';
                } else if (metricType.includes('processing capacity')) {
                    el.textContent = data[r].processingCapacity + '% utilized';
                }
                
                // Make sure change indicators are visible
                const changeEl = metricCard.querySelector('.metric-change');
                if (changeEl) {
                    if (changeEl.textContent.trim() === '') {
                        if (metricType.includes('milk collection')) {
                            changeEl.textContent = '4.3% from last month';
                            changeEl.className = 'metric-change up';
                        } else if (metricType.includes('cheese production')) {
                            changeEl.textContent = '3.1% from last month';
                            changeEl.className = 'metric-change up';
                        } else if (metricType.includes('active suppliers')) {
                            changeEl.textContent = 'No change';
                            changeEl.className = 'metric-change neutral';
                        } else if (metricType.includes('processing capacity')) {
                            changeEl.textContent = '3% this month';
                            changeEl.className = 'metric-change up';
                        }
                    }
                }
            });
            
            // Update suppliers table if it exists
            const suppliersTable = document.querySelector(`#${r} .data-table tbody`);
            if (suppliersTable && data[r].suppliers) {
                suppliersTable.innerHTML = '';
                data[r].suppliers.forEach(supplier => {
                    const qualityClass = supplier.qualityRating ? 
                        (supplier.qualityRating.includes('A') ? 'badge-success' : 'badge-warning') :
                        'badge-success';
                    
                    const qualityRating = supplier.qualityRating || 'A';
                    
                    suppliersTable.innerHTML += `
                        <tr>
                            <td>${supplier.name}</td>
                            <td>${supplier.location}</td>
                            <td>${supplier.dailySupply} L</td>
                            <td><span class="${qualityClass}">${qualityRating}</span></td>
                            <td>${supplier.lastDelivery}</td>
                            <td>
                                <button class="btn-icon"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
        }
    });
    
    // Update Reports section metrics
    updateReportsMetrics();
    
    // Update Reports table
    updateReportsTable();
}

/**
 * Update the metrics in the Reports section
 */
function updateReportsMetrics() {
    document.querySelectorAll('#reports .metric-value').forEach(el => {
        const metricCard = el.closest('.metric-card');
        const metricType = metricCard.querySelector('h4').textContent.toLowerCase();
        
        if (metricType.includes('production efficiency')) {
            el.textContent = '92.4%';
        } else if (metricType.includes('total revenue')) {
            el.textContent = '$5.28M';
        } else if (metricType.includes('generated reports')) {
            el.textContent = '28';
        } else if (metricType.includes('kpi achievement')) {
            el.textContent = '86%';
        }
        
        // Make sure change indicators are visible
        const changeEl = metricCard.querySelector('.metric-change');
        if (changeEl) {
            if (metricType.includes('production efficiency')) {
                changeEl.textContent = '3.2% from last month';
                changeEl.className = 'metric-change up';
            } else if (metricType.includes('total revenue')) {
                changeEl.textContent = '4.7% from last month';
                changeEl.className = 'metric-change up';
            } else if (metricType.includes('generated reports')) {
                changeEl.textContent = '5 more this month';
                changeEl.className = 'metric-change up';
            } else if (metricType.includes('kpi achievement')) {
                changeEl.textContent = '4% this quarter';
                changeEl.className = 'metric-change up';
            }
        }
    });
}

/**
 * Update the reports table in the Reports section
 */
function updateReportsTable() {
    const reportsTable = document.querySelector('#reports .data-table tbody');
    if (reportsTable) {
        // Clear existing table content
        reportsTable.innerHTML = '';
        
        // Add sample report data
        const reports = [
            {
                name: 'Monthly Production Summary',
                type: 'Production',
                date: 'Mar 15, 2025',
                region: 'All Regions',
                status: 'Completed'
            },
            {
                name: 'Quarterly Financial Analysis',
                type: 'Financial',
                date: 'Mar 10, 2025',
                region: 'All Regions',
                status: 'Completed'
            },
            {
                name: 'Supplier Performance Review',
                type: 'Suppliers',
                date: 'Mar 5, 2025',
                region: 'NSW',
                status: 'Completed'
            },
            {
                name: 'Quality Control Analysis',
                type: 'Quality',
                date: 'Mar 3, 2025',
                region: 'Victoria',
                status: 'Completed'
            },
            {
                name: 'Annual Production Report',
                type: 'Production',
                date: 'In Progress',
                region: 'All Regions',
                status: 'Generating'
            }
        ];
        
        // Add each report to the table
        reports.forEach(report => {
            const statusClass = report.status === 'Completed' ? 'badge-success' : 'badge-warning';
            const disabledButtons = report.status !== 'Completed';
            
            reportsTable.innerHTML += `
                <tr>
                    <td>${report.name}</td>
                    <td>${report.type}</td>
                    <td>${report.date}</td>
                    <td>${report.region}</td>
                    <td><span class="${statusClass}">${report.status}</span></td>
                    <td>
                        <button class="btn-icon" ${disabledButtons ? 'disabled' : ''}><i class="fas fa-download"></i></button>
                        <button class="btn-icon" ${disabledButtons ? 'disabled' : ''}><i class="fas fa-eye"></i></button>
                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

/**
 * Initialize charts with fetched data
 */
function initializeCharts(data, region) {
    // Define available charts
    const charts = {
        // Overview charts
        regionCollectionChart: {
            type: 'bar',
            container: 'regionCollectionChart',
            cssClass: 'bar-chart',
            data: () => ({
                labels: ['New South Wales', 'Queensland', 'Western Australia', 'Victoria'],
                datasets: [{
                    label: 'Milk Collection (Liters)',
                    data: [
                        data.nsw?.milkCollection || 0,
                        data.queensland?.milkCollection || 0,
                        data.wa?.milkCollection || 0,
                        data.victoria?.milkCollection || 0
                    ],
                    backgroundColor: [
                        'rgba(0, 91, 153, 0.7)',
                        'rgba(76, 175, 80, 0.7)',
                        'rgba(247, 183, 51, 0.7)',
                        'rgba(108, 117, 125, 0.7)'
                    ],
                    borderWidth: 0
                }]
            })
        },
        productionTrendChart: {
            type: 'line',
            container: 'productionTrendChart',
            cssClass: 'line-chart',
            data: () => ({
                labels: data.overview.productionTrend.months,
                datasets: [{
                    label: 'Milk Collection (K Liters)',
                    data: data.overview.productionTrend.milk.map(val => val/1000),
                    borderColor: 'rgba(0, 91, 153, 1)',
                    backgroundColor: 'rgba(0, 91, 153, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Cheese Production (K kg)',
                    data: data.overview.productionTrend.cheese.map(val => val/1000),
                    borderColor: 'rgba(247, 183, 51, 1)',
                    backgroundColor: 'rgba(247, 183, 51, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            })
        },
        // NSW charts
        nswDailyCollectionChart: {
            type: 'line',
            container: 'nswDailyCollectionChart',
            cssClass: 'line-chart',
            data: () => ({
                labels: data.nsw.dailyCollection.days,
                datasets: [{
                    label: 'Daily Collection (Liters)',
                    data: data.nsw.dailyCollection.values,
                    borderColor: 'rgba(0, 91, 153, 1)',
                    backgroundColor: 'rgba(0, 91, 153, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            })
        },
        nswProductDistributionChart: {
            type: 'pie',
            container: 'nswProductDistributionChart',
            cssClass: 'pie-chart',
            data: () => ({
                labels: data.nsw.productDistribution.categories,
                datasets: [{
                    data: data.nsw.productDistribution.values,
                    backgroundColor: [
                        'rgba(0, 91, 153, 0.7)',
                        'rgba(76, 175, 80, 0.7)',
                        'rgba(247, 183, 51, 0.7)',
                        'rgba(108, 117, 125, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderWidth: 0
                }]
            })
        },
        // Queensland charts
        qldDailyCollectionChart: {
            type: 'line',
            container: 'qldDailyCollectionChart',
            cssClass: 'line-chart',
            data: () => ({
                labels: data.queensland.dailyCollection.days,
                datasets: [{
                    label: 'Daily Collection (Liters)',
                    data: data.queensland.dailyCollection.values,
                    borderColor: 'rgba(76, 175, 80, 1)',
                    backgroundColor: 'rgba(76, 175, 80, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            })
        },
        qldProductDistributionChart: {
            type: 'pie',
            container: 'qldProductDistributionChart',
            cssClass: 'pie-chart',
            data: () => ({
                labels: data.queensland.productDistribution.categories,
                datasets: [{
                    data: data.queensland.productDistribution.values,
                    backgroundColor: [
                        'rgba(0, 91, 153, 0.7)',
                        'rgba(76, 175, 80, 0.7)',
                        'rgba(247, 183, 51, 0.7)',
                        'rgba(108, 117, 125, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderWidth: 0
                }]
            })
        },
        // WA charts
        waDailyCollectionChart: {
            type: 'line',
            container: 'waDailyCollectionChart',
            cssClass: 'line-chart',
            data: () => ({
                labels: data.wa.dailyCollection.days,
                datasets: [{
                    label: 'Daily Collection (Liters)',
                    data: data.wa.dailyCollection.values,
                    borderColor: 'rgba(247, 183, 51, 1)',
                    backgroundColor: 'rgba(247, 183, 51, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            })
        },
        waProductDistributionChart: {
            type: 'pie',
            container: 'waProductDistributionChart',
            cssClass: 'pie-chart',
            data: () => ({
                labels: data.wa.productDistribution.categories,
                datasets: [{
                    data: data.wa.productDistribution.values,
                    backgroundColor: [
                        'rgba(0, 91, 153, 0.7)',
                        'rgba(76, 175, 80, 0.7)',
                        'rgba(247, 183, 51, 0.7)',
                        'rgba(108, 117, 125, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderWidth: 0
                }]
            })
        },
        // Victoria charts
        vicDailyCollectionChart: {
            type: 'line',
            container: 'vicDailyCollectionChart',
            cssClass: 'line-chart',
            data: () => ({
                labels: data.victoria.dailyCollection.days,
                datasets: [{
                    label: 'Daily Collection (Liters)',
                    data: data.victoria.dailyCollection.values,
                    borderColor: 'rgba(108, 117, 125, 1)',
                    backgroundColor: 'rgba(108, 117, 125, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            })
        },
        vicProductDistributionChart: {
            type: 'pie',
            container: 'vicProductDistributionChart',
            cssClass: 'pie-chart',
            data: () => ({
                labels: data.victoria.productDistribution.categories,
                datasets: [{
                    data: data.victoria.productDistribution.values,
                    backgroundColor: [
                        'rgba(0, 91, 153, 0.7)',
                        'rgba(76, 175, 80, 0.7)',
                        'rgba(247, 183, 51, 0.7)',
                        'rgba(108, 117, 125, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderWidth: 0
                }]
            })
        }
    };
    
    // Create or update charts based on available data
    Object.keys(charts).forEach(chartId => {
        const chartConfig = charts[chartId];
        const chartElement = document.getElementById(chartConfig.container);
        
        if (chartElement) {
            // Add CSS class for specific chart type
            if (chartConfig.cssClass) {
                chartElement.classList.add(chartConfig.cssClass);
            }
            
            // Check if we need to create or update the chart
            if (chartElement.chart) {
                // Update existing chart
                chartElement.chart.data = chartConfig.data();
                chartElement.chart.update();
            } else {
                // Create chart wrapper if it doesn't exist
                if (!chartElement.parentElement.classList.contains('chart-wrapper')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'chart-wrapper';
                    chartElement.parentNode.insertBefore(wrapper, chartElement);
                    wrapper.appendChild(chartElement);
                }
                
                // Create new chart
                chartElement.chart = new Chart(chartElement.getContext('2d'), {
                    type: chartConfig.type,
                    data: chartConfig.data(),
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: chartConfig.type === 'bar',
                                grid: {
                                    borderDash: [3, 3]
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: chartConfig.type !== 'line' || chartId === 'productionTrendChart',
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 15,
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        },
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10
                            }
                        }
                    }
                });
            }
        }
    });
}

/**
 * Helper function to format numbers with commas
 */
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
} 