<!-- addressbook.php -->
<html>
<head><title>DSCables Address Book</title></head>
<body>
<h1>Address Book</h1>

<!-- Form to Add a Record -->
<form method="post" action="">
    <table>
        <tr><td>User ID:</td><td><input type="text" name="t1" required></td></tr>
        <tr><td>Name:</td><td><input type="text" name="t2" required></td></tr>
        <tr><td>Phone No:</td><td><input type="text" name="t3" required></td></tr>
        <tr><td>Email:</td><td><input type="email" name="t4" required></td></tr>
        <tr><td>Permanent Address:</td><td><input type="text" name="t5" required></td></tr>
        <tr><td>Temporary Address:</td><td><input type="text" name="t6" required></td></tr>
    </table>
    <input type="submit" name="add" value="ADD">
</form>

<?php
// Connect to DB
$con = mysqli_connect("localhost", "root", "", "addressbook");
if (mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_error();
    exit();
}

// Handle Add
if (isset($_POST['add'])) {
    $id = $_POST['t1'];
    $name = $_POST['t2'];
    $phno = $_POST['t3'];
    $email = $_POST['t4'];
    $padd = $_POST['t5'];
    $tadd = $_POST['t6'];

    $sql = "INSERT INTO person (id, name, phno, email, padd, tadd)  VALUES ('$id', '$name', '$phno', '$email', '$padd', '$tadd')";
    if (mysqli_query($con, $sql)) {
        echo "<p style='color:green;'>Record added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($con) . "</p>";
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    $sql = "DELETE FROM person WHERE id = '$id'";
    if (mysqli_query($con, $sql)) {
        echo "<p style='color:red;'>Record deleted successfully!</p>";
    } else {
        echo "<p style='color:red;'>Delete error: " . mysqli_error($con) . "</p>";
    }
}

// Display All Records
$result = mysqli_query($con, "SELECT * FROM person");
if (mysqli_num_rows($result) > 0) {
    echo "<h2><center>Stored Records</center></h2>";
    echo "<table border='1' align='center'>";
    echo "<tr><th>ID</th><th>Name</th><th>Phone</th><th>Email</th><th>Permanent Address</th><th>Temporary Address</th><th>Actions</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['phno']}</td>
            <td>{$row['email']}</td>
            <td>{$row['padd']}</td>
            <td>{$row['tadd']}</td>
            <td>
                <!-- Update Button -->
                <form method='post' action='update.php' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    <input type='submit' value='Update'>
                </form>
                <!-- Delete Button -->
                <form method='post' action='' style='display:inline;'>
                    <input type='hidden' name='delete_id' value='{$row['id']}'>
                    <input type='submit' name='delete' value='Delete' onclick=\"return confirm('Delete this record?');\">
                </form>
            </td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No records found.</p>";
}

mysqli_close($con);
?>
</body>
</html>







<!-- update.php -->
<?php
$con = mysqli_connect("localhost", "root", "", "addressbook");
if (mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_error();
    exit();
}

// Fetch record to edit
$id = $_POST['id'];
$sql = "SELECT * FROM person WHERE id = '$id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<html>
<head><title>Update Record</title></head>
<body>
<h2>Update Record</h2>
<form method="post" action="">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <table>
        <tr><td>Name:</td><td><input type="text" name="name" value="<?php echo $row['name']; ?>" required></td></tr>
        <tr><td>Phone No:</td><td><input type="text" name="phno" value="<?php echo $row['phno']; ?>" required></td></tr>
        <tr><td>Email:</td><td><input type="email" name="email" value="<?php echo $row['email']; ?>" required></td></tr>
        <tr><td>Permanent Address:</td><td><input type="text" name="padd" value="<?php echo $row['padd']; ?>" required></td></tr>
        <tr><td>Temporary Address:</td><td><input type="text" name="tadd" value="<?php echo $row['tadd']; ?>" required></td></tr>
    </table>
    <input type="submit" name="update" value="Update">
</form>

<?php
// Handle update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phno = $_POST['phno'];
    $email = $_POST['email'];
    $padd = $_POST['padd'];
    $tadd = $_POST['tadd'];

    $sql = "UPDATE person SET 
                name = '$name', 
                phno = '$phno', 
                email = '$email', 
                padd = '$padd', 
                tadd = '$tadd' 
            WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        echo "<p style='color:green;'>Record updated successfully!</p>";
    } else {
        echo "<p style='color:red;'>Update error: " . mysqli_error($con) . "</p>";
    }

    echo "<br><a href='addressbook.php'>Back to Address Book</a>";
}

mysqli_close($con);
?>
</body>
</html>
