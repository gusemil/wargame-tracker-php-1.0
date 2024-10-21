<?php 
session_start();
include('dbconnect.php');
$page_title = "Dashboard";
include('include/header.php');
include('include/navbar.php'); 
include('unsetsessions.php'); 

//get user id from url
$url = basename($_SERVER['REQUEST_URI']);
$id_to_parse = substr($url, strrpos($url, '?') + 1);
parse_str($id_to_parse, $id_output);
$id = $id_output['id'];

$user_data_query = "SELECT * FROM users WHERE id='$id'";
$user_data_result = $connection->execute_query($user_data_query);
$user_data = mysqli_fetch_assoc($user_data_result);

if(!isset($user_data))
{
        header("Location: viewplayers.php");
        exit(0);
}
?>

<div id="" class="container bg-dark p-3">
    <div class="container text-white">
    <div class="row">
        <div class="justify-content-center w-100 mx-auto text-center p-1 m-3">
            <div class="bg-black mt-1 mb-1 p-3">
                <div class="">
                    <h1>User Info</h1>
                </div>
                <div class="">
                    <h4><span class="text-info">Username:</span> <span class="text-primary"><?php echo $user_data["username"]; ?></span></h4>
                    <h4><span class="text-info">Total ELO score:</span> <?php echo $user_data["totalELO"] ?></h4>
                    <h4><span class="text-info">Total Matches Played:</span> <?php echo $user_data["total_matches_played"] ?></h4>
                    <h4><span class="text-info">Wins:</span> <?php echo $user_data["wins"] ?></h4>
                    <h4><span class="text-info">Losses:</span> <?php echo $user_data["losses"] ?></h4>
                    <h4><span class="text-info">Draws:</span> <?php echo $user_data["draws"] ?></h4>
                    <h4><span class="text-info">Win/Lose Ratio:</span> 
                    <?php if($user_data["wins"] != 0 AND $user_data["losses"] != 0)
                    { echo number_format((float)($user_data["wins"] / $user_data["losses"]), 1, '.', '');}
                    else { echo "0";} ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>