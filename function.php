<?php
	function init_web($dbc)
	{
		if(!isset($_SESSION["user_id"])){
		    if(isset($_COOKIE["user_id"])){
		        //用cookie给session赋值
		        $_SESSION["user_id"]=$_COOKIE["user_id"];
		        $query = "SELECT * FROM All_users WHERE stuID=\"".mysqli_real_escape_string($dbc, $_SESSION["user_id"])."\" COLLATE utf8_bin ";
	        	$data = mysqli_query($dbc,$query);
	        	$result = $data->fetch_array();
	        	$_SESSION["username"]=$result['username'];
	        	$_SESSION["useremail"]=$result['email'];
		    }
		} else {
			$query = "SELECT * FROM All_users WHERE stuID=\"".mysqli_real_escape_string($dbc, $_SESSION["user_id"])."\" COLLATE utf8_bin ";
        	$data = mysqli_query($dbc,$query);
        	$result = $data->fetch_array();
        	$_SESSION["username"]=$result['username'];
        	$_SESSION["useremail"]=$result['email'];
		}
	}

	function init_dash_web($dbc)
	{
		if(!isset($_SESSION["user_id"])){
		    if(isset($_COOKIE["user_id"])){
		        //用cookie给session赋值
		        $_SESSION["user_id"]=$_COOKIE["user_id"];
		        $query = "SELECT username FROM All_users WHERE stuID=\"".mysqli_real_escape_string($dbc, $_SESSION["user_id"])."\" COLLATE utf8_bin ";
            	$data = mysqli_query($dbc,$query);
            	$result = $data->fetch_array();
            	$_SESSION["username"]=$result[0];
		    } else {
		        $home_url = "login.php";
		        header("Location:".$home_url);
		        return;
		    }
		}
	}

	function db_connect()
	{
		return mysqli_connect("localhost", "root", "Incoming29", "acweb_db");
	}

	function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
	{
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);

		if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
		{
		if($maxwidth && $pic_width>$maxwidth)
		{
		$widthratio = $maxwidth/$pic_width;
		$resizewidth_tag = true;
		}

		if($maxheight && $pic_height>$maxheight)
		{
		$heightratio = $maxheight/$pic_height;
		$resizeheight_tag = true;
		}

		if($resizewidth_tag && $resizeheight_tag)
		{
		if($widthratio<$heightratio)
		$ratio = $widthratio;
		else
		$ratio = $heightratio;
		}

		if($resizewidth_tag && !$resizeheight_tag)
		$ratio = $widthratio;
		if($resizeheight_tag && !$resizewidth_tag)
		$ratio = $heightratio;

		$newwidth = $pic_width * $ratio;
		$newheight = $pic_height * $ratio;

		if(function_exists("imagecopyresampled"))
		{
		$newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
		imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
		}
		else
		{
		$newim = imagecreate($newwidth,$newheight);
		imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
		}

		$name = $name.$filetype;
		imagejpeg($newim,$name);
		imagedestroy($newim);
		}
		else
		{
		$name = $name.$filetype;
		imagejpeg($im,$name);
		}
	}
	//使用方法：
	/*
	$im=imagecreatefromjpeg("./20140416103023202.jpg");//参数是图片的存方路径
	$maxwidth="600";//设置图片的最大宽度
	$maxheight="400";//设置图片的最大高度
	$name="123";//图片的名称，随便取吧
	$filetype=".jpg";//图片类型
	resizeImage($im,$maxwidth,$maxheight,$name,$filetype);//调用上面的函数
	*/

	// upload photo
    function get_photo_addr($post_key='', $prefix='', $my_file_id='')
    {
        if (!empty($_FILES[$post_key]["tmp_name"])) 
        {
            if ((($_FILES[$post_key]["type"] == "image/jpeg") 
            || ($_FILES[$post_key]["type"] == "image/pjpeg")) 
            && ($_FILES[$post_key]["size"] < 5000000)) 
            { 
            if ($_FILES[$post_key]["error"] > 0) 
            { 
                echo "Return Code: " . $_FILES[$post_key]["error"] . "<br />"; 
            } 
            else 
                { 
                echo "Upload: " . $_FILES[$post_key]["name"] . "<br />"; 
                echo "Type: " . $_FILES[$post_key]["type"] . "<br />"; 
                echo "Size: " . ($_FILES[$post_key]["size"] / 1024) . " Kb<br />"; 
                echo "Temp file: " . $_FILES[$post_key]["tmp_name"] . "<br />"; 
                if (file_exists("upload/" . $prefix.$my_file_id.".jpg"))
                    { 
                    unlink("upload/" . $prefix.$my_file_id.".jpg"); 
                    } 
                        $im=imagecreatefromjpeg($_FILES[$post_key]["tmp_name"]);//参数是图片的存方路径
                        $maxwidth="600";//设置图片的最大宽度
                        $maxheight="600";//设置图片的最大高度
                        $name="upload/" . $prefix.$my_file_id;//图片的名称，随便取吧
                        $filetype=".jpg";//图片类型
                        resizeImage($im,$maxwidth,$maxheight,$name,$filetype);//调用上面的函数
                    //move_uploaded_file($_FILES["mem_photo"]["tmp_name"], 
                    //"upload/" . $_SESSION["user_id"].$_POST["mem_org"].".jpg"); 
                    echo "Stored in: " . "upload/" . $prefix.$my_file_id.".jpg"; 
                }
                $photo_addr["content"] = "upload/" . $prefix.$my_file_id.".jpg";
                $photo_addr["error"]="";
                $photo_addr["new_file"]=true;
            } 
            else 
            { 
                echo "Invalid file";
                $photo_addr["new_file"]=fales;
            	$photo_addr["content"] = "";
                $photo_addr["error"]="Upload fail, please check file type and make sure it is within the size limit.";
            }
        }else{
            $photo_addr["content"] = "";
            $photo_addr["error"]="";
            $photo_addr["new_file"]=false;
        }
        return $photo_addr;
    }

    // upload photo
    function get_pdf_addr($post_key='', $prefix='', $my_file_id='', $size_limit=5000000)
    {
        if (!empty($_FILES[$post_key]["tmp_name"])) 
        {
            if ((($_FILES[$post_key]["type"] == 'application/pdf')) 
            && ($_FILES[$post_key]["size"] < $size_limit)) 
            { 
            if ($_FILES[$post_key]["error"] > 0) 
            { 
                echo "Return Code: " . $_FILES[$post_key]["error"] . "<br />"; 
            } 
            else 
                { 
                echo "Upload: " . $_FILES[$post_key]["name"] . "<br />"; 
                echo "Type: " . $_FILES[$post_key]["type"] . "<br />"; 
                echo "Size: " . ($_FILES[$post_key]["size"] / 1024) . " Kb<br />"; 
                echo "Temp file: " . $_FILES[$post_key]["tmp_name"] . "<br />"; 
                if (file_exists("upload/" . $prefix.$my_file_id.".pdf"))
                    { 
                    unlink("upload/" . $prefix.$my_file_id.".pdf"); 
                    } 
                    move_uploaded_file($_FILES[$post_key]["tmp_name"], 
                    "upload/" . $prefix.$my_file_id.".pdf"); 
                    echo "Stored in: " . "upload/" . $prefix.$my_file_id.".pdf"; 
                }
                $pdf_addr["content"] = "upload/" . $prefix.$my_file_id.".pdf";
                $pdf_addr["error"]="";
                $pdf_addr["new_file"]=true;
            } 
            else 
            { 
                echo "Invalid file"; 
                $pdf_addr["content"] = "";
                $pdf_addr["new_file"]=false;
                $pdf_addr["error"]="Upload fail, please check file type and make sure it is within the size limit.";
            }
        }else{
            $pdf_addr["content"] = "";
            $pdf_addr["error"]="";
            $pdf_addr["new_file"]=false;
        }
        return $pdf_addr;
    }
?>
