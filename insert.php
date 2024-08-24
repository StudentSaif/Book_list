<?php
// include "connection.php";

// // echo"<pre>";
// // var_dump("hii");
// // die();

// if (isset($_POST["submit"])) {

//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $phonenumber = $_POST['number'];
//     $address = $_POST['address'];

//     $bookname = implode(', ', $_POST['book_name']);
//     $author = implode(', ', $_POST['author']);
//     $price = implode(', ', $_POST['price']);

//     // echo '<pre>';
//     // var_dump($price);
//     // die();

//     $sql1 = "INSERT INTO user_details(name, email, phone_number, address) VALUES ('$name', '$email', '$phonenumber', '$address')";
//     $result1 = mysqli_query($conn, $sql1);

//     $id = $conn->insert_id;

//     $sql2 = "INSERT INTO book_details(book_id, book_name, author, price) VALUES ('$id', '$bookname', '$author', '$price')";
//     $result2 = mysqli_query($conn, $sql2);

//     header("Location:index.php");
// }


include "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];


    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $number = mysqli_real_escape_string($conn, trim($_POST['number']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));

    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email)) {
        $errors[] = "E-mail is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid e-mail format.";
    }
    if (empty($number)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match('/^[0-9]+$/', $number)) {
        $errors[] = "Invalid phone number format.";
    }
    if (empty($address)) {
        $errors[] = "Address is required.";
    }


    $bookNames = $_POST['book_name'];
    $authors = $_POST['author'];
    $prices = $_POST['price'];

    foreach ($bookNames as $index => $bookName) {
        if (empty($bookName)) {
            $errors[] = "Book name is required for book " . ($index + 1) . ".";
        }
        if (empty($authors[$index])) {
            $errors[] = "Author is required for book " . ($index + 1) . ".";
        }
        if (empty($prices[$index])) {
            $errors[] = "Price is required for book " . ($index + 1) . ".";
        } elseif (!is_numeric($prices[$index])) {
            $errors[] = "Invalid price format for book " . ($index + 1) . ".";
        }
    }

    if (empty($errors)) {

        $sql1 = "INSERT INTO user_details (name, email, phone_number, address) VALUES ('$name', '$email', '$number', '$address')";
        if (mysqli_query($conn, $sql1)) {
            $id = mysqli_insert_id($conn);


            foreach ($bookNames as $index => $bookName) {
                $author = mysqli_real_escape_string($conn, trim($authors[$index]));
                $price = mysqli_real_escape_string($conn, trim($prices[$index]));

                $sql2 = "INSERT INTO book_details (book_id, book_name, author, price) VALUES ('$id', '$bookName', '$author', '$price')";
                if (!mysqli_query($conn, $sql2)) {
                    die("Error inserting book details: " . mysqli_error($conn));
                }
            }

            header("Location:index.php");
            exit();
        } else {
            die("Error inserting user details: " . mysqli_error($conn));
        }
    } else {

        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
} else {
    die("Invalid request method.");
}
