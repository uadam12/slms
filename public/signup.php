<?php require_once '../script/functions.php';
  require_once '../script/auth.php';

  logout_required();

  if(is_post_request()) {
    require_once '../script/database.php';

    $password = get_posted('password');
    $password = password_hash($password, PASSWORD_BCRYPT);

    $has_signed_up = $db->insert_record(
      'borrowers', 
      firstname: $firstname = get_posted('firstname'),
      lastname: $lastname = get_posted('lastname'),
      email: $email = get_posted('email'),
      password: $password
    );

    if($has_signed_up) redirect_to('login.php');
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Now</title>
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
          <h3 class="card-title text-primary">Sign UP Now</h3>
      </div>

      <div class="card-body">
        <!-- Name -->
        <div class="input-group mb-2">
            <label for="firstname" class="input-group-text">
              <span class="text-danger">*</span> Firstname
            </label>
            <input value="<?=$firstname??''?>" type="text" id="firstname" name="firstname" class="form-control" placeholder="Please enter your firstname" required>
        </div>

        <div class="input-group mb-2">
            <label for="lastname" class="input-group-text">Lastname</label>
            <input value="<?=$lastname??''?>" type="text" id="lastname" name="lastname" class="form-control" placeholder="Please enter your lastname">
        </div>

        <!-- Email -->
        <div class="input-group mb-2">
            <label for="email" class="input-group-text">
              <span class="text-danger">*</span> Email Address
            </label>
            <input value="<?=$email??''?>" type="email" id="email" name="email" class="form-control" placeholder="Please enter your email address" required>
            <label for="email" class="input-group-text text-muted">
              <i class="fa fa-message"></i>
            </label>
        </div>

        <!-- Password -->
        <div class="input-group mb-2">
            <label for="password" class="input-group-text">
              <span class="text-danger">*</span> Password
            </label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter strong password" required>
            <label for="password" class="input-group-text text-muted">
              <i class="fa fa-lock"></i>
            </label>
        </div>
      </div>

      <div class="card-footer text-end">
        <button class="btn btn-success">
            Sign UP <i class="fa fa-paper-plane"></i>
        </button>
      </div>
    </form>
  </main>
  <?php include_once '../html/footer.php' ?>
</body>

</html>