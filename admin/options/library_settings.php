<?php
include "../../header.php";
include "../admin_template_header.php";

if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

// Update library data
$success = "";
$error = "";
if(isset($_POST['name'])){
    //select all updated data
    $name = $_POST['name'];
    $Address = $_POST['Address'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $book_return = $_POST['book-return'];
    $book_issue = $_POST['book-issue'];
    $book_fine = $_POST['book-fine'];

    $update_sql = "UPDATE `library_settings` SET `id`= 1,`name`= '$name',`address`= '$Address',`number`='$number',`email`= '$email',`return_day_limit`= '$book_return',`per_user_book_issue_limit`='$book_issue',`return_fine` = '$book_fine'  WHERE 1";
    $updated_info_result = mysqli_query($con, $update_sql);

    if($updated_info_result){
        $success = "Updated Successfully";
    }else{
        $error = "Error updating data";
    }
}


//get all the library data
$sql = "SELECT * FROM `library_settings` WHERE 1";
$get_result = mysqli_query($con, $sql);
$get_result_row = mysqli_fetch_assoc($get_result);
?>

<div class="container mb-4 mt-4">

    <?php 
        if($success != ""){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert"> '.$success.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }

        if($error != ""){
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> '.$error.'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
    ?>
    <div class="card" style={max-width: 1200px}>
        <div class="card-header">
            <i class="fa-solid fa-user-pen me-2"></i> Edit library settings
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Library name</label>
                    <input type="text" name="name" class="form-control" id="name" aria-describedby="username"
                        value="<?php echo $get_result_row['name']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="Address" class="form-label">Library Address</label>
                    <input type="text" name="Address" class="form-control" id="Address" aria-describedby="emailHelp"
                        value="<?php echo $get_result_row['address']; ?>" required>
                </div>
                <div class="row mb-3 gy-3">
                    <div class="col-md-6">
                        <label for="number" class="form-label">Contact number</label>
                        <input type="text" name="number" class="form-control" id="number"
                            value="<?php echo $get_result_row['number']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email"
                            value="<?php echo $get_result_row['email']; ?>" required>
                    </div>
                </div>
                <div class="mb-3 row gx-3 gy-3">
                    <div class="col-md-6">
                        <label for="book-return" class="form-label">Book return day limit</label>
                        <input type="number" name="book-return" class="form-control" id="book-return"
                            value="<?php echo $get_result_row['return_day_limit']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="book-issue" class="form-label">Per user book issue limit</label>
                        <input type="number" name="book-issue" class="form-control" id="book-issue"
                            value="<?php echo $get_result_row['per_user_book_issue_limit']; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="book-fine" class="form-label">Book late return fine (TK)</label>
                        <input type="number" name="book-fine" class="form-control" id="book-fine"
                            value="<?php echo $get_result_row['return_fine']; ?>" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>
</div>

<?php
include "../admin_template_footer.php";
include "../../footer.php";
?>