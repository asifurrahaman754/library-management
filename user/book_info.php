<?php 
include "../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_user_login())
{   
    header('location: ../user_login.php');
}

//get book data
$book_id = $_GET['id'];
$get_book_sql = "SELECT * FROM `books` WHERE `ISBN` = '$book_id'";
$get_book_result = mysqli_query($con, $get_book_sql);
$book_data = mysqli_fetch_assoc($get_book_result);

//get total number of books this user has issued
$total_book_issue_sql = "SELECT * FROM `book_issue` WHERE `user_id` = ".$_SESSION['user_id']."";
$total_book_issue_result = mysqli_query($con, $total_book_issue_sql);

//get location racks
$get_location_sql = "SELECT `name` FROM `location_rack`";
$get_location_result = mysqli_query($con, $get_location_sql);

//get maximum issue day limit
$max_issue_day_sql = "SELECT `return_day_limit`,`per_user_book_issue_limit` FROM `library_settings`";
$max_issue_day = mysqli_fetch_assoc(mysqli_query($con, $max_issue_day_sql));
$max_issue_day_limit = $max_issue_day['per_user_book_issue_limit'];

//check if the book is already issued
$check_book_issue_sql = "SELECT * FROM `book_issue` WHERE `book_isbn` = '$book_id' 
AND `user_id` = ".$_SESSION['user_id']."";
$check_book_issue_result = mysqli_query($con, $check_book_issue_sql);
$check_book_issue_row = mysqli_num_rows($check_book_issue_result);

//set a new book issue
$success = "";
$error = "";
if($check_book_issue_row > 0){
    $error = "You have already issued this book";
}else{
    if(isset($_POST['submit'])){
        $username = $_SESSION['user_username'];
        $userId = $_SESSION['user_id'];
        $book_return = $_POST['return_date'];
        $book_name = $book_data['name'];
        $book_isbn = $book_data['ISBN'];
        $book_cat = $book_data['category'];
        $book_location = $book_data['location_rack'];
        $time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $created = $time->format('Y-m-d H:i:s');
    
        $book_issue_sql = "INSERT INTO `book_issue`(`user_name`, `user_id`, `book_name`, `book_isbn`, `book_cat`, `book_loc`, `created`, `book_return`) VALUES ('$username','$userId','$book_name','$book_isbn','$book_cat', '$book_location', '$created','$book_return')";
        $book_issue_result = mysqli_query($con, $book_issue_sql);
    
        if($book_issue_result){
            $success = "Book issued successfully";
        }else{
            $error = "Book issued failed";
        }
    
    }
}

$issue_btn = true;

include 'user_header.php';
?>

<section style="background: #F9F3EE; min-height: calc(100vh - 40px);">
    <div class="row gy-3 gx-5 m-auto p-sm-4 pb-5 pt-5" style="max-width: 800px">
        <?php
            if($success){
                echo '<div class="mb-3 m-auto alert alert-success alert-dismissible fade show" style="max-width: 600px" role="alert"> '.$success.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            }

            if(mysqli_num_rows($total_book_issue_result) >= $max_issue_day_limit){
                $issue_btn = false;
                echo '<div class="text-center border m-auto alert alert-warning alert-dismissible fade show" style="max-width: 600px" role="alert"> Your have exceeded your maximum issue limit.
                </div>';
            }
            else if($error){
                $issue_btn = false;
                echo '<div class="text-center border m-auto alert alert-warning alert-dismissible fade show" style="max-width: 600px" role="alert"> You have already issued this book.
                </div>';
            }else if($book_data['book_copies'] == 0){
                $issue_btn = false;
                echo '<div class="text-center border m-auto alert alert-warning alert-dismissible fade show" style="max-width: 600px" role="alert"> This book is not available at the moment.
                </div>';
            }
            
        ?>
        <div class="col-sm-6">
            <div class="img_wrap position-relative ms-auto" style="width: fit-content">
                <img class="issue_book_cover" src="../upload/<?php echo $book_data['image'] ?>" alt="book cover">
                <span class="book-badge position-absolute text-white fs-5 d-grid  rounded-circle"
                    style="background: #9354FB"><?php echo $book_data['book_copies'] ?></span>
            </div>
        </div>

        <div class="col-sm-6">
            <h1 class="fs-2" style="color: #611547"><?php echo $book_data['name'] ?></h1>
            <p class="mt-2"><span><i class="fa-solid fa-user-pen me-3"></i></span><?php echo $book_data['author'] ?></p>
            <p>Category: <span class="fw-bold"><?php echo $book_data['category'] ?></span></p>

            <div class="btn-group mt-3 pe-none" role="location group">
                <?php while($row = mysqli_fetch_assoc($get_location_result)) { ?>
                <button type="button"
                    class="btn btn-outline-primary <?php echo ($row['name'] == $book_data['location_rack']) ? 'active' : '' ?>"><?php echo $row['name'] ?></button>
                <?php } ?>
            </div>

            <button data-bs-toggle="modal" data-bs-target="#exampleModal"
                class="book-issue-btn btn d-block text-white mt-5 <?php echo (!$issue_btn) ? 'disabled' : '' ?>">Issue
                book</button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Set book return date</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input
                                max="<?= date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$max_issue_day['return_day_limit'].' days')) ?>"
                                min="<?= date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 days')) ?>" name="return_date"
                                id="return_date" type="date" class="form-control"
                                value="<?= date('Y-m-d', strtotime(date('Y-m-d'). ' + 1 days')) ?>">
                        </div>
                        <div class="modal-footer">
                            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include '../footer.php'?>