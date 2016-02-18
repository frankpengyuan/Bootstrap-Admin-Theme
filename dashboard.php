<!DOCTYPE html>
<?php

//应用会话内存储的变量值之前必须先开启会话
session_start();
//若是会话没有被设置，查看是否设置了cookie
include 'function.php';
include 'component.php';
$dbc = db_connect();
init_dash_web($dbc);

$cnt=0;
$all_orgs = array();
$query = "SELECT belong_org FROM Member WHERE stuID=\"".$_SESSION["user_id"]."\" ORDER BY belong_org";
        $result=mysqli_query($dbc,$query);
        if ($result) {
            if($result->num_rows>0){                                               //判断结果集中行的数目是否大于0
                while($row =$result->fetch_array() ){
                    $all_orgs[$cnt]=$row[0];
                    $cnt++;
                }
            }
        }else {
            echo "query failed";
        }

if(isset($_POST["submit"])){
    if (!empty($_FILES["mem_photo"]["tmp_name"])) {
        if ((($_FILES["mem_photo"]["type"] == "image/jpeg") 
        || ($_FILES["mem_photo"]["type"] == "image/pjpeg")) 
        && ($_FILES["mem_photo"]["size"] < 5000000)) 
        { 
        if ($_FILES["mem_photo"]["error"] > 0) 
        { 
            echo "Return Code: " . $_FILES["mem_photo"]["error"] . "<br />"; 
        } 
        else 
            { 
            echo "Upload: " . $_FILES["mem_photo"]["name"] . "<br />"; 
            echo "Type: " . $_FILES["mem_photo"]["type"] . "<br />"; 
            echo "Size: " . ($_FILES["mem_photo"]["size"] / 1024) . " Kb<br />"; 
            echo "Temp file: " . $_FILES["mem_photo"]["tmp_name"] . "<br />"; 
            if (file_exists("upload/" . $_SESSION["user_id"].$_POST["mem_org"])) 
                { 
                unlink("upload/" . $_SESSION["user_id"].$_POST["mem_org"].".jpg"); 
                } 
            else 
                {
                    $im=imagecreatefromjpeg($_FILES["mem_photo"]["tmp_name"]);//参数是图片的存方路径
                    $maxwidth="200";//设置图片的最大宽度
                    $maxheight="200";//设置图片的最大高度
                    $name="upload/" . $_SESSION["user_id"].$_POST["mem_org"];//图片的名称，随便取吧
                    $filetype=".jpg";//图片类型
                    resizeImage($im,$maxwidth,$maxheight,$name,$filetype);//调用上面的函数
                //move_uploaded_file($_FILES["mem_photo"]["tmp_name"], 
                //"upload/" . $_SESSION["user_id"].$_POST["mem_org"].".jpg"); 
                echo "Stored in: " . "upload/" . $_SESSION["user_id"].$_POST["mem_org"].".jpg"; 
                } 
            } 
        } 
        else 
        { 
            echo "Invalid file"; 
        }
        $photo_addr = "upload/" . $_SESSION["user_id"].$_POST["mem_org"].".jpg";
        $query = "UPDATE member SET Photo_link=\"". $photo_addr
        ."\" WHERE StuID=\"".$_SESSION["user_id"]."\" AND Belong_org=\"".$_POST["mem_org"]."\"";
        $data = mysqli_query($dbc,$query);
    }else{
        $photo_addr = "";
    }
    // update user table
    if (!empty($_POST["user_update"])) {
        $query = "UPDATE All_users SET Email=\"". mysqli_real_escape_string($dbc, $_POST["mem_email"])
        ."\", username=\"". mysqli_real_escape_string($dbc, $_POST["mem_name"])
        ."\", Phone=\"". mysqli_real_escape_string($dbc, $_POST["mem_phone"])
        ."\", dob=\"". mysqli_real_escape_string($dbc, $_POST["mem_dob"])
        ."\" WHERE StuID=\"".$_SESSION["user_id"]."\"";
        $data = mysqli_query($dbc,$query);
        $_SESSION["username"] = mysqli_real_escape_string($dbc, $_POST["mem_name"]);
        echo $query;
        echo mysqli_error($dbc);
    }

    // update password
    if (!empty($_POST["password_update"])) {
        $query = "UPDATE All_users SET password=\"". mysqli_real_escape_string($dbc, $_POST["new_password"])
        ."\" WHERE StuID=\"".$_SESSION["user_id"]."\" AND password='".mysqli_real_escape_string($dbc, $_POST["old_password"])."' COLLATE utf8_bin";
        $data = mysqli_query($dbc,$query);
        echo $query;
        echo mysqli_error($dbc);
    }

    // update member table
    if (!empty($_POST["mem_update"])) {
        $query = "UPDATE member SET Description=\"".mysqli_real_escape_string($dbc, $_POST["mem_des"])
        ."\", Tag=\"".mysqli_real_escape_string($dbc, $_POST["mem_tag"])
        ."\" WHERE StuID=\"".$_SESSION["user_id"]."\" AND Belong_org=\"".mysqli_real_escape_string($dbc, $_POST["mem_org"])."\"";
        $data = mysqli_query($dbc,$query);
        echo $query;
        echo mysqli_error($dbc);
    }
}

?>
<html class="no-js">
    
    <head>
        <?php gen_header_admin();?>
    </head>
    
    <body>
        <?php gen_navbar_admin();?>
        <div class="container-fluid">
            <div class="row-fluid">
                <?php gen_sidebar_admin(0);?>
                
                <!--/span-->
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">User Profile</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                    <fieldset>
                                    <legend>Welcome <?php echo $_SESSION["username"]; ?>!</legend>
                                        <?php
                                            $query = "SELECT * FROM All_users WHERE stuID='".$_SESSION["user_id"]."'";
                                            $result = mysqli_query($dbc,$query);
                                            if ($result) {
                                                $row_usr =$result->fetch_array();
                                            }
                                        ?>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Name </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="mem_name" value="<?php echo $_SESSION["username"]; ?>">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">ID </label>
                                          <div class="controls">
                                            <input type="text" class="input-xlarge disabled" id="disabledInput" disabled="" value="<?php echo $_SESSION["user_id"]; ?>">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Email </label>
                                          <div class="controls">
                                            <input type="text" class="span6" id="typeahead" name="mem_email" value="<?php echo $row_usr['email'] ?>">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Phone </label>
                                          <div class="controls">
                                            <input type="text" class="span6" id="typeahead" name="mem_phone" value="<?php echo $row_usr['phone'] ?>">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="date01">Birthday</label>
                                          <div class="controls">
                                            <input type="text" class="input-xlarge datepicker" id="date01" value="<?php echo $row_usr['dob'] ?>" name="mem_dob">
                                          </div>
                                        </div>
                                        <div class="form-actions">
                                          <input type="hidden" name="user_update" value="set">
                                          <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                                          <button type="reset" class="btn">Cancel</button>
                                        </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Security</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                    <fieldset>
                                        <legend>Security</legend>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Old password </label>
                                          <div class="controls">
                                            <input type="password" class="span6"  id="typeahead" name="old_password">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">New password </label>
                                          <div class="controls">
                                            <input type="password" class="span6" id="typeahead" name="new_password">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">New password again </label>
                                          <div class="controls">
                                            <input type="password" class="span6" id="typeahead" name="new_password2">
                                          </div>
                                        </div>
                                        <div class="form-actions">
                                          <input type="hidden" name="password_update" value="set">
                                          <button type="submit" class="btn btn-primary" name="submit">Change password</button>
                                          <button type="reset" class="btn">Cancel</button>
                                        </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php for ($i=0; $i < $cnt; $i++) { ?>
                    <div class="row-fluid">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Profile for organization</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    </hr>
                                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"];?>">
                                      <fieldset>
                                        <legend><?php echo $all_orgs[$i] ?></legend>
                                        <?php
                                            $query = "SELECT * FROM Member WHERE stuID='".$_SESSION["user_id"]."' AND belong_org='".$all_orgs[$i]."'";
                                            $result = mysqli_query($dbc,$query);
                                            if ($result) {
                                                $row_mem =$result->fetch_array();
                                            }
                                        ?>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Organization </label>
                                          <div class="controls">
                                            <input type="hidden"name="mem_org" value="<?php echo $all_orgs[$i] ?>">
                                            <input type="text" class="input-xlarge disabled" id="disabledInput" disabled="" value="<?php echo $all_orgs[$i] ?>">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">Tag </label>
                                          <div class="controls">
                                            <input type="text" class="span6" id="typeahead" name="mem_tag" value="<?php echo $row_mem['tag'] ?>">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="fileInput">Photo</label>
                                          <div class="controls">
                                            <img src="<?php echo $row_mem['photo_link'] ?>"><hr>
                                            <input class="input-file uniform_on" id="fileInput" type="file" name="mem_photo">
                                          </div>
                                        </div>
                                        <div class="control-group">
                                          <label class="control-label" for="textarea2">Description</label>
                                          <div class="controls">
                                            <textarea id="ckeditor_standard" name="mem_des" ><?php echo $row_mem['description'] ?></textarea>
                                          </div>    
                                        </div>
                                        <div class="form-actions">
                                          <input type="hidden" name="mem_update" value="set">
                                          <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                                          <button type="reset" class="btn">Cancel</button>
                                        </div>
                                      </fieldset>
                                    </form>
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <hr>
        <?php gen_footer_admin();?>
        </div>
        <!--/.fluid-container-->
    <?php 
    gen_Admin_pageEnd();
    mysqli_close($dbc);
    ?>
    </body>

</html>