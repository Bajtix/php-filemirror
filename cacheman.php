<?php

include_once "paths.php";

$cachedfiles = array();

function cm_getcache($path) {
    global $cachedfiles;

    cm_load();

    foreach ($cachedfiles as $v) {
        if ($v["file"] == $path) {
            return $v["cached"];
        }
    }

    cm_save();

    return null;
}

function cm_save() {
    global $cachedfiles;

    $json = json_encode($cachedfiles);
    file_put_contents(".cache.json", $json);
}

function cm_load() {
    global $cachedfiles;

    if (!file_exists(".cache.json")) {
        $cachedfiles = array();
        return;
    }

    $json = file_get_contents(".cache.json");
    $cachedfiles = json_decode($json, true);

    if ($cachedfiles == null) {
        $cachedfiles = array();
    }
}

function cm_addcache($path, $cache, $duration) {
    global $cachedfiles;

    cm_load();

    array_push($cachedfiles, ["file" => $path, "cached" => $cache, "expire" => time() + $duration]);

    cm_save();
}

function cm_getcachepath($path) {
    return pth_combine(pth_updir($path), ".cashed-" . pth_gettoplevel($path));
    // $cachedir = pth_combine(__DIR__, "cache");

    // if (!is_dir($cachedir)) mkdir($cachedir);

    // return pth_combine($cachedir, ".cached-" . pth_getfilenamenoext($path));
}

function cm_cleanup() {
    global $cachedfiles;

    cm_load();

    if (sizeof($cachedfiles) == 0) {
        return;
    }

    $now = time();
    foreach ($cachedfiles as $k => $v) {
        if ($v["expire"] < $now) {
            if (file_exists($v["cached"])) {
                unlink($v["cached"]);
            }
            unset($cachedfiles[$k]);
        }
    }

    cm_save();
}

function cm_clean_all_cached_files_dont_use_this_unless_you_have_to() {
    global $cachedfiles;

    cm_load();

    if (sizeof($cachedfiles) == 0) {
        return;
    }

    foreach ($cachedfiles as $k => $v) {
        if (file_exists($v["cached"])) {
            unlink($v["cached"]);
        }
        unset($cachedfiles[$k]);
    }

    cm_save();
}
