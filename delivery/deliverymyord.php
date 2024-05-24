<?php
ob_start(); 

$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'Ann');
include '../connection.php';
include("connect.php"); 

if($_SESSION['name']==''){
	header("location:deliverylogin.php");
}

$name=$_SESSION['name'];
$id=$_SESSION['Did'];

// Query to fetch data from the assigned table
$sql = "SELECT name, phoneno, date, address FROM assigned";
$result = mysqli_query($connection, $sql);

// Check if query executed successfully
if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="delivery.css">
    <link rel="stylesheet" href="../home.css">
</head>
<body>
<header>
    <div class="logo">आहार<b style="color: #06C167;">मित्र</b></div>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="delivery.php">Home</a></li>
            <li><a href="openmap.php">map</a></li>
            <li><a href="deliverymyord.php" class="active">myorders</a></li>
        </ul>
    </nav>
</header>
<br>
<script>
    hamburger=document.querySelector(".hamburger");
    hamburger.onclick =function(){
        navBar=document.querySelector(".nav-bar");
        navBar.classList.toggle("active");
    }
</script>
<style>
    .itm{
        background-color: white;
        display: grid;
    }
    .itm img{
        width: 400px;
        height: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    p{
        text-align: center; 
        font-size: 28px;
        color: black; 
    }
    a{
        /* text-decoration: underline; */
    }
    @media (max-width: 767px) {
        .itm{
            /* float: left; */
        }
        .itm img{
            width: 350px;
            height: 350px;
        }
    }
</style>

<div class="itm">
    <img src="../img/delivery.gif" alt="" width="400" height="400"> 
</div>

<div class="get">
    <div class="log">
        <!-- <button type="submit" name="food" onclick="">My orders</button> -->
        <a href="delivery.php">Take orders</a>
        <p>Order assigned to you</p>
        <br>
    </div>

    <!-- Display the orders from the assigned table in an HTML table -->
    <div class="table-container">
        <!-- <p id="heading">donated</p> -->
        <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone No</th>
                    <th>Date/Time</th>
                    <th>Pickup Address</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                // Iterate over the result set and populate table rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['phoneno'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='name' value='" . $row['name'] . "'>";
                    echo "<input type='hidden' name='phoneno' value='" . $row['phoneno'] . "'>";
                    echo "<input type='hidden' name='date' value='" . $row['date'] . "'>";
                    echo "<input type='hidden' name='address' value='" . $row['address'] . "'>";
                    
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<br>
<br>
</body>
</html>
