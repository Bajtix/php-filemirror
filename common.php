<?php

include_once("paths.php");
include_once("configs.php");
include_once("cacheman.php");

function get_p_path() {
    global $illegal_files;
    if (array_key_exists("p", $_GET)) {
        return pth_assure_legal(
            pth_assure_no_beginning_trailing_slash(
                pth_assure_level($_GET["p"])
            ),
            $illegal_files
        );
    } else {
        return "";
    }
}

function show_file_error($error, $description, $link, $href) {
    echo ("<div class='view-error'><h3>{$error}</h3><p>{$description}</p><a href='${href}'>{$link}</a>");
}

function p_path_from_full($path) {
    global $basepath;
    return str_replace($basepath, "", $path);
}

cm_cleanup(); // we want this to be called as often as possible


function debug_log(string $msg) {
    echo ("<script>console.log(`" . $msg . "`)</script>");
}

function str_starts_with($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}
