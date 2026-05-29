

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="About the Power Ed project team">
    <meta name="keywords" content="HTML, CSS, About, Team">
    <meta name="author" content="Max Ryan">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <!-- Embedded CSS example required on page -->
    <style>
        .student-id {
            color: #1d3557;
            font-weight: bold;
        }
        
        .about-note {
            background-color: #f1f8ff;
            border-left: 5px solid #457b9d;
            padding: 0.8em;
            margin: 1em 0;
        }
    </style>
</head>

<body>
    

    <!-- Top navigation bar -->
    <?php
        $page = "about";
        include 'header.inc';
        include 'nav.inc'; ?>

    <main class="content">
        <h1>About Our Team</h1>

        <p class="about-note">
            We are <strong>Rahul and the Chipmunks</strong>, a student team developing the Power Ed recruitment website for an Educational Technology (EdTech) company.
        </p>

        <section>
            <h2>Class Times</h2>
            <ul>
                <li>Monday
                    <ul>
                        <li>Live Online Lecture</li>
                        <li>12:30pm - 1:30pm</li>
                    </ul>
                </li>
                <li>Friday
                    <ul>
                        <li>Class 1
                            <ul>
                                <li>Room BA603 - HAW</li>
                            </ul>
                        </li>
                        <li>10:30am - 12:30pm</li>
                    </ul>
                </li>
            </ul>
        </section>

        <section>
            <h2>Group Photo</h2>
            <figure class="group-photo">
                <img src="Images/group.jpg" alt="Group photo of Rahul and the Chipmunks team members" width="450">
                <figcaption>Rahul and the Chipmunks working together on the Power Ed website project.</figcaption>
            </figure>
        </section>

        <section>
            <h2>Member Contributions and Quotes For Part 1</h2>
            <dl>
                <dt>Maxwell Ryan - <span class="student-id">106566540</span></dt>
                <dd>Contributions:
                    <ul>
                        <li>about.html</li>
                        <li>style.css</li>
                    </ul>
                </dd>
                <dd>Quote: "私はアリが好きです。" - "I like ants."</dd>

                <dt>Shubhpreet Kaur - <span class="student-id">106191722</span></dt>
                <dd>Contributions:
                    <ul>
                        <li>apply.html</li>
                        <li>style.css</li>
                    </ul>
                </dd>
                <dd>Quote: "सफलता मेहनत से मिलती है।" - "Success comes through hard work."</dd>

                <dt>Dante Rosini - <span class="student-id">105335972</span></dt>
                <dd>Contributions:
                    <ul>
                        <li>index.html</li>
                        <li>style.css</li>
                        <li>Responsible for group submissions</li>
                    </ul>
                </dd>
                <dd>Quote: "Τα μιτοχόνδρια είναι η μονάδα παραγωγής ενέργειας του κυττάρου." - "Mitochondria are the energy production unit of the cell."</dd>

                <dt>Harry McDonald - <span class="student-id">106501172</span></dt>
                <dd>Contributions:
                    <ul>
                        <li>jobs.html</li>
                        <li>style.css</li>
                        <li>Responsible for group communications</li>
                    </ul>
                </dd>
                <dd>Quote: "找到一句名言很难，我的大脑就不是为此而生的。" - "Finding a famous quote is difficult; my brain wasn't designed for that."</dd>
            </dl>
        </section>

        <section>
            <h2>Fun Facts About Our Team</h2>
            <table class="fun-facts">
                <caption>Team fun facts</caption>
                <tr>
                    <th>Name</th>
                    <th>Dream Job</th>
                    <th>Coding Snack</th>
                    <th>Hometown</th>
                </tr>
                <tr>
                    <td>Maxwell</td>
                    <td>Mechanical Engineer</td>
                    <td>Monster Energy Drinks</td>
                    <td>Melbourne</td>
                </tr>
                <tr>
                    <td>Shubhpreet</td>
                    <td>Head of the software development team </td>
                    <td>Namkeen</td>
                    <td>Jandali</td>
                </tr>
                <tr>
                    <td>Dante</td>
                    <td>Cybersecurity incident reponder</td>
                    <td>KFC</td>
                    <td>Melbourne</td>
                </tr>
                <tr>
                    <td>Harry</td>
                    <td>Game Developer</td>
                    <td>M&M’s</td>
                    <td>Bessibelle</td>
                </tr>
            </table>
        </section>

        <section>
            <h2>Acknowledgement</h2>
            <p style="font-style: italic;">
                We acknowledge the Traditional Owners of the land on which we live, learn, and work, and pay our respects to Elders past and present. We value inclusion and encourage applications from Aboriginal and Torres Strait Islander peoples.
            </p>
        </section>
    </main>
    <h1>Contribution table</h1>

    <?php

    require_once "settings.php";
    

    $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

    if ($dbconn) {

        $query = "SELECT * FROM members";
        $result = mysqli_query($dbconn, $query);


        if ($result && mysqli_num_rows($result) > 0) {
            

            echo "<table border='1' class='fun-facts'>\n";
            echo "<tr>\n";
            echo "<th>#</th>\n";
            echo "<th>Name</th>\n";
            echo "<th>Student ID.</th>\n";
            echo "<th>Project 1 </th>\n";
            echo "<th>Project 2</th>\n";
            echo "</tr>\n";


            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>\n";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>\n";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>\n";
                echo "<td>" . htmlspecialchars($row['student_id']) . "</td>\n";
                echo "<td>" . htmlspecialchars($row['project1_contrib']) . "</td>\n";
                echo "<td>" . htmlspecialchars($row['project2_contrib']) . "</td>\n";
                echo "</tr>\n";
            }


            echo "</table>\n";
            

            mysqli_free_result($result);

        } else {

            echo "<p>There are no students to display.</p>";
        }


        mysqli_close($dbconn);

    } else {
        echo "<p>Unable to connect to the db.</p>";
    }
    ?>

    <?php include 'footer.inc'; ?>
</body>

</html>
