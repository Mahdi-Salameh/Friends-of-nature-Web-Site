
<?php
    //Start the session in this page to get acces to session values
    //to make sure if user is connected or no
    session_start();
    
    //if connected redirect to home page
    if(isset($_SESSION['email']))
        header("location:index.php");

    //Login button clicked
    if(isset($_REQUEST['btnLogin']))
    {
        //get email and password from textbox
        //by post method
        $email=$_REQUEST['txtEmail'];
        $pwd=$_REQUEST['txtPwd'];
        //if remember me is checked save email and password in cookies
        if(isset($_REQUEST['chkMemo']))
        {
            setcookie("email","$email",mktime(0,0,0,12,31,2020));
            setcookie("pwd","$pwd",mktime(0,0,0,12,31,2020));
        }
        //connect to database
        require_once("connexion.php");
        //check if email and password are compatible or if user exist
        $sql="select first_name,type from users where email='$email' and password='$pwd'";
        $res=mysqli_query($link,$sql);
        if(mysqli_num_rows($res) == 1)
        {
            $ligne=mysqli_fetch_array($res);
            //save data in the session to read it from all website pages
            $_SESSION['email']=$email;
            $_SESSION['first_name']=$ligne['first_name'];
            $_SESSION['type']=$ligne['type'];
            //echo "<script>alert('$ligne[0]')</script>";
            //redirect to home page
            header("location:index.php");

        }
        else
            //if there is an error an alert box will show
            echo "<script>alert('email password Incorrect')</script>";
    }
    else if(isset($_COOKIE['email'],$_COOKIE['pwd']))
    {
        //get email and password from cookies
        $email=$_COOKIE['email'];
        $pwd=$_COOKIE['pwd'];
    }
    else
        $email=$pwd='';
 ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Friends of Nature</title>
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
                    <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
                </ul>
        </div>
        </div>
    </nav>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Log In</h2>
                    <p></p>
                </div>
                <form class="" action="" method="post">
                    <div class="form-group"><label for="email">Email</label><input class="form-control item" type="email" id="email" required name="txtEmail" value="<?php echo $email ?>"></div>
                    <div class="form-group"><label for="password">Password</label><input class="form-control" type="password" id="password" required name="txtPwd" value="<?php echo $pwd ?>"></div>
                    <div class="form-group">
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="checkbox" name="chkMemo"><label class="form-check-label" for="checkbox">Remember me</label></div>
                    </div><button class="btn btn-primary btn-block" name="btnLogin" type="submit" value="Login">LogIn</button></form>
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