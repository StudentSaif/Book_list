<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
        }

        .form-container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
        }

        .btn-remove {
            background-color: #ff5252;
            color: white;
        }

        .btn-add {
            background-color: dimgray;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container mt-5">
            <h2>Edit Record</h2>
            <?php
            include "connection.php";

            $id = $_GET['id'];

            $sql = "SELECT ud.id, ud.name, ud.email, ud.phone_number, ud.address, Group_concat(bd.book_name SEPARATOR ', ') as book_name, Group_concat(bd.author SEPARATOR ', ') as author, Group_concat(bd.price SEPARATOR ', ') as price FROM user_details AS ud
                    INNER JOIN book_details AS bd ON ud.id = bd.book_id
                    WHERE ud.id = $id
                    GROUP BY ud.id";

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }

            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $book_names = explode(", ", $row["book_name"]);
                $authors = explode(", ", $row["author"]);
                $prices = explode(", ", $row["price"]);
            ?>
                <form action="update.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="name">Name :</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" id="name" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="email">E-mail :</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" id="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="number">Phone Number :</label>
                            <input type="number" name="number" value="<?php echo htmlspecialchars($row['phone_number']); ?>" id="number" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="address">Address :</label>
                            <textarea name="address" id="address" class="form-control" required><?php echo htmlspecialchars($row['address']); ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-add btn-secondary" onclick="addBook()">Add Book</button>
                            <button type="submit" name="update" class="btn btn-add btn-primary">Update</button>
                        </div>
                    </div>
                    <div id="books-container">
                        <?php
                        for ($i = 0; $i < count($book_names); $i++) {
                        ?>
                            <div class="row mb-3 book-row">
                                <div class="col-lg-4">
                                    <label for="bookname">Book Name :</label>
                                    <input type="text" placeholder="Book name" value="<?php echo htmlspecialchars($book_names[$i]); ?>" class="form-control" name="book_name[]" required>
                                </div>
                                <div class="col-lg-4">
                                    <label for="author">Author :</label>
                                    <input type="text" placeholder="Author" value="<?php echo htmlspecialchars($authors[$i]); ?>" class="form-control" name="author[]" required>
                                </div>
                                <div class="col-lg-2">
                                    <label for="price">Price :</label>
                                    <input type="number" placeholder="Price" value="<?php echo htmlspecialchars($prices[$i]); ?>" class="form-control" name="price[]" required>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-remove btn-danger" onclick="removeBook(this)">Remove</button>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </form>
            <?php
            } else {
                echo "<p>No data found for the provided ID.</p>";
            }
            ?>
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a href="index.php" type="button" class="btn btn-secondary">Back</a>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function addBook() {
            const booksContainer = document.getElementById('books-container');
            const bookRow = document.createElement('div');
            bookRow.classList.add('row', 'mb-3', 'book-row');
            bookRow.innerHTML = `
                <div class="col-lg-4">
                    <input type="text" placeholder="Book name" class="form-control" name="book_name[]" required>
                </div>
                <div class="col-lg-4">
                    <input type="text" placeholder="Author" class="form-control" name="author[]" required>
                </div>
                <div class="col-lg-2">
                    <input type="number" placeholder="Price" class="form-control" name="price[]" required>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-remove btn-danger" onclick="removeBook(this)">Remove</button>
                </div>
            `;
            booksContainer.appendChild(bookRow);
        }

        function removeBook(button) {
            const bookRow = button.parentElement.parentElement;
            bookRow.remove();
        }
    </script>
</body>

</html>