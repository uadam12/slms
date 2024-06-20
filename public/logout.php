<?php
    require_once '../script/functions.php';
    require_once '../script/auth.php';

    login_required();

    $user->logout();
    
    redirect_to('login.php');
?>