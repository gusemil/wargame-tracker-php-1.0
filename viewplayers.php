<?php 
session_start();
include('dbconnect.php');
$page_title = "View Players";
include('include/header.php');
include('include/navbar.php'); 
include('unsetsessions.php'); 

function createPlayerCard($id, $username, $elo, $matches, $wins, $losses, $draws, $win_lose_ratio){
    echo 
    "
       <!--<div class='row justify-content-center'>-->
                <div class='col col-6 col-md-4 card my-card-styling bg-black' style='width: 20rem;'>
        <div class='card-body'>
          <h2 class='card-title text-center text-white mb-3'>";
          echo '<span class="fs-1">' . $username . '</span>' . " <span class='text-primary'>(ID:" . $id . ")</span></h2>";
          echo "<p class='card-text text-center text-info mt-4 mb-3 fs-5'> <span class='fs-3'>ELO:<span class='text-white'>$elo</span></span> <br> WINS:<span class='text-white'>$wins</span> LOSSES:<span class='text-white'>$losses</span> DRAWS:<span class='text-white'>$draws</span> MATCHES:<span class='text-white'>$matches</span> <br> WIN/LOSER RATIO:<span class='text-white'>$win_lose_ratio</span></p>";
          echo "<div class='form-group text-center'>
            <a href='viewplayer.php?id=". $id . "'<button class='btn btn-primary'>Check User Page</button></a>
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
                    <h1 class="text-center mb-3">Top 10 Players</h1>
                </div>
                <div class='row justify-content-center'>
                    <?php
                    $max_player_entries = 10;
                    $player_entries = 0;                     
                    $result = $connection->execute_query("SELECT id, username, totalELO, total_matches_played, wins, losses, draws FROM users ORDER BY totalELO DESC");
                    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                        if($player_entries >= $max_player_entries) break;
                        if($row[4] != 0 AND $row[5] != 0)
                        {
                            $win_lose = number_format((float)($row[4] / $row[5]), 1, '.', '');
                        }
                        else
                        {
                            $win_lose = 0;
                        }
                        createPlayerCard($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$win_lose);
                        $player_entries++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>