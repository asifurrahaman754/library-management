<?php 
include "../../connection.php";

$id = $_GET['id'];

//get all the info from user_fine table
$getInfo_user_fine_query = "SELECT * FROM `user_fine` WHERE `unique_id` = '$id'";
$getInfo_user_fine_result = mysqli_query($con, $getInfo_user_fine_query);

while($row = mysqli_fetch_assoc($getInfo_user_fine_result)){
    //increase the book copies by 1
    $book_isbn = $row['book_isbn'];
    $update_quantity_sql = "UPDATE `books` SET `book_copies` = `book_copies` + 1 WHERE `ISBN` = '$book_isbn'";
    $update_quantity_result = mysqli_query($con, $update_quantity_sql);

    //increase the total_books in rack by 1
    $book_loc = $row['book_loc'];
    $update_rack_sql = "UPDATE `location_rack` SET `total_books` = `total_books` + 1 WHERE `name` = '$book_loc'";
    $update_rack_result = mysqli_query($con, $update_rack_sql);

    //delete the coresponding issue from the book_issue table
    $delete_issue_query = "DELETE FROM `book_issue` WHERE `user_id` = '$id' AND `book_isbn` = '$book_isbn'";
    $delete_issue_result = mysqli_query($con, $delete_issue_query);
}

 //delete the coresponding fine from the user_fine table
 $delete_fine_query = "DELETE FROM `user_fine` WHERE `unique_id` = '$id'";
 $delete_fine_result = mysqli_query($con, $delete_fine_query);
 $error = "";
 $success = "";

 if($delete_fine_result) {
     header("Location: index.php?success=fine deleted");
 } else {
     header("Location: index.php?error=fine deleting failed!");
 }

?>