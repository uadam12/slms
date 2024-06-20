<?php require_once '../script/functions.php';
    require_once '../script/database.php';

    only_admin();

    $id = get_id();
    $db = new Database();
    $next = 'borrowers.php';

    if(
        is_post_request() && 
        $db->delete_record($id, 'borrowers')
    ) redirect_to($next);

    $borrower = $db->get($id, 'borrowers', "CONCAT(firstname, ' ', lastname) AS fullname");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Confirmation Page</title>
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

    <main class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-primary text-center">Delete Confirmation</h3>
            </div>

            <div class="card-body">
                <p class="text-danger text-center">
                    Are you sure, you want to delete record of <?= $borrower['fullname'] ?> with his/her details permanently?
                </p>
            </div>

            <form class="card-footer text-end" method='post'>
                <a href="<?=$next?>" class="btn btn-success">
                    <i class="fa fa-arrow-left"></i> Cancel
                </a>

                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </main>


    <?php include_once '../html/footer.php' ?>
</body>

</html>
