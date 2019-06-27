<div class="widget hotest">
    <div class="container">
        <div class="items">
            <?php if (!empty($sliders)): ?>
                <?php foreach ($sliders as $v): ?>
                <div class="item">
                    <div class="poster">
                        <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL.'/videos/detail/'.$v['slug'];?>">
                            <img alt="<?php echo $v['name'];?>" src="<?php echo $v['image'];?>">
                        </a>
                    </div>
                    <div class="status"><?php echo !empty($v['last_episode']) ? $v['last_episode'] : 'HD';?></div>
                    <div class="info">
                        <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL.'/videos/detail/'.$v['slug'];?>"><?php echo $v['name'];?></a>
                        <dfn><?php echo $v['name'];?></dfn>
                    </div>
                    <!--<i class="dub"></i>-->
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>