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

.navbar ul li a:hover {
    color: #666; 
}
    .dashboard {
        margin-left: 200px;
        padding-top: 70px;
    }

    .content {
        text-align: center;
        background-color: #f4f2f2;
        padding: 20px;
        border-radius: 5px;

    }

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

    .logo {
        max-width: 50px;
        max-height: 50px;
    }

    .top-left {
        padding: 10px;
    }

    .top-right {
        padding: 30px;
        border-radius: 5px
    }


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


    .statisticalgraph-box {
        text-align: center;
        width: calc(30% - 20px); 
        background-color: #787fce;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        display: inline-block; 
        float: right
    
    }
    .filter-box {
        text-align: center;
        width: calc(30% - 20px);
        background-color: #0041f7;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        display: inline-block; 
        float: right
        float: right;
        margin-left: auto;
        margin-right: auto; 
    
    
}

.piechart-box,
.statisticalgraph-box,
.filter-box {
    width: calc(40% - 20px);
    height: 400px; 
    margin: 20px;
}

.footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 0px ;
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 5;
}
    

   
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