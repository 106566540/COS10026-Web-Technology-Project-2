<?php
require_once("settings.php");

$query = "SELECT * FROM jobs";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Applied Web Project, Jobs page">
    <meta name="author" content="Harry McDonald">
    <meta name="keywords" content="html, css, jobs">
    <title>Jobs</title>

    <link rel="stylesheet" type="text/css" href="style.css">

    <style>
        h2 {
            color: red;
            font-size: 24px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <img src="Images/logo.png" alt="Logo" class="logo">

    <div class="topnav">
        <a href="index.html">Home</a>
        <a href="apply.html">Apply Now</a>
        <a class="active" href="jobs.php">Jobs</a>
        <a href="about.html">About Us</a>
        <a href="login.php">Management</a>
    </div>

    <div style="background-image: url('Images/background.png'); background-size: cover; background-position: center;">

        <div class="content">

            <h1>Job Listings</h1>

            <aside>
                <p>
                    All positions that are currently available, including details on
                    responsibilities and requirements, as well as salaries.
                </p>
            </aside>

            <?php
            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    $essentialSkills = explode("|", $row['essential_skills']);
                    $desirableSkills = explode("|", $row['desirable_skills']);
            ?>

                    <section>

                        <h2><?php echo $row['title']; ?></h2>

                        <p>
                            <strong>Reference Number:</strong>
                            <?php echo $row['reference_number']; ?>
                        </p>

                        <p>
                            <strong>Description:</strong>
                            <?php echo $row['description']; ?>
                        </p>

                        <p>
                            <strong>Salary and Benefits:</strong>
                            <?php echo $row['salary']; ?>
                        </p>

                        <p>
                            <strong>Reporting Line:</strong>
                            <?php echo $row['reporting_line']; ?>
                        </p>

                        <p>
                            <strong>Key Responsibilities:</strong>
                            <?php echo $row['responsibilities']; ?>
                        </p>

                        <p><strong>Essential Skills:</strong></p>

                        <ol>
                            <?php
                            foreach ($essentialSkills as $skill) {
                                echo "<li>$skill</li>";
                            }
                            ?>
                        </ol>

                        <p><strong>Desirable Skills:</strong></p>

                        <ul>
                            <?php
                            foreach ($desirableSkills as $skill) {
                                echo "<li>$skill</li>";
                            }
                            ?>
                        </ul>

                        <p style="font-family: cursive;">
                            <strong><?php echo $row['position_level']; ?></strong>
                        </p>

                    </section>

            <?php
                }
            } else {
                echo "<p>No jobs available.</p>";
            }

            mysqli_close($conn);
            ?>

        </div>
    </div>

</body>

</html>