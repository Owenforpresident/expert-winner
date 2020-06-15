<?php 

/* Main compression function, takes an image, destination and quality level  */
/* function compress_image($src, $dest , $quality) 
{ 
	$info = getimagesize($src);
	/*check image format */
/*	if ($info["mime"] == "image/jpeg" ) 
	{
		$image = imagecreatefromjpeg($src);
		/*reduces the image to quality, an saves it to destination */
		 /* imagejpeg($image, $dest, $quality);
/*	} 
	elseif ($info["mime"] == "image/png") 
	{
		/* pngs handled seperately by compress_png function, result saved to destination */
/*	file_put_contents($dest, compress_png($src, $quality)); 
	}
	else{
		echo "Image type not recognized . . .$src";
	}
} 


/*takes file path to png image, and maximum quality value for compression */
/* function compress_png($path_to_png_file, $max_quality )
{   
    $min_quality = 25;
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg(    $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}

/* Loops through directory 'images' to build array of file paths as strings */
/*	$fileSystemIterator = new FilesystemIterator('images');
	$entries = array();
foreach ($fileSystemIterator as $fileInfo){
    $entries[] = $fileInfo->getFilename();
}

/* for every file path in the entries array, find the image size and then set the compression amount and call compress function */
/*  foreach($entries as $image){ 


		$output2 = shell_exec("identify -format '%f: %Q' images/$image");
		$stringvalue = substr($output2, -2); 
		$value = (int) $stringvalue; 
		$info = getimagesize("images/$image");
	
	
		if ( (strpos($image, 'default') !== false)) {
			compress_image("images/$image", "build/C-35--$image", 35 );
		}
	
		if ($value) {
			/*check for quality value and compare against with cases to decide by how much to reduce */
		/*	switch ($value) {
				case $value <=30:
				compress_image("images/$image", "build/O-$value-C-90--$image", 100); 
				break;
				case $value >30 && $value <=35:
				compress_image("images/$image", "build/O-$value-C-93--$image", 93); 	
				break;
				case $value >35 && $value <=40:
				compress_image("images/$image", "build/O-$value-C-90--$image", 90); 	
				break;
				case $value >40 && $value <=45:
				compress_image("images/$image", "build/O-$value-C-87--$image", 87); 	
				break;
				case $value >45 && $value <=50:
				compress_image("images/$image", "build/O-$value-C-84--$image", 84); 	
				break;
				case $value >50 && $value <=55:
				compress_image("images/$image", "build/O-$value-C-81--$image", 81); 	
				break;
				case $value >55 && $value <=60:
				compress_image("images/$image", "build/O-$value-C-78--$image", 78); 	
				break;
				case $value >60 && $value <=75:
				compress_image("images/$image", "build/O-$value-C-75--$image", 75); 	
				break;
				case $value >75 && $value <=80:
				compress_image("images/$image", "build/O-$value-C-72--$image", 72); 	
				break;
				case $value >80 && $value <=85:
				compress_image("images/$image", "build/O-$value-C-69--$image", 69); 	
				break;
				case $value >85 && $value <=90:
				compress_image("images/$image", "build/O-$value-C-66--$image", 66); 	
				break;
				case $value >90 && $value <=95:
				compress_image("images/$image", "build/O-$value-C-63--$image", 63); 	
				break;
				case $value >95:
				compress_image("images/$image", "build/O-$value-C-60--$image", 60); 	
				break;
				default:
				compress_image("images/$image", "build/O-$value-C-85--$image", 85);  
				break;
				}	/*if the quality value isn't available or undefined compress based on image dimensions instead */
					/* }/*  else { 
						switch ($info) {
							case $info[0] >= 1200 || $info[1] >= 1200:
							compress_image("images/$image", "build/C-93--$image", 93); 
							break;
							case $info[0] > 800 || $info[1] > 800:
							compress_image("images/$image", "build/C-80--$image", 80); 
							break;
							case $info[0] > 400 || $info[1] > 400:
							compress_image("images/$image", "build/C-60--$image", 60); 
							break;	
							case $info[0] <= 400 && $info[1] <= 400:
							compress_image("images/$image", "build/C-35--$image", 35); 
							break;
							default:
							compress_image("images/$image", "build/C-85--$image", 85);  
							break;			
						}		
			}  					  	
	
} 

