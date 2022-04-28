<?php 
include "../../header.php";

$this_page = "home";
//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

//get the total books
$total_books_sql = "SELECT * FROM `books`";
$total_books = mysqli_num_rows(mysqli_query($con, $total_books_sql));

//get the total categories
$total_cat_sql = "SELECT * FROM `category`";
$total_cat = mysqli_num_rows(mysqli_query($con, $total_cat_sql));

//get the total users
$total_user_sql = "SELECT * FROM `users`";
$total_user = mysqli_num_rows(mysqli_query($con, $total_user_sql));

//get the total location rack
$total_rack_sql = "SELECT * FROM `location_rack`";
$total_rack = mysqli_num_rows(mysqli_query($con, $total_rack_sql));

//get the total issued books
$total_issued_sql = "SELECT * FROM `book_issue` WHERE `status` = 'pending'";
$total_issued = mysqli_num_rows(mysqli_query($con, $total_issued_sql));

include "../admin_template_header.php";
?>

<h1 class="fs-3 mt-4 mb-5">Welcome <?php echo $_SESSION['admin_username'] ?></h1>
<div class="row" style="max-width: 1200px">
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white mb-3" style="background: #16a3ef">
            <div class="card-body text-center position-relative">
                <i class="fa-solid fa-book-open-reader dash-icon"></i>
                <h5 class="card-title fs-1"><?php echo $total_issued ?></h5>
                <p class="card-text">Total pending book issue</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white mb-3" style="background: #de5e75">
            <div class="card-body text-center position-relative">
                <i class="fa-solid fa-book dash-icon"></i>
                <h5 class="card-title fs-1"><?php echo $total_books ?></h5>
                <p class="card-text">Total books</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white mb-3">
            <div class="card-body text-center position-relative" style="background: #9050fa">
                <i class="fa-solid fa-table-list dash-icon"></i>
                <h5 class="card-title fs-1"><?php echo $total_cat ?></h5>
                <p class="card-text">Total category</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white mb-3" style="background: #5663cf">
            <div class="card-body text-center position-relative">
                <i class="fa-solid fa-users dash-icon"></i>
                <h5 class="card-title fs-1"><?php echo $total_user ?></h5>
                <p class="card-text">Total users</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-dark mb-3">
            <div class="card-body text-center position-relative">
                <i class="fa-solid fa-window-maximize dash-icon"></i>
                <h5 class="card-title fs-1"><?php echo $total_rack ?></h5>
                <p class="card-text">Total location rack</p>
            </div>
        </div>
    </div>
</div>

<?php 
include "../admin_template_footer.php";
include "../../footer.php";
?>