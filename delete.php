<?php
    include('conf.php');
    $uid = $_REQUEST['uid'];
    // $img_del = $_REQUEST['del_img'];
    $sql = "DELETE FROM now WHERE serial = $uid";
    $matchine = mysqli_query($conn,$sql);
    if($matchine){
        // unlink("uploaded/$img_del");
        header("location: index.php?deleted");
    }else{
        header("location: index.php?sorry");
    }
?>