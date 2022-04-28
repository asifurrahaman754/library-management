<?php 
include "../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_user_login())
{   
    header('location: ../user_login.php');
}

//update user data
$success = "";
$error = "";
if(isset($_POST['submit'])){
    //select the updated data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE `users` SET `name`= '$username',`email`= '$email',`password`= '$password' WHERE id = '".$_SESSION["user_id"]."'";
    $updated_info_result = mysqli_query($con, $sql);

    if($updated_info_result){
        $success = "Updated Successfully";
    }else{
        $error = "Error updating data";
    }
}

//get all the data of the current loged_in user
$sql = "SELECT * FROM `users` WHERE `unique_id` = '".$_SESSION["user_id"]."'";
$get_data_result = mysqli_query($con, $sql);
$get_data_result_row = mysqli_fetch_assoc($get_data_result);

include 'user_header.php';
?>

<div class="container">
    <h1 class="fs-3 text-center mb-4 mt-5">User Profile</h1>

    <div style="max-width: 500px; margin: auto">
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
                            aria-describedby="username" value="<?php echo $get_data_result_row['name']; ?>" required>
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
                    <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                    <a href="../admin/options/logout.php" class="btn btn-danger">Log out</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'?>