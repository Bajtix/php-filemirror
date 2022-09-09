<?php
include_once "common.php";

$path = pth_combine($basepath, get_p_path());

$nodownload = array_key_exists("nodownload", $_GET);

if (file_exists($path)) {
    if (is_dir($path)) {
        //zip the directory
        if (cm_getcache($path) == null) {

            $targetZip = pth_combine(pth_updir($path), "." . pth_gettoplevel($path) . ".zip");
            echo ("Zipping directory: " . $path . " to " . $targetZip . "<br>");

            if (file_exists($targetZip)) {
                unlink($targetZip);
            }

            $zip = new ZipArchive();
            $res = $zip->open($targetZip, ZipArchive::CREATE);
            echo ($res);
            //add files from path directory to zip

            $files = scandir($path);
            foreach ($files as $file) {
                if ($file != "." && $file != ".." && file_exists(pth_combine($path, $file))) {
                    echo (pth_combine($path, $file) . "<br>");
                    $zip->addFile(pth_combine($path, $file), $file);
                }
            }

            if ($zip->close()) {
                cm_addcache($path, $targetZip, $cacheduration);
                $path = $targetZip;
            } else {
                die("Could not create zip file");
            }
        } else {
            $path = cm_getcache($path);
        }
    }


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
