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

// Get the base URL dynamically
$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

// Handle pagination
$page = 1;
if (preg_match('/index\.php\/page\/(\d+)/', $_SERVER['REQUEST_URI'], $matches)) {
    $page = intval($matches[1]);
}
$page = max(1, $page);
$limit = 10;
$offset = ($page - 1) * $limit;

// Fetch contacts sorted by phone number
$sql = "SELECT name, phone FROM employees ORDER BY phone ASC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Check if more pages exist
$total_query = "SELECT COUNT(*) as total FROM employees";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$has_next = ($page * $limit) < $total_records;

// Start XML output
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo "<CiscoIPPhoneDirectory>";
echo "<Title>Contacts (Page $page)</Title>";
echo "<Prompt>Select a contact to dial</Prompt>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<DirectoryEntry>";
        echo "<Name>" . htmlspecialchars($row['name']) . "</Name>";
        echo "<Telephone>" . htmlspecialchars($row['phone']) . "</Telephone>";
        echo "</DirectoryEntry>";
    }
} else {
    echo "<Title>No Contacts</Title>";
    echo "<Prompt>No contacts found</Prompt>";
}

// Soft keys
echo "<SoftKeyItem>";
echo "<Name>Exit</Name>";
echo "<Position>1</Position>";
echo "<URL>SoftKey:Exit</URL>";
echo "</SoftKeyItem>";

if ($page > 1) {
    echo "<SoftKeyItem>";
    echo "<Name>Previous</Name>";
    echo "<Position>2</Position>";
    echo "<URL>$base_url/index.php/page/" . ($page - 1) . "</URL>";
    echo "</SoftKeyItem>";
}

if ($has_next) {
    echo "<SoftKeyItem>";
    echo "<Name>Next</Name>";
    echo "<Position>3</Position>";
    echo "<URL>$base_url/index.php/page/" . ($page + 1) . "</URL>";
    echo "</SoftKeyItem>";
}

echo "<SoftKeyItem>";
echo "<Name>Dial</Name>";
echo "<Position>4</Position>";
echo "<URL>SoftKey:Dial</URL>";
echo "</SoftKeyItem>";

echo "</CiscoIPPhoneDirectory>";

// Close the database connection
$conn->close();
?>
