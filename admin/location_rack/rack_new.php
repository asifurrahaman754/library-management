<?php

$error = "";
$success = "";
if(isset($_POST['name'])){
    $rack_name = $_POST['name'];
    $total_book = $_POST['total_books'];

    //check if the rack name is already exist
    $check_rack_sql = "SELECT * FROM `location_rack` WHERE `name` = '$rack_name'";
    $check_rack_result = mysqli_query($con, $check_rack_sql);
    
    //if the category name is already exist show error else insert the category
    if(mysqli_num_rows($check_rack_result) > 0){
        $error = "Location Rack already exist!";
    }else{
        // Changed the timezone to my timezone!
        $time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $created_date = $time->format('Y-m-d H:i:s');

        $rack_sql = "INSERT INTO `location_rack`(`name`, `total_books`, `created`) VALUES ('$rack_name','$total_book','$created_date')";
        $insert_new_rack = mysqli_query($con, $rack_sql);

        if($insert_new_rack){
            $success = "New Location rack added successfully";
        }else{
            $error = "Failed Adding location rack!";
        }
    }    
}

?>

<?php
    if($success != ""){
        echo '<div class="mt-5 m-auto alert alert-success alert-dismissible fade show" style="max-width: 600px" role="alert"> '.$success.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    if($error != ""){
        echo '<div class="mt-5 m-auto alert alert-danger alert-dismissible fade show" style="max-width: 600px" role="alert"> '.$error.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
?>

<div class="card mt-4 m-auto" style="max-width: 600px">
    <div class="card-header"><i class="fa-solid fa-window-maximize me-2"></i> Add new location rack</div>
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Rack name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter rack name" required>
            </div>
            <div class="mb-3">
                <label for="total_books" class="form-label">Total books</label>
                <input type="number" class="form-control" id="total_books" name="total_books" value="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>