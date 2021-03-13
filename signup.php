<?php
session_start();

error_reporting(0);


// connect to database
include('includes/connection.php');

// connect to functions file
include('includes/function.php');

if(isset($_POST["signup"])){
    $signup_name=$signup_city=$signup_phone=$signup_email=$signup_password="";
    
    $signup_name= validateFormData($_POST["signup_name"]);
    $signup_city = validateFormData($_POST["signup_city"]);
    $signup_phone = validateFormData($_POST["signup_phone"]);
    $signup_email = validateFormData($_POST["signup_email"]);
    $signup_password = validateFormData($_POST["signup_password"]);
    
    // if required fields  have data
    if($signup_password && $signup_password){
        
        $hashed_pass = password_hash("$signup_password",PASSWORD_DEFAULT);
        
        // create query
        $query = "INSERT INTO users (id, username, password, name, city, phone_number) VALUES (NULL, '$signup_email','$hashed_pass','$signup_name','$signup_city','$signup_phone')";
        
        $result = mysqli_query($conn,$query);
        
        // if result was successful
        if($result){
            // refresh page with query string
            header("Location: signin.php?alert=success");
        }else{
            // something went wrong
            $error = "Error: ".$query." <br>" .mysqli_error($conn);
            echo "Error: ".$query."<br>".mysqli_error($conn);
        }
    }
}

 mysqli_close($conn);

include('includes/header.php');?>
        
        <?php echo $error; ?>
        <form class="form-signin" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
            <div class="container">
                <h3 class="mb-3">Sign In to Rently</h3>   
                <div class="row">
                   
                    <div class="col-sm-4 offset-1">
                        <div class="text-left mb-4">
                            <h3 class="mb-3">Personal Info</h3>
                        </div>
                        
                        <div class="form-label-group">
                            <input type="text" name="signup_name" placeholder="your name" class="form-control" required autofocus>
                            <label>Name</label>
                        </div>
                        
                        <div class="form-label-group">
                            <input type="text" name="signup_city" placeholder="hometown" class="form-control" required >
                            <label>City</label>
                        </div>
                         
                         <div class="form-label-group">
                            <input type="tel" name="signup_phone" placeholder="03xxxxxxxxx" class="form-control"  required >
                            <label>Phone Number</label>
                        </div>
                     </div>
                    
                    <div class="col-sm-4 offset-2">
                        <div class="text-left mb-4">
                            <h3 class="mb-3">Sign In Info</h3>
                        </div>
                        
                        <div class="form-label-group">
                            <input type="email" name="signup_email" placeholder="xyz@rently.com" class="form-control" required autofocus>
                            <label>Email</label>
                        </div>
                        
                        <div class="form-label-group">
                            <input type="password" name="signup_password" placeholder="password" class="form-control" required>
                            <label>Password</label>
                        </div>
                    </div>
                    
                    <div class="signup_button">
                        <button class="btn btn-primary btn-lg " name="signup" type="submit">Sign Up</button>
                    </div>
                </div>
            </div>
        </form>
        
        
       
         
     <?php include('includes/footer.php');?>
