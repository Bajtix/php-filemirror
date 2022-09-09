<?php
/*
i will not admit to being the author of this
*/


include_once "common.php";

$security_path = get_p_path();

$security_passfile = pth_combine($basepath, $security_path);
if (is_dir($security_passfile)) {
    $security_passfile = pth_combine($security_passfile, ".password");
    if (!file_exists($security_passfile)) goto END;
} else {
    $security_passfile = pth_combine(pth_updir($security_passfile), ".password");
    if (!file_exists($security_passfile)) goto END;
    $security_path = pth_updir($security_path);
}

$security_path = pth_assure_no_beginning_trailing_slash($security_path);

$correct = trim(file_get_contents($security_passfile));

if (!array_key_exists($security_path, $_SESSION)) {
    $psw = "";
} else {
    $psw = $_SESSION[$security_path];
}

if ($psw == $correct) {
    goto END;
} else {
    die("<script>var passwd = prompt('Folder password'); const formData = new FormData(); formData.append('pass',passwd); let urld = window.document.URL.split('?')[1]; let ctn = {method: 'POST', body: formData}; fetch('auth.php?' + urld, ctn).then(()=>{window.location = window.location;}); </script>");
}

END:
