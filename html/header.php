<header class='mb-5'>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid ">
            <a class="navbar-brand " href="/">
                <i class="fa fa-home"></i> SLMS
            </a>

            <button 
                class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" 
                aria-expanded="false" 
                aria-label="Toggle navigation"> 
                    <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                <?php
                    include_once '../script/auth.php'; 
                    if($user->is_logged_in()): 
                ?>
                    <?php if($user->is_admin()): ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="borrowers.php">Borrowers</a>
                    </li>    
                    <?php endif ?>
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="signup.php">
                            <i class="fa fa-user-plus"></i> Register
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">
                            <i class="fa fa-user"></i> Login
                        </a>
                    </li>
                <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
</header>