<?php
// contacts.php

// Database connection settings
$host = "localhost";
$user = "user";
$pass = "password";
$dbname = "phonebook";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all contacts, sorted by phone number in ascending order
$sql = "SELECT id, name, phone FROM employees ORDER BY phone ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact List</title>
    <style>
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
        .actions a { margin-right: 10px; }
    </style>
</head>
<body>
    <h1>Contact List</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td class="actions">
                    <a href="edit_contact.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete_contact.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this contact?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="3">No contacts found.</td></tr>
        <?php endif; ?>
    </table>

    <h2>Add New Contact</h2>
    <form action="add_contact.php" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br><br>
        <input type="submit" value="Add Contact">
    </form>
</body>
</html>
<?php
$conn->close();
?>
