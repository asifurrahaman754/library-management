<?php 
include "../../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

$this_page = "books";

//get all the data of the books
$get_books_sql = "SELECT * FROM `books`";
$get_books_result = mysqli_query($con, $get_books_sql);

include "../admin_template_header.php";
?>

<h1 class="fs-3 mt-4 mb-5 pb-3 text-center">Books Management</h1>

<?php 
if(isset($_GET['action'])){
    //if user clicked the new button
    if($_GET['action'] == 'add'){
        include "book_new.php";
    }

    //if user clicked the delete button
    if($_GET['action'] == 'delete'){
        include "book_delete.php";
    }

}else{
    //display message on successfull category update and delete
   if(isset($_GET['msg'])){
    echo '<div class="mt-3 alert alert-success alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['msg'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }

    //display message if the Category delete failed
   if(isset($_GET['book_del_error'])){
    echo '<div class="mt-3 alert alert-danger alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['book_del_error'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }
?>

<div class="card mb-4" style="max-width: 1200px">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="fa-solid fa-book me-2"></i>Books</div>
        <a href="books.php?action=add" class="btn btn-success">New</a>
    </div>
    <div class="card-body table-responsive ">
        <table id="datatablesSimple" class="mt-3 table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Location rack</th>
                    <th scope="col">Listed on</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(mysqli_num_rows($get_books_result) > 0){  
                            while($row = mysqli_fetch_assoc($get_books_result)) { ?>
                <tr>
                    <td><img style="width: 30px" class="m-auto d-block" src="../../upload/<?php echo $row['image'] ?>"
                            alt="books cover"></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo $row['name'] ; ?></td>
                    <td><?php echo $row['category'] ; ?></td>
                    <td><?php echo $row['book_copies'] ; ?></td>
                    <td><?php echo $row['ISBN'] ; ?></td>
                    <td><?php echo $row['location_rack'] ; ?></td>
                    <td><?php echo $row['created'] ; ?></td>
                    <td class="d-flex justify-content-center">
                        <button onclick="delete_book('<?php echo $row['name'] ?>','<?php echo $row['ISBN'] ?>')"
                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash me-1"></i> Delete
                        </button>
                    </td>
                </tr>
                <?php       }
                    }else{
                            echo "<tr><td class='text-center' colspan='5'>No category found</td></tr>";
                        };
                    ?>
            </tbody>
        </table>

        <script>
        //take confirmation before deleting category
        function delete_book(book_name, isbn) {
            if (confirm(`Are you sure you want to delete the "${book_name}" book?`)) {
                window.location.href = "books.php?action=delete&isbn=" + isbn;
            }
        }
        </script>
    </div>
</div>


<?php 
};
include "../admin_template_footer.php";
include "../../footer.php";
?>