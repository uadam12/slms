<?php require_once '../script/functions.php';
    require_once '../script/database.php';
    require_once '../script/auth.php';

    only_admin();

    $id = get_id();
    $db = new Database();

    if(is_post_request()) {
        if(isset($_POST['approve'])) $status = 'Approved';
        elseif(isset($_POST['reject'])) $status = 'Rejected';
        else $status = 'Pending';

        $db->update_record(
            get_posted('loan_id'), 'loans', 
            status: $status,
            approved_on: date('Y-m-d h-i-s')
        );
        
        header('Refresh: 0');
    }
    
    $borrower = $db->get($id, 'borrowers', "id, email, CONCAT(firstname, ' ', lastname) AS fullname");
    $loans = $db->filter(
        'loans', "borrower_id = $id", 
        order_by: 'applied_on',
    );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrower details page</title>
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
        <h1 class="text-center text-primary">Loans of <?= $borrower['fullname'] ?></h1>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>S/N</th>
                    <th>Applied On</th>
                    <th>Duration</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>

                <?php if(empty($loans)): ?>
                <!-- No borrower -->
                <tr>
                    <td colspan="6" class="text-muted text-center">
                        Borrower didn't apply for a loan yet.
                    </td>
                </tr>

                <?php else: ?> <?php foreach($loans as $n=>$loan): 
                    $duration = $loan['duration'];
                    if($duration >= 12) 
                        $duration = ((int) $duration /= 12). ' year';
                    else $duration .= ' month';
                ?>
                <!-- Loop over borrowers-->
                <tr>
                    <td><?= $n +1 ?></td>
                    <td><?= $loan['applied_on'] ?></td>
                    <td><?= $duration ?></td>
                    <td title="Purpose: <?= $loan['purpose'] ?>"><?= display_amount($loan['amount']) ?></td>
                    <td>
                        <form method="post" class='btn-group'>
                            <input value="<?= $loan['id'] ?>" name="loan_id" type="hidden">

                            <?php if($loan['status'] != 'Approved'): ?>
                            <button name="approve" class="btn btn-outline-success">
                                &check;
                            </button>
                            <?php endif ?>

                            
                            <?php if($loan['status'] != 'Rejected'): ?>
                            <button name="reject" class="btn btn-outline-danger">
                                &times;
                            </button>
                            <?php endif ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach ?> <?php endif ?>
            </table>
        </div>
    </main>

    <?php include_once '../html/footer.php' ?>
</body>
</html>