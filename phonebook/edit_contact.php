<?php
// edit_contact.php

// Database connection settings
$host = "localhost";
$user = "user";
$pass = "password";
$dbname = "phonebook";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the update
    $id    = intval($_POST['id']);
    $name  = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    
    $sql = "UPDATE employees SET name='$name', phone='$phone' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: contacts.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else if (isset($_GET['id'])) {
    // Retrieve existing contact information to populate the form
    $id = intval($_GET['id']);
    $sql = "SELECT id, name, phone FROM employees WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $contact = $result->fetch_assoc();
    } else {
        echo "Contact not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>
    <form action="edit_contact.php" method="post">
        <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($contact['name']); ?>" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($contact['phone']); ?>" required><br><br>
        <input type="submit" value="Update Contact">
    </form>
    <br>
    <a href="contacts.php">Back to Contact List</a>
</body>
</html>
<?php
$conn->close();
?>
