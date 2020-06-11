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


/*takes file path to png image, and maximum quality value for compression */
function compress_png($path_to_png_file, $max_quality )
{   
    $min_quality = 25;
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg(    $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}

/* Loops through directory 'images' to build array of file paths as strings */
$fileSystemIterator = new FilesystemIterator('images');
$entries = array();
foreach ($fileSystemIterator as $fileInfo){
    $entries[] = $fileInfo->getFilename();
}

/* for every file path in the entries array, find the image size and then set the compression amount and call compress function */
 foreach($entries as $image){ 

	$output2 = shell_exec("identify -format '%f: %Q' images/$image");
	$stringvalue = substr($output2, -2); 
	$value = (int) $stringvalue; 

 if ($value) {
	switch ($value) {
		case $value <=50:
			compress_image("images/$image", "build/85----$image", 85); 
			break;
		case $value >50 && $value <=60:
			compress_image("images/$image", "build/75----$image", 75); 	
			break;
		case $value >60 && $value <=70:
			compress_image("images/$image", "build/70----$image", 70); 	
			break;
		case $value >70 && $value <=80:
			compress_image("images/$image", "build/65----$image", 65); 	
			break;
		case  $value> 80:
			compress_image("images/$image", "build/60----$image", 60); 
			break;
		default:
		compress_image("images/$image", "build/85----$image", 85); 
		break;
		}
		} else { 
			$info = getimagesize("images/$image");
			
			if($info[0] > 800 || $info[1] > 800 ) {

				compress_image("images/$image", "build/85----$image", 85 ); 
				} elseif( (strpos($image, 'default') !== false)) {

					compress_image("images/$image", "build/35----$image", 35 ); 
				} else{
						compress_image("images/$image", "build/55----$image", 55 ); 
			}  
	}  

}
