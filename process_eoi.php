<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}

$page = "apply";

require_once("settings.php");

if (!$conn) {
    die("Database connection failed:" . mysqli_connect_error());
}

function sanitise_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$jobRef = sanitise_input($_POST["jobRef"] ?? "");
$fname = sanitise_input($_POST["fname"] ?? "");
$lname = sanitise_input($_POST["lname"] ?? "");
$dob = sanitise_input($_POST["dob"] ?? "");
$gender = sanitise_input($_POST["gender"] ?? "");

$street = sanitise_input($_POST["street"] ?? "");
$suburb = sanitise_input($_POST["suburb"] ?? "");
$state = sanitise_input($_POST["state"] ?? "");
$postcode = sanitise_input($_POST["postcode"] ?? "");

$email = sanitise_input($_POST["email"] ?? "");
$phone = sanitise_input($_POST["phone"] ?? "");

$other_skills = sanitise_input($_POST["other"] ?? "");

if (isset($_POST["skills"])) {
    $clean_skills = array_map("sanitise_input", $_POST["skills"]);
    $skills = implode(",", $clean_skills);
} else {
    $skills = "";
}

$errors = array();

// Job Reference
if (!preg_match("/^[A-Za-z0-9]{5}$/", $jobRef)) {
    $errors[] = "Job reference must be exactly 5 alphanumeric characters.";
}

// First Name
if (!preg_match("/^[A-Za-z]{1,20}$/", $fname)) {
    $errors[] = "First name must be 1–20 letters only, no spaces or numbers.";
}

// Last Name
if (!preg_match("/^[A-Za-z]{1,20}$/", $lname)) {
    $errors[] = "Last name must be 1–20 letters only, no spaces or numbers.";
}

// Date of Birth
if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
    $errors[] = "Date of birth must be in dd/mm/yyyy format.";
}

// Gender
$validGenders = ["male", "female", "other"];
if (!in_array(strtolower($gender), $validGenders)) {
    $errors[] = "Please select a valid gender.";
}

// Street Address
if (!preg_match("/^.{1,40}$/", $street)) {
    $errors[] = "Street address must be between 1 and 40 characters.";
}

// Suburb
if (!preg_match("/^.{1,40}$/", $suburb)) {
    $errors[] = "Suburb must be between 1 and 40 characters.";
}

// State
$validStates = ["VIC", "NSW", "QLD", "NT", "WA", "SA", "TAS", "ACT"];
if (!in_array($state, $validStates)) {
    $errors[] = "Please select a valid Australian state or territory.";
}

// Postcode
if (!preg_match("/^[0-9]{4}$/", $postcode)) {
    $errors[] = "Postcode must be exactly 4 digits.";
}

// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

// Phone
if (!preg_match("/^[0-9]{8,12}$/", $phone)) {
    $errors[] = "Phone number must contain 8 to 12 digits only.";
}

include "header.inc";
include "nav.inc";

echo "<main class='content'>";

if (!empty($errors)) {

    echo "<h2>Validation Errors</h2>";

    foreach ($errors as $error) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }

    echo "<p><a href='apply.php'>Return to application form</a></p>";

    echo "</main>";
    mysqli_close($conn);
    include "footer.inc";
    exit();
}

// Insert into DB and confirm auto generated EOI number
$query = "INSERT INTO eoi 
(jobRef, first_name, last_name, dob, gender, street, suburb, state, postcode, email, phone, skills, other_skills)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssss",
        $jobRef,
        $fname,
        $lname,
        $dob,
        $gender,
        $street,
        $suburb,
        $state,
        $postcode,
        $email,
        $phone,
        $skills,
        $other_skills
);

if (mysqli_stmt_execute($stmt)) {
    $eoiNumber = mysqli_insert_id($conn);
    echo "<h2>Application Submitted Successfully!</h2>";
    echo "<p>Thank you, <strong>" . htmlspecialchars($fname) . " " . htmlspecialchars($lname) . "</strong>. Your EOI number is: <strong>" . htmlspecialchars($eoiNumber) . "</strong></p>";
} else {
    echo "<p>Error saving application: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
}

echo "</main>";

mysqli_close($conn);
include "footer.inc";
?>