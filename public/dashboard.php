<?php require_once '../script/functions.php';
    require_once '../script/auth.php';
    require_once '../script/database.php';

    login_required();

    $borrower_id = $user->data()['id'];

    if(is_post_request()) {
        $inserted = $db->insert_record(
            'loans', borrower_id: $borrower_id,
            amount: $amount = get_posted('amount'),
            purpose: $purpose = get_posted('purpose'),
            duration: get_posted('duration')
        );
        
        if($inserted) refresh();
    }

    $loans = $db->filter(
        'loans', "borrower_id = $borrower_id", 
        columns: '*, DATE_ADD(approved_on, INTERVAL duration MONTH) AS due_on',
        order_by: 'status, applied_on',
    );
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
    <h2 class="text-dark text-center">Welcome back <?= $user->name() ?></h2>
    <p class="text-muted text-center"><?= $user->data()['email'] ?></p>

    <?php if(empty($loans)): ?>
    <h3 class="text-info text-center">You have not apply for a loan.</h3>

    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered caption-top table-hover table-striped">
            <caption>Your applied loans</caption>
            <tr>
                <th>SN</th>
                <th>Loan Amount</th>
                <th>Applied on</th>
                <th>Due on</th>
                <th>Status</th>
            </tr>

            <?php foreach($loans as $n=>$loan): ?>
            <tr>
                <td><?= $n +1 ?></td>
                <td title="Purpose: <?= $loan['purpose'] ?>">
                    <?= display_amount($loan['amount']) ?>
                </td>
                <td><?= display_date($loan['applied_on']) ?></td>
                <td><?= display_date($loan['due_on']) ?></td>
                <td>
                <?php 
                    if($loan['status'] != 'Approved') echo $loan['status'];
                    else {
                ?>
                    <?php 
                      if($loan['amount'] == $loan['amount_paid'])
                            echo 'Paid';
                        else {
                ?>
                    <a href="pay.php?id=<?= $loan['id'] ?>" class="btn btn-success">
                        Pay
                    </a>
                <?php }} ?>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </div>
    <?php endif ?>

    <form method="post" class="card shadow my-3">
        <div class="card-header text-center">
            <h3 class="card-title text-dark">Apply For Our Instant Loan Here</h3>
        </div>

        <div class="card-body">
            <!-- Amount -->
            <div class="input-group">
                <label for="amount" class="input-group-text">
                    <span class="text-danger">*</span> Amount
                </label>

                <input value="<?=$amount??''?>" type="number" step='.05' id="amount" name="amount" class="form-control" placeholder="Please enter amount" required>

                <label for="amount" class="input-group-text text-muted">₦</label>
            </div>
            <p class="p-0 text-danger text-end"><?= $errors['amount']?? '' ?></p>

            <!-- Duration -->
            <div class="input-group mt-2">
                <label for="duration" class="input-group-text">
                    <span class="text-danger">*</span> Duration
                </label>

                <select name="duration" id="duration" class="form-control" required>
                    <option selected disabled>Please select loan duration</option>
                    <option value="1">A Month</option>
                    <option value="3">Three Months</option>
                    <option value="6">Six Months</option>
                    <option value="12">A Year</option>
                    <option value="24">Two years</option>
                </select>
            </div>
            <p class="p-0 text-danger text-end"><?= $errors['duration']?? '' ?></p>

            <!-- Purpose -->
            <div class="input-group mt-2">
                <label for="purpose" class="input-group-text">
                    <span class="text-danger">*</span> Purpose
                </label>

                <input type="text" value="<?=$purpose??''?>" class="form-control" name="purpose" id="purpose" placeholder="Enter loan purpose. eg Paying school fees" required>
            </div>
        </div>

        <div class="card-footer text-end">
            <button class="btn btn-primary">
                Apply Now
            </button>
        </div>
    </form>
</main>

<?php include_once '../html/footer.php' ?>

</body>

</html>