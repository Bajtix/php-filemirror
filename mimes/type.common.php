<?php

include_once("common.php");

function spitout($path) {
    header('Content-Description: File Transfer');
    header('Content-Type: ' . mime_content_type($path));
    header('Content-Disposition: inline; filename=' . basename($path));
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

function ffmpeg_tomp4_cache($path) {
    global $cacheduration, $basepath;

    $output = cm_getcachepath($path) . ".mp4";
    $command = "ffmpeg -i \"{$path}\" -vcodec libx264 -preset ultrafast \"{$output}\"";

    if (cm_getcache($path) == null) {
        $val = exec($command);
        if (!$val) {
            show_file_error("File couldn't be converted", "The file could not be converted to MP4. Please check if <b>ffmpeg</b> is installed on the server.", "", "");
        }
        cm_addcache($path, $output, $cacheduration);
    }

    $relativePath = pth_assure_no_beginning_trailing_slash(str_replace($basepath, "", $output));
    header("Location: display.php?p={$relativePath}");
}

function ffmpeg_tomp3_cache($path) {
    global $cacheduration, $basepath;

    $output = cm_getcachepath($path) . ".mp3";
    $command = "ffmpeg -i \"{$path}\" -preset ultrafast \"{$output}\"";

    if (cm_getcache($path) == null) {
        $val = exec($command);
        if (!$val) {
            show_file_error("File couldn't be converted", "The file could not be converted to MP3. Please check if <b>ffmpeg</b> is installed on the server.", "", "");
        } else
            cm_addcache($path, $output, $cacheduration);
    }

    $relativePath = pth_assure_no_beginning_trailing_slash(str_replace($basepath, "", $output));
    header("Location: display.php?p={$relativePath}");
}



function imgck_topng_cache($path) {
    global $cacheduration, $basepath;

    $output = cm_getcachepath($path) . ".png";
    $command = "convert \"{$path}\" \"{$output}\"";

    if (cm_getcache($path) == null) {
        $val = exec($command);
        if (!$val) {
            show_file_error("File couldn't be converted", "The file could not be converted to PNG. Please check if <b>imagemagick</b> is installed on the server.", "", "");
        } else
            cm_addcache($path, $output, $cacheduration);
    }

    $relativePath = pth_assure_no_beginning_trailing_slash(str_replace($basepath, "", $output));
    header("Location: display.php?p={$relativePath}");
}

function imgck_topng_flatten_cache($path) {
    global $cacheduration, $basepath;

    $output = cm_getcachepath($path) . ".png";
    $command = "convert \"{$path}\" -background none -flatten \"{$output}\"";

    if (cm_getcache($path) == null) {
        $val = exec($command);
        if (!$val) {
            show_file_error("File couldn't be converted", "The file could not be converted to PNG. Please check if <b>imagemagick</b> is installed on the server.", "", "");
        } else
            cm_addcache($path, $output, $cacheduration);
    }

    $relativePath = pth_assure_no_beginning_trailing_slash(str_replace($basepath, "", $output));
    header("Location: display.php?p={$relativePath}");
}

function load_text_editor($path, $highlighting) {
    $text = file_get_contents($path);
    echo ('<script language="javascript" type="text/javascript" src="./js/edit_area/edit_area_full.js"></script>');
    echo ("<textarea readonly id='code-editor' style='display:block; width: 100%; height:100%;'>{$text}</textarea>");
    echo ('<script>editAreaLoader.init({
        id: "code-editor",
        syntax: "' . $highlighting . '",
        start_highlight: true,
        is_editable: false,
        word_wrap: true,
        allow_toggle: true,
        allow_resize: false,
        load: "later"
    });</script>');
}
