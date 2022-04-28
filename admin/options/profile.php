<?php 
include "../../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

// Update admin data
$success = "";
$error = "";
if(isset($_POST['email'])){
    //select the updated data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE `admin` SET `id`= '".$_SESSION["admin_id"]."',`username`= '$username',`email`= '$email',`password`= '$password' WHERE id = '".$_SESSION["admin_id"]."'";
    $updated_info_result = mysqli_query($con, $sql);

    if($updated_info_result){
        $success = "Updated Successfully";
    }else{
        $error = "Error updating data";
    }
}

//get all the data of the current loged_in admin
$sql = "SELECT * FROM `admin` WHERE email = '".$_SESSION["admin_email"]."'";
$get_data_result = mysqli_query($con, $sql);
$get_data_result_row = mysqli_fetch_assoc($get_data_result);

include "../admin_template_header.php";
?>

<div class="container">
    <h1 class="fs-3 mb-4 mt-3">Admin Profile</h1>

    <div style="max-width: 500px">
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

        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-user-pen me-2"></i> Edit profile details
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username"
                            aria-describedby="username" value="<?php echo $get_data_result_row['username']; ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp"
                            value="<?php echo $get_data_result_row['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password"
                            value="<?php echo $get_data_result_row['password']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
include "../admin_template_footer.php";
include "../../footer.php";
?>