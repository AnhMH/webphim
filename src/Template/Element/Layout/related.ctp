<?php if (!empty($movies)): ?>
<div class="widget-title clear-top">
    <div class="title up">Có thể bạn muốn xem</div>
</div>
<div class="widget-body">
    <ul class="list-film">
        <?php foreach ($movies as $v): ?>
        <li>
            <div class="poster">
                <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL;?>/videos/detail/<?php echo $v['slug'];?>">
                    <img alt="<?php echo $v['name'];?>" src="<?php echo $v['image'];?>">
                </a>
                <span class="mli-eps"><span><?php echo !empty($v['last_episode']) ? $v['last_episode'] : 'HD';?></span></span>
            </div>
            <div class="name">
                <h4>
                    <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL;?>/videos/detail/<?php echo $v['slug'];?>"><?php echo $v['name'];?></a>
                </h4>
                <dfn><?php echo $v['name'];?></dfn>
            </div>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
