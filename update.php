<?php
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $book_names = $_POST['book_name'];
    $authors = $_POST['author'];
    $prices = $_POST['price'];


    $sql = "UPDATE user_details SET name=?, email=?, phone_number=?, address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $number, $address, $id);
    $stmt->execute();


    $sql = "DELETE FROM book_details WHERE book_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();


    $sql = "INSERT INTO book_details (book_id, book_name, author, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    for ($i = 0; $i < count($book_names); $i++) {
        $stmt->bind_param("isss", $id, $book_names[$i], $authors[$i], $prices[$i]);
        $stmt->execute();
    }


    header("Location: index.php");
    exit();
} else {
    echo "Invalid request method.";
}
