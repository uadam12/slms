<?php require_once '../script/functions.php';
    require_once '../script/database.php';

    only_admin();

    $id = get_id();
    $db = new Database();

    if(is_post_request()) {
        $updated = $db->update_record(
            $id, 'borrowers',
            name: $name = get_posted('name'),
            phone: $phone = get_posted('phone'),
            address: $address = get_posted('address')
        );

        if($updated) redirect_to('borrowers.php');
    } else {
        $record = $db->get($id, 'borrowers');
        $name = $record['name'];
        $phone = $record['phone'];
        $address = $record['address'];
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Borrowers</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <header class="p-3 mb-5 container-fluid text-white bg-dark">
        <a href="./" class="text-decoration-none link-info">
            <i class="fa fa-home"></i> SLMS
        </a>
    </header>

    <main class="container">
        <h1 class="text-center text-primary">Update Borrower</h1>
        <?php require_once '../html/borrower-form.php' ?>
    </main>
</body>

</html>