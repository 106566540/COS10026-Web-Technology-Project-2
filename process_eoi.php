  if ($_SERVER["REQUEST_METHOD"] == "POST") {
header(loaction : "apply.php");
exit();
}
require_once("settings.php");
$conn= mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
die("Database connection failed:". mysqli_connect_error());
}
