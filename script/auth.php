<?php session_start();

class User {
    private static array $admin_emails = [
        'uadam12@gmail.com'
    ];

    function login(string $email, string $password): array {
        require_once '../script/database.php';
        
        $errors = [];
        $user = $db->filter('borrowers', "email = '$email'")[0];

        if(empty($user)) $errors['email'] = 'Account not found.';
        elseif(!password_verify($password, $user['password']))
            $errors['password'] = "Wrong password";
        else {
            unset($user['password']);
            $_SESSION['user'] = $user;
        }

        return $errors;
    }

    function logout(): void {
        unset($_SESSION['user']);
    }

    function data() : array {
        return $_SESSION['user']?? [];
    }

    function id() : int {
        return $this->data()['id'];
    }

    function name() : string {
        $data = $this->data();

        return trim($data['firstname']. ' ' .$data['lastname']);
    }

    function is_logged_in() : bool {
        return !empty($this->data());
    }

    function is_admin(): bool {        
        return $this->is_logged_in() && in_array(
            $this->data()['email'], 
            static::$admin_emails
        );
    }
}


$user = new User();

function login_required() : void {
    global $user;

    if(!$user->is_logged_in()) {
        redirect_to('login.php');
        exit;
    }
}

function logout_required() : void {
    global $user;

    if($user->is_logged_in()) {
        redirect_to('dashboard.php');
        exit;
    }
}

function only_admin() : void {
    global $user;

    if(!$user->is_admin()) {
        $user->logout();
        redirect_to('login.php');
        exit;
    }
}

?>