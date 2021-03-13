<?php

    error_reporting(0);
    
    session_start();

    include('includes/function.php');

    // if login form was submitted
    if(isset($_POST['login'])){
        
        // create variables
        // wrap data with validate function
        $formEmail= validateFormData($_POST['login-email']);
        $formPass= validateFormData($_POST['login-password']);
        
        // connect to database
        include('includes/connection.php');
        
        // create query
        $query="SELECT name, password FROM users WHERE username='$formEmail'";
        
        // store the result
        $result=mysqli_query($conn,$query);
        
        // verify if result is returned
        if(mysqli_num_rows($result)>0){
            // store basic data in user variables
            while($row=mysqli_fetch_assoc($result)){
                $name = $row['name'];
                $hashedPass = $row['password'];    
            }
            
            // verify hashed password with submitted password
            if(password_verify($formPass,$hashedPass)){
                // corretc login details
                // store data in SESSION Variables
                
                $_SESSION['loggedinUser'] = $name;
                
                // redirect user to clients page
                header("Location: show_car.php");
                
            }else{
                // hashed password didnt verify
                
                //error message
                $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try Again.</div>";
            }
        }else{
            // no results in database
            
            //error message
            $loginError = "<div class='alert alert-danger'>No such user in database. Please Try Again.<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    }

mysqli_close($conn);

    include('includes/header.php');
?>
        
        
        
        <div class="container">
            <div class="row">
                <div class="col-sm-4 offset-4">
                    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">        
                        <div class="text-center mb-4">
                            <img class="mb-4" src="/docs/4.4/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
                            <h1 class="h3 mb-3 font-weight-normal">Sign in to Rently</h1>
                            <p class="lead"><a>Better than Car Rental!</a></p>
                        </div>
                        <?php echo $loginError; ?>

                        <div class="form-label-group">
                            <input name="login-email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            <label for="inputEmail">Email address</label>
                        </div>

                        <div class="form-label-group">
                            <input name="login-password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>

                        <div class="checkbox mb-3">
                            <label>
                                <input type="checkbox" value="remember-me"> Remember me
                            </label>
                        </div>
                        <p id="signup-link">New to Rently! <a href="signup.php">Sign up</a></p>
                        <button name="login" id="signin-btn" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
        
        <?php include('includes/footer.php');?>