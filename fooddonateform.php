<?php
include("login.php"); 
if ($_SESSION['name'] == '') {
    header("location: signin.php");
}
$emailid = $_SESSION['email'];
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'Ann');

if (isset($_POST['submit'])) {
    $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal = mysqli_real_escape_string($connection, $_POST['meal']);
    $category = $_POST['image-choice'];
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);

    // Server-side validation
    if (is_numeric($foodname)) {
        echo '<script type="text/javascript">alert("Food name should not be a number.");</script>';
    } elseif (!is_numeric($quantity) || $quantity <= 0) {
        echo '<script type="text/javascript">alert("Quantity should be a positive number.");</script>';
    } elseif (preg_match('/\d/', $name)) {
        echo '<script type="text/javascript">alert("Name should not include a number.");</script>';
    } else {
        $query = "INSERT INTO food_donations(email, food, type, category, phoneno, location, address, name, quantity) 
                  VALUES ('$emailid', '$foodname', '$meal', '$category', '$phoneno', '$district', '$address', '$name', '$quantity')";
        $query_run = mysqli_query($connection, $query);
        if ($query_run) {
            echo '<script type="text/javascript">alert("Data saved");</script>';
            header("location: delivery.html");
        } else {
            echo '<script type="text/javascript">alert("Data not saved");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnnBramha</title>
    <link rel="stylesheet" href="loginstyle.css">
    <script>
        function validateForm() {
            const foodName = document.getElementById('foodname').value;
            const quantity = document.getElementById('quantity').value;
            const name = document.getElementById('name').value;
            const errorMessage = document.getElementById('error-message');
            errorMessage.textContent = '';

            // Validate food name is not a number
            if (!isNaN(foodName)) {
                errorMessage.textContent = 'Food name should not be a number.';
                return false;
            }

            // Validate quantity is a positive number
            if (isNaN(quantity) || quantity <= 0) {
                errorMessage.textContent = 'Quantity should be a positive number.';
                return false;
            }

            // Validate name does not include numbers
            if (/\d/.test(name)) {
                errorMessage.textContent = 'Name should not include a number.';
                return false;
            }

            return true;
        }
    </script>
</head>
<body style="background-color: #06C167;">
    <div class="container">
        <div class="regformf">
            <form action="" method="post" onsubmit="return validateForm()">
                <p class="logo" style="color:black;">आहार<b style="color: #06C167;">मित्र</b></p>

                <div class="input">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required />
                </div>

                <div class="radio">
                    <label for="meal">Meal type :</label>
                    <br><br>
                    <input type="radio" name="meal" id="veg" value="veg" required />
                    <label for="veg" style="padding-right: 40px;">Veg</label>
                    <input type="radio" name="meal" id="Non-veg" value="Non-veg">
                    <label for="Non-veg">Non-veg</label>
                </div>
                <br>
                <div class="input">
                    <label for="food">Select the Category:</label>
                    <br><br>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                            <img src="img/raw-food.png" alt="raw-food">
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                            <img src="img/cooked-food.png" alt="cooked-food">
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                            <img src="img/packed-food.png" alt="packed-food">
                        </label>
                    </div>
                    <br>
                </div>
                <div class="input">
                    <label for="quantity">Quantity:(number of person /kg)</label>
                    <input type="text" id="quantity" name="quantity" required />
                </div>
                <b><p style="text-align: center;">Contact Details</p></b>
                <div class="input">
                    <div>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" required />
                    </div>
                    <div>
                        <label for="phoneno">Phone No:</label>
                        <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required />
                    </div>
                </div>
                <div class="input">
                    <label for="Area">Area:</label>
                    <select id="Area" name="Area" style="padding:10px; padding-left: 20px;">
                        <option value="Chinchwad">Chinchwad</option>
                        <option value="PimpleSaudagar">Pimple Saudagar</option>
                        <option value="Pimpri" selected>Pimpri</option>
                    </select>
                    <label for="address" style="padding-left: 10px;">Address:</label>
                    <input type="text" id="address" name="address" required />
                </div>
                <div class="btn">
                    <button type="submit" name="submit">Submit</button>
                </div>
                <p id="error-message" style="color: red;"></p>
            </form>
        </div>
    </div>
</body>
</html>
