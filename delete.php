<!-- 
include("connection.php");

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $sql1 = "DELETE  FROM user_details WHERE id = '$id'";
    $result1 = mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM book_details WHERE book_id = '$id'";
    $result2 = mysqli_query($conn, $sql2);

    header("Location:index.php");

} -->

<?php

include 'connection.php';


$id = $_GET['id'];

$sql1 = "DELETE FROM user_details where id = $id";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "DELETE FROM book_details where book_id = $id";
$result2 = mysqli_query($conn, $sql2);


header("Location:index.php");
?>