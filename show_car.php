<?php

    session_start();

    // if user is not logged in
    if(!$_SESSION['loggedinUser']){
        // send them to the login page
        
        header("Location: signin.php");
    }

    // connect to database
    include('includes/connection.php');

    //query & result
    $query = "SELECT * FROM car_directory ORDER BY id DESC";
    $result = mysqli_query($conn, $query);


    // check for query string
    if(isset($_GET['alert'])){
        // new client added
        
         
        
        if($_GET['alert']=='success'){
            $alertMessage = "<div style='margin: 70px;' class='alert alert-success'>New Car Added!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
        
        elseif($_GET['alert']=='updatesuccess'){
            $alertMessage = "<div style='margin: 70px;' class='alert alert-success'>Car Details Updated!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
        elseif($_GET['alert']=='deleted'){
            $alertMessage = "<div style='margin: 70px;' class='alert alert-success'>Car Ad Deleted!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    }

    // close the mysql connection 
    mysqli_close($conn);

    include('includes/header.php');
?>

<?php echo $alertMessage; ?>

<div class="container">
    <h3 class="mb-3" style="margin-top:70px;">Showing Cars Nearby</h3>
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-sm-8 offset-2">
       
            
            <?php
                if(mysqli_num_rows($result)>0){
                    // we have data
                    // output the data
                    
                    while($row=mysqli_fetch_assoc($result)){
                        echo "<div class='card mb-3' style='max-width: 540px;'>
                            <div class='row no-gutters'>
                                <div class='col-md-4'>
                                    <img src='data:image;base64,".$row['picture']."' class='card-img' alt='car'>
                                </div>
                                <div class='col-md-8'>
                                    <div class='card-body'>
                                        <h5 class='car-title'>".$row['production_year']."<small> - </small>".$row['manufacturer']."<small> </small>".$row['model']."</h5>
                                        <p class='card-text'>".$row['description']."</p>
                                        <p class='card-text'><small>Starting at ".$row['rent']."$/day</small><a href='view_car.php?id=".$row['id']."' class='btn btn-success float-right' style='margin-bottom:10px;'>Show More</a></p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>";
                    }
                }else{
                    echo "<div class='alert alert-success'>No cars to show!<a class='close' data-dismiss='alert'>&times;</a></div>";
                }
            ?>
            
        </div>  
    </div>
</div>



<?php
    include('includes/footer.php');
?>
