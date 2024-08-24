<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Displaying Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .table-container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-warning {
            background-color: #ff9800;
            border: none;
        }

        .btn-danger {
            background-color: #f44336;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container table-container">
        <h2 class="mb-4">User Details</h2>
        <table class="table table-dark table-hover">
            <thead>
                <a href="create.php" class="btn btn-secondary">Add Record</a>
                <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "connection.php";

                $sql = "SELECT ud.id, ud.name, ud.email, ud.phone_number, ud.address, Group_concat(bd.book_name SEPARATOR ', ') as book_name ,  Group_concat(bd.author SEPARATOR ', ') as author , Group_concat(bd.price SEPARATOR ', ') as price FROM user_details AS ud
                        INNER JOIN book_details AS bd ON ud.id = bd.book_id
                        GROUP BY bd.book_id";

                $result = mysqli_query($conn, $sql);

                // echo "<pre>";
                // print_r(mysqli_fetch_assoc($result));
                // die(); 

                if (!$result) {
                    die("Query failed: " . mysqli_error($conn));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $book_names = explode(",", $row["book_name"]);
                        $authors = explode(",", $row["author"]);
                        $prices = explode(",", $row["price"]);
                ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php
                                foreach ($book_names as $book_name) {
                                    if ($book_name) {
                                        echo (string) $book_name . ",";
                                    }
                                } ?></td>

                            <td><?php
                                foreach ($authors as $author) {
                                    if ($author) {
                                        echo (string) $author . ",";
                                    }
                                } ?></td>

                            <td><?php foreach ($prices as $price) {
                                    if ($price) {
                                        echo (string) $price . ",";
                                    }
                                } ?></td>



                            <!-- <td><a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-secondary btn-sm">View Books</a></td> -->
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                }

                ?>

            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>