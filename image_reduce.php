<?php 

/* Main compression function, takes an image, destination and quality level  */
function compress_image($src, $dest , $quality) 
{ 
	$info = getimagesize($src);
	/*check image format */
	if ($info["mime"] == "image/jpeg" ) 
	{
		$image = imagecreatefromjpeg($src);
		/*reduces the image to quality, an saves it to destination */
		imagejpeg($image, $dest, $quality);
	}
	elseif ($info["mime"] == "image/png") 
	{
		/* pngs handled seperately by compress_png function, result saved to destination */
	file_put_contents($dest, compress_png($src, $quality)); 
	}
	else{
		echo "Image type not recognized . . .$src";
	}
}


/*takes file path to png image,  and maximum quality value for compression */
function compress_png($path_to_png_file, $max_quality )
{   
    $min_quality = 25;
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
	/* images with a height or a width greater than those of a product image are reduced to 75% quality */
	 if($info[0] > 800 || $info[1] > 800 ) {

	 compress_image("images/$image", "build/$image", 75 ); 

	} elseif( (strpos($image, 'default') !== false)) {

		compress_image("images/$image", "build/$image", 25 ); 

	} else{
			/* Product images or smaller are reduced to 55% quality */
			compress_image("images/$image", "build/$image", 55 ); 
		}
 } 

 ?> 