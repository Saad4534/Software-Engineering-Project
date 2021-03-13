<?php
session_start();

error_reporting(0);


// connect to database
include('includes/connection.php');

// connect to functions file
include('includes/function.php');
$carID = $_GET['id'];
include('includes/connection.php');
$query = "SELECT * FROM car_directory WHERE id = $carID ";
$result = mysqli_query($conn, $query);
    
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
        $carModel = $row['model'];
        $carPY = $row['production_year'];
        $carManufacturer = $row['manufacturer'];
    }
}

$car = $carPY." - ".$carManufacturer." ".$carModel;

if(isset($_POST["book_now"])){
    $cnic=$full_name=$full_address=$borrow_date=$return_date=$remarks="";
    
    $cnic= validateFormData($_POST["cnic"]);
    $full_name = validateFormData($_POST["full_name"]);
    $full_address = validateFormData($_POST["full_address"]);
    $borrow_date = validateFormData($_POST["borrow_date"]);
    $return_date = validateFormData($_POST["return_date"]);
    $remarks = validateFormData($_POST["remarks"]);
    
    
    
   
        
    // create query
    $query = "INSERT INTO bookings (id, cnic, full_name, full_address, car,  take_time, return_time, remarks) VALUES (NULL, '$cnic','$full_name','$full_address','$car','$borrow_date','$return_date', '$remarks')";
        
    $result = mysqli_query($conn,$query);
        
    // if result was successful
    if($result){
        // refresh page with query string
        header("Location: bookings.php?alert=booked");
    }else{
        // something went wrong
        $error = "Error: ".$query." <br>" .mysqli_error($conn);
        echo "Error: ".$query."<br>".mysqli_error($conn);
    }
    
    mysqli_close($conn);
}

    
 

include('includes/header.php');?>
        
        <?php echo $error; ?>
        <form class="form-signin" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
            <div class="container">
                <h3 class="mb-3">Book your Car</h3>
                <p class="lead" style="margin-left: 390px;">Car booking for <?php echo "$carPY - $carManufacturer $carModel"?></p>
                <div class="row">
                   
                    <div class="col-sm-4 offset-1">
                        <div class="text-left mb-4">
                            <h3 class="mb-3">Your Info</h3>
                        </div>
                        
                        
                        <div class="form-label-group">
                            <input type="number" name="cnic" placeholder="your cnic" class="form-control"  required autofocus>
                            <label>CNIC</label>
                        </div>
                        
                        <div class="form-label-group">
                            <input type="text" name="full_name" placeholder="your full name" class="form-control" required >
                            <label>Full Name<br><small class="danger">* As in your NIC</small></label>
                        </div>
                         
                         <div class="form-label-group">
                            <input type="text" name="full_address" placeholder="your address" class="form-control" required >
                            <label>Address<br><small class="danger">* As in your NIC</small></label>
                        </div>
                     </div>
                    
                    <div class="col-sm-4 offset-2">
                        <div class="text-left mb-4">
                            <h3 class="mb-3">Booking Timings</h3>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-label-group">
                                    <input type="date" name="borrow_date" class="form-control" required autofocus>
                                    <label>Borrow Date</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-label-group">
                                    <input type="date" name="return_date"  class="form-control" required autofocus>
                                    <label>Return Date</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-label-group">
                           <label>Payment type</label><br>
                            <input type="radio" name="payment_type">By Cash<br>
                            <input type="radio" name="payment_type">By Credit Card<br><br>
                        </div>
                        
                        
                        <div class="form-label-group">
                           <textarea class="form-control" name="remarks" rows="4" cols="10"></textarea>
                            <label>Remarks for the owner<br><small class="success">* Optional</small></label>
                        </div>
                        
                        <button class=" float-right btn btn-success btn-lg " name="book_now" type="submit">Book Now</button>
                    </div>
                </div>
            </div>
        </form>
        
    

       
         
     <?php include('includes/footer.php');?>
