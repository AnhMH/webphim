<?php 
echo $this->element('Layout/sliders', array(
    'sliders' => $movies
)); 
?>
<div class="wrapper home container">
    <div class="main">
        <div class="widget update">
            <div class="widget-title">
                <!--<h3 class="title">Phim mới cập nhật</h3>-->
            </div>

            <div class="widget-body">
                <div class="content" id="all" data-name="all">
                    <ul class="list-film">
                        <?php if (!empty($movies)): ?>
                            <?php foreach ($movies as $v): ?>
                            <li class="nhan-anime">
                                <div class="poster">
                                    <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL.'/'.$v['slug'];?>">
                                        <img alt="<?php echo $v['name'];?>" src="<?php echo $v['image'];?>">
                                    </a>
                                    <span class="mli-eps"><span><?php echo $v['last_episode'];?></span></span>
                                </div>
                                <div class="name">
                                    <h4>
                                        <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL.'/'.$v['slug'];?>"><?php echo $v['name'];?></a>
                                    </h4>
                                    <dfn><?php echo $v['name'];?></dfn>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                    <script type="text/javascript" src="http://autofb.localhost/assets/js/loadmore.js"></script>
                </div>
            </div>
        </div>
    </div>
    
    <?php echo $this->element('Layout/siderbar');?>
</div>
