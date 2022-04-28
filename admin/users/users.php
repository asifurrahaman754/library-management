<?php 
include "../../header.php";

//if the admin is not logged in, redirect to admin_login page
if(!is_admin_login())
{   
    header('location: ../../admin_login.php');
}

$this_page = "users";

//get all the location racks
$get_users_sql = "SELECT * FROM `users`";
$get_users_sql_result = mysqli_query($con, $get_users_sql);

include "../admin_template_header.php";
?>

<h1 class="fs-3 mt-4 mb-5 text-center">All users management</h1>

<?php 
if(isset($_GET['action'])){
    //if user clicked the disable button
    if($_GET['action'] == 'disable'){
        //get user details with selected id
        $id = $_GET['id'];
        $status = ($_GET['status'] == 'Enable') ? 'Disable' : 'Enable';
        $get_userWithID_sql = "UPDATE `users` SET `status`= '$status'  WHERE `id` = '$id'";
        $get_userWithID_result = mysqli_query($con, $get_userWithID_sql);
        
        if($get_userWithID_result){
            echo("<script>location.href = '".base_url()."/admin/users/users.php?msg=User status changed to ".$status."';</script>");
        }else{
            echo("<script>location.href = '".base_url()."/admin/users/users.php?error=Changing user status failed!';</script>");
        }
    }

}else{
    //display message on successfull changing the user status
   if(isset($_GET['msg'])){
    echo '<div class="mt-3 alert alert-success alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['msg'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }

   //display message if the status changing failed
   if(isset($_GET['error'])){
    echo '<div class="mt-3 alert alert-danger alert-dismissible fade show" style="max-width: 1200px" role="alert"> '.$_GET['cat_del_error'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
   }
?>

<div class="card mb-4" style="max-width: 1200px">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div> <i class="fa-solid fa-users me-2"></i>All users</div>
    </div>
    <div class="card-body table-responsive ">
        <table id="datatablesSimple" class="mt-3 table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created on</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if(mysqli_num_rows($get_users_sql_result) > 0){  
                            while($row = mysqli_fetch_assoc($get_users_sql_result)) { ?>
                <tr>
                    <td><?php echo $row['name'] ; ?></td>
                    <td><?php echo $row['email'] ; ?></td>
                    <td><?php echo $row['contact'] ; ?></td>
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
                    <td class="d-flex justify-content-center">
                        <button
                            onclick="delete_rack(<?php echo $row['id'] ?>, '<?php echo $row['name'] ?>', '<?php echo $row['status'] ?>')"
                            class="btn btn-danger me-2 btn-sm <?php echo ($row['status'] == "Disable") ? 'disabled' : '' ?>"><i
                                class="fa-solid fa-ban me-1"></i> Disable
                        </button>
                        <button
                            onclick="delete_rack(<?php echo $row['id'] ?>, '<?php echo $row['name'] ?>', '<?php echo $row['status'] ?>')"
                            class="btn btn-primary btn-sm <?php echo ($row['status'] == "Disable") ? '' : 'disabled' ?>"><i
                                class="fa-solid fa-check"></i> Enable
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
        function delete_rack(user_Id, user_name, status) {
            var status_p = (status == "Enable") ? 'Diactivate' : 'Activate';
            if (confirm(`Are you sure you want to ${status_p} the "${user_name}" account?`)) {
                window.location.href = "users.php?action=disable&id=" + user_Id + "&status=" + status;
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