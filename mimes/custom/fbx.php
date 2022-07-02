<?php
include_once("mimes/type.common.php");
$p_path = p_path_from_full($path);
?>


<script type="text/javascript" src="./js/o3dv/o3dv.min.js"></script>
<div class="online_3d_viewer" style="width: 100%; height: 100%;" model="<?php echo ("download.php?p=" . p_path_from_full($path)); ?>">
</div>

<script>
    OV.SetExternalLibLocation('./js/o3dv/libs');
    OV.Init3DViewerElements(); // init all viewers on the page
</script>