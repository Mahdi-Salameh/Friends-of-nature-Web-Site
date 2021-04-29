<?php
    //Start the session in this page to get acces to session values
    //to make sure if user is connected or no
    session_start();
    //if connected redirect to home page
    if(isset($_SESSION['email']))
        header("location:index.php");
    
    //Sign up button clicked
    if(isset($_POST['btnSignup']))
    {
        //all data filled in the form 
        if(isset($_POST["txtFirst"],$_POST["txtLast"],$_POST["txtPwd"],$_POST["txtEmail"]))
        {
            //connect to database
            require_once("connexion.php");
            //insert to databse new user information
            $sql="insert into users(email,first_name,last_name,password,type)
            values('{$_POST['txtEmail']}', '{$_POST['txtFirst']}', '{$_POST['txtLast']}', '{$_POST['txtPwd']}', 'user')";

            mysqli_query($link, $sql);
            //check if there is any change in database
            //maybe user already exist
            if(mysqli_affected_rows($link) > 0)
                header("location:login.php");
            else 
                echo "<script>alert('User already exist!')</script>";
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - Friends of Nature</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="assets/fonts/simple-line-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="assets/css/smoothproducts.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="index.php">Friends of Nature</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                    <?php
                        //check if the user is connected by checking if session variable exist
                        //and if he is an admin the best photo link in Nav Bar will transfer him to admin page
                        //and if he is not it will transfer him to the normal page
                        if(isset($_SESSION['type']) && $_SESSION['type'] == 'admin')
                            $gallery_page="admin-gallery.php";
                        else
                            $gallery_page="gallery.php";
                    ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $gallery_page?>">Best Photos</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link active" href="registration.php">Register</a></li>
                </ul>
        </div>
        </div>
    </nav>
    <main class="page registration-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Registration</h2>
                    <p></p>
                </div>
                <form class="" action="" method="post">
                    <div class="form-group"><label for="name">First Name</label><input class="form-control item" type="text" id="name" required name="txtFirst"></div>
                    <div class="form-group"><label for="name">Last Name</label><input class="form-control item" type="text" id="name" required name="txtLast"></div>
                    <div class="form-group"><label for="email">Email</label><input class="form-control item" type="email" id="email" required name="txtEmail"></div>
                    <div class="form-group"><label for="password">Password</label><input class="form-control item" type="password" required id="password" name="txtPwd"></div>
                    <button class="btn btn-primary btn-block" type="submit" name="btnSignup">Sign Up</button>
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