<!Doctype html>
<html>
<head>
    <title> Reset Password Design</title>
    <link rel="stylesheet" type="text/css" href="../global.css">   
</head>
    <body>
    <div class="login-box">
    <img src="../images/avatar.png" alt="login Img" class="avatar">
        <h1>Reset Password</h1>
            <form method = "POST">
				<p>Username</p>
				<input type="text" name="username" placeholder="Enter Username">
				<p>Password</p>
                <input type="password" name="password" placeholder="Enter Password">
                <p>Confirm Password</p>
                <input type="password" name="confirm_pass" placeholder="Confirm Password">
                <div class ="btn_reset">
                    <input type="submit" name="submit" value="Reset Password">
                </div>
            </form>
        </div>
        <?php
            require_once("connect.php");
            if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST["submit"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $confirmpwd = $_POST["confirm_pass"];
                $query = "SELECT *
                          FROM User";
                $sql = "UPDATE User
                        SET Password = '".$password."'
                        WHERE Username = '".$username."'";
                $target = NULL;
                $result = mysqli_query($db, $query);
                if ($password != $confirmpwd) {
                    echo "The passwords are not the same.";
                    exit();
                }
                else if (empty($username) && empty($password) && empty($confirmpwd)) {
                    echo "Enter a value in all fields.";
                    exit();
                }
                else if (empty($username)) {
                    echo "Enter a valid username";
                    exit();
                }
                else if (empty($password)) {
                    echo "Enter a valid password";
                    exit();
                }
                else if (empty($confirmpwd)) {
                    echo "Enter a valid password to confirm";
                    exit();
                }
                else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['Username'] == $username) {
                            $target = $username;
                            break;
                        }
                    }
                    if ($result == FALSE) {
                        echo "You have entered an invalid username.";
                        exit();
                    }
                    else if (is_null($target)) {
                        echo "Enter a valid username";
                        exit();
                    }
                    else {
                        if (mysqli_query($db, $sql)) {
                            echo "Password updated successfully";
                            header("location: http://localhost/TCSS545-node-database/login.html");
                        } else {
                            echo "Error: " . $sql . "<br>" . mysqli_error($db);
                            exit();
                        }
                    }
                }
            }
            mysqli_close($db);
        ?>
    </body>
</html>
