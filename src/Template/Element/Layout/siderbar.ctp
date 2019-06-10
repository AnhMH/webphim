<div class="sidebar">
    <?php if(!empty($_newMovies)): ?>
    <div class="widget chart">
        <div class="widget-title">
            <div class="title">Mới ra mắt</div>
        </div>
        <div class="widget-body">
            <div class="content active" id="le" data-name="le">
                <ul>
                    <?php foreach ($_newMovies as $v): ?>
                    <li>
                        <span><i class="fa fa-star" aria-hidden="true"></i></span>
                        <h5>
                            <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL.'/videos/detail/'.$v['slug'];?>"><?php echo $v['name'];?></a>
                        </h5>
                        <dfn><?php echo $v['name'];?></dfn>
                    </li>  
                    <?php endforeach; ?>                    
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if(!empty($_randomMovies)): ?>
    <div class="widget list-film"> 
        <div class="widget-title"> 
            <div class="title">Phim ngẫu nhiên</div> 
        </div>
        <div class="widget-body">
            <ul>
                <li>
                    <span class="status"><?php echo $v['pro_year'];?></span>
                    <img alt="<?php echo $v['name'];?>" src="<?php echo $v['image'];?>">
                    <a title="<?php echo $v['name'];?>" href="<?php echo $BASE_URL.'/videos/detail/'.$v['slug'];?>"><?php echo $v['name'];?></a>
                    <dfn><?php echo $v['name'];?></dfn>
                    <dfn><?php echo date('Y-m-d', $v['updated']);?></dfn>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
</div>

