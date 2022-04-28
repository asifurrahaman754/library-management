<?php

//get category details with selected id
$id = $_GET['id'];
$get_catWithID_sql = "SELECT * FROM `category` WHERE `id` = '$id'";
$get_catWithID_result = mysqli_query($con, $get_catWithID_sql);
$get_catWithID_result_row = mysqli_fetch_assoc($get_catWithID_result);

//update category details
$error = "";
$success = "";
if(isset($_POST['name'])){
    $up_cat_name = $_POST['name'];
    $up_cat_status = $_POST['status'];
    $created_date = $get_catWithID_result_row['created'];
    
    // Changed the timezone to my timezone!
    $time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $updated_date = $time->format('Y-m-d H:i:s');

    $update_cat_sql = "UPDATE `category` SET `id`= '$id',`name`= '$up_cat_name',`status`= '$up_cat_status',`created`= '$created_date',`updated`= '$updated_date' WHERE id = '$id'";
    $update_cat_sql_result = mysqli_query($con, $update_cat_sql);

    if($update_cat_sql_result){
        //redirect to category_list.php[using this because of error in header()]
        echo("<script>location.href = '".base_url()."/admin/category/category.php?msg=Category updated successfully';</script>");
    }else{
        $error = "Category update failed";
    } 
}

?>

<?php
    if($error != ""){
        echo '<div class="mt-5 m-auto alert alert-danger alert-dismissible fade show" style="max-width: 600px" role="alert"> '.$error.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
?>

<div class="card mt-4 m-auto" style="max-width: 600px">
    <div class="card-header"><i class="fa-solid fa-table-list me-2"></i> Edit category</div>
    <div class="card-body">
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Category name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name"
                    value="<?php echo $get_catWithID_result_row['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <?php 
                        if($get_catWithID_result_row['status'] == "Enable"){
                            echo '<option selected value="Enable">Enable</option>';
                            echo '<option value="Disable">Disable</option>';
                        }else{
                            echo '<option value="Enable">Enable</option>';
                            echo '<option selected value="Disable">Disable</option>';
                        }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
</div>