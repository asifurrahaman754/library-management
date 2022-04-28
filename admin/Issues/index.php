<?php 
include "../../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

$this_page = "book_issue";

//delete the book issue
$success = "";
$error = "";
if(isset($_GET['action']) && $_GET['action'] == "delete"){
    $issue_id = $_GET['id'];
    $delete_issue_sql = "DELETE FROM `book_issue` WHERE `id` = '$issue_id'";
    $delete_issue_result = mysqli_query($con, $delete_issue_sql);

    if($delete_issue_result){
        $success = "Book issue deleted successfully";
    }else{
        $error = "Book issue delete failed";
    }
}

//approve the book issue
if(isset($_GET['action']) && $_GET['action'] == "approve"){
    $issue_id = $_GET['id'];
    $approve_issue_sql = "UPDATE `book_issue` SET `status` = 'approved' WHERE `id` = '$issue_id'";
    $approve_issue_result = mysqli_query($con, $approve_issue_sql);

    if($approve_issue_result){
        //reduce the book copies by 1
        $book_isbn = $_GET['isbn'];
        $update_quantity_sql = "UPDATE `books` SET `book_copies` = `book_copies` - 1 WHERE `ISBN` = '$book_isbn'";
        $update_quantity_result = mysqli_query($con, $update_quantity_sql);

        //reduce the total_books in rack by 1
        $book_loc = $_GET['loc'];
        $update_rack_sql = "UPDATE `location_rack` SET `total_books` = `total_books` - 1 WHERE `name` = '$book_loc'";
        $update_rack_result = mysqli_query($con, $update_rack_sql);
    }else{
        $error = "Book issue approve failed";
    }
}

//get all the issued books 
$query = "SELECT * FROM `book_issue`";
$result = mysqli_query($con, $query);

$time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
$present_date = $time->format('Y-m-d');

include "../admin_template_header.php";
?>

<h1 class="fs-3 mt-4 mb-5 text-center">All book isssue management</h1>

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

<div class="card mb-4" style="max-width: 1200px">
    <div class="card-header">
        <div><i class="fa-solid fa-book-open-reader me-2"></i>book issued</div>
    </div>
    <div class="card-body table-responsive ">
        <table id="datatablesSimple" class="mt-3 table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Book name</th>
                    <th scope="col">Book ISBN</th>
                    <th scope="col">Issue created</th>
                    <th scope="col">Book return</th>
                    <th scope="col">Issue status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)) { 
                       
                        //check if book return date is less than present date
                        $date_status = '';
                        if($present_date == $row['book_return']){
                            $date_status = 'bg-secondary text-white';
                        }else if($present_date > $row['book_return']){
                            $date_status = 'bg-danger text-white';
                        }
                ?>

                <tr class="<?php echo $date_status ?>">
                    <td><?php echo $row['user_name'] ; ?></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo $row['book_name'] ; ?></td>
                    <td><?php echo $row['book_isbn'] ; ?></td>
                    <td><?php echo $row['created'] ; ?></td>
                    <td><?php echo $row['book_return'] ; ?></td>
                    <td class="text-center"><span
                            class="badge <?php echo ($row['status'] == 'pending') ? 'bg-warning text-dark' : 'bg-success text-white' ?>  "><?php echo $row['status'] ; ?></span>
                    </td>
                    <td class="d-flex justify-content-center">
                        <button
                            onclick="approve_issue(<?php echo $row['id'] ?>, '<?php echo $row['book_name'] ?>', '<?php echo $row['book_isbn'] ?>', '<?php echo $row['book_loc'] ?>')"
                            class="btn me-2 btn-primary btn-sm <?php echo ($row['status'] == "pending") ? '' : 'disabled' ?>"><i
                                class="fa-solid fa-check"></i> Approve
                        </button>
                        <button onclick="delete_issue(<?php echo $row['id'] ?>, '<?php echo $row['book_name'] ?>')"
                            class="btn btn-danger  btn-sm <?php echo ($row['status'] == "approved") ? 'disabled' : '' ?>"><i
                                class="fa-solid fa-ban me-1"></i> Cancel
                        </button>
                    </td>
                </tr>
                <?php    }
                }else{
                        echo "<tr><td class='text-center' colspan='7'>No issued books listed</td></tr>";
                    };
                
                ?>
            </tbody>
        </table>

        <script>
        //take confirmation before canceling the book issue
        function delete_issue(issue_Id, book_name) {
            if (confirm(`Are you sure you want to cancel the "${book_name}" book issue?`)) {
                window.location.href = "index.php?action=delete&id=" + issue_Id;
            }
        }
        //take confirmation before approving the book issue
        function approve_issue(issue_Id, book_name, isbn, loc) {
            if (confirm(`Are you sure you want to approve the "${book_name}" book issue?`)) {
                window.location.href = "index.php?action=approve&id=" + issue_Id + "&isbn=" + isbn + "&loc=" + loc;
            }
        }
        </script>
    </div>
</div>

<?php 
include "../admin_template_footer.php";
include "../../footer.php";
?>