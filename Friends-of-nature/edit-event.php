<?php
    session_start();
    //admin test
    //get the event information from the databse after getting id_hike from $_GET['id_hike'] from URL
    //update all information and get back to admin-hiking page
    if(isset($_SESSION['email']) && $_SESSION['type']=='admin' )
    {
        if(isset($_POST['btnAdd'])) header("location:addevent.php");
        if(!isset($_GET['id_hike'])) header("location:admin-hiking.php");
        if(isset($_POST['btnDone'])) header("location:admin-hiking.php");

        if(isset($_POST['btnUpdate']))
        {
            $target_dir = "assets/img/";
            //$target_file = $target_dir.basename($_FILES["imgUp"]["name"]);
            if(basename($_FILES["imgUp"]["name"]) == "") 
                $img=$_POST['txtHidden'];
            else
                $img=$target_dir.basename($_FILES["imgUp"]["name"]);
            require_once("connexion.php");
            $sql="update hiking set location='{$_POST['txtLocation']}', date='{$_POST['txtDate']}', departure='{$_POST['txtDeparture']}', duration='{$_POST['txtDuration']}', img='$img' where id_hike={$_GET['id_hike']}";
            mysqli_query($link,$sql);
            if(mysqli_affected_rows($link) > 0)
                echo "<script>alert('Update successful')</script>";
            else
                echo "<script>alert('ERROR')</script>";

        }

        require_once("connexion.php");
        $sql="select * from hiking where id_hike={$_GET['id_hike']}";
        
        $res=mysqli_query($link,$sql);
        if(mysqli_num_rows($res) > 0)
        {
            $ligne=mysqli_fetch_array($res);
            $id=$ligne[0];
            $location=$ligne[1];
            $date=$ligne[2];
            $departure=$ligne[3];
            $duration=$ligne[4];
            $img=$ligne[5];
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
    <title>Edit Event - Friends of Nature</title>
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
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Edit Event</h2>
                    <p></p>
                </div>
                <form class="" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Location">Location</label>
                        <input class="form-control item" required name="txtLocation" value="<?php echo $location ?>">
                    </div>
                    <div class="form-group">
                        <label for="Date">Date</label>
                        <input class="form-control" type="datetime-local" name="txtDate" value="<?php echo date('Y-m-d\TH:i', strtotime($date)); ?>">
                    </div>
                    <div class="form-group">
                        <label for="Departure">Departure</label>
                        <input class="form-control" type="text" name="txtDeparture" value="<?php echo $departure ?>">
                    </div>
                    <div class="form-group">
                        <label for="Duration">Duration</label>
                        <input class="form-control" type="text" name="txtDuration" value="<?php echo $duration ?>">
                    </div>
                    <div class="form-group">
                        <label for="img">Photos</label>
                        <input type="file" name="imgUp"><br><br>
                        <img class="card-img-top w-100 d-block" src="<?php echo $img ?>">
                        <input type="hidden" name="txtHidden" value="<?php echo $img ?>">
                        
                    </div>
                    <button class="btn btn-primary btn-block" name="btnUpdate" type="submit" value="<?php echo $id ?>">Update</button>
                    <button class="btn btn-primary btn-block" name="btnDone" type="submit">Done</button>
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