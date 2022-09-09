<?php
session_start();
include_once("common.php");

$p_path = get_p_path();
$path = pth_combine($basepath, $p_path);

include "security.php";
?>

<html>

<head>
    <title>
        <?php
        echo (pth_gettoplevel($path));
        ?>
    </title>
    <link href="index.css" rel="stylesheet" />
</head>

<body>
    <?php

    if (is_file($path)) {
        $type = mime_content_type($path);

        $handler = "mimes/" . str_replace("/", ".", $type) . ".php";
        if (is_file($handler)) {
            include_once $handler;
        } else {
            show_file_error("File type cannot be previewed", "The file type <i>{$type}</i> is not supported. You have to download the file to view it's contents.", "Download", "download.php?p={$p_path}");
        }
    } else if (is_dir($path)) {
        show_file_error("A directory cannot be viewed directly", "Please use the directory view instead", "View the directory", "./?p={$p_path}");
    } else {
        http_response_code(404);
        show_file_error("404", "The file or directory you requested does not exist", "", "");
    }
    ?>
</body>

</html>