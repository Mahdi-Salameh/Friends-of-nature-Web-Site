<?php
    //Start the session in this page to get acces to session values
    //to make sure if the user is connected or no
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Friends of Nature</title>
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
    <main class="page landing-page">
        <section class="clean-block clean-hero" style="background-image: url(&quot;assets/img/bg.jpg&quot;);color: rgba(9,162,255,0.24);">
            <div class="text">
                <h2>Live Love Nature</h2>
                <p>Going to the mountains is like going home.<br></p>
            </div>
        </section>
        <section class="clean-block clean-info dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Join Us</h2>
                    <p>Over 100,000 hikes. 20 million explorers. Endless memories.</p>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6"><img class="img-thumbnail" src="assets/img/image5.jpg"></div>
                    <div class="col-md-6">
                        <h3>What are you waiting for?</h3>
                        <div class="getting-started-info">
                            <?php
                                if(isset($_SESSION['email']))
                                    $page="events.php";
                                else
                                    $page="registration.php";
                            ?>
                            <p>Experience the uniqueness and authentic beauty of mother nature in our nature adventure tours. Join thrilling expeditions in various parts of Lebanon</p>
                        </div><a class="btn btn-outline-primary btn-lg" role="button" href="<?php echo $page ?>">Join Now</a></div>
                </div>
            </div>
        </section>
        <section class="clean-block features"></section>
        <section class="clean-block slider dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Lebanon</h2>
                    <p>The 470km-long Lebanon Mountain Trail traverses the full length of this tiny Middle Eastern country, passing through ancient cedar forests and olive orchards, and ambling by rushing waterfalls, Roman temples and monasteries carved
                        into cliff faces</p>
                </div>
                <div class="carousel slide" data-ride="carousel" id="carousel-1">
                    <div class="carousel-inner">
                    <?php
                        //connect to the database
                        require_once("connexion.php");
                        //select photos path from best_photos table
                        $sql="select img from best_photos";
                        //run the sql query
                        $res=mysqli_query($link,$sql);
                        if(mysqli_num_rows($res) > 0)
                        {
                            //extract a row from the result
                            $row=mysqli_fetch_array($res);
                            //display the first photo separatly and add the active class to it
                            echo "<div class='carousel-item active'><img class='w-100 d-block' src='$row[0]' alt='Slide Image'></div>";
                            //display all photos from the table
                            while($row=mysqli_fetch_array($res))
                                echo "<div class='carousel-item'><img class='w-100 d-block' src='$row[0]' alt='Slide Image'></div>";
                        }

                    
                    ?>
                    </div>
                    <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button"
                            data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
                    <ol class="carousel-indicators">
                        <?php
                            //connect to the databse
                            require_once("connexion.php");
                            //extract the number of photos in the database
                            $sql="select count(id) from best_photos";
                            $res=mysqli_query($link,$sql);
                            if(mysqli_num_rows($res) == 1)
                            {
                                //this help to navigate between photos smoothly without errors
                                //by indicating how much photos do we have
                                
                                //read the extracted ligne (contains only one number)
                                $row=mysqli_fetch_array($res);
                                //convert the extracted number to an integer to use it in for
                                $length=intval($row[0]);
                                echo "<li data-target='#carousel-1' data-slide-to='0' class='active'></li>";
                                for($i=1;$i<$length;$i++)
                                    echo "<li data-target='#carousel-1' data-slide-to='$i'></li>";     
                            }
                        ?>
                    </ol>
                </div>
            </div>
        </section>
        <section id="au" class="clean-block about-us">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">About Us</h2>
                    <p>We live Lebanon and love our country and want to share our country with the world.</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-lg-4">
                        <div class="card clean-card text-center"><img class="card-img-top w-100 d-block" src="assets/img/avatar1.jpg">
                            <div class="card-body info">
                                <h4 class="card-title">Mahdi Salameh</h4>
                                <p class="card-text">I am Lebanese, and in love with Lebanon. I come from engineering background, and my passion is to discover Lebanon and let others see its beauty and diversity with all its wonderful cultural and natural places<br></p>
                                <div class="icons">
                                    <a add target="_blank" href="https://www.facebook.com/mahdi.salameh"><i class="icon-social-facebook"></i></a>
                                    <a add target="_blank" href="https://www.instagram.com/mahdi_salameh/"><i class="icon-social-instagram"></i></a>
                                    <a add target="_blank" href="https://twitter.com/salamehmahdi"><i class="icon-social-twitter"></i></a>
                                </div>
                        </div>
                    </div>
                </div>
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