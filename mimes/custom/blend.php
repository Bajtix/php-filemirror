<?php
include_once("mimes/type.common.php");
$p_path = p_path_from_full($path);

$output = cm_getcachepath($path) . ".fbx";
$command = "blender \"{$path}\" -b --python-expr \"import bpy;bpy.ops.export_scene.fbx(filepath='{$output}', use_selection=False)\"";

if (cm_getcache($path) == null) {
    $val = exec($command);
    if (!$val) {
        show_file_error("File couldn't be converted", "The file could not be converted to FBX. Please check if <b>blender</b> is installed on the server.", "", "");
    } else
        cm_addcache($path, $output, $cacheduration);
}
?>


<script type="text/javascript" src="./js/o3dv/o3dv.min.js"></script>
<div class="online_3d_viewer" style="width: 100%; height: 100%;" model="<?php echo ("download.php?p=" . p_path_from_full($output)); ?>">
</div>

<script>
    OV.SetExternalLibLocation('./js/o3dv/libs');
    OV.Init3DViewerElements(); // init all viewers on the page
</script>