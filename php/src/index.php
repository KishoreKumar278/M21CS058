<?php
//echo "Hello there, this is a PHP Apache container"
?>

<?php
//These are the defined authentication environment in the db service

// The MySQL service named in the docker-compose.yml.
/*$host = 'db';

// Database use name
$user = 'MYSQL_USER';

//database user password
$pass = 'MYSQL_PASSWORD';

// check the MySQL connection status
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL server successfully!";
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Form to store data</title>
</head>

<body>
<center>
<h1>Storing Form data in Database</h1>
<form action="insert.php" method="post">		
<p>
<label for="firstName">First Name:</label>
<input type="text" name="first_name" id="firstName">
</p>
<p>
<label for="lastName">Last Name:</label>
<input type="text" name="last_name" id="lastName">
</p>
<p>
<label for="Gender">Gender:</label>
<input type="text" name="gender" id="Gender">
</p>
<p>
<label for="Address">Address:</label>
<input type="text" name="address" id="Address">
</p>
<p>
<label for="emailAddress">Email Address:</label>
<input type="text" name="email" id="emailAddress">
</p>
<input type="submit" value="Submit">
</form>
</center>
</body>
</html>
