<?php 

//gets file path from the request params
$filepath = $_GET['filepath'];
    $info = getimagesize("$filepath");
    //folder and file names need to be formatted correctly so they can be used in the shell command below
    $output = shell_exec("identify -format '%f: %Q' $filepath");
    $str = substr($output, -2); 
    $quality_test_value = (int) $str; 

switch ($info) {
    case $info[0] >= 1200 || $info[1] >= 1200:     
        compress_image("$filepath", "$filepath", 100, $quality_test_value, $info); 
    break;
    case $info[0] > 800 || $info[1] > 800:
        compress_image("$filepath", "$filepath", 90, $quality_test_value, $info); 
    break;
    case $info[0] > 400 || $info[1] > 400:
        compress_image("$filepath", "$filepath", 80, $quality_test_value, $info); 
    break;	
    case $info[0] <= 400 && $info[1] <= 400:
        compress_image("$filepath", "$filepath", 70, $quality_test_value, $info); 
    break;
    default:
        compress_image("$filepath", "$filepath", 85, $quality_test_value, $info);  
    break;			
}	


function compress_image($src, $dest, $max_compression_quality, $quality_test_value, $info ) 
{     
$increment = 3; 
// check image format 
if ($info["mime"] == "image/jpeg" ) 
{   
    //create an image resource from filepath string
    $image = imagecreatefromjpeg($src);

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
		echo "Image not recognized . . . $src";
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
