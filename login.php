<?php 
session_start();
if(isset($_SESSION['loggedin']))
{
    header('Location: dashboard.php');
    exit(0);
}

$page_title = "Login";
include('include/header.php');
include('include/navbar.php');

?>

<div class="container bg-dark p-3">
    <div class="container text-white">
    <div class="row">
        <div class="col-md-8 w-100 mx-auto p-1 m-3">
            <div class="card-header">
                <h2 class="text-info">Login Form</h2>
            </div>
            <div>
                <?php if(isset($_SESSION['loginerror']))
                {
                    echo "<p class='text-danger'><b>" . $_SESSION['loginerror'] . "</b></p>";
                } ?>
            </div>
            <div class="card-body">
            <form action="logincode.php" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">UserName</label>
                    <input type="text" name="username" class="form-control" minlength="4" maxlength="12" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" aria-describedby="emailHelp" minlength="6" maxlength="20" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" minlength="8" maxlength="20">
                </div>
                <div class="form-group">
                    <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
                </div>
                <div class="mt-3">
                    <a href="verification.php" class="text-info my-nav-link">Click here to verify your email</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>