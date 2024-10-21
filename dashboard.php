<?php 
include('authentication.php');
include('dbconnect.php');
$page_title = "Dashboard";
include('include/header.php');
include('include/navbar.php'); 
include('unsetsessions.php'); 

$user_email = $_SESSION['auth_user']['email'];

$user_data_query = "SELECT total_matches_played,totalELO,wins,losses,draws FROM users WHERE email='$user_email'";
$user_data_result = $connection->execute_query($user_data_query);
$user_data_row = mysqli_fetch_assoc($user_data_result);

$user_data_matches_amount = $user_data_row["total_matches_played"];
$user_data_elo = $user_data_row["totalELO"];

?>

<div id="" class="container bg-dark p-3">
    <div class="container text-white">
    <div class="row">
        <div class="justify-content-center w-100 mx-auto text-center p-1 m-3">
            <div class="bg-black mt-1 mb-1 p-3">
                <div class="">
                    <h1 class="mt-3 mb-3">User Dashboard</h1>
                </div>
                <div class="">
                    <h4><span class="text-info">Username:</span> <?php echo $_SESSION['auth_user']['username']; ?></h4>
                    <h4><span class="text-info">Email:</span> <?php echo $_SESSION['auth_user']['email']; ?></h4>
                    <h4><span class="text-info">Your total ELO score:</span> <?php echo $user_data_elo ?></h4>
                    <h4><span class="text-info">Total Matches Played:</span> <?php echo $user_data_row["total_matches_played"] ?></h4>
                    <h4><span class="text-info">Wins:</span> <?php echo $user_data_row["wins"] ?></h4>
                    <h4><span class="text-info">Losses:</span> <?php echo $user_data_row["losses"] ?></h4>
                    <h4><span class="text-info">Draws:</span> <?php echo $user_data_row["draws"] ?></h4>
                    <h4><span class="text-info">Win/Lose Ratio:</span> 
                    <?php if($user_data_row["wins"] != 0 AND $user_data_row["losses"] != 0)
                    { echo number_format((float)($user_data_row["wins"] / $user_data_row["losses"]), 1, '.', '');}
                    else { echo "0";} ?>
                    </h4>
                    <?php if($_SESSION['auth_user']['is_admin'] == 1) : ?>
                    <br>
                    <h2 class="text-success">You are an admin</h2>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>