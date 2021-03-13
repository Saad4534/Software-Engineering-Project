<?php

    session_start();

    // if user is not logged in
    if(!$_SESSION['loggedinUser']){
        // send them to the login page
        
        header("Location: signin.php");
    }

   

    
    $carID = $_GET['id'];
    include('includes/connection.php');
    $query = "SELECT * FROM car_directory WHERE id = $carID ";
    $result = mysqli_query($conn, $query);
    
    





    
    
// if delete button was submitted
if(isset($_POST["delete"])){
    
    echo "<div style='margin: 50px;'>
            $alertMessage = <div class='alert alert-danger'>
                    <p>Are you sure you want to delete this car ad? No take backs!</p><br>
                    <form action='".htmlspecialchars($_SERVER["PHP_SELF"])."?id=$carID' method='post'>
                        <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes! Delete!'>
                            <a type='button' class='btn btn-light btn-outline-dark btn-sm' data-dismiss='alert'>Oops, No thanks!</a>
                    </form>
                </div>
        </div>";
    
    
    
}

if(isset($_POST["confirm-delete"])){
        // new database query and result
        $query = "DELETE FROM car_directory WHERE id = '$carID'";
        $result = mysqli_query($conn,$query);
    
        if($result){
            // redirect to client page with query string
            header("Location: show_car.php?alert=deleted");
        }else{
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    

// if confirm delete button was pressed



    // close the mysql connection 

    include('includes/header.php');
?>

<?php echo $alertMessage; ?>


       
            
            <?php
                
                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){
                        echo "
                            <div class='container'>
                                <h3 class= 'mb-3' style='margin-top:70px;'>Car Details</h3>
                                <div class='row'>
                                    <div class='col-sm-8'>
                                        <p class='lead'>Car Production Year: <big>".$row['production_year']."</big></p>
                                        <p class='lead'>Car Manufacturer: <big>".$row['manufacturer']."</big></p>
                                        <p class='lead'>Car Model: <big>".$row['model']."</big></p>
                                        <p class='lead'>Car Rent: <big>".$row['rent']."<small>$ per day</small></big></p>
                                        <p class='lead'>Description: <big>".$row['description']."</big></p>
                                        <form action='".htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$carID."' method='post'>
                                            <button style='margin: 135px 20px 0 0;' type='submit' class='btn btn-lg btn-danger float-left' name='delete'>Delete this ad</button>
                                        </form>
                                    </div>
                                    <div class='col-sm-4'>
                                        <div class='rounded float-right'>
                                            <img style='width:400px; height:300px;' src='data:image;base64,".$row['picture']."'>
                                            
                                            <p class='card-text'><a href='book_car.php?id=".$row['id']."' class='btn btn-lg btn-primary' style='margin:100px 0 0 250px;'>Book this car</a></p>
                                        </div>
                                    </div>  
                                </div>
                            </div>" ;
                    }
                }
            
            ?>
            
        



<?php
    include('includes/footer.php');
?>
