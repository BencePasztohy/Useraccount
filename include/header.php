<div class="main-link">
    <h3>
        <a href="index.php">Main Page</a>
        <?php 
        if (isset($_SESSION['username'])) {
            echo '<a href="profile.php" class="user-profile">User Profile</a>';
        } else {}
        ?>
    </h3>
</div>
<div class="user-info">
    <h3>
        <?php 
        if (isset($_SESSION['username'])) {
            echo '<span>' . $_SESSION['username'] . ' is logged in</span>';
            echo '<a href="logout.php">Logout</a>'; 
        } else {
            echo '<a href="login.php">Log In</a>';
            echo '<a href="signup.php">Sign Up</a>';
        }
        ?>
    </h3>
</div>