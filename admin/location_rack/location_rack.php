<?php 
include "../../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

$this_page = "rack";

//get all the location racks
$get_rack_sql = "SELECT * FROM `location_rack`";
$get_rack_result = mysqli_query($con, $get_rack_sql);

include "../admin_template_header.php";
?>

<h1 class="fs-3 mt-4 mb-5 text-center">Location Rack Management</h1>
<?php 
if(isset($_GET['action'])){
    //if user clicked the new button
    if($_GET['action'] == 'add'){
        include "rack_new.php";
    }

    //if user clicked the delete button
    if($_GET['action'] == 'delete'){
        $rack_id = $_GET['id'];
        $delete_rack_sql = "DELETE FROM `location_rack` WHERE `id` = '$rack_id'";
        $delete_rack_result = mysqli_query($con, $delete_rack_sql);

        if($delete_rack_result){
            echo("<script>location.href = '".base_url()."admin/location_rack/location_rack.php?msg=Rack deleted successfully';</script>");
        }else{
            echo("<script>location.href = '".base_url()."admin/location_rack/location_rack.php?rack_del_error=Rack delete failed';</script>");
        }
    }

}else{
    //display message on successfull category update and delete
   if(isset($_GET['msg'])){
    echo '<div class="mt-5 m-auto alert alert-success alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['msg'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }

    //display message if the Category delete failed
   if(isset($_GET['rack_del_error'])){
    echo '<div class="mt-5 alert alert-danger alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['rack_del_error'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }
?>

<div class="card mt-5 mb-4" style="max-width: 1200px">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div><i class="fa-solid fa-window-maximize me-2"></i>Location Racks</div>
        <a href="location_rack.php?action=add" class="btn btn-success">New</a>
    </div>
    <div class="card-body table-responsive ">
        <table id="datatablesSimple" class="mt-3 table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Rack name</th>
                    <th scope="col">Total books</th>
                    <th scope="col">Created on</th>
                    <th scope="col">Active</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(mysqli_num_rows($get_rack_result) > 0){  
                            while($row = mysqli_fetch_assoc($get_rack_result)) { ?>
                <tr>
                    <td><?php echo $row['name'] ; ?></td>
                    <td><?php echo $row['total_books'] ; ?></td>
                    <td><?php echo $row['created'] ; ?></td>
                    <td class="d-flex justify-content-center">
                        <button onclick="delete_rack(<?php echo $row['id'] ?>, '<?php echo $row['name'] ?>')"
                            class="btn btn-danger btn-sm"><i class="fa-solid fa-trash me-1"></i> Delete
                        </button>
                    </td>
                </tr>
                <?php       }
                    }else{
                            echo "<tr><td class='text-center' colspan='5'>No rack found</td></tr>";
                        };
                    
                    ?>
            </tbody>
        </table>
        <script>
        //take confirmation before deleting rack
        function delete_rack(rack_Id, rack_name) {
            if (confirm(`Are you sure you want to delete the "${rack_name}" Rack?`)) {
                window.location.href = "location_rack.php?action=delete&id=" + rack_Id;
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