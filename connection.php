<?php

$conn = mysqli_connect("localhost", "root", "", "books");
if (!$conn) {
    die("connection failed". mysqli_connect_error());
} 
// else {
//     echo"database connected";
// }
?>