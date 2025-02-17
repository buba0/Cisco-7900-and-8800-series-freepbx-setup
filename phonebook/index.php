<?php
header("Content-Type: text/xml");

// Database connection
$host = "localhost";
$user = "user";
$pass = "password";
$dbname = "phonebook";
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("<?xml version='1.0' encoding='UTF-8'?><CiscoIPPhoneError><ErrorText>Database connection failed</ErrorText></CiscoIPPhoneError>");
}

// Get search query from phone
$search = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

// SQL to fetch employees based on search query, sorted by phone number in ascending order
$sql = "SELECT name, phone FROM employees WHERE name LIKE '%$search%' OR phone LIKE '%$search%' ORDER BY phone ASC LIMIT 10";
$result = $conn->query($sql);

// Start XML output
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo "<CiscoIPPhoneDirectory>";

if ($result->num_rows > 0) {
    // Add a prompt for the phone to display
    echo "<Title>Employee Directory</Title>";
    echo "<Prompt>Search for an employee</Prompt>";
    
    // Loop through results and generate XML for each entry
    while ($row = $result->fetch_assoc()) {
        echo "<DirectoryEntry>";
        echo "<Name>" . htmlspecialchars($row['name']) . "</Name>";
        echo "<Telephone>" . htmlspecialchars($row['phone']) . "</Telephone>";
        echo "</DirectoryEntry>";
    }
} else {
    // If no results are found, show this message
    echo "<Title>No Results</Title>";
    echo "<Prompt>No employees match your search</Prompt>";
}

echo "</CiscoIPPhoneDirectory>";

// Close the database connection
$conn->close();
?>
