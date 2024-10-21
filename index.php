<?php 
session_start();
$page_title = "Home Page";
include('include/header.php');
include('include/navbar.php');
include('unsetsessions.php'); 
?>

<div id="" class="container bg-dark p-3" style="margin-top:15rem; margin-bottom:15rem;">
    <div class="container text-white">
    <div class="row">
        <div class="justify-content-center w-100 mx-auto text-center p-1 m-3">
            <h2>Welcome To</h2>
            <h1 class="mt-5 text-info"><b>WarGameTracker</b></h1>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>