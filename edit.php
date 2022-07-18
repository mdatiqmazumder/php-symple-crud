<?php
    include('conf.php');
    if(isset($_REQUEST['uid'])){
        $userid = $_REQUEST['uid'];
        $sql = "SELECT * FROM now WHERE serial = $userid";
        $query = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Db info</title>
</head>
<body>
<form method="POST" action="editor.php">

<?php
    if(isset($_REQUEST['sorry'])){
        echo "<p class='error' >faild to update data.</p>";
    }
    while( $data = mysqli_fetch_assoc($query) ){
        ?>
        <input type="text" name="fname" value="<?php echo $data['fname']; ?>">
        <input type="text" name="lname" value="<?php echo $data['lname']; ?>" >
        <input type="text" name="email" value="<?php echo $data['email']; ?>" >
        <input type="text" name="password" value="<?php echo $data['password']; ?>" readonly>
        <img style="height:50px;width:50px" src="uploaded/<?php echo $data['profile_pic']; ?>">
        <input type="submit" name="submit" value="Update" >
        <input type="hidden" name="user_id" value="<?php echo $data['serial']; ?>">
        <?php
        }
    }
?>
</form>

</body>
</html>