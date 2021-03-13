<?php
session_start();

//error_reporting(0);


// connect to database
include('includes/connection.php');

// connect to functions file
include('includes/function.php');

if(isset($_POST["insert"])){
    $manufacturer=$model=$production_year=$rent=$address=$description=$target=$image="";
    
    $manufacturer= validateFormData($_POST["manufacturer"]);       
    $model = validateFormData($_POST["model"]);
    $production_year = validateFormData($_POST["production_year"]);
    $rent = validateFormData($_POST["rent"]);
    $address = validateFormData($_POST["address"]);
    $description = validateFormData($_POST["description"]);
    
    $image=addslashes($_FILES['image']['tmp_name']);
    $image=file_get_contents($image);
    $image=base64_encode($image);
    
    
    
//    $target = "renty/car_directory/".basename($_FILES['image']['name']);
//    
//    $image = $_FILES['image']['name'];
//    echo $image;
    
    // for image
//    $image = addslashes(file_get_contents($_FILES["image"]["temp_name"]));
    
   
        
    $hashed_pass = password_hash("$signup_password",PASSWORD_DEFAULT);
        
    // create query
    $query = "INSERT INTO car_directory (id, manufacturer, model, production_year, rent, address, picture, description) VALUES (NULL, '$manufacturer','$model','$production_year','$rent','$address','$image','$description')";
        
    $result = mysqli_query($conn,$query);
    
    
    
    // if result was successful
    if($result){
        
        header("Location: show_car.php?alert=success");
        
    }else{
        // something went wrong
        $error = "Error: ".$query." <br>" .mysqli_error($conn);
        echo "Error: ".$query."<br>".mysqli_error($conn);
    }
}

 mysqli_close($conn);

include('includes/header.php');?>

<?php echo $error; ?>
<form class="form-signin" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" >
    <div class="container">
        <h3 class="mb-3">Add a Car</h1>   
            <div class="row">
                <div class="col-sm-4 offset-1">
                    <div class="form-label-group">
                        <input type="text" name="manufacturer" placeholder="e.g. toyota" class="form-control" required autofocus>
                        <label>Automaker</label>
                    </div>
                        
                    <div class="form-label-group">
                        <input type="text" name="model" placeholder="e.g. corolla" class="form-control" required>
                        <label>Model</label>
                    </div>
                         
                    <div class="form-label-group">
                        <input type="number" name="production_year" placeholder="e.g. 2020" class="form-control" min="2000" max="2020" required >
                        <label>Production_year<br><small class="danger">* only 2000 and above models></small></label>
                    </div>
                    
                    <div class="form-label-group">
                        <input type="file" name="image" id="image"  required >
                        <label>Image<br><small class="danger">* Required</small></label>
                    </div>
                </div>
                    
                <div class="col-sm-4 offset-2">
                        
                    <div class="form-label-group">
                        <div class="input-group">
                            <div class="input-group-addon">$</div>
                        <input type="number" name="rent" placeholder="price per day" class="form-control" required autofocus min="0" max="100"></div>
                        <label>Rent</label>
                            
                    </div>
                        
                    <div class="form-label-group">
                        <input type="text" name="address" placeholder="e.g. abc town lahore" class="form-control" required>
                        <label>Address</label>
                    </div>
                    
                    <div class="form-label-group">
                        <label>Description<br><small class="success">* Optional</small></label>
                        <textarea name="description" class="form-control" rows="5" cols="10" placeholder="little about the car"></textarea>
                    </div>
                </div>
                    
                <div class="signup_button">
                    <button class="btn btn-success btn-lg " name="insert" type="submit" id="insert">Add Car</button>
                </div>
            </div>
        </div>
    </form>

<!--
<script>
    $document.ready(function(){
       $('#insert').onclick(function(){
            var image_name = $('#image').val();
           
            var extension = $('#image').val().split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                {
                    alert('Invalid Image File');
                    $('#image'),val('');
                    return false;
                }
       }); 
    });
                    
</script>
-->






<?php include('includes/footer.php')?>