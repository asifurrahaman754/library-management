<?php 
include "header.php";

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    //get all the data of the registered user
    $sql = "SELECT * FROM `users` WHERE `email`= '$email' AND `password`= '$password'";
    $result = mysqli_query($con, $sql);
    session_start();

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        //check if the user is disabled
        if($row['status'] == 'Disable'){
            header("Location: user_login.php?error=Your account is disabled");
        }else if($row['status'] == 'Enable'){
            $_SESSION['user_id'] = $row['unique_id'];
            $_SESSION['user_username'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header("Location: user/home.php");
        }
    }else{
        $checkEmail = "SELECT * FROM `users` WHERE email= '$email'";
        $checkEmail_result = mysqli_query($con, $checkEmail);
        
        if(mysqli_num_rows($checkEmail_result) > 0){
            header("Location: user_login.php?error=Incorrect Password");
        }else{
            header("Location: user_login.php?error=Incorrect Email");
        }
    }
}
?>

<div class="admin_login_container">
    <div class="container ">
        <div class="card">
            <h1 class="fs-4 p-3 text-center card-header">Login to your account</h1>
            <?php
                if(isset($_GET['error'])){
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> '.$_GET['error'].'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            ?>

            <div class="card-body">
                <form method="POST">
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
                        <label class="form-check-label" for="exampleCheck1">New here? <a
                                href="user/user_register.php">register</a></label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include "footer.php"?>