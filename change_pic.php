<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Picture</title>
</head>
<?php
    include("conf.php");
    if($_REQUEST['uid']){
        $user_id = $_REQUEST['uid'];
        // $img_del_path = $_REQUEST['del_img'];
        // move_uploaded_file($_FILES['re-photo']['tmp_name'],"re/img.jpg");
        if(isset($_REQUEST['submit'])){
            if($_FILES['re-photo']['tmp_name']){
                $new_pic_tmp_file = $_FILES['re-photo']['tmp_name'];
                $new_pic_rnd_name = uniqid().".jpg";
                $query = " UPDATE now SET profile_pic='$new_pic_rnd_name' WHERE serial = $user_id ";
                $operation = mysqli_query($conn,$query);
                if($operation){
                    move_uploaded_file($new_pic_tmp_file = $_FILES['re-photo']['tmp_name'],"uploaded/".$new_pic_rnd_name);
                    // unlink("uploaded/$img_del_path");
                    header("location: index.php?success_pic");
                }else{
                    header("location: index.php?failed_pic");
                }
            }else{
                echo "Photo is required";
            }
        }
?>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="re-photo" >
        <input type="submit" name="submit" value="Upload" >
    </form>
<?php
    } 
?>
</body>
</html>
