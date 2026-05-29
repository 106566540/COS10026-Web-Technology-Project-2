<?php
$page = "apply";
require_once "settings.php";

function clean($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["jobRef"])) {
    header("Location: apply.php");
    exit();
}

$errors = [];

$job_reference = clean($_POST["jobRef"] ?? "");
$first_name = clean($_POST["fname"] ?? "");
$last_name = clean($_POST["lname"] ?? "");
$dob = clean($_POST["dob"] ?? "");
$gender = clean($_POST["gender"] ?? "");
$street = clean($_POST["street"] ?? "");
$suburb = clean($_POST["suburb"] ?? "");
$state = clean($_POST["state"] ?? "");
$postcode = clean($_POST["postcode"] ?? "");
$email = clean($_POST["email"] ?? "");
$phone = clean($_POST["phone"] ?? "");
$skills = isset($_POST["skills"]) ? implode(", ", array_map("clean", $_POST["skills"])) : "";
$other = clean($_POST["other"] ?? "");

if (!preg_match("/^[A-Za-z0-9]{5}$/", $job_reference)) $errors[] = "Job reference must be 5 alphanumeric characters.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) $errors[] = "First name must contain letters only.";
if (!preg_match("/^[A-Za-z]{1,20}$/", $last_name)) $errors[] = "Last name must contain letters only.";
if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) $errors[] = "Date of birth must be dd/mm/yyyy.";
if ($gender == "") $errors[] = "Gender is required.";
if ($street == "" || strlen($street) > 40) $errors[] = "Street address is required and must be under 40 characters.";
if ($suburb == "" || strlen($suburb) > 40) $errors[] = "Suburb is required and must be under 40 characters.";
if (!in_array($state, ["VIC", "NSW", "QLD", "NT", "WA", "SA", "TAS", "ACT"])) $errors[] = "Invalid state.";
if (!preg_match("/^\d{4}$/", $postcode)) $errors[] = "Postcode must be 4 digits.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
if (!preg_match("/^\d{8,12}$/", $phone)) $errors[] = "Phone must be 8 to 12 digits.";

include "header.inc";
include "nav.inc";

echo "<main class='content'>";

if (count($errors) > 0) {
    echo "<h1>Application Error</h1>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul>";
    echo "<p><a href='apply.php'>Return to application form</a></p>";
} else {
    $query = "INSERT INTO eoi 
    (job_reference, first_name, last_name, dob, gender, street_address, suburb, state, postcode, email, phone, skills, other_skills)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssss",
        $job_reference,
        $first_name,
        $last_name,
        $dob,
        $gender,
        $street,
        $suburb,
        $state,
        $postcode,
        $email,
        $phone,
        $skills,
        $other
    );

    mysqli_stmt_execute($stmt);

    $eoi_number = mysqli_insert_id($conn);

    echo "<h1>Application Submitted</h1>";
    echo "<p>Your Expression of Interest has been saved.</p>";
    echo "<p><strong>EOI Number:</strong> " . htmlspecialchars($eoi_number) . "</p>";
}

echo "</main>";

include "footer.inc";
?>