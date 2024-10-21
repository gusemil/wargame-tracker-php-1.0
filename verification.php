<?php
session_start(); 
$page_title = "Verification";
include('include/header.php');
include('include/navbar.php'); 

?>

<div class="container bg-dark p-3">
    <div class="container text-white">
    <div class="row">
        <div class="col-md-8 w-100 mx-auto p-1 m-3">
            <div class="card-header">
            <h2 class="text-info">Verify Form</h2>
            </div>
            <div>
                <?php if(isset($_SESSION['verificationerror']))
                {
                    echo "<p class='text-danger'><b>" . $_SESSION['verificationerror'] . "</b></p>";
                } ?>
            </div>
            <div class="card-body">
                <form action="verificationcode.php" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">UserName</label>
                    <input type="text" name="username" class="form-control" minlength="4" maxlength="12" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" aria-describedby="emailHelp" minlength="6" maxlength="40" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" minlength="8" maxlength="20">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password Verify</label>
                    <input type="password" name="password_verify" class="form-control" minlength="8" maxlength="20">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Verify Token</label>
                    <input type="password" name="verifytoken" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" name="verification_btn" class="btn btn-primary">Verify Now</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>