
<?php 

	session_start();
	// Check if the user is already logged in, if yes then redirect him to welcome page

	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		header("location: index.html");
		exit;
	}

	require_once("connect.php");
	if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST["submit"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$sql = "SELECT * 
				FROM User 
				WHERE username = '".$username."' AND password='".$password."'";

		$result=mysqli_query($db, $sql);

		if(mysqli_num_rows($result)>0){
			echo " You Have Successfully Logged in";
			header("Location: http://localhost/myHTML5/database.html");
			exit();
		}
		else{
			echo "You have entered an invalid username or password.";
			exit();
		}

	}
	mysqli_close($conn);
?>