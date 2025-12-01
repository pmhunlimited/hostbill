<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $pin = password_hash($_POST['pin'], PASSWORD_DEFAULT);

    // Create a new MySQLi object
    $mysqli = new mysqli($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pass'], $_SESSION['db_name']);

    // Prepare the SQL statement
    $stmt = $mysqli->prepare("INSERT INTO `users` (`name`, `email`, `password`, `pin`, `is_admin`) VALUES (?, ?, ?, ?, 1)");

    // Bind the parameters
    $stmt->bind_param('ssss', $name, $email, $password, $pin);

    // Execute the statement
    $stmt->execute();

    // Redirect to the next stage
    header('Location: index.php?stage=4');
    exit();
}
?>

<h1 class="mb-4">Admin Setup</h1>
<p>Please enter your admin credentials below.</p>

<form method="post">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="pin">Security PIN</label>
        <input type="password" name="pin" id="pin" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Next</button>
</form>
