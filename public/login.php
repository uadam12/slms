<?php require_once '../script/functions.php';
  require_once '../script/auth.php';

  logout_required();

  if(is_post_request()) {
    $email = get_posted('email');
    $password = get_posted('password');
    $errors = $user->login($email, $password);

    if(empty($errors)) {
      if($user->is_admin()) redirect_to('borrowers.php');
      else redirect_to('dashboard.php');
    }
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login to SLMS</title>
  <!-- Latest compiled and minified CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Latest compiled JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
  <?php include_once '../html/header.php' ?>
  <main class="container">
    <form method="post" class="card shadow my-3">
      <div class="card-header text-center">
          <h3 class="card-title text-primary">Login Now</h3>
      </div>

      <div class="card-body">
        <!-- Email -->
        <div class="input-group">
            <label for="email" class="input-group-text">
              <span class="text-danger">*</span> Email Address
            </label>
            <input value="<?=$email??''?>" type="email" id="email" name="email" class="form-control" placeholder="Please enter your email address" required>
            <label for="email" class="input-group-text text-muted">
              <i class="fa fa-message"></i>
            </label>
        </div>
        <p class="p-0 text-danger text-end"><?= $errors['email']?? '' ?></p>


        <!-- Password -->
        <div class="input-group mt-2">
            <label for="password" class="input-group-text">
              <span class="text-danger">*</span> Password
            </label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter strong password" required>
            <label for="password" class="input-group-text text-muted">
              <i class="fa fa-lock"></i>
            </label>
        </div>
        <p class="p-0 text-danger text-end"><?= $errors['password']?? '' ?></p>
      </div>

      <div class="card-footer text-end">
        <button class="btn btn-success">
            Login <i class="fa fa-paper-plane"></i>
        </button>
      </div>
    </form>
  </main>
  <?php include_once '../html/footer.php' ?>
</body>

</html>