<div id="flashgame" width="100%" height="100%">

</div>

<script src="https://unpkg.com/@ruffle-rs/ruffle"></script>

<script>
    <?php
    include_once("type.common.php");
    $pt = p_path_from_full($path);
    ?>

    window.RufflePlayer = window.RufflePlayer || {};
    window.addEventListener("load", (event) => {
        const ruffle = window.RufflePlayer.newest();
        const player = ruffle.createPlayer();
        const container = document.getElementById("flashgame");
        container.appendChild(player);
        player.load("download.php?p=<?php echo ($pt); ?>");
    });
</script>