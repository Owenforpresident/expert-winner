<?php 

function compress_image($src, $dest , $quality) 
{
	$info = getimagesize($src);
	if ($info["mime"] == "image/jpeg" ) 
	{
		$image = imagecreatefromjpeg($src);
	}
	elseif ($info["mime"] == "image/png") 
	{
		$image = imagecreatefrompng($src);
	}
	else{
		echo "Image type not recognized . . .$src";
	}

	imagejpeg($image, $dest, $quality);

}
 
$fileSystemIterator = new FilesystemIterator('images');

$entries = array();

foreach ($fileSystemIterator as $fileInfo){
    $entries[] = $fileInfo->getFilename();
}

foreach($entries as $image){ 


	$info = getimagesize("images/$image");

	if($info[0] > 800 || $info[1] > 800 ) {

		 compress_image("images/$image", "build/$image.jpg", 85 ); 

	} elseif($info[0] <= 800 && $info[1] <= 800 ) {

		 compress_image("images/$image", "build/$image.jpg", 60 ); 

	} else {

		 compress_image("images/$image", "build/$image.jpg", 100 );

	}	
	
 } 

 ?> 