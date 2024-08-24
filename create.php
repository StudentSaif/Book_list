<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>book details</title>
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
            position: absolute;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container mt-5">
            <h2>ALL RECORDS</h2>
            <form action="insert.php" method="post">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <label for="name">Name :</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label for="email">E-mail :</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <label for="number">Phone Number :</label>
                        <input type="number" name="number" id="number" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <label for="address">Address :</label>
                        <textarea name="address" id="address" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-add btn-secondary" onclick="addBook()">Add Book</button>
                    </div>
                </div>
                <div id="books-container">
                    <div class="row mb-3 book-row">
                        <div class="col-lg-4">
                            <label for="bookname">Book Name :</label>
                            <input type="text" placeholder="Book name" class="form-control" name="book_name[]" required>
                        </div>
                        <div class="col-lg-4">
                            <label for="author">Author :</label>
                            <input type="text" placeholder="Author" class="form-control" name="author[]" required>
                        </div>
                        <div class="col-lg-2">
                            <label for="price">Price :</label>
                            <input type="text" placeholder="Price" class="form-control" name="price[]" required>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <a href="index.php" type="button" class="btn btn-secondary">Back</a>
                        <button type="submit" name="submit" class="btn btn-add btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function addBook() {
            const bookRows = document.querySelectorAll('.book-row');
            for (let row of bookRows) {
                const bookName = row.querySelector('input[name="book_name[]"]').value.trim();
                const author = row.querySelector('input[name="author[]"]').value.trim();
                const price = row.querySelector('input[name="price[]"]').value.trim();

                if (!bookName || !author || !price) {
                    alert('Please fill in all fields before adding a new book.');
                    return;
                }
            }

            const booksContainer = document.getElementById('books-container');
            const bookRow = document.createElement('div');
            bookRow.classList.add('row', 'mb-3', 'book-row');
            bookRow.innerHTML = `
                <div class="col-lg-4">
                    <input type="text" placeholder="Book name" class="form-control" name="book_name[]">
                </div>
                <div class="col-lg-4">
                    <input type="text" placeholder="Author" class="form-control" name="author[]">
                </div>
                <div class="col-lg-2">
                    <input type="number" placeholder="Price" class="form-control" name="price[]">
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