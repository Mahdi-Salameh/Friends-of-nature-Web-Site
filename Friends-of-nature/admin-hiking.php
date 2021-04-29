<?php
    session_start();
    //admin test
    if(isset($_SESSION['email']) && $_SESSION['type']=='admin' )
    {
        if(isset($_POST['btnAdd'])) header("location:add-event.php");

        //Delete event from database
        //By getting the id_hike from $_POST['btnDel']
        if(isset($_POST['btnDel']))
        {
            require_once("connexion.php");
            //delete before all reservations to this event
            $sql="delete from reservations where id_hike={$_POST['btnDel']}";
            mysqli_query($link,$sql);
            
            $sql="delete from hiking where id_hike={$_POST['btnDel']}";
            mysqli_query($link,$sql);
            if(mysqli_affected_rows($link) > 0)
                echo "<script>alert('The Event has been deleted')</script>";
        }

        //by clicking on Edit button
        //it will transfer the admin to the edit page 
        //with the id_hike int the url
        if(isset($_POST['btnEdit']))
            header("location:edit-event.php?id_hike={$_POST['btnEdit']}");
    }
    else
        header("location:login.php");    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Hiking - Friends of Nature</title>
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
    <main class="page service-page">
        <section class="clean-block clean-services dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Hiking Events</h2>
                    <p>Escape from the city &amp; feel the benefits of walking outdoors, spending a few hours exercising in nature will boost your mood and well being.</p>
                    <br>
                    <form method='post'>
                        <button class='btn btn-outline-primary btn-sm' type='submit' name='btnAdd'>Add Event</button>   
                    </from>
                </div>
                <div class="row justify-content-center">
                <form method='post'>
                <?php
                    require_once("connexion.php");
                    $sql="select id_hike,location,DATE_FORMAT(date,'%d/%m/%Y %H:%i'),departure,duration,img from hiking order by date";
                    $res=mysqli_query($link, $sql);
                    if(mysqli_num_rows($res) > 0)
                        //Display all events from database with two buttons edit and delete
                        //give id_hike to the buttons value to update database later
                        while($ligne=mysqli_fetch_array($res))
                            echo "<div class='col-md-6 col-lg-4'>
                                    <div class='card'>
                                        <img class='card-img-top w-100 d-block' width='500' height='200' src='$ligne[5]'>
                                        <div class='card-body'>
                                            <h4 class='card-title'>Hiking $ligne[1]</h4>
                                            <p class='card-text'>$ligne[2]</p>
                                            <p class='card-text'>Duration: $ligne[4]</p>
                                            <p class='card-text'>Departure: $ligne[3]</p>
                                        </div>
                                        <div>
                                                <button class='btn btn-outline-primary btn-sm' type='submit' name='btnDel' value='$ligne[0]'>Delete</button>   
                                                <button class='btn btn-outline-primary btn-sm' type='submit' name='btnEdit' value='$ligne[0]'>Edit</button>
                                        </div>
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