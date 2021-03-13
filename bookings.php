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
    $query = "SELECT * FROM bookings";
    $result = mysqli_query($conn, $query);


    // check for query string
    if(isset($_GET['alert'])){
        // new client added
        if($_GET['alert']=='booked'){
            $alertMessage = "<div style='margin: 70px;' class='alert alert-success'>A car has been booked!<a class='close' data-dismiss='alert'>&times;</a></div>";
        }
    }

    // close the mysql connection 
    mysqli_close($conn);

    include('includes/header.php');
?>

<h3 class="mb-3" style="margin-top: 70px;">Bookings</h3>

<?php echo $alertMessage; ?>

<table class="table table-striped table-bordered">
    <tr>
        <th>CNIC</th>
        <th>Full Name</th>
        <th>Full Address</th>
        <th>Car</th>
        <th>Borrow Date</th>
        <th>Return Date</th>
        <th>Remarks</th>
    </tr>
    
    <?php
    
    if(mysqli_num_rows($result)>0){
        // we have data
        // output the data
        
        while($row=mysqli_fetch_assoc($result)){
            echo "<div style='margin: 50px;'>";
            
            
            echo "<tr>"; 
            
            echo "<td>".$row['cnic']."</td><td>".$row['full_name']."</td><td>".$row['full_address']."</td><td>".$row['car']."</td><td>".$row['take_time']."</td><td>".$row['return_time']."</td><td>".$row['remarks']."</td>";
            
            
            echo "</tr>";
            echo "</div>";
        }
        
    }else{
        echo "<div class='alert alert-warning'>You have no Bookings!</div>";
    }
    
    
     mysqli_close($conn);
    ?>
    
    
</table>



<?php
    include('includes/footer.php');
?>