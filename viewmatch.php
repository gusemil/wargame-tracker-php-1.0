<?php 
session_start();
include('dbconnect.php');
$page_title = "Match Result";
include('include/header.php');
include('include/navbar.php'); 
include('unsetsessions.php'); 

//get match id from url
$url = basename($_SERVER['REQUEST_URI']);
$id_to_parse = substr($url, strrpos($url, '?') + 1);
parse_str($id_to_parse, $id_output);
$id = $id_output['id'];

$match_query = "SELECT * FROM played_matches WHERE id=$id";
$match_result = $connection->execute_query($match_query);
$match_row = mysqli_fetch_assoc($match_result);

if(!isset($match_row))
{
        header("Location: viewmatches.php");
        exit(0);
}

$winner = $match_row["winner"];
$match_result_text;
if($winner == 1)
{
    //Player 1 wins
    $match_result_text = "Winner: <span class='text-danger'>" . $match_row["user_1_name"] . "!</span><br>With a score of " . $match_row['user_1_score'] . " against a score of " . $match_row['user_2_score'];
} 
else if($winner == -1)
{
    //Player 2 wins
    $match_result_text = "Winner: <span class='text-danger'>" . $match_row["user_2_name"] . "!</span><br>With a score of " . $match_row['user_2_score'] . " against a score of " . $match_row['user_1_score'];
}
else
{
    //Draw
    $match_result_text = "The match is a draw!<br> With scores: " . $match_row['user_1_score'] . "-" . $match_row['user_2_score'];
}
?>

<div id="" class="container bg-dark p-3">
    <div class="container text-white">
    <div class="row">
        <div class="justify-content-center w-100 mx-auto text-center p-1 m-3">
            <div class="bg-black mt-1 mb-1 p-3">
                <div class="">
                    <h1>Match Result (Match ID: <?php echo '<span class="text-info">' . $match_row["id"] . '</span>' . " - " . '<span class="text-info">' . $match_row["created_at"] . '</span>' ?>)</h1>
                </div>
                <div class="">
                    <h2><?php echo "Player 1: " . '<span class="text-warning">' . $match_row["user_1_name"] . '</span>' . " VS Player 2: " . '<span class="text-warning">' . $match_row["user_2_name"] . '</span>' ?></h2>
                    <h2> <?php echo '<span class="text-primary">' . "$match_result_text" . '</span>' ?> </h2>
                    <h4><?php echo $match_row["user_1_name"] . ": Current ELO " . '<span class="text-info">' . $match_row["user_1_elo"] . '</span>' . ", with an ELO score change of " . '<span class="text-info">' . $match_row["user_1_elo_change"] . '</span>'  ?></h4>
                    <h4><?php echo $match_row["user_2_name"] . ": Current ELO " . '<span class="text-info">' . $match_row["user_2_elo"] . '</span>' . ", with an ELO score change of " . '<span class="text-info">' . $match_row["user_2_elo_change"] . '</span>'  ?></h4>
                    <h4><?php echo "Game: " . '<span class="text-info">' . $match_row["game"] . '</span>' . " at " . '<span class="text-info">' . $match_row["playgroup"] . '</span>' ?></h4><br>
                    <h5><?php echo "Description: " . '<span class="text-success">' . $match_row["description"] . '</span>' ?></h5>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>