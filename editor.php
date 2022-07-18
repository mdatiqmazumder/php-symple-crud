<?php
    include('conf.php');
    if(isset($_REQUEST['submit'])){
        $fname = $_REQUEST['fname'];
        $lname = $_REQUEST['lname'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $user_id = $_REQUEST['user_id'];
        $sql = "UPDATE now set fname='$fname',lname='$lname',email='$email',password='$password' WHERE serial = $user_id";
        $operation = mysqli_query($conn,$sql);

        if($operation){
            header("location: index.php?updated");
        }else{
            header("location: edit.php?edit_sorry");
        }
    }

?>