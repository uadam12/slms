<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLMS 404(Not Found)</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <?php include_once '../html/header.php' ?>

    <main class="container text-center">
        <h1 class="text-secondary">404 - NOT FOUND</h1>
        <p>
            <?=
                $_REQUEST['msg']??
                "Page not found"
            ?>
        </p>

        <hr>

        <a href="/" class="btn btn-dark">
            Goto Home <i class="fa fa-home"></i>
        </a>
    </main>

    <?php include_once '../html/footer.php' ?>
</body>
</html>