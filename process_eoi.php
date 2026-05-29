  if ($_SERVER["REQUEST_METHOD"] == "POST") {
header(loaction : "apply.php");
exit();
}
require_once("settings.php");
$conn= mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
die("Database connection failed:". mysqli_connect_error());
}
function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


$jobRef = sanitise_input($_POST["jobRef"]);
$fname = sanitise_input($_POST["fname"]);
$lname = sanitise_input($_POST["lname"]);
$dob = sanitise_input($_POST["dob"]);
$gender = sanitise_input($_POST["gender"]);

$street = sanitise_input($_POST["street"]);
$suburb = sanitise_input($_POST["suburb"]);
$state = sanitise_input($_POST["state"]);
$postcode = sanitise_input($_POST["postcode"]);

$email = sanitise_input($_POST["email"]);
$phone = sanitise_input($_POST["phone"]);

$other_skills = sanitise_input($_POST["other"]);
