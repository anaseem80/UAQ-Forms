<?php
define('DB_HOST', 'sikkatbeirutcom.ipagemysql.com'); // 'localhost'
define('DB_USER', 'uaqforms');  // 'root'
define('DB_PASS', 'Root@123456'); // ''
define('DB_NAME', 'uaqforms'); // 'uaq-forms'

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}


