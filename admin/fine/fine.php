<?php 

$id = $row['user_id'];
$book_name = $row['book_name'];
$book_loc = $row['book_loc'];
$book_isbn = $row['book_isbn'];

//get library fine quantity
$library_fine_Quantity_sql = "SELECT `return_fine` FROM `library_settings` WHERE 
`id` = 1";
$library_fine_Quantity = mysqli_query($con, $library_fine_Quantity_sql);
$library_fine_Quantity_data = mysqli_fetch_assoc($library_fine_Quantity);

//calculate fine
$days_between = ceil(abs($return_date - $present_time) / 86400);
$fine = $library_fine_Quantity_data['return_fine'] * $days_between;

//check if the fine data is already added
$check_fine_sql = "SELECT * FROM `user_fine` WHERE `unique_id` = '$id' AND `book_name` = '$book_name'";
$check_fine_result = mysqli_query($con, $check_fine_sql);
$check_fineWithFine_sql = "SELECT * FROM `user_fine` WHERE `unique_id` = '$id' AND `book_name` = '$book_name' AND `fine` != '$fine'";
$check_fineWithFine_result = mysqli_query($con, $check_fineWithFine_sql);

if(mysqli_num_rows($check_fine_result) == 0 || mysqli_num_rows($check_fineWithFine_result) == 1){
    //delete the oldest fine data
    $delete_fine_sql = "DELETE FROM `user_fine` WHERE `unique_id` = '$id' AND `book_name` = '$book_name'";
    $delete_fine_sql_result = mysqli_query($con, $delete_fine_sql);

    //get user details
    $user_detail_sql = "SELECT * FROM `users` WHERE `unique_id` = '$id'";
    $user_detail_result = mysqli_query($con, $user_detail_sql);
    $user_detail_row = mysqli_fetch_assoc($user_detail_result);

    //send corresponding user fine details to the fine table
    $name = $user_detail_row["name"];
    $email = $user_detail_row["email"];
    $contact = $user_detail_row["contact"];

    $fine_sql = "INSERT INTO `user_fine`(`username`, `book_name`, `book_isbn`, `book_loc`, `email`, `contact`, `unique_id`, `fine`) VALUES ('$name','$book_name','$book_isbn','$book_loc','$email','$contact','$id', $fine)";
    $fine_result = mysqli_query($con, $fine_sql);
}

?>