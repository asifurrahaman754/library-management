<?php 

session_start();

//set the base url so that we can use the boostrap file from anywehere
function base_url()
{
	return "http://localhost/library%20management/";
}

//check if the admin is logged in
function is_admin_login()
{
	if(isset($_SESSION['admin_id']))
	{
		return true;
	}
	return false;
}

//check if the user is logged in
function is_user_login()
{
	if(isset($_SESSION['user_id']))
	{
		return true;
	}
	return false;
}

//get book name from user_fine table with specific email
function get_books_with_email($email, $con)
{
	$sql = "SELECT `book_name` FROM `user_fine` WHERE `email` = '$email'";
	$sql_result = mysqli_query($con, $sql);

	return $sql_result;
}

//calculate the fine for the user
function calculate_fine($con)
{
	//get all the issued books 
	$issued_query = "SELECT * FROM `book_issue`";
	$issued_query_result = mysqli_query($con, $issued_query);

	$time = new DateTime('now', new DateTimezone('Asia/Dhaka'));
	$present_date = $time->format('Y-m-d');

	//calculate fine for each book and store it in the user_fine table
	while($row = mysqli_fetch_assoc($issued_query_result)) {
		if($present_date > $row['book_return'] && $row['status'] == 'approved') {
			$return_date = strtotime($row['book_return']);
			$present_time = strtotime($present_date);
			include 'admin/fine/fine.php';
		}
	}
}

//get the total user fine from the user_fine table
function get_fine($con, $user_id)
{
	$fine = 0;
	$sql = "SELECT `fine` FROM `user_fine` WHERE `unique_id` = '$user_id'";
	$sql_result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_assoc($sql_result))
	{
		$fine = $fine + $row['fine'];
	}

	return $fine;
}
?>