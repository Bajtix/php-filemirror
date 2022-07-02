<?php

include_once("type.common.php");


$output = cm_getcachepath($path) . ".mp3";
$command = "timidity \"{$path}\" -Ow -o - | ffmpeg -i - -preset ultrafast \"{$output}\"";

if (cm_getcache($path) == null) {
    $val = exec($command);
    if (!$val) {
        show_file_error("File couldn't be converted", "The file could not be converted to MP3. Please check if <b>ffmpeg</b> and <b>timidity</b> are installed on the server.", "", "");
    } else
        cm_addcache($path, $output, $cacheduration);
}

$relativePath = pth_assure_no_beginning_trailing_slash(str_replace($basepath, "", $output));
header("Location: display.php?p={$relativePath}");
