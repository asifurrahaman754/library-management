<?php 
$book_isbn = $_GET['isbn'];

//get the book
$get_book_query = "SELECT * FROM `books` WHERE `ISBN` = '$book_isbn'";
$get_book_result = mysqli_query($con, $get_book_query);
$get_book_data = mysqli_fetch_assoc($get_book_result);

$image_name = $get_book_data['image'];
$imageUrl = "../../upload/".$image_name;
//delete the image
if(unlink($imageUrl)){
    //delete book from books table
    $delete_book_sql = "DELETE FROM `books` WHERE `ISBN` = '$book_isbn'";
    $delete_book_result = mysqli_query($con, $delete_book_sql);

    //reduce category books count
    $category = $get_book_data['category'];
    $category_books_count_sql = "UPDATE `category` SET `total_books` = `total_books` - 1 WHERE `name` = '$category'";
    $category_books_count_result = mysqli_query($con, $category_books_count_sql);

    //reduce the location rack books count
    $books_count = $get_book_data['book_copies'];
    $location_rack = $get_book_data['location_rack'];
    $reduce_location_rack_sql = "UPDATE `location_rack` SET `total_books` = `total_books` - $books_count WHERE `name` = '$location_rack'";
    $reduce_location_rack_result = mysqli_query($con, $reduce_location_rack_sql);

    if($delete_book_result){
        echo("<script>location.href = '".base_url()."admin/books/books.php?msg=book deleted successfully';</script>");
    }else{
        echo("<script>location.href = '".base_url()."admin/books/books.php?book_del_error=book delete failed';</script>");
    }
}else{
    echo("<script>location.href = '".base_url()."admin/books/books.php?book_del_error=book image delete failed';</script>");
}
?>