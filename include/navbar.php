
                <nav class="navbar navbar-expand-lg sticky-top bg-black ">
                <div class="container-fluid">
                    <a class="navbar-brand text-white" href="index.php" style="padding-right: 30vw">WarGameTracker</a>
                    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                    <a class="nav-link text-white my-nav-link fs-4" href="viewmatches.php">View Matches</a>
                    <a class="nav-link text-white my-nav-link fs-4" href="viewplayers.php">View Players</a>
                    <?php if(isset($_SESSION['loggedin']) AND ($_SESSION['auth_user']['is_admin'] == 1)) : ?>
                    <a class="nav-link text-white my-nav-link fs-4" href="addmatch.php">Add Match</a>
                    <?php endif ?>
                    <?php if(!isset($_SESSION['loggedin'])) : ?>
                    <a class="nav-link text-success my-nav-link fs-4" href="registration.php">Register</a>
                    <?php endif ?>
                    <?php if(!isset($_SESSION['loggedin'])) : ?>
                    <a class="nav-link text-warning my-nav-link fs-4" href="login.php">Login</a>
                    <?php endif ?>
                    <?php if(isset($_SESSION['loggedin'])) : ?>
                    <a class="nav-link text-success my-nav-link fs-4" href="dashboard.php">User Dashboard</a>
                    <?php endif ?>
                    <?php if(isset($_SESSION['loggedin'])) : ?>
                    <a class="nav-link text-danger my-nav-link fs-4" href="logout.php">Log Out</a>
                    <?php endif ?>
                    </div>
                    </div>
                    </div>
                </div>
                </nav>

