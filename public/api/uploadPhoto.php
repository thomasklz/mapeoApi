<?php
    $target_dir = "imagenes/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	$check = getimagesize($_FILES["file"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
?>