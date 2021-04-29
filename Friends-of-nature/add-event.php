<?php
    //session start
    session_start();
    //check if admin is connected else will be redirected to login
    if(isset($_SESSION['email']) && $_SESSION['type']=='admin' )
    {
        //Add button clicked
        if(isset($_POST['btnAdd']))
        {
            //choose directory where photos are saved in project
            $target_dir = "assets/img/";
            //if admin didnt choose a photo an alert box will show
            if(basename($_FILES["imgUp"]["name"]) == "") 
                echo "<script>alert('Please Add Photo')</script>";
            else
            {
                //get the photo choosed by admin
                $img=$target_dir.basename($_FILES["imgUp"]["name"]);
                require_once("connexion.php");
                //insert all event information from the post form into database
                $sql="insert into hiking(location,date,departure,duration,img) values('{$_POST['txtLocation']}','{$_POST['txtDate']}','{$_POST['txtDeparture']}','{$_POST['txtDuration']}', '$img')";
                mysqli_query($link,$sql);
                if(mysqli_affected_rows($link) > 0)
                {
                    echo "<script>alert('Event successfully added')</script>";
                    header("location:admin-hiking.php");
                }
                    
                else
                    echo "<script>alert('ERROR')</script>";
        }

        }
    }
    else
        header("location:login.php");
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Add Event - Friends of Nature</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="events.php">Events</a></li>
                    <?php
                        //check if the user is connected by checking if the session variable exist
                        //and if he is an admin the best photo link in the Nav Bar will transfer him to the admin page
                        //and if he is not it will transfer him to the normal page
                        if(isset($_SESSION['type']) && $_SESSION['type'] == 'admin')
                            $gallery_page="admin-gallery.php";
                        else
                            $gallery_page="gallery.php";
                    ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $gallery_page?>">Best Photos</a></li>
                    <?php
                        //check if the user is connected by testing if session variable exist
                        //if he is connected the login and registration links will desapear
                        //and a logout link will show 
                        //if the admin login an extra link will show to make him able to go to the users page
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
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Add Event</h2>
                    <p></p>
                </div>
                <form class="" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Location">Location</label>
                        <input class="form-control item" required name="txtLocation">
                    </div>
                    <div class="form-group">
                        <label for="Date">Date</label>
                        <input class="form-control" type="datetime-local" required name="txtDate">
                    </div>
                    <div class="form-group">
                        <label for="Departure">Departure</label>
                        <input class="form-control" type="text" required name="txtDeparture">
                    </div>
                    <div class="form-group">
                        <label for="Duration">Duration</label>
                        <input class="form-control" type="text" required name="txtDuration">
                    </div>
                    <div class="form-group">
                        <label for="img">Photos</label>
                        <input type="file" name="imgUp"><br><br>
                    </div>
                    <button class="btn btn-primary btn-block" name="btnAdd" type="submit">Add</button>
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