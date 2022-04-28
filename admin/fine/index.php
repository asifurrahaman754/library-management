<?php 
include "../../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

$this_page = "book_fine";

//calculate the fine for the user
calculate_fine($con);

//get all the fine data
$get_fine_query = "SELECT * FROM `user_fine`";
$get_fine_result = mysqli_query($con, $get_fine_query);

//get all data of unique fined user
$get_uniqueFine_query = "SELECT * FROM `user_fine` GROUP BY(`email`)";
$get_uniqueFine_query_result = mysqli_query($con, $get_uniqueFine_query);

include "../admin_template_header.php";

if(isset($_GET['success'])) {
    echo "<div class='alert mt-3 alert-success alert-dismissible fade show' role='alert' style='max-width:1200px'>
            <strong>Success!</strong> ".$_GET['success']."
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
}

if(isset($_GET['error'])) {
    echo "<div class='alert mt-3 alert-danger alert-dismissible fade show' role='alert' style='max-width:1200px'>
            <strong>Error!</strong> ".$_GET['error']."
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
}
?>
<div class="card mt-4 mb-4" style="max-width: 1200px">
    <div class="card-header">
        <div> <i class="fa-solid fa-money-check-dollar me-2"></i>All fined user</div>
    </div>

    <div class="card-body table-responsive ">
        <table id="datatablesSimple" class="mt-3 table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">isbn</th>
                    <th scope="col">Books</th>
                    <th scope="col">Total Fine(TK)</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    while($row = mysqli_fetch_assoc($get_uniqueFine_query_result)) { 
                ?>

                <tr>
                    <td><?php echo $row['username'] ; ?></td>
                    <td><?php echo $row['email'] ; ?></td>
                    <td><?php echo $row['contact'] ; ?></td>
                    <td><?php echo $row['book_isbn'] ; ?></td>
                    <td style="max-width: 200px">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>All the books</option>
                            <?php 
                                //get the book name of the specific user
                                $get_booksWithEmail_query_result = get_books_with_email($row['email'], $con);

                                while($bookWithEmail = mysqli_fetch_assoc($get_booksWithEmail_query_result)) {
                                    echo "<option  value='".$bookWithEmail['book_name']."'>".$bookWithEmail['book_name']."</option>";
                                }
                            ?>
                        </select>
                    </td>
                    <td> <?php echo get_fine($con, $row['unique_id'])?> </td>
                    <td> <button onclick="deleteFine('<?php echo $row['unique_id'] ?>')"
                            class="btn btn-danger btn-sm">delete
                            fine</button> </td>
                </tr>
                <?php  } ?>
            </tbody>
        </table>

        <script>
        function deleteFine(id) {
            if (confirm("Are you sure to delete fine?")) {
                window.location.href = "delete_fine.php?id=" + id;
            }
        }
        </script>
    </div>
</div>

<?php 
include "../admin_template_footer.php";
include "../../footer.php";
?>