<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['blotter_id'])) {
        $blotter_id = $_POST['blotter_id'];

       
        $blotter_id = mysqli_real_escape_string($con, $blotter_id);

 
        $delete_query = "DELETE FROM blotter WHERE blotter_id = $blotter_id";

        if (mysqli_query($con, $delete_query)) {
            echo "Record deleted successfully!";
        } else {
            echo "Error deleting record: " . mysqli_error($con);
        }
    }
}
?>
