<?php 

//iterate through folder to get file paths 
$fileSystemIterator = new FilesystemIterator('images');
$entries = array();
foreach ($fileSystemIterator as $fileInfo){
$entries[] = $fileInfo->getFilename();
}

//for each file, get the image quality, then call compress function with starting value of quality depending on the image dimensions
foreach($entries as $image){
    $info = getimagesize("images/$image");

    //this is the cmd for returning the 'quality' of an image, it is form the imagick library 
                //identiy -format '%f:%Q' filename.jpg //    for single image files (for testing)
    // will return the 'quality' of the jpg file 
    $output = shell_exec("identify -format '%f: %Q' images/$image");
    //just keep the actualy value for quality
    $str = substr($output, -2); 
    //turn it into a number for comparison operators
    $quality_test_value = (int) $str; 

        //to start reductions at lower $maximum_compression_quality values based on the dimensions of the picture using switch
    switch ($info) {
        case $info[0] >= 1200 || $info[1] >= 1200:
        //for the biggest images(over 1200) call compress and start with 100 as the maximum value for quality
            compress_image("images/$image", "build/O-$quality_test_value-MQ-100-X-$info[0]-Y-$info[1]-$image", 100, $quality_test_value, $info); 
        break;
        //as the images get smaller, reduce the maximum value for quality that is sent to the compress function
        case $info[0] > 800 || $info[1] > 800:
            compress_image("images/$image", "build/O-$quality_test_value-MQ-90-X-$info[0]-Y-$info[1]-$image", 90, $quality_test_value, $info); 
        break;
        case $info[0] > 400 || $info[1] > 400:
            compress_image("images/$image", "build/O-$quality_test_value-MQ-80-X-$info[0]-Y-$info[1]-$image", 80, $quality_test_value, $info); 
        break;	
        case $info[0] <= 400 && $info[1] <= 400:
             compress_image("images/$image", "build/O-$quality_test_value-MQ-70-X-$info[0]-Y-$info[1]-$image", 70, $quality_test_value, $info); 
        break;
        default:
             compress_image("images/$image", "build/O-$quality_test_value-MQ-85-X-$info[0]-Y-$info[1]-$image", 85, $quality_test_value, $info);  
        break;			
    }	


    //to reduce all images simply based on the $quality_test_value, with max_compresion_value of 80%
  /*  compress_image("images/$image", "build/O-$quality_test_value-MQ-100-X-$info[0]-Y-$info[1]-$image", 80, $quality_test_value, $info); */
} 

function compress_image($src, $dest, $max_compression_quality, $quality_test_value, $info ) 
{     
$increment = 3; 
/*check image format */
if ($info["mime"] == "image/jpeg" ) 
{
    $image = imagecreatefromjpeg($src);
    
    //compress the jpg by maximum compression minus multiples of the increment depending on quality_test_value
    //the lower the quality_test_value the more quality will be retained (which means a higher value sent to the imagejpeg function)
    switch ($quality_test_value) {
        case $quality_test_value <=40:
            imagejpeg($image, $dest, ($max_compression_quality - (1*$increment)));
        break;
        case $quality_test_value >40 && $quality_test_value <=45:
            imagejpeg($image, $dest, ($max_compression_quality - (2*$increment))); 	
        break;
        case $quality_test_value >45 && $quality_test_value <=50:
            imagejpeg($image, $dest, ($max_compression_quality - (3*$increment)));; 	
        break;
        case $quality_test_value >50 && $quality_test_value <=55:
            imagejpeg($image, $dest, ($max_compression_quality - (4*$increment))); 	
        break;
        case $quality_test_value >55 && $quality_test_value <=60:
            imagejpeg($image, $dest, ($max_compression_quality - (5*$increment))); 	
        break;
        case $quality_test_value >60 && $quality_test_value <=65:
            imagejpeg($image, $dest, ($max_compression_quality - (6*$increment))); 	
        break;
        case $quality_test_value >65 && $quality_test_value <=70:
            imagejpeg($image, $dest, ($max_compression_quality - (7*$increment))); 	
        break;
        case $quality_test_value >70 && $quality_test_value <=75:
            imagejpeg($image, $dest, ($max_compression_quality - (8*$increment))); 	
        break;
        case $quality_test_value >75 && $quality_test_value <=80:
            imagejpeg($image, $dest, ($max_compression_quality - (9*$increment))); 	
        break;
        case $quality_test_value >80 && $quality_test_value <=85:
            imagejpeg($image, $dest, ($max_compression_quality - (10*$increment))); 	
        break;
        case $quality_test_value >85 && $quality_test_value <=90:
            imagejpeg($image, $dest, ($max_compression_quality - (11*$increment))); 	
        break;
        case $quality_test_value >90 && $quality_test_value <=95:
            imagejpeg($image, $dest, ($max_compression_quality - (12*$increment))); 	
        break;
        case $quality_test_value >95:
            imagejpeg($image, $dest, ($max_compression_quality - (13*$increment))); 	
        break;
        default:
            imagejpeg($image, $dest, ($max_compression_quality - (5*$increment)));;   
        break;
        }
               
}   //same as above, except for the PNG images 

 elseif ($info["mime"] == "image/png") 
	{
    switch ($quality_test_value) {
       
        case $quality_test_value <=40:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (1*$increment)))); 
        break;
        case $quality_test_value >40 && $quality_test_value <=45:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (2*$increment))));  	
        break;
        case $quality_test_value >45 && $quality_test_value <=50:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (3*$increment)))); 	
        break;
        case $quality_test_value >50 && $quality_test_value <=55:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (4*$increment)))); 
        break;
        case $quality_test_value >55 && $quality_test_value <=60:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (5*$increment)))); 
        break;
        case $quality_test_value >60 && $quality_test_value <=65:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (6*$increment)))); 
        break;
        case $quality_test_value >65 && $quality_test_value <=70:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (7*$increment)))); 	
        break;
        case $quality_test_value >70 && $quality_test_value <=75:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (8*$increment))));  	
        break;
        case $quality_test_value >75 && $quality_test_value <=80:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (9*$increment)))); 	
        break;
        case $quality_test_value >80 && $quality_test_value <=85:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (10*$increment)))); 	
        break;
        case $quality_test_value >85 && $quality_test_value <=90:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (11*$increment))));  	
        break;
        case $quality_test_value >90 && $quality_test_value <=95:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (12*$increment)))); 	
        break;
        case $quality_test_value >95:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (13*$increment)))); 	
        break;
        default:
            file_put_contents($dest, compress_png($src, ($max_compression_quality - (5*$increment))));   
        break;
        }
}  else {
		echo "Image type not recognized . . .$src";
	}
} 

//this is the function for compressing png files 
function compress_png($path_to_png_file, $quality )
{   
    //min_quality value needs to be below any number passed into the compress function,
    //this is tricky because small low quality pngs can have very low values for quality passed to his function from the switch statements above
    //png quality is different to jpg, it is done by using a range of values (hence, min and max)
    $min_quality = 20;
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$quality - < ".escapeshellarg( $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}



