<?php
    session_start();

    //admin test
    if(!isset($_SESSION['email']) && $_SESSION['type']!='admin' )
        header("location:login.php");

    if(isset($_POST['btnDel']))
    {
        require_once("connexion.php");
        //delete all reservation related to chosen user
        $sql="delete from reservations where user='{$_POST['btnDel']}'";
        mysqli_query($link,$sql);
        //delete user
        $sql="delete from users where email='{$_POST['btnDel']}'";
        mysqli_query($link,$sql);
        if(mysqli_affected_rows($link) > 0)
            echo "<script>alert('User has been deleted')</script>";
    }

    if(isset($_POST['btnUpdate']))
        {
            require_once("connexion.php");
            //extract the type of user wants to update his type
            $sql="select type from users where email='{$_POST['btnUpdate']}'";
            $res=mysqli_query($link,$sql);
            if(mysqli_num_rows($res) == 1)
                $row=mysqli_fetch_array($res);
            //if he is an admin new type is user
            if($row[0] == 'admin')
                $newType='user';
            else
                //if he is a user new type is admin
                $newType='admin';
            //update user according to the new type selected and the email of user (get it by POST)
            $sql="update users set type='$newType' where email='{$_POST['btnUpdate']}'";
            mysqli_query($link,$sql);
            if(mysqli_affected_rows($link) > 0)
                echo "<script>alert('Update successful')</script>";
            else
                echo "<script>alert('ERROR')</script>";

        }
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Users - Friends of Nature</title>
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
                    <li class="nav-item"><a class="nav-link" href="<?php echo $gallery_page?>">Best Photos</a></li>
                    <?php
                    if(!isset($_SESSION['first_name']))
                        echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>';
                    else
                    {
                        if($_SESSION['type'] == 'admin')
                            echo '<li class="nav-item"><a class="nav-link active" href="users.php">Users</a></li>';
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
                    <h2 class="text-info">Users</h2>
                    <p></p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post">
                        <?php
                            require_once("connexion.php");
                            $sql="select * from users where email!='{$_SESSION['email']}'";
                            $res=mysqli_query($link,$sql);
                            if(mysqli_num_rows($res) > 0)
                                //Display all users information with two button fo each user
                                //one for change type and one for delete user
                                while($row=mysqli_fetch_array($res))
                                {
                                    if($row[4] == 'admin')
                                        $newType='user';
                                    else
                                        $newType='admin';
                                    echo "
                                        <tr>
                                            <td>$row[0]</td>
                                            <td>$row[1]</td>
                                            <td>$row[2]</td>
                                            <td>$row[4]</td>
                                            <td><button class='btn btn-outline-primary btn-sm' type='submit' name='btnUpdate' value='$row[0]'>Make $newType</button></td>
                                            <td><button class='btn btn-outline-primary btn-sm' type='submit' name='btnDel' value='$row[0]'>Delete</button></td>
                                        </tr>
                                    ";
                                }

                            else
                                echo "<script>alert(ERROR!)</script>";
                        ?>
                        </form>
                    </tbody>
                    
                </table>
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