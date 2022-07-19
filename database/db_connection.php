<?php
//call it to open DB connection
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "student_registration";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
    if (!$conn) {
        exit();
    }
    return $conn;
}

//call it to close DB connection
function CloseCon($conn)
{
    $conn->close();
}
