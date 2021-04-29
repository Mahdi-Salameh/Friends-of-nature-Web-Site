<?php
    //session start
    session_start();
    //check if admin is connected else will be redirected to login
    if(isset($_SESSION['type']) && $_SESSION['type'] == 'admin')
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
                //insert photo into database
                $sql="insert into best_photos(img) values('$img')";
                mysqli_query($link,$sql);
                if(mysqli_affected_rows($link) > 0)
                    echo "<script>alert('Photo successfully added')</script>";    
                else
                    echo "<script>alert('ERROR')</script>";
            }
        }
        //Delet button clicked
        if(isset($_POST['btnDel']))
        {
            //echo "<script>alert('delete from best_photos where id={$_POST['btnDel']}')</script>";
            require_once("connexion.php");
            //delete the photo from database according to its id transfered in $_POST['btnDel']
            $sql="delete from best_photos where id={$_POST['btnDel']}";
            mysqli_query($link,$sql);
            if(mysqli_affected_rows($link) > 0)
                echo "<script>alert('Photo has been deleted')</script>";
            else
                echo "<script>alert('ERROR')</script>";
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
    <title>Gallery - Friends of Nature</title>
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
                    <li class="nav-item"><a class="nav-link" href="events.php">Events</a></li>
                    <?php
                        if(isset($_SESSION['type']) && $_SESSION['type'] == 'admin')
                            $gallery_page="admin-gallery.php";
                        else
                            $gallery_page="gallery.php";
                    ?>
                    <li class="nav-item"><a class="nav-link active" href="<?php echo $gallery_page?>">Best Photos</a></li>
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
    <main class="page gallery-page">
        <section class="clean-block clean-services dark">
            <div class="container">
                <div class="block-heading">
                <h2 class="text-info">Best Photos</h2>
                    <p>Lebanon is known, in the region, for its natural wealth and beauty. With unparalleled green expanses and a history stretching as far back as the earliest of human activity, the country is littered with small natural treasures. If you’re
                        looking for beautiful sites around Lebanon, here are the most stunning.<br></p>
                    <br>
                    <form method='post' enctype='multipart/form-data'>
                            <input type='file' name='imgUp'><br><br>   
                            <button class='btn btn-outline-primary btn-sm' type='submit' name='btnAdd'>Add Photos</button>   
                    </from>
                </div>
                <div class="row justify-content-center">
                    <form method='post'>
                        <?php
                            //connect to database
                            require_once("connexion.php");
                            //extract photos information from databse
                            //put the id photo in btnDelete value to send it in POST
                            $sql="select * from best_photos";
                            $res=mysqli_query($link, $sql);
                            if(mysqli_num_rows($res) > 0)
                                //Display all photos from databse with a delete button for each one
                                while($row=mysqli_fetch_array($res))
                                    echo "<div class='col-md-6 col-lg-4'>
                                                <a class='lightbox' href='$row[1]'><img class='card-img-top w-100 d-block' height='200' src='$row[1]'></a>
                                                <div class='form-group'>
                                                        <button class='btn btn-outline-primary btn-sm form-control' type='submit' name='btnDel' value='$row[0]'>Delete</button>           
                                                </div>
                                        </div>";
                        ?>
                    </from>

                </div>
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