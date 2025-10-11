<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">

        <h2 class="mb-4 text-success">Edit User Details</h2>

        <form action="update_user_script.php" method="POST" class="p-4 border rounded shadow-sm">

            <input type="hidden" name="user_id" value="123">

            <div class="mb-3">
                <label for="editInputName" class="form-label fw-bold">Name</label>
                <input type="text" class="form-control" id="editInputName" name="name" value="Rimon Khan" required>
            </div>

            <div class="mb-3">
                <label for="editInputEmail" class="form-label fw-bold">Email address</label>
                <input type="email" class="form-control" id="editInputEmail" name="email" value="rimon@example.com"
                    required>
            </div>

            <div class="mb-3">
                <label for="editInputAddress" class="form-label fw-bold">Address</label>
                <input type="text" class="form-control" id="editInputAddress" name="address"
                    value="House 42, Road 10, Dhaka" required>
            </div>

            <div class="mb-3">
                <label for="editContact" class="form-label fw-bold">Contact</label>
                <input type="text" class="form-control" id="editContact" name="contact" value="+880171xxxxxxx" required>
            </div>

            <button type="submit" class="btn btn-success me-2">Update User</button>
            <button type="button" class="btn btn-secondary">Cancel</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>