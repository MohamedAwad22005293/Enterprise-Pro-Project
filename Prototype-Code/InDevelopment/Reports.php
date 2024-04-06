<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    // Redirect to login page if not logged in
    header("Location: Login.html");
    exit();
}


// Establish a database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "rwsdb";

$connection = mysqli_connect($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rakusen</title>

<style>
  
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f2f2;
    }

    /* Navbar styles */
    .navbar {
        position: fixed;
        top: 103px;
        left: 0;
        width: 200px;
        height: calc(100% - 70px);
        background-color: #ffffff;
        color: #000000;
        padding-top: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
    }

    /* Navbar list styles */
    .navbar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .navbar ul li {
        padding: 10px 20px;
        border-bottom: 1px solid #fff;
    }

    .navbar ul li:last-child {
        border-bottom: none;
    }
    
    .navbar ul li a {
    text-decoration: none; 
    color: black; 
}

/* Navbar link hover effect */
.navbar ul li a:hover {
    color: #666; 
}

    /* Dashboard content container */
    .dashboard {
        margin-left: 200px;
        padding-top: 70px;
    }

    /* Content styling */
    .content {
        text-align: center;
        background-color: #f4f2f2;
        padding: 20px;
        border-radius: 5px;
    }

    /* Top bar styling */
    .top-bar {
        background-color: #ffffff;
        color: #000000;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        border-bottom: 1px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Logo styling */
    .logo {
        max-width: 50px;
        max-height: 50px;
    }

    /* Top left section styling */
    .top-left {
        padding: 10px;
    }

    /* Top right section styling */
    .top-right {
        padding: 30px;
        border-radius: 5px
    }

    /* Responsive styles for smaller screens */
    @media (max-width: 600px) {
        .top-bar {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }
        .top-right {
            margin-top: 10px; 
        }
        .navbar {
            top: 120px; 
        }
    }
    
    /* Styling for pie chart box */
    .piechart-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #60eb60;
        padding: 20px;
        margin-right: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        float: left;
    }

    /* Styling for statistical graph box */
    .statisticalgraph-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #787fce;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        display: inline-block; 
        float: right;
    }

    /* Styling for filter box */
    .filter-box {
    text-align: center;
    width: calc(30% - 20px);
    background-color: #0041f7;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    margin-left: auto;
    margin-right: auto; 
}

    /* Common styling for box elements */
    .piechart-box,
    .statisticalgraph-box,
    .filter-box {
        width: calc(40% - 20px);
        height: 400px; 
        margin: 20px;
    }

    /* Footer styling */
    .footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 10px; /* Adjust padding as needed */
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 50px; /* Set the height with a unit (e.g., pixels) */
    }

    /* Responsive styles for smaller screens */
    @media (max-width: 600px) {
        .piechart-box {
            width: calc(100% - 20px); 
            margin-right: 0;
        }
        .filter-box {
            width: calc(100% - 20px);
        }
    }
</style>

</head>
<body>

    <!-- Top bar section -->
    <div class="top-bar">
        <!-- Left section with logo -->
        <div class="top-left">
            <img src="rakusen.png" alt="Company Logo" class="logo">
        </div>
        <!-- Middle section with title -->
        <div class="middle-section">
            <h1>Rakusen Warehouse</h1>
        </div>
        <!-- Right section with contact link -->
        <div class="top-right">
            <a href="ContactUsPage.html" style="color: rgb(0, 0, 0);">Contact Us</a>
        </div>
    </div>
    
    <!-- Navbar section -->
    <div class="navbar">
        <ul>
            <li><a href="Dashboard.php">Dashboard</a></li>
            <li><a href="Inventory.php">Inventory</a></li>
            <li><a href="Orders.php">Orders</a></li>
            <li><a href="Alerts.php">Alerts</a></li>
            <li><a href="Reports.php">Reports</a></li>
            <li><a href="AccountPage.php">Account</a></li>
            <?php 
            // Check if the user is logged in and retrieve their role from the database
            if (isset($_SESSION['user_email'])) {
                // Establish database connection (replace with your connection code)
                $connection = mysqli_connect($host, $username, $password, $database);

                // Check if connection was successful
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // Retrieve user's role from the database
                $user_email = $_SESSION['user_email'];
                $query = "SELECT role FROM users WHERE email = '$user_email'";
                $result = mysqli_query($connection, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $user_role = $row['role'];
                }

                // Close database connection
                mysqli_close($connection);

                // Check if user is a manager and display the "Manage Users" and "Vendor Orders" link
                if ($user_role == 'Manager') {
                    echo '<li><a href="VendorItems.php">Vendor Orders</a></li>';
                    echo '<li><a href="Manage_users.php">Manage Users</a></li>';
                }
            }
        ?>
            <li><a href="Logout.php.">Logout</a></li>
        </ul>
    </div>
    
    

    <!-- Main dashboard content -->
    <div class="dashboard">
        <div class="content">
            <h3>Inventory Analysis & Reports Section</h3>
            <!-- Pie chart box -->
            <div class="piechart-box">
                <h3>Products-wise Inventory Value</h3>
                <canvas id="pieChart" width="400" height="400"></canvas>
                <button onclick="window.print()">Print Pie Chart</button>
            </div>

            <!-- Statistical graph box -->
            <div class="statisticalgraph-box">
                <h3>Most Requested Products</h3>
                <canvas id="myChart" style="width:100%;max-width:600px;height:400px"></canvas>
                <button onclick="window.print()">Print Statistical Graph</button>
            </div>

            <!-- Filter box -->
            <div class="filter-box">
                <h3>Item Performance Filter</h3>
                <div class="filter-container">
                    <label for="period" class="filter-label">Period:</label>
                    <select id="period" class="filter-select">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
                <div class="filter-container">
                    <label for="item" class="filter-label">Item:</label>
                    <select id="item" class="filter-select">
                        <option value="Rakusen's Matzos Crackers">Rakusen's Matzos Crackers</option>
                        <option value="Vegan Water Biscuit">Vegan Water Biscuit</option>
                        <option value="Passover - Matzos">Passover - Matzos</option>
                        <option value="Chocolate Oaties">Chocolate Oaties</option>
                        <option value="Baked Beans">Baked Beans</option>
                    </select>
                </div>
                <canvas id="performanceChart"></canvas>
                <p></p>
                <button onclick="applyFilter()">Apply Filter</button>
                <button onclick="window.print()">Print Filtered Results</button>
            </div>
        </div>
    </div>
    
    <!-- Footer section -->
    <footer class="footer">
        <p>&copy; 2024 Rakusen. All rights reserved.</p>
    </footer>

<!-- Chart.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

<!-- JavaScript code -->
<script>
// Data for the pie chart
const pieChartLabels = ["Rakusen's Matzos Crackers", "Vegan Water Biscuit", "Passover - Matzos", "Chocolate Oaties", "Baked Beans"];
const pieChartData = [200, 150, 180, 120, 170]; 

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

var data = {
    daily: {
        "Rakusen's Matzos Crackers": [30, 40, 45, 55, 60, 65, 70],
        "Vegan Water Biscuit": [20, 25, 30, 35, 40, 45, 50],
        "Passover - Matzos": [50, 55, 60, 65, 70, 75, 80],
        "Chocolate Oaties": [45, 50, 55, 60, 65, 70, 75],
        "Baked Beans": [55, 60, 65, 70, 75, 80, 85]
    },
    weekly: {
        "Rakusen's Matzos Crackers": [120, 150, 170, 200, 220],
        "Vegan Water Biscuit": [90, 110, 130, 150, 170],
        "Passover - Matzos": [180, 200, 220, 240, 260],
        "Chocolate Oaties": [160, 180, 200, 220, 240],
        "Baked Beans": [200, 220, 240, 260, 280]
    },
    monthly: {
        "Rakusen's Matzos Crackers": [500, 600, 700, 800, 900, 1000],
        "Vegan Water Biscuit": [400, 500, 600, 700, 800, 900],
        "Passover - Matzos": [800, 900, 1000, 1100, 1200, 1300],
        "Chocolate Oaties": [700, 800, 900, 1000, 1100, 1200],
        "Baked Beans": [900, 1000, 1100, 1200, 1300, 1400]
    }
};

var ctx = document.getElementById('performanceChart').getContext('2d');
var myChart;

function updateChart() {
    var period = document.getElementById('period').value;
    var item = document.getElementById('item').value;
    if (myChart) {
        myChart.destroy();
    }
    myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: getLabels(period),
            datasets: [{
                label: item,
                data: getData(period, item),
                borderColor: 'red', 
                borderWidth: 2,
                fill: false
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

function getLabels(period) {
    if (period === 'daily') {
        return ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
    } else if (period === 'weekly') {
        return ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
    } else if (period === 'monthly') {
        return ['Month 1', 'Month 2', 'Month 3', 'Month 4', 'Month 5', 'Month 6'];
    }
}

function getData(period, item) {
    return data[period][item];
}

updateChart();

document.getElementById('period').addEventListener('change', updateChart);
document.getElementById('item').addEventListener('change', updateChart);

function applyFilter() {
    updateChart();
}

</script>

</body>
</html>