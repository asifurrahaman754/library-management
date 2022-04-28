<?php 
include "../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_user_login())
{   
    header('location: ../user_login.php');
}

//calculate the fine for the user
calculate_fine($con);

//get the user fine
$user_id = $_SESSION['user_id'];
$fine = get_fine($con, $user_id);

$time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
$present_date = $time->format('Y-m-d');

include 'user_header.php';

//return the book
if(isset($_GET['action']) && $_GET['action'] == "delete"){
    $isbn = $_GET['isbn'];
    $loc = $_GET['loc'];

    $return_issue_sql = "DELETE FROM `book_issue` WHERE `book_isbn` = '$isbn'";
    $return_issue_result = mysqli_query($con, $return_issue_sql);

    if($return_issue_result){
        //increase the book copies by 1
        $update_quantity_sql = "UPDATE `books` SET `book_copies` = `book_copies` + 1 WHERE `ISBN` = '$isbn'";
        $update_quantity_result = mysqli_query($con, $update_quantity_sql);

        //increase the total_books in rack by 1
        $update_rack_sql = "UPDATE `location_rack` SET `total_books` = `total_books` + 1 WHERE `name` = '$loc'";
        $update_rack_result = mysqli_query($con, $update_rack_sql);
        header('location: book_issue.php');
    }
}

//get all the issued books of the current user
$query = "SELECT * FROM `book_issue` WHERE user_id = '$user_id'";
$result = mysqli_query($con, $query);
?>

<h1 class="fs-3 text-center mt-4 mb-5">All your issued books</h1>
<div style="max-width: 1100px" class="overflow-auto me-auto p-3 border ms-auto">
    <?php 
        if($fine){
            echo '<div class="alert alert-danger">You have to pay the fine of <strong><i class="fa-solid fa-money-bill-wave me-2 ms-2"></i>'.$fine.'TK.</strong></div>';
        }
    ?>

    <table id="datatablesSimple" class="mt-3 table table-bordered" style="white-space:nowrap">
        <thead>
            <tr>
                <th scope="col">Book name</th>
                <th scope="col">Category</th>
                <th scope="col">Location</th>
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
                <td title="<?php echo $row['book_name']?>" class="text-truncate" style="max-width: 150px;">
                    <?php echo $row['book_name'] ; ?></td>
                <td><?php echo $row['book_cat'] ; ?></td>
                <td><?php echo $row['book_loc'] ; ?></td>
                <td><?php echo $row['book_isbn'] ; ?></td>
                <td><?php echo $row['created'] ; ?></td>
                <td><?php echo $row['book_return'] ; ?></td>
                <td class="text-center"><span
                        class="badge <?php echo ($row['status'] == 'pending') ? 'bg-warning text-dark' : 'bg-success text-white' ?>  "><?php echo $row['status'] ; ?></span>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm <?php echo ($row['status'] == 'pending') ? 'disabled' : '' ?>"
                        onClick="<?php echo ($fine > 0) ? "alert('You have to first clear your fine to return book')" : "returnBook('".$row['book_name']."', '".$row['book_isbn']."','".$row['book_loc']."')" ?>">Return</button>
                </td>
            </tr>
            <?php    }
                }else{
                        echo "<tr><td class='text-center' colspan='8'>You have no books issued</td></tr>";
                    };
                
                ?>
        </tbody>

        <script>
        function returnBook(book, isbn, loc) {
            if (confirm(`Are you sure you want to return the "${book}" book?`)) {
                window.location.href = "book_issue.php?action=delete&isbn=" + isbn + "&loc=" + loc;
            }
        }
        </script>
    </table>
</div>

<?php include '../footer.php'?>