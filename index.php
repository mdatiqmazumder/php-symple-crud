<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>
<body>
    <section id="sec">
            <div class="regForm">
                <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="fname" placeholder="Enter First Name">
                    <input type="text" name="lname" placeholder="Enter Last Name"><br> <br>
                    <input type="text" name="email" placeholder="Enter Email"> 
                    <input type="text" name="password" placeholder="Enter Password"> <br> <br>
                    <input type="radio" name="gender" value="male">Male
                    <input type="radio" name="gender" value="female">Female <br>
                    <select name="country" >
                        <option value="">Select</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Turkey">Turkey</option>
                    </select><br> <br>
                    <input type="file" name="prof_pic">
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
                <br>
            <div class="serchBox">
                <form  method="post">
                    <input class="serchInput" type="text" name="serchInp" placeholder="Enter like First Name" >
                    <input class="serchSubmit" type="submit" name='src_submit' value="Search">
                    <?php if(isset($_REQUEST['src_submit'])){
                        $rec_key = $_REQUEST['serchInp'];
                        if( !($rec_key == null) ){
                            echo "<p>Serch reasult for ".htmlspecialchars($rec_key)." </p>";
                        }elseif($rec_key == null){
                            header("location:  {$_SERVER['PHP_SELF']}?enter_tos");
                        }
                    }
                    ?>
                    
                </form>
            </div>
    <?php
            include('conf.php');
            if( isset($_REQUEST['submit'])){
                $fname = $_REQUEST['fname'];
                $lname = $_REQUEST['lname'];
                $email =  $_REQUEST['email'];
                $password =  $_REQUEST['password'];
                $gender =  $_REQUEST['gender'];
                $country =  $_REQUEST['country'];
                $tmp_pic_file = $_FILES['prof_pic']['tmp_name'];
                $rnd_pic_name = uniqid().".png";
                switch($fname && $lname && $email && $password && $country && $tmp_pic_file):
                    case true;
                        move_uploaded_file($tmp_pic_file,"uploaded/".$rnd_pic_name);
                        $sql = " INSERT INTO now (fname,lname,email,password,gender,country,profile_pic) VALUES ('$fname','$lname','$email','$password','$gender','$country','$rnd_pic_name') ";
                        $operation = mysqli_query($conn,$sql);
                        switch($operation):
                                case (true);
                                header("location:  {$_SERVER['PHP_SELF']}?reg_success");
                                break;
                                case (false):
                                header("location:  {$_SERVER['PHP_SELF']}?reg_fail");
                        endswitch;
                        break;
                    case false:
                    header("location:  {$_SERVER['PHP_SELF']}?reg_req");
                endswitch;
            }
            if(isset($_REQUEST['del_bulk'])){
                if(isset($_REQUEST['bulk_selector'])){
                    $del_ids = $_REQUEST['bulk_selector'];
                    $ar_ids = implode(",", $del_ids);
                    $sql_bulk_del = " DELETE FROM now WHERE serial in ($ar_ids) ";
                    $matchine_bulk_del = mysqli_query($conn,$sql_bulk_del);
                    if($matchine_bulk_del){
                        header("location:  {$_SERVER['PHP_SELF']}?success_bdel");
                    }else{
                        header("location:  {$_SERVER['PHP_SELF']}?sorry_bdel");
                    }
                }else{
                    header("location:  {$_SERVER['PHP_SELF']}?select_bdel");
                }
            }
        $sql = " SELECT * FROM now ";
        // $serch_key = isset($_REQUEST['serchInp']);
        if(isset($_REQUEST['src_submit'])){
            $serch_key = $_REQUEST['serchInp'];
            $sql = " SELECT * FROM `now` WHERE `fname` LIKE '%{$serch_key}%' ";
            if($serch_key == null){
                $sql = " SELECT * FROM now ";
            }
        }
        $matchine = mysqli_query($conn,$sql);
        $calculator = mysqli_num_rows($matchine);
        if(isset($_REQUEST['reg_success'])){
            echo "<p class='success' >Data import success.</p>";
        }elseif(isset($_REQUEST['reg_req'])){
            echo "<p class='error' >All fields are require.</p>";
        }elseif(isset($_REQUEST['reg_fail'])){
            echo "<p class='error' >Failed to import data.</p>";
        }
            if($calculator > 0){ 
                if( isset($_REQUEST['deleted']) ){
                    echo "<p class='success' >Record Delete Successfully.</p>";
                }else if(isset($_REQUEST['sorry'])){
                    echo "<p class='error' >Failed to Delete record.</p>";
                }else if( isset($_REQUEST['updated'])){
                    echo "<p class='success' >Data Update Successfully.</p>";
                }else if(isset($_REQUEST['edit_sorry'])){
                    echo "<p class='error' >Failed to edit record.</p>";
                }else if(isset($_REQUEST['success_pic'])){
                    echo "<p class='success' >Picture Update Successfully.</p>";
                }else if(isset($_REQUEST['failed_pic'])){
                    echo "<p class='error' >Failed to Update Picture.</p>";
                }else if(isset($_REQUEST['success_bdel'])){
                    echo "<p class='success' >Selected items deleted.</p>";
                }else if(isset($_REQUEST['sorry_bdel'])){
                    echo "<p class='error' >Failed to delete selected.</p>";
                }else if(isset($_REQUEST['select_bdel'])){
                    echo "<p class='error' >Please! Select an item.</p>";
                }else if(isset($_REQUEST['enter_tos'])){
                    echo "<p class='error' >Please! Enter Something.</p>";
                }
            
            ?>
            <form method="post" >
                <table border="1px" >
                    <thead>
                        <tr>
                            <th colspan="14" class="totalUser">Total Number Found : <?php echo $calculator ; ?></th>
                        </tr>
                    </thead>
                    <thead >
                        <tr>
                            <th class="header" >SL.</th>
                            <th class="header" >User ID</th>
                            <th class="header" >Profile Picture</th>
                            <th class="header" >First Name</th>
                            <th class="header" >Last Name</th>
                            <th class="header" >Email</th>
                            <th class="header" >Password</th>
                            <th class="header" >Gender</th>
                            <th class="header" >Country</th>
                            <th class="header" >Reg. Time</th>
                            <th class="header" colspan="3">Action</th>
                            <th class="header" ><input class="bulkSubmit" type="submit" name="del_bulk" value="Del Selected"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        for ($i = 1;$i <= $calculator;$i ++) { 
                        $result = mysqli_fetch_assoc($matchine);
                        ?>
                        <tr>
                            <th class="mainData" ><?php echo $i; ?></th>
                            <th class="mainData" ><?php echo $result['serial']; ?></th>
                            <th class="mainData" ><img class="profile_pic" src="uploaded/<?php echo $result['profile_pic']; ?>"></th>
                            <th class="mainData" ><?php echo htmlspecialchars($result['fname']); ?></th>
                            <th class="mainData" ><?php echo htmlspecialchars($result['lname']); ?></th>
                            <th class="mainData" ><?php echo htmlspecialchars($result['email']); ?></th>
                            <th class="mainData" ><?php echo htmlspecialchars($result['password']); ?></th>
                            <th class="mainData" ><?php echo htmlspecialchars($result['gender']); ?></th>
                            <th class="mainData" ><?php echo htmlspecialchars($result['country']); ?></th>
                            <th class="mainData" ><?php echo htmlspecialchars($result['create_time']); ?></th>
                            <th class="mainData" ><a href="edit.php?uid=<?php echo $result['serial']; ?>">Edit</th>
                            <th class="mainData" ><a href="change_pic.php?uid=<?php echo $result['serial']; ?>">change pic</th>
                            <th class="mainData" ><a onclick="return confirm('Are You Sure to Dlete?')" href="delete.php?uid=<?php echo $result['serial']; ?>">Delete</th>
                            <th class="mainData" ><input type="checkbox" name="bulk_selector[]" value="<?php echo $result['serial']; ?>"></th>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </form>
        <?php   
            }else{
                echo "<p class='noData' >No Data To shaw.</ p>";
            }
        ?>
    </section>
</body>
</html>