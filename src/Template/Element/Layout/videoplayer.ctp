<?php
$types = array(
    '.mp4',
    'iframe',
    'embed'
);
$type = 'mp4';
foreach ($types as $t) {
    if (strpos($video, $t) !== false) {
        $type = $t;
        break;
    }
}
?>
<div class="player-wrapper">
    <?php if ($type == '.mp4'): ?>
    <script type="text/javascript" src="<?php echo $BASE_URL; ?>/js/jwplayer.js"></script>
    <div id="moviePlayer"></div>
    <script>
        jwplayer("moviePlayer").setup({
            sources: [
            {file: "<?php echo $video; ?>",type: 'mp4',label: '1080'}
            ],
            width: '100%',
            height: '100%',
            title: '',
            controls: true,
            displaytitle: false,
            aspectratio: '16:9',
            fullscreen: 'true',
            primary: 'html5',
            mute: false,
            provider: 'http'
        });
    </script>
    <?php endif; ?>
    
    <?php if (in_array($type, array('iframe'))): ?>
    <div id="moviePlayer"><?php echo $video;?></div>
    <style>
        iframe {
            width: 100% !important;
        }
    </style>
    <?php endif;?>
    
    <?php if ($type == 'embed'): ?>
    <div id="moviePlayer"><iframe src="<?php echo $video;?>" style="width: 100%; min-height:500px"></iframe></div>
    <?php endif; ?>
    
<!--                <div class="controls" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
                    <a target="_blank" href="<?php echo $BASE_URL; ?>"><div class="download"><i></i><span>Download</span></div></a>
                    <div class="light"><i></i></div>
                    <div class="autonext active"><i></i></div>
                    <div class="toggle-size playermini" data-on="Thu nhỏ" data-off="Phóng to">
                        <i class="fa fa-exchange"></i> <span>Phóng to</span>
                    </div>

                </div>-->
</div>
