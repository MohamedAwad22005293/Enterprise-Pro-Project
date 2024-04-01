<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rakusen</title>
<link rel="stylesheet" href="ReportsStyle.Css">
</head>
<body>

    <div class="top-bar">
        <div class="top-left">
            <img src="Images\rakusen.png" alt="Company Logo" class="logo">
        </div>
        <div class="middle-section">
            <h1>Inventory Analysis & Reports</h1>
        </div>
        <div class="top-right">
            <a href="#" style="color: rgb(0, 0, 0);">Contact Us</a>
        </div>
    </div>
    
    <div class="navbar">
        <ul>
            <li><a href="Dashboard.html">Dashboard</a></li>
            <li><a href="Items.html">Items</a></li>
            <li><a href="Orders.html">Orders</a></li>
            <li><a href="Alerts.html">Alerts</a></li>
            <li><a href="Reports.html">Reports</a></li>
            <li><a href="Account.html">Account</a></li>
            <li><a href="Login.html">Logout</a></li>
        </ul>
    </div>
    
    <div class="dashboard">
        <div class="content">
            <h3>Inventory Analysis & Reports Section</h3>
            <div class="piechart-box">
                <h3>Products-wise Inventory Value</h3>
                <canvas id="pieChart" width="400" height="400"></canvas>
                <button onclick="window.print()">Print Pie Chart</button>
            </div>

            <div class="statisticalgraph-box">
                <h3>Most Requested Products</h3>
                <canvas id="myChart" style="width:100%;max-width:600px;height:400px"></canvas>
                <button onclick="window.print()">Print Statistical Graph</button>
            </div>

            <div class="filter-box">
                <h3>Item Performance Filter</h3>
                <p></p>
                <button onclick="applyFilter()">Apply Filter</button>
                <button onclick="window.print()">Print Filtered Results</button>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <p>&copy; 2024 Rakusen. All rights reserved.</p>
    </footer>

<!-- Chart.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

<script>
// Data for the pie chart
const pieChartLabels = ["Rakusen's Matzos Crackers", "Vegan Water Biscuit", "Passover - Matzos", "Chocolate Oaties", "Baked Beans"];
const pieChartData = [200, 150, 180, 120, 170]; // Example data for inventory value

// Pie chart configuration
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: pieChartLabels,
        datasets: [{
            label: 'Inventory Value',
            data: pieChartData,
            backgroundColor: ['red', 'green', 'blue', 'orange', 'brown']
        }]
    },
    options: {
        legend: { display: true, position: 'bottom' },
        title: { display: true, text: 'Products-wise Inventory Value' }
    }
});

// Data for the bar chart
const xValues = ["Rakusen's Matzos Crackers", "Vegan Water Biscuit", "Passover - Matzos", "Chocolate Oaties", "Baked Beans"];
const yValues = [55, 49, 44, 24, 45];
const barColors = ["red", "green", "blue", "orange", "brown"];

// Bar chart configuration
new Chart(document.getElementById('myChart'), {
    type: 'bar',
    data: {
        labels: xValues,
        datasets: [{
            backgroundColor: barColors,
            data: yValues
        }]
    },
    options: {
        legend: { display: false },
        title: { display: true, text: 'Most Requested Products' }
    }
});
</script>

</body>
</html>