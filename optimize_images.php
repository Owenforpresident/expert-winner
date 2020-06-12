<?php 
//iterate through folder to get file paths 
$fileSystemIterator = new FilesystemIterator('images');
$entries = array();
foreach ($fileSystemIterator as $fileInfo){
$entries[] = $fileInfo->getFilename();
}

//sort by size 
foreach($entries as $image){
    $info = getimagesize("images/$image");
    $output = shell_exec("identify -format '%f: %Q' images/$image");
    $str = substr($output, -2); 
    $quality_test_value = (int) $str; 

    switch ($info) {
        case $info[0] >= 1200 || $info[1] >= 1200:
        //call a function which compresses each image with a maximum quality quality_test_value of 
            compress_image("images/$image", "build/O-$quality_test_value-MQ-100-X-$info[0]-Y-$info[1]-$image", 100, $quality_test_value, $info); 
        break;
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
}


function compress_image($src, $dest, $max_compression_quality, $quality_test_value, $info ) 
{     
$increment = 3; 
/*check image format */
if ($info["mime"] == "image/jpeg" ) 
{
    $image = imagecreatefromjpeg($src);
    
    /*reduces the image to quality, an saves it to destination */
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
        
} elseif ($info["mime"] == "image/png") 
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


function compress_png($path_to_png_file, $quality )
{   
    $min_quality = 20;
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$quality - < ".escapeshellarg( $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}

?> 