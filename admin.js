document.addEventListener('DOMContentLoaded', () => {
    loadHeader();
    loadSideNav();
    initializeDashboard();
    setupReportsFilter();
});

// Load header
function loadHeader() {
    fetch('php/header.php')
        .then(response => response.text())
        .then(html => document.getElementById('header').innerHTML = html)
        .catch(error => console.error('Error loading header:', error));
}

// Load side navigation
function loadSideNav() {
    fetch('php/adminsidenav.php')
        .then(response => response.text())
        .then(html => document.getElementById('sidenav').innerHTML = html)
        .catch(error => console.error('Error loading sidenav:', error));
}

// Initialize dashboard
function initializeDashboard() {
    const monthSelector = document.getElementById('monthSelector');
    const currentMonth = document.getElementById('currentMonth');

    populateMonthSelector();
    fetchAndRenderDashboardData(monthSelector.value);

    monthSelector.addEventListener('change', (e) => {
        const selectedMonth = e.target.value;
        currentMonth.textContent = monthSelector.options[monthSelector.selectedIndex].textContent;
        fetchAndRenderDashboardData(selectedMonth);
    });
}

function populateMonthSelector() {
    const date = new Date();
    const monthSelector = document.getElementById('monthSelector');
    for (let i = 0; i < 12; i++) {
        const month = new Date(date.getFullYear(), date.getMonth() - i, 1);
        const option = document.createElement('option');
        option.value = month.toISOString().slice(0, 7);
        option.textContent = month.toLocaleString('default', { month: 'long', year: 'numeric' });
        monthSelector.appendChild(option);
    }
}

async function fetchAndRenderDashboardData(month) {
    try {
        const response = await fetch(`php/admin_data.php?month=${month}`);
        const data = await response.json();

        renderSalesChart(data.sales);
        renderTopProducts(data.topProducts);
        renderMonthlyOrders(data.orders);
        renderLowStock(data.lowStock);
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
}

function renderSalesChart(sales) {
    const salesChartCtx = document.getElementById('salesChart').getContext('2d');
    const dates = sales.map(sale => sale.sale_date);
    const totals = sales.map(sale => sale.total);

    new Chart(salesChartCtx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Sales',
                data: totals,
                borderColor: 'blue',
                fill: false,
            }]
        },
    });
}

function renderTopProducts(topProducts) {
    const topProductsList = document.getElementById('topProducts');
    topProductsList.innerHTML = '';
    topProducts.forEach(product => {
        const listItem = document.createElement('li');
        listItem.textContent = `${product.productName} (${product.total_sold} sold)`;
        topProductsList.appendChild(listItem);
    });
}

function renderMonthlyOrders(orders) {
    const monthlyOrdersTable = document.getElementById('monthlyOrders');
    monthlyOrdersTable.innerHTML = '';
    orders.forEach(order => {
        const row = document.createElement('tr');
        row.innerHTML = `<td>${order.productName}</td><td>${order.quantity}</td><td>${order.total}</td>`;
        monthlyOrdersTable.appendChild(row);
    });
}

function renderLowStock(lowStock) {
    const lowStockList = document.getElementById('lowStock');
    lowStockList.innerHTML = '';
    lowStock.forEach(product => {
        const listItem = document.createElement('li');
        listItem.textContent = `${product.productName} (${product.quantity} left)`;
        listItem.classList.add('text-danger');
        lowStockList.appendChild(listItem);
    });
}

// Setup report filter
function setupReportsFilter() {
    const filterButton = document.getElementById('filterButton');
    filterButton.addEventListener('click', async () => {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (startDate && endDate) {
            const response = await fetch(`php/reports_data.php?startDate=${startDate}&endDate=${endDate}`);
            const salesReports = await response.json();

            renderSalesReports(salesReports);
        }
    });
}

function renderSalesReports(salesReports) {
    const salesReportsTable = document.getElementById('salesReports');
    salesReportsTable.innerHTML = '';
    salesReports.forEach(report => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${report.sale_id}</td>
            <td>${report.user_id}</td>
            <td>${report.product_id}</td>
            <td>${report.quantity}</td>
            <td>${report.price}</td>
            <td>${report.sale_date}</td>
        `;
        salesReportsTable.appendChild(row);
    });
}
