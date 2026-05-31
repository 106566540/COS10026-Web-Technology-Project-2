<!DOCTYPE html>
<html lang="en">

<head>
    <!--meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Home Page">
    <meta name="author" content="Dante Rosini">
    <meta name="keywords" content="html, css, index">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <!-- navigation and logo  -->
    <?php
        $page = "home";
        include 'header.inc';
        include 'nav.inc'; ?>

    <div class="content">
        <!--background image -->

        <div style="background-image: url('images/background.png'); background-size: cover; background-position: center;">
            <h1>Power Ed</h1>
            <p> Power Through Learning</p>
            <br>
            <div class="search-container">
                <input type="text" placeholder="Search our learning tools...">
                <button type="submit">Search</button>
            </div>
            <!--AI used for to write description-->
            <p>Power Ed is a digital learning lab dedicated to engineering accessible and inclusive educational platforms. We bridge the gap between technology and pedagogy by developing high-performance tools designed to empower every learner, regardless
                of their background or ability. Driven by a mission to make quality education a universal right, we collaborate with visionary web developers and designers to build seamless, WCAG-compliant digital environments. At Power Ed, we don’t just
                create software we build the infrastructure for a more equitable future in global education.</p>
            <br>
            <!--table-->
            <table>
                <tr>
                    <th colspan="2">Maintenance </th>
                </tr>
                <tr>
                    <td rowspan="2"> April 1st to 3rd </td>
                    <td> Bug fixes </td>
                </tr>
                <tr>
                    <td rowspan="2"> Update language model </td>
                </tr>
            </table>
            <br>
            <br>
            <br>

            <div style="padding: 100px;">
            </div>
            <hr>
            <!--footer-->
            <?php include 'footer.inc'; ?>






        </div>


</body>

</html>
