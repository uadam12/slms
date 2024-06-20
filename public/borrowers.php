<?php require_once '../script/functions.php';
    require_once '../script/database.php';
    require_once '../script/auth.php';

    only_admin();

    $page = $_SERVER['PHP_SELF'];
    $db = new Database(0, 'name');
    $borrowers = $db->all(
        'borrowers', order_by: 'firstname', columns:
        "id, email, CONCAT(firstname, ' ', lastname) AS fullname", 
    );
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
    <?php include_once '../html/header.php' ?>
    
    <main class="container">
        <h1 class="text-center text-primary">All Borrowers</h1>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>S/N</th>
                    <th>Fullname</th>
                    <th>Email address</th>
                    <th>Action</th>
                </tr>

                <?php if(empty($borrowers)): ?>
                <!-- No borrower -->
                <tr>
                    <td colspan="4" class="text-muted text-center">
                        No Available borrower yet.
                    </td>
                </tr>

                <?php else: ?> <?php foreach($borrowers as $n=>$borrower): ?>
                <!-- Loop over borrowers-->
                <tr>
                    <td><?= $n +1 ?></td>
                    <td><?= $borrower['fullname'] ?></td>
                    <td><?= $borrower['email'] ?></td>
                    <td>
                        <a href="borrower.php?id=<?= $borrower['id'] ?>" class="btn btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>

                        <a href="delete-borrower.php?id=<?= $borrower['id'] ?>" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach ?> <?php endif ?>
            </table>
        </div>
    </main>

  <?php include_once '../html/footer.php' ?>
</body>

</html>