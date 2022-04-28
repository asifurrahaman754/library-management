<?php

$error = "";
$success = "";
if(isset($_POST['name'])){
    $cat_name = $_POST['name'];
    $cat_status = $_POST['status'];

    //check if the category name is already exist
    $check_cat_sql = "SELECT * FROM `category` WHERE `name` = '$cat_name'";
    $check_cat_result = mysqli_query($con, $check_cat_sql);
    
    //if the category name is already exist show error else insert the category
    if(mysqli_num_rows($check_cat_result) > 0){
        $error = "Category name already exist!";
    }else{
        // Changed the timezone to my timezone!
        $time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $created_date = $time->format('Y-m-d H:i:s');

        $cat_sql = "INSERT INTO `category`(`name`, `status`, `created`) VALUES ('$cat_name','$cat_status','$created_date')";
        $insert_new_cat = mysqli_query($con, $cat_sql);

        if($insert_new_cat){
            $success = "Category added successfully";
        }else{
            $error = "Adding Category failed";
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
    <div class="card-header"><i class="fa-solid fa-table-list me-2"></i> Add new category</div>
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Category name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name"
                    required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option selected value="">---select category status---</option>
                    <option value="Enable">Enable</option>
                    <option value="Disable">Disable</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>