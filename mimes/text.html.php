<script language="javascript" type="text/javascript" src="./js/edit_area/edit_area_full.js"></script>


<?php
include_once("common.php");
$p_path = p_path_from_full($path);
?>


<div id="html-content">
    <iframe id="html-view" src="<?php echo ("download.php?p=" . $p_path . "&nodownload=1"); ?>" width="100%" height="100%" style="background-color:white; border: none; display:none;"></iframe>
    <div id="code-view" style="display:block; width:100%; height:100%;">
        <textarea readonly id="code-editor" style="display:block; width: 100%; height:100%;">
<?php
echo (file_get_contents($path));
?>
        </textarea>
    </div>
</div>
<div id="switcher" style="position:absolute; bottom:0px; right:0px; background-color: rgba(0,0,0,0.5);">
    <a href="#" onclick="viewCode()">View source</a>
    <a href="#" onclick="viewPage()">View page</a>
</div>

<script>
    function viewCode() {
        document.getElementById('html-view').style.display = 'none';
        document.getElementById('code-view').style.display = 'block';
    }

    function viewPage() {
        document.getElementById('html-view').style.display = 'block';
        document.getElementById('code-view').style.display = 'none';
    }
</script>

<script language="javascript" type="text/javascript">
    editAreaLoader.init({
        id: "code-editor",
        syntax: "html",
        start_highlight: true,
        is_editable: false,
        word_wrap: true,
        allow_toggle: true,
        allow_resize: false,
        load: "later"
    });

    setTimeout(() => viewPage(), 1000);
</script>