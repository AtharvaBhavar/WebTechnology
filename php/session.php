<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store submitted username and password in session
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];

    // Redirect to dashboard page
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
</head>
<body>
    <h2>Login</h2>

    <form method="POST" action="login.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>





//dashboard.php
<?php
session_start();

// Check if session data exists
if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
    echo "No session data found. Please <a href='login.php'>login again</a>.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to Dashboard</h2>
    <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>
    <p><strong>Password:</strong> <?php echo $_SESSION['password']; ?></p>

    <form method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</body>
</html>


// logout.php
<?php
session_start();
session_unset();
session_destroy();

// Redirect to login
header("Location: login.php");
exit();
