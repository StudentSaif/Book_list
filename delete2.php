<?php

include 'connection.php';

// if($_SERVER['REQUEST_METHOD'] == 'POST')
if(isset($_POST['upddelete']))
{
$id = $_GET['id'];

$sql1 = "DELETE FROM user_details where id = $id";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "DELETE FROM book_details where book_id = $id";
$result2 = mysqli_query($conn, $sql2);


header("Location:edit.php");
}
?>