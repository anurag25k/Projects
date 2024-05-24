<?php
ob_start(); 
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'Ann');
include("connect.php"); 
include '../connection.php';
if($_SESSION['name']==''){
    header("location:deliverylogin.php");
}
$name=$_SESSION['name'];
$city=$_SESSION['city'];
$id=$_SESSION['Did'];

// Query to fetch data from food_donations table
$sql = "SELECT name, phoneno, date, address FROM food_donations";
$result = mysqli_query($connection, $sql);

// Check if query executed successfully
if (!$result) {
    die("Error executing query: " . mysqli_error($connection));
}

// Function to insert data into Assigned table
function insertIntoAssigned($connection, $name, $phoneno, $date, $address) {
    $query = "INSERT INTO Assigned (name, phoneno, date, address) VALUES ('$name', '$phoneno', '$date', '$address')";
    $insertResult = mysqli_query($connection, $query);
    if (!$insertResult) {
        die("Error inserting data into Assigned table: " . mysqli_error($connection));
    }
}

// Check if the "Take" button is clicked
if (isset($_POST['take'])) {
    $name = $_POST['name'];
    $phoneno = $_POST['phoneno'];
    $date = $_POST['date'];
    $address = $_POST['address'];
    insertIntoAssigned($connection, $name, $phoneno, $date, $address);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../home.css">
    <link rel="stylesheet" href="delivery.css">
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
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="openmap.php">Map</a></li>
            <li><a href="deliverymyord.php">My Orders</a></li>
            <li><a href="../index.html">Logout</a></li> <!-- Logout button -->
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

<div class="itm">
    <img src="../img/delivery.gif" alt="" width="400" height="400"> 
</div>

<h2><center>Welcome <?php echo $name; ?></center></h2>

<div class="log">
    <a href="deliverymyord.php">My Orders</a>
</div>

<!-- Display the orders in an HTML table -->
<div class="table-container">
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone No</th>
                    <th>Date/Time</th>
                    <th>Pickup Address</th>
                    <th>Action</th>
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
                    echo "<button type='submit' name='take'>Take</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<br>
<br>
</body>
</html>
