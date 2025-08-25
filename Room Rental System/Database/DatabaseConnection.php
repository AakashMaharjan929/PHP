<?php

$db = new mysqli('localhost', 'root', '', 'gharbhadadb');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>