<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contact Us - Friends of Nature</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/smoothproducts.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container">
            <a class="navbar-brand logo" href="index.php">Friends of Nature </a>
            <a><?php if(isset($_SESSION['first_name'])) echo "Welcome {$_SESSION['first_name']}" ?></a>
            <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>

            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                    <?php
                        if(isset($_SESSION['type']) && $_SESSION['type'] == 'admin')
                            $gallery_page="admin-gallery.php";
                        else
                            $gallery_page="gallery.php";
                    ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $gallery_page?>">Best Photos</a></li>
                    <?php
                    if(!isset($_SESSION['first_name']))
                        echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>';
                    else
                    {
                        if($_SESSION['type'] == 'admin')
                            echo '<li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    }
                        
                    ?>
                </ul>
        </div>
        </div>
    </nav>
    <main class="page contact-us-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Contact Us</h2>
                    <p></p>
                </div>
                <form data-bss-recipient="b7fe9dc8b89be9db2f86030d1ac7fe0b">
                    <div class="form-group"><label>Name</label><input class="form-control" type="text"></div>
                    <div class="form-group"><label>Subject</label><input class="form-control" type="text"></div>
                    <div class="form-group"><label>Email</label><input class="form-control" type="email"></div>
                    <div class="form-group"><label>Message</label><textarea class="form-control"></textarea></div>
                    <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Send</button></div>
                </form>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="registration.php">Sign up</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li></li>
                        <li><a href="contact-us.php">Contact us</a></li>
                        <li><a href="index.php#au">About Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2020 Friends of Nature</p>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/smart-forms.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="assets/js/smoothproducts.min.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>