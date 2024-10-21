<?php
include('dbconnect.php'); 
include('adminauthentication.php');
$page_title = "Add Match";
include('include/header.php');
include('include/navbar.php'); 

$query_users = "SELECT * FROM users";
$result_users = $connection->execute_query($query_users);

if (mysqli_num_rows($result_users) > 0) {
    $users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);
} else {
    $users = [];
}

$query_games = "SELECT * FROM games";
$result_games = $connection->execute_query($query_games);

if (mysqli_num_rows($result_games) > 0) {
    $games = mysqli_fetch_all($result_games, MYSQLI_ASSOC);
} else {
    $games = [];
}

$query_groups = "SELECT * FROM playgroups";
$result_groups = $connection->execute_query($query_groups);

if (mysqli_num_rows($result_groups) > 0) {
    $playgroups = mysqli_fetch_all($result_groups, MYSQLI_ASSOC);
} else {
    $playgroups = [];
}

?>

<div class="container bg-dark p-3">
    <div class="container text-white">
    <div class="row">
        <div class="col-md-8 w-100 mx-auto p-1 m-3">
            <div class="card-header">
                <h2 class="text-info">Add Match</h2>
            </div>
            <div>
                <?php if(isset($_SESSION['addmatcherror']))
                {
                    echo "<p class='text-danger'><b>" . $_SESSION['addmatcherror'] . "</b></p>";
                } ?>
            </div>
            <div class="card-body">
                <form action="addmatchcode.php" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Player 1</label>
                    <?php
                    echo '<select name="user1" class="form-control">';
                    foreach ($users as $user1) {
                        echo '<option value="' . $user1['id'] . '">' . $user1['username'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Player 2</label>
                    <?php
                    echo '<select name="user2" class="form-control">';
                    foreach ($users as $user2) {
                        echo '<option value="' . $user2['id'] . '">' . $user2['username'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Player 1 Score</label>
                    <input type=number name="player1score" class="form-control" value="0"></input>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Player 2 Score</label>
                    <input type=number name="player2score" class="form-control" value="0"></input>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Game</label>
                    <?php
                    echo '<select name="game" class="form-control">';
                    foreach ($games as $game) {
                        echo '<option value="' . $game['id'] . '">' . $game['name'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Group</label>
                    <?php
                    echo '<select name="playgroup" class="form-control">';
                    foreach ($playgroups as $playgroup) {
                        echo '<option value="' . $playgroup['id'] . '">' . $playgroup['name'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Description</label>
                    <input type=text name="description" class="form-control" value="-" maxlength="100" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required></input>
                </div>
                <div class="form-group mb-5">
                    <button type="submit" name="add_match_btn" class="btn btn-primary">Submit Match</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<?php include('include/footer.php'); ?>