<?php


function compress_png($path_to_png_file, $max_quality = 90)
{
    if (!file_exists($path_to_png_file)) {
        throw new Exception("File does not exist: $path_to_png_file");
    }

    // guarantee that quality won't be worse than that.
    $min_quality = 60;
    $compressed_png_content = shell_exec("pngquant --quality=$min_quality-$max_quality - < ".escapeshellarg(    $path_to_png_file));

    if (!$compressed_png_content) {
        throw new Exception("Conversion to compressed PNG failed. Is pngquant 1.8+ installed on the server?");
    }

    return $compressed_png_content;
}


$path_to_uncompressed_file = 'images/image (5).png';
$path_to_compressed_file = 'build/image (5).png';

// this will ensure that $path_to_compressed_file points to compressed file
// and avoid re-compressing if it's been done already
if (!file_exists($path_to_compressed_file)) {
    file_put_contents($path_to_compressed_file, compress_png($path_to_uncompressed_file));
}

