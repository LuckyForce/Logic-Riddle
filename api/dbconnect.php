<?php
require "../config.php";
$dbhost = $config['db']['host'];
$dbuser = $config['db']['user'];
$dbpassword = $config['db']['password'];
$dbname = $config['db']['dbname'];

try {
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo einblenden um zu testen ob die DB Verbindung erfolgreich war!!!!
    // echo "<p>Connected successfully</p>"; 

} catch (PDOException $e) {
    // echo "<p>Connection failed: " . $e->getMessage() . "</p>";
    die($e);
}
