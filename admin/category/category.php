<?php 
include "../../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

$this_page = "category";

//get all the data of the categories
$get_cat_sql = "SELECT * FROM `category`";
$get_cat_result = mysqli_query($con, $get_cat_sql);

include "../admin_template_header.php";
?>

<h1 class="fs-3 mt-4 mb-5 text-center">Category Management</h1>

<?php 
if(isset($_GET['action'])){
    //if user clicked the new button
    if($_GET['action'] == 'add'){
        include "category_new.php";
    }

    //if user clicked the edit button
    if($_GET['action'] == 'edit'){
        include "category_edit.php";
    }

    //if user clicked the delete button
    if($_GET['action'] == 'delete'){
        $cat_id = $_GET['id'];
        $delete_cat_sql = "DELETE FROM `category` WHERE `id` = '$cat_id'";
        $delete_cat_result = mysqli_query($con, $delete_cat_sql);

        if($delete_cat_result){
            echo("<script>location.href = '".base_url()."/admin/category/category.php?msg=Category deleted successfully';</script>");
        }else{
            echo("<script>location.href = '".base_url()."/admin/category/category.php?cat_del_error=Category delete failed';</script>");
        }
    }

}else{
    //display message on successfull category update and delete
   if(isset($_GET['msg'])){
    echo '<div class="mt-3 alert alert-success alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['msg'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }

    //display message if the Category delete failed
   if(isset($_GET['cat_del_error'])){
    echo '<div class="mt-3 alert alert-danger alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['cat_del_error'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }
?>

<div class="card mb-4" style="max-width: 1200px">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="fa-solid fa-table-list me-2"></i> Categories</div>
        <a href="category.php?action=add" class="btn btn-success">New</a>
    </div>
    <div class="card-body table-responsive ">
        <table id="datatablesSimple" class="mt-3 table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Category name</th>
                    <th scope="col">Total books</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created on</th>
                    <th scope="col">Updated on</th>
                    <th scope="col">Active</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(mysqli_num_rows($get_cat_result) > 0){  
                            while($row = mysqli_fetch_assoc($get_cat_result)) { ?>
                <tr>
                    <td><?php echo $row['name'] ; ?></td>
                    <td><?php echo $row['total_books'] ; ?></td>
                    <td>
                        <?php  
                            if($row['status'] == "Enable"){
                                echo "<span class='badge bg-success'>Enable</span>";
                            }else{
                                echo "<span class='badge bg-danger'>Disable</span>";
                            }               
                        ?>
                    </td>
                    <td><?php echo $row['created'] ; ?></td>
                    <td><?php echo $row['updated'] ; ?></td>
                    <td class="d-flex justify-content-center">
                        <a href="category.php?action=edit&id=<?php echo $row['id'] ?>"
                            class="btn btn-primary me-3 btn-sm"><i class="fa-solid fa-pen-to-square me-1"></i>
                            Edit</a>
                        <button onclick="delete_cat(<?php echo $row['id'] ?>, '<?php echo $row['name'] ?>')"
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
        function delete_cat(cat_Id, cat_name) {
            if (confirm(`Are you sure you want to delete the "${cat_name}" category?`)) {
                window.location.href = "category.php?action=delete&id=" + cat_Id;
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