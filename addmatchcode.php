<?php

session_start();
include('dbconnect.php');


if(isset($_POST['add_match_btn']))
{
    $user1_id = $_POST['user1'];
    $user2_id = $_POST['user2'];
    $game_id = $_POST['game'];
    $playgroup_id = $_POST['playgroup'];
    $user_1_points = $_POST['player1score'];
    $user_2_points = $_POST['player2score'];
    $description = $_POST['description'];

    if($user1_id == $user2_id){
        $_SESSION['addmatcherror'] = "Please ensure Player 1 and Player 2 are different";
        header('Location: addmatch.php');
        exit(0);
    }
    else
    {
        unset($_SESSION['addmatcherror']);
    }
        $is_draw;
        $player_1_wins;
        $winner = 0; //winner is 0 if draw, 1 if player 1, -1 if player 2
        if(isset($user_1_points) && isset($user_2_points))
        {
            if($user_1_points > $user_2_points)
            {
               //User 1 wins 
               $player_1_wins = true;
               $is_draw = false;
            }
            else if($user_2_points > $user_1_points){
                //User 2 wins
                $player_1_wins = false;
                $is_draw = false;
            }
            else 
            {
                //Draw
                $is_draw = true;
            }
        }
        else 
        {
            $_SESSION['status'] = "Please Ensure User 1 and User 2 scores are set";
            header('Location: addmatch.php');
            exit(0); 
        }

        $player_1_score_query = "SELECT totalELO FROM users WHERE id=$user1_id";
        $player_2_score_query = "SELECT totalELO FROM users WHERE id=$user2_id";

        $player_1_result = $connection->execute_query($player_1_score_query);
        $player_2_result = $connection->execute_query($player_2_score_query);

        $player_1_row = mysqli_fetch_assoc($player_1_result);
        $player_2_row = mysqli_fetch_assoc($player_2_result);

        $player_1_score = $player_1_row["totalELO"];
        $player_2_score = $player_2_row["totalELO"];

        $player_1_old_score = $player_1_score;
        $player_2_old_score = $player_2_score;

        $player_1_matches_query = "SELECT total_matches_played FROM users WHERE id=$user1_id";
        $player_2_matches_query = "SELECT total_matches_played FROM users WHERE id=$user2_id";

        $player_1_matches_result = $connection->execute_query($player_1_matches_query);
        $player_2_matches_result = $connection->execute_query($player_2_matches_query);

        $player_1_matches_row = mysqli_fetch_assoc($player_1_matches_result);
        $player_2_matches_row = mysqli_fetch_assoc($player_2_matches_result);

        $player_1_matches_amount = $player_1_matches_row["total_matches_played"];
        $player_2_matches_amount = $player_2_matches_row["total_matches_played"];

        //Algorithm help: https://www.geeksforgeeks.org/elo-rating-algorithm/

        if(!$is_draw)
        {
    
            $amountOfGamesPlayed = 1;
    
            //Propability
            $p1 = (1.0 / (1.0 + Pow(10, (($player_2_score - $player_1_score) / 400)))) / $amountOfGamesPlayed; //400 * wins - losses = 400 * 1
            $p2 = (1.0 / (1.0 + Pow(10, (($player_1_score - $player_2_score) / 400)))) / $amountOfGamesPlayed; //400 * wins - losses = 400 * 1
    
            //Update ranking
    
            //Algorithm help: https://www.omnicalculator.com/sports/elo
            //https://www.noveltech.dev/elo-ranking-csharp-unity
    
            //FIDE uses k-factor of 40 for players under 2300 ELO and less than 30 games: https://en.wikipedia.org/wiki/Elo_rating_system#Most_accurate_K-factor
            //20 for over 30 games but under 2400 ELO
            //10 if 2400 or over ELO and at least 30 games
            $k;
    
            //If player 1 wins
            if($player_1_wins)
            {
                if($player_1_old_score < 2300)
                {
                    if ($player_1_matches_amount <= 30)
                    {
                        $k = 40;
                    }
                    else
                    {
                        $k = 20;
                    }
                }
                else
                {
                    $k = 10;
                }

                $winner = 1;
                $player_1_score = round($player_1_score + ($k * (1 - $p1)) * $amountOfGamesPlayed); //1 win - 0 losses = 1
                $player_2_score = round($player_2_score +  ($k * ($p1 - 1)) * $amountOfGamesPlayed); //0 wins - 1 losses = -1    
            }
            else //Else player 2 wins
            {
                if($player_2_old_score < 2300)
                {
                    if ($player_2_matches_amount <= 30)
                    {
                        $k = 40;
                    }
                    else
                    {
                        $k = 20;
                    }
                }
                else
                {
                    $k = 10;
                }
                
                $winner = -1;
                $player_2_score = round($player_2_score + ($k * (1 - $p2)) * $amountOfGamesPlayed); //1 win - 0 losses = 1
                $player_1_score = round($player_1_score +  ($k * ($p2 - 1)) * $amountOfGamesPlayed); //0 wins - 1 losses = -1     
            }

            $update_user1_query = "UPDATE users SET totalELO=$player_1_score WHERE id=$user1_id";
            $update_user2_query = "UPDATE users SET totalELO=$player_2_score WHERE id=$user2_id";
    
            $connection->execute_query($update_user1_query);
            $connection->execute_query($update_user2_query);
        }

        //Update total matches

        $player_1_matches_amount = $player_1_matches_amount +1;
        $player_2_matches_amount = $player_2_matches_amount +1;
        

        //Update matches played
        $update_user1_matches_query = "UPDATE users SET total_matches_played=$player_1_matches_amount WHERE id=$user1_id";
        $update_user2_matches_query = "UPDATE users SET total_matches_played=$player_2_matches_amount WHERE id=$user2_id";

        $connection->execute_query($update_user1_matches_query);
        $connection->execute_query($update_user2_matches_query);

        //Update player wins/losses/draw

        $player_1_wins_losses_query = "SELECT wins,losses,draws FROM users WHERE id=$user1_id";
        $player_2_wins_losses_query = "SELECT wins,losses,draws FROM users WHERE id=$user2_id";

        $player_1_wins_losses_result = $connection->execute_query($player_1_wins_losses_query);
        $player_2_wins_losses_result = $connection->execute_query($player_2_wins_losses_query);

        $player_1_wins_losses_row = mysqli_fetch_assoc($player_1_wins_losses_result);
        $player_2_wins_losses_row = mysqli_fetch_assoc($player_2_wins_losses_result);

        $update_user_1_wins_losses_draws_query;
        $update_user_2_wins_losses_draws_query;

        if($is_draw)
        {
            $player_1_draws_amount = $player_1_wins_losses_row["draws"];
            $player_2_draws_amount = $player_2_wins_losses_row["draws"];
            $player_1_draws_amount = $player_1_draws_amount +1;
            $player_2_draws_amount = $player_2_draws_amount +1;
            $update_user_1_wins_losses_draws_query = "UPDATE users SET draws=$player_1_draws_amount WHERE id=$user1_id";
            $update_user_2_wins_losses_draws_query = "UPDATE users SET draws=$player_2_draws_amount WHERE id=$user2_id";
        }
        else
        {
            $player_1_wins_amount = $player_1_wins_losses_row["wins"];
            $player_1_losses_amount = $player_1_wins_losses_row["losses"];
            $player_2_wins_amount = $player_2_wins_losses_row["wins"];
            $player_2_losses_amount = $player_2_wins_losses_row["losses"];

            if($player_1_wins)
            {
                $player_1_wins_amount = $player_1_wins_amount +1;
                $player_2_losses_amount = $player_2_losses_amount +1;
                $update_user_1_wins_losses_draws_query = "UPDATE users SET wins=$player_1_wins_amount WHERE id=$user1_id";
                $update_user_2_wins_losses_draws_query = "UPDATE users SET losses=$player_2_losses_amount WHERE id=$user2_id";
            }
            else
            {
                $player_2_wins_amount = $player_2_wins_amount +1;
                $player_1_losses_amount = $player_1_losses_amount +1;
                $update_user_2_wins_losses_draws_query = "UPDATE users SET wins=$player_2_wins_amount WHERE id=$user2_id";
                $update_user_1_wins_losses_draws_query = "UPDATE users SET losses=$player_1_losses_amount WHERE id=$user1_id";
            }
        }

        $connection->execute_query($update_user_1_wins_losses_draws_query);
        $connection->execute_query($update_user_2_wins_losses_draws_query);

        ///Player name query and insertion

        $player_1_name_query = "SELECT username FROM users WHERE id=$user1_id";
        $player_2_name_query = "SELECT username FROM users WHERE id=$user2_id";

        $player_1_result = $connection->execute_query($player_1_name_query);
        $player_2_result = $connection->execute_query($player_2_name_query);

        $player_1_row = mysqli_fetch_assoc($player_1_result);
        $player_2_row = mysqli_fetch_assoc($player_2_result);

        $player_1_name = $player_1_row["username"];
        $player_2_name = $player_2_row["username"];

        ///Game query and insertion

        $game_query = "SELECT name FROM games WHERE id=$game_id";
        $game_result = $connection->execute_query($game_query);
        $game_row = mysqli_fetch_assoc($game_result);
        $game_name = $game_row["name"];

        ///Playgroup query and insertion

        $playgroup_query = "SELECT name FROM playgroups WHERE id=$playgroup_id";
        $playgroup_result = $connection->execute_query($playgroup_query);
        $playgroup_row = mysqli_fetch_assoc($playgroup_result);
        $playgroup_name = $playgroup_row["name"];

        $default_match_name = $player_1_name . "-". $player_2_name;
        $default_description = htmlspecialchars($description);

        $player_1_elo_change = $player_1_score - $player_1_old_score;
        $player_2_elo_change = $player_2_score - $player_2_old_score;

        $insert_match_query = "INSERT INTO played_matches (name,description, user_1_name, user_2_name, user_1_elo, user_2_elo, user_1_elo_change, user_2_elo_change, user_1_score, user_2_score, winner, game, playgroup)
        VALUES ('$default_match_name','$default_description','$player_1_name','$player_2_name','$player_1_score','$player_2_score','$player_1_elo_change','$player_2_elo_change','$user_1_points','$user_2_points','$winner','$game_name','$playgroup_name')";

        $connection->execute_query($insert_match_query);

        $_SESSION['last_match_id'] = $connection->insert_id;

        $_SESSION['status'] = "Adding the match was successful";
        header("Location: viewmatch.php?id=" . $_SESSION['last_match_id']);
}

?>