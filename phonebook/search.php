<?php
header("Content-Type: text/xml");

// Get the base URL dynamically
$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

// Start XML output
echo "<?xml version='1.0' encoding='UTF-8'?>";
echo "<CiscoIPPhoneInput>";
echo "<Title>Search Contacts</Title>";
echo "<Prompt>Enter name or number</Prompt>";
echo "<URL>$base_url/index.php</URL>";

echo "<InputItem>";
echo "<DisplayName>Search</DisplayName>";
echo "<QueryStringParam>search</QueryStringParam>";
echo "<InputFlags>A</InputFlags>";
echo "</InputItem>";

echo "<SoftKeyItem>";
echo "<Name>Search</Name>";
echo "<Position>3</Position>";
echo "<URL>SoftKey:Submit</URL>";
echo "</SoftKeyItem>";

echo "<SoftKeyItem>";
echo "<Name>Clear</Name>";
echo "<Position>2</Position>";
echo "<URL>SoftKey:Delete</URL>";
echo "</SoftKeyItem>";

echo "<SoftKeyItem>";
echo "<Name>Exit</Name>";
echo "<Position>1</Position>";
echo "<URL>SoftKey:Exit</URL>";
echo "</SoftKeyItem>";

echo "</CiscoIPPhoneInput>";
?>
