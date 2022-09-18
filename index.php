<?php session_start();
include_once "common.php";
$p_path = "";
try {
    $p_path = get_p_path();
} catch (Exception $e) {
    header("Location: /");
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta lang="en-US" />
    <title>Filemirror</title>
    <link href="index.css" rel="stylesheet" />

    <?php
    echo ('<meta property="og:title" content="filemirror -> ' . pth_gettoplevel($p_path) . '">');
    echo ('<meta property="title" content="filemirror -> ' . pth_gettoplevel($p_path) . '">');
    echo ('<meta property="og:description" content="&#8962;/'  . $p_path . '">');
    echo ('<meta property="description" content="&#8962;/'  . $p_path . '">');
    ?>
</head>

<body>
    <div id="container">
        <div id="header">
            <img src="graphics/filemirror-logo.svg" alt="File Mirror" id="logo" />
        </div>
        <div id="content">
            <?php
            include "security.php";
            ?>

            <div id="navigation">
                <div id="n-bar">
                    <?php
                    $pathFolders = pth_breakdown($p_path);

                    echo ('<a href="?p=">&#8962;</a>');
                    $utn = "";
                    foreach ($pathFolders as $val) {
                        $utn = pth_combine($utn, $val);
                        echo ("<span class='path-arrow'>&rarr;</span> <a class='path-element' href='?p={$utn}'>{$val}</a>");
                    }
                    ?>
                </div>
                <script>
                    //make sure that we're at the end of the path
                    var navbar = document.querySelector("#navigation");
                    navbar.scrollLeft = navbar.scrollWidth;
                </script>
            </div>
            <div id="current-view">
                <?php
                $fullpath = pth_combine($basepath, $p_path);
                if (is_dir($fullpath)) {
                    $list = [];
                    try {
                        $list = scandir($fullpath);
                        if (!$list) throw new Exception();

                        echo ("<div id='directory-list'>");
                        natsort($list);
                        foreach ($list as $value) {
                            if (!($value == "." || $value == ".." || substr($value, 0, 1) == ".")) {
                                $fp = pth_combine($p_path, $value);
                                echo ("<a class='list-item' href='?p={$fp}'>{$value}</a>");
                            }
                        }
                        echo ("</div>");
                        goto DONE;
                    } catch (Exception $exc) {
                    }
                }
                echo ("<iframe src='display.php?p={$p_path}'></iframe>");
                DONE:
                ?>
            </div>
            <div id="toolbar">
                <script>
                    //function that copies text to clipboard
                    function copyToClipboard(text) {
                        var dummy = document.createElement("input");
                        document.body.appendChild(dummy);
                        dummy.setAttribute("value", text);
                        dummy.select();
                        document.execCommand("copy");
                        document.body.removeChild(dummy);
                    }
                </script>

                <a class="toolbar-item" href="download.php?p=<?php echo ($p_path); ?>">Download</a>
                <a class="toolbar-item" href="display.php?p=<?php echo ($p_path); ?>">Open</a>
                <a class="toolbar-item" href="#" onclick="copyToClipboard(window.location.href); alert('Copied!');">Copy URL</a>
                <a class="toolbar-item" href="#" onclick="copyToClipboard(document.querySelector('iframe').src); alert('Copied!');">Copy file URL</a>

            </div>
        </div>
        <div id="footer">
            <a href="https://bajtix.xyz">&#169; bajtixone 2022-</a>
        </div>
    </div>


</body>

</html>