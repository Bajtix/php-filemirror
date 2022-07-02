<?php
/*
    SIMPLE PATH LIBRARY FOR PHP
    HANDLES THE MOST BASIC OPERATIONS BUT IS QUITE LIGHT, ALBEIT NOT VERY FAST
    
    created by bajtixone 2022
*/

/* 
UNILICENSE

This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to <http://unlicense.org/>
*/

function pth_combine(string $pa1, string $pa2): string {
    return pth_assure_trailing_slash($pa1) . $pa2;
}

function pth_assure_no_trailing_slash(string $path): string {
    $path = pth_assure_no_doubleslashes($path);

    if (substr($path, -1) == "/")
        return substr($path, 0, strlen($path) - 1);
    else
        return $path;
}

function pth_assure_trailing_slash(string $path): string {
    $path = pth_assure_no_doubleslashes($path);

    if (substr($path, -1) == "/")
        return $path;
    else
        return $path . "/";
}

function pth_assure_no_beginning_slash(string $path): string {
    $path = pth_assure_no_doubleslashes($path);
    if (substr($path, 0, 1) == "/")
        return substr($path, 1);
    else
        return $path;
}

function pth_assure_beginning_slash(string $path): string {
    $path = pth_assure_no_doubleslashes($path);
    if (substr($path, 0, 1) == "/")
        return $path;
    else
        return "/" . $path;
}

function pth_assure_no_beginning_trailing_slash(string $path): string {
    return pth_assure_no_trailing_slash(pth_assure_no_beginning_slash($path));
}

function pth_assure_beginning_trailing_slash(string $path): string {
    return pth_assure_trailing_slash(pth_assure_beginning_slash($path));
}

function pth_getparent(string $path): string {
    $broken = pth_breakdown($path);

    if (sizeof($broken) <= 1) throw new Exception("Cannot updir from base");
    array_pop($broken);
    return array_pop($broken);
}

function pth_updir(string $path): string {
    $broken = pth_breakdown($path);

    if (sizeof($broken) <= 1) throw new Exception("Cannot updir from base");
    array_pop($broken);

    return pth_weld($broken);
}

function pth_weld(array $broken): string {
    $full = "";
    foreach ($broken as $val) {
        $full = pth_combine($full, $val);
    }

    return $full;
}

function pth_gettoplevel(string $path): string {
    $broken = pth_breakdown($path);
    return array_pop($broken);
}


function pth_assure_level(string $path): string {
    $broken = pth_breakdown($path);

    $up_to_now = "";
    foreach ($broken as $val) {
        if ($val == "..") {
            $up_to_now = pth_updir($up_to_now);
        } else if ($val == ".") {
            //ignore
        } else {
            $up_to_now = pth_combine($up_to_now, $val);
        }
    }

    return $up_to_now;
}

function pth_breakdown(string $path): array {
    if (pth_assure_no_beginning_trailing_slash($path) == "") return [];
    return explode("/", pth_assure_no_trailing_slash($path));
}

function pth_getfilenamenoext(string $path): string {
    $name = pth_gettoplevel($path);
    $broken = explode(".", $name);
    array_pop($broken);
    return implode(".", $broken);
}

function pth_getfilenameext(string $path): string {
    $name = pth_gettoplevel($path);
    $broken = explode(".", $name);
    return array_pop($broken);
}

function pth_assure_no_doubleslashes(string $path): string {
    if (strstr($path, "//")) {
        $path = str_replace("//", "/", $path);
        if (strstr($path, "//")) {
            return pth_assure_no_doubleslashes($path);
        }
    }

    return $path;
}
