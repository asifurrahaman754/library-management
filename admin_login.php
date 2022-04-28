<?php 
include "header.php";
?>

<div class="admin_login_container">
    <div class="container ">
        <div class="card">
            <h1 class="fs-4 p-3 text-center card-header">Admin Login</h1>
            <?php
                if(isset($_GET['error'])){
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"> '.$_GET['error'].'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            ?>

            <div class="card-body">
                <form method="POST" action="check_admin_login.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include "footer.php"?>