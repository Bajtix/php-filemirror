<?php

include_once("type.common.php");

//this is too general, we need to implement cases for different extensions then!

$ext = pth_getfilenameext($path);

$handler = "mimes/custom/" . $ext . ".php";
if (is_file($handler)) {
    include_once $handler;
} else {
    show_file_error("File type cannot be previewed", "The file type <i>{$type}:{$ext}</i> is not supported. You have to download the file to view it's contents.", "Download", "download.php?p={$p_path}");
}
