<?php
session_start(); 
include('dbconnect.php');
$page_title = "View Matches";
include('include/header.php');
include('include/navbar.php'); 
include('unsetsessions.php'); 

function createMatchCard($id, $name, $game, $playgroup, $user_1_score, $user_2_score, $timestamp){
    echo 
    "
       <!--<div class='row justify-content-center'>-->
                <div class='col col-6 col-md-4 card my-card-styling bg-black' style='width: 18rem;'>
        <div class='card-body'>
          <h2 class='card-title text-center text-white mb-3'>";
          echo '<span class="fs-1">' . $name . '</span>' . " <span class='text-primary'>(ID:" . $id . ")</span></h2>";
          echo "<p class='card-text text-center text-info mt-4 mb-3 fs-5'> <span class='text-warning fs-3'>$user_1_score<span class='text-white'> - </span>$user_2_score</span> <br>
          <span class='fs-3'>$game<span class='text-white'>@</span><span class='text-warning'>$playgroup</span></span> <br>
          $timestamp</p>";
          echo "<div class='form-group text-center'>
            <a href='viewmatch.php?id=". $id . "'<button class='btn btn-primary'>Check Match Info</button></a>
            </div>
        </div>
      </div>
    ";
}
?>

<div class="container bg-dark p-3">
    <div class="container text-white">
    <div class="row">
        <div class="col-md-8 w-100 mx-auto p-1 m-3">
            <div class="">
                <div class="">
                    <h1 class="text-center mb-3">Latest 20 Matches</h1>
                </div>
                <div class='row justify-content-center'>
                    <?php                     
                    $result = $connection->execute_query("SELECT id, name, game, playgroup, user_1_score, user_2_score, created_at FROM played_matches ORDER BY created_at DESC LIMIT 20");

                    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                        createMatchCard($row[0],$row[1],$row[2],$row[3], $row[4], $row[5], $row[6]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>