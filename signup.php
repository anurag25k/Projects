<?php
include 'connection.php';
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'Ann');

if (isset($_POST['sign'])) {
    $username = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    // Server-side validation
    if (!preg_match('/^[a-zA-Z0-9]{3,}$/', $username)) {
        echo "<h1><center>Username must be at least 3 characters long and contain only alphanumeric characters</center></h1>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<h1><center>Invalid email format</center></h1>";
    } elseif (strlen($password) < 6) {
        echo "<h1><center>Password must be at least 6 characters long</center></h1>";
    } elseif (!in_array($gender, ['male', 'female'])) {
        echo "<h1><center>Please select a valid gender</center></h1>";
    } else {
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("SELECT * FROM login WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $num = $result->num_rows;

        if ($num == 1) {
            echo "<h1><center>Account already exists</center></h1>";
        } else {
            $stmt = $connection->prepare("INSERT INTO login (name, email, password, gender) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $pass, $gender);
            if ($stmt->execute()) {
                header("Location: signin.php");
            } else {
                echo '<script type="text/javascript">alert("Data not saved")</script>';
            }
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
    <title>Login</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script>
        function validateForm() {
            const username = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const male = document.getElementById('male').checked;
            const female = document.getElementById('female').checked;

            const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            const usernamePattern = /^[a-zA-Z0-9]{3,}$/;

            if (!username.match(usernamePattern)) {
                alert('Username must be at least 3 characters long and contain only alphanumeric characters.');
                return false;
            }

            if (!email.match(emailPattern)) {
                alert('Please enter a valid email address.');
                return false;
            }

            if (password.length < 6) {
                alert('Password must be at least 6 characters long.');
                return false;
            }

            if (!male && !female) {
                alert('Please select your gender.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>

    <div class="container">
        <div class="regform">
            <form action="" method="post" onsubmit="return validateForm()">
                <p class="logo">आहार<b style="color: #06C167;">मित्र</b></p>
                <p id="heading">Create your account</p>
                
                <div class="input">
                    <label class="textlabel" for="name">User name</label><br>
                    <input type="text" id="name" name="name" required/>
                </div>
                <div class="input">
                    <label class="textlabel" for="email">Email</label>
                    <input type="email" id="email" name="email" required/>
                </div>
                <label class="textlabel" for="password">Password</label>
                <div class="password">
                    <input type="password" name="password" id="password" required/>
                    <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>
                </div>
                <div class="radio">
                    <input type="radio" name="gender" id="male" value="male" required/>
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="female">
                    <label for="female">Female</label>
                </div>
                <div class="btn">
                    <button type="submit" name="sign">Continue</button>
                </div>
                <div class="signin-up">
                    <p style="font-size: 20px; text-align: center;">Already have an account? <a href="signin.php">Sign in</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="admin/login.js"></script>
</body>
</html>
