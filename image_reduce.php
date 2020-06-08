<?php 

function compress_image($src, $dest , $quality) 
{
	$info = getimagesize($src);

	if ($info["mime"] == "image/jpeg" ) 
	{
		$image = imagecreatefromjpeg($src);
		imagejpeg($image, $dest, $quality);
	}
	elseif ($info["mime"] == "image/png") 
	{

		 file_put_contents($dest, compress_png($src, $quality)); 
		/* copy(compress_png($src, $quality), $dest); */
		
	}
	else{
		echo "Image type not recognized . . .$src";
	}

}


function compress_png($path_to_png_file, $max_quality )
{
    if (!file_exists($path_to_png_file)) {
        throw new Exception("File does not exist: $path_to_png_file");
    }
    $min_quality = 60;
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg(    $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}


/* Loop through images folder to build array of file paths as strings */
$fileSystemIterator = new FilesystemIterator('images');
$entries = array();
foreach ($fileSystemIterator as $fileInfo){
    $entries[] = $fileInfo->getFilename();
}



/* for every file path in the entries array, find the image size and then set the compression amount and call compress function */
 foreach($entries as $image){ 

	$info = getimagesize("images/$image");
	var_dump($image, $info[0], $info[1]); 

	if($info[0] > 800 || $info[1] > 800 ) {

		 compress_image("images/$image", "build/$image", 85 ); 

	} elseif( $info[0] <= 800 && $info[1] <= 800) {

		 compress_image("images/$image", "build/$image", 60 ); 

	} else {

		 compress_image("images/$image", "build/$image", 100 );

	}	
	
 } 

 ?> 