<?php
include_once "common.php";

session_start();

$pp = get_p_path();

if (!is_dir(pth_combine($basepath, $pp))) {
    $pp = pth_updir($pp);
}

$pp = pth_assure_no_beginning_trailing_slash($pp);

$ps = $_POST["pass"];

$_SESSION[$pp] = trim($ps);
