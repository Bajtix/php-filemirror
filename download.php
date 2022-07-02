<?php
include_once "common.php";

$path = pth_combine($basepath, get_p_path());

$nodownload = array_key_exists("nodownload", $_GET);

if (file_exists($path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: ' . mime_content_type($path));
    if ($nodownload) {
        header('Content-Disposition: inline; filename="' . basename($path) . '"');
    } else {
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
    }
    //header('Content-Disposition: attachment; filename=' . basename($path));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($path));
    ob_clean();
    flush();
    readfile($path);
    exit;
}
