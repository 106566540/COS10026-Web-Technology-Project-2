<?php
session_start();

$page = "manage";

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

include 'settings.php';

$conn = mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

function sanitise($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if (isset($_POST['delete'])) {
    $job_ref = sanitise($_POST['job_ref_delete']);

    $query = "DELETE FROM eoi WHERE job_reference = '$job_ref'";
    mysqli_query($conn, $query);
}

if (isset($_POST['update_status'])) {
    $eoi_id = sanitise($_POST['eoi_id']);
    $status = sanitise($_POST['status']);

    $query = "UPDATE eoi SET status = '$status' WHERE EOInumber = '$eoi_id'";
    mysqli_query($conn, $query);
}

$where = [];

if (!empty($_GET['job_ref'])) {
    $job_ref = sanitise($_GET['job_ref']);
    $where[] = "job_reference = '$job_ref'";
}

if (!empty($_GET['first_name'])) {
    $first_name = sanitise($_GET['first_name']);
    $where[] = "first_name LIKE '%$first_name%'";
}

if (!empty($_GET['last_name'])) {
    $last_name = sanitise($_GET['last_name']);
    $where[] = "last_name LIKE '%$last_name%'";
}

$allowed_sort = ['EOInumber', 'job_reference', 'first_name', 'last_name', 'status'];
$sort = 'EOInumber';

if (!empty($_GET['sort']) && in_array($_GET['sort'], $allowed_sort)) {
    $sort = $_GET['sort'];
}

$query = "SELECT * FROM eoi";

if (count($where) > 0) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$query .= " ORDER BY $sort";

$result = mysqli_query($conn, $query);

include 'header.inc';
include 'nav.inc';
?>

    <main class="content">
        <h1>Management Page</h1>

        <p>Welcome to the management page, <?php echo htmlspecialchars($_SESSION['user']); ?>.</p>

        <h2>Search EOIs</h2>

        <form method="get" action="manage.php" novalidate>
            <label for="job_ref">Job Reference:</label>
            <input type="text" name="job_ref" id="job_ref">

            <br><br>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name">

            <br><br>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name">

            <br><br>

            <label for="sort">Sort By:</label>
            <select name="sort" id="sort">
                <option value="EOInumber">EOI Number</option>
                <option value="job_reference">Job Reference</option>
                <option value="first_name">First Name</option>
                <option value="last_name">Last Name</option>
                <option value="status">Status</option>
            </select>

            <br><br>

            <input type="submit" value="Search">
        </form>

        <h2>Delete EOIs by Job Reference</h2>

        <form method="post" action="manage.php" novalidate>
            <label for="job_ref_delete">Job Reference:</label>
            <input type="text" name="job_ref_delete" id="job_ref_delete">

            <input type="submit" name="delete" value="Delete">
        </form>

        <h2>EOI List</h2>

        <table>
            <tr>
                <th>EOI Number</th>
                <th>Job Reference</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['EOInumber']); ?></td>
                    <td><?php echo htmlspecialchars($row['job_reference']); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <form method="post" action="manage.php" novalidate>
                            <input type="hidden" name="eoi_id" value="<?php echo htmlspecialchars($row['EOInumber']); ?>">

                            <select name="status">
                                <option value="New">New</option>
                                <option value="Current">Current</option>
                                <option value="Final">Final</option>
                            </select>

                            <input type="submit" name="update_status" value="Update">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </main>

<?php
mysqli_close($conn);
include 'footer.inc';
?>