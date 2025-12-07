<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
$server="sql300.infinityfree.com";
$uname="if0_39334455";
$pass="QyJs4kRRMX";
$db = "if0_39334455_disease";
$conn = new mysqli("$server", "$uname", "$pass", "$db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

