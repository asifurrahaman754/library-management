<?php 
include "../header.php";

$error = "";
//insert user data into database
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashPassword = password_hash($password, PASSWORD_DEFAULT );
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
    $created_date = $time->format('Y-m-d H:i:s');
    $unique_id = time().rand(1000,2000).time().rand(10,1000);

    //check if the username or phone is already exist
    $name_verify_sql = "SELECT * FROM `users` WHERE `email` = '$email'";
    $name_verify_sql_result = mysqli_query($con, $name_verify_sql);
    $phone_verify_sql = "SELECT * FROM `users` WHERE `contact` = '$phone'";
    $phone_verify_sql_result = mysqli_query($con, $phone_verify_sql);

    if(mysqli_num_rows($name_verify_sql_result) > 0){
        $error = "Email already exist";
    }else if(mysqli_num_rows($phone_verify_sql_result) > 0){
        $error = "Phone number already exist";
    }else{
        $insert_user_sql = "INSERT INTO `users`(`unique_id`, `name`, `email`, `password`, `contact`, `created`, `status`) VALUES ('$unique_id','$username','$email','$password','$phone','$created_date', 'Enable')";
        $insert_user_result = mysqli_query($con, $insert_user_sql);
    
        if($insert_user_result){
            $_SESSION['user_id'] = $unique_id;
            $_SESSION['user_username'] = $username;
            $_SESSION['user_email'] = $email;
            header("Location: home.php");
        }else{
            $error = "User registration failed!";
        }
    }
}
?>

<div class="admin_login_container">
    <div class="container ">
        <div class="card">
            <h1 class="fs-4 p-3 text-center card-header">User Registration</h1>
            <?php
                if($error){
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> '.$error.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            ?>

            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input name="username" type="text" class="form-control" id="username"
                            aria-describedby="usernameHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input name="phone" type="text" class="form-control" id="phone" required>
                        <div class="form-text">We'll never share your information with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label" for="exampleCheck1">Already have an account? <a
                                href="../user_login.php">Log in</a></label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include "../footer.php"?>