<?php require_once '../script/functions.php';
    require_once '../script/database.php';
    require_once '../script/auth.php';

    login_required();

    $id = get_id();
    $db = new Database();
    $loan = $db->get($id, 'loans');
    $amount = $loan['amount'];
    $amount_paid = $loan['amount_paid'];
    $balance = $paying_amount = $amount - $amount_paid;
    $approved_on = date('l d F, Y', strtotime($loan['approved_on']));
    $error = '';

    if(
        $loan['status'] != 'Approved' || // Only approved loan can be paid by the user
        $loan['borrower_id'] != $user->id() && // User can only pay his loan
        !$user->is_admin() // Admin user can pay any loan
    ) redirect_to('dashboard.php');

    if(is_post_request()) {
        $paying_amount = get_posted('amount');
        if($paying_amount < 0) $error = 'Paying amount cannot be less than '. display_amount(0);
        elseif($paying_amount > $balance) $error = 'Paying amount cannot be greater than '. display_amount($balance);
        else {
            $db->update_record(
                $id, 'loans', 
                amount_paid: $amount_paid + $paying_amount
            );
            refresh();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to your personal page</title>
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <?php include_once '../html/header.php' ?>

  <main class="container">
    <h1 class="text-center">Pay Loan Of <?=$loan['purpose']?></h1>
    <ul class="list-group">
        <li class="list-group-item">
            <b>Amount</b>: <?= display_amount($amount) ?>
        </li>

        <li class="list-group-item">
            <b>Amount Paid</b>: <?= display_amount($amount_paid) ?>
        </li>

        <li class="list-group-item">
            <b>Balance</b>: <?= display_amount($balance) ?>
        </li>

        <li class="list-group-item">
            <b>Applied On</b>: <?= date('l d F, Y', strtotime($loan['applied_on'])) ?>
        </li>

        <li class="list-group-item">
            <b>Approved On</b>: <?= date('l d F, Y', strtotime($loan['approved_on'])) ?>
        </li>

        <li class="list-group-item">
        <?php if($balance > 0): ?>
            <form method='post' class='input-group'>
                <input name="amount" value="<?= $paying_amount ?>" min="0" max="<?= $balance ?>" type="number" step='0.01' class="form-control" placeholder="Enter amount you want to pay." required>
                <button class="btn btn-success input-group-text">Pay</button>
            </form>
            <p class="text-end text-danger"><?= $error ?></p>
        <?php else: ?>
            <p class='text-center'>
                <b>Paid completely.</b>
            </p>
        <?php endif ?>
        </li>
    </ul>
  </main>

  <?php include_once '../html/footer.php' ?>
</body>

</html>