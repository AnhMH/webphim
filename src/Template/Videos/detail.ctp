<div class="wrapper home container">
    <div class="main">
        <div class="breadcrumb">
            <div class="item">
                <a href="<?php echo $BASE_URL;?>">
                    <span>Home</span>
                </a>
            </div>
            <div href="<?php echo $BASE_URL;?>/videos/detail/<?php echo $data['slug'];?>" title="<?php echo $data['name'];?>" class="item">
                <span><?php echo $data['name'];?></span>
            </div>
<!--            <div class="item">
                <span>Tập 1</span>
            </div>-->
        </div>

        <div id="media">
            <?php echo $this->element('Layout/videoplayer', array('video' => $video));?>
            <div class="main-controls">
                <div class="server-list" style="margin-left: 0px !important;">
                    <div class="server-wrapper">
                        <h3 class="watch">Episodes</h3>
                        <div class="server" data-type="watch">
                            <ul class="episodes">
                                <?php foreach ($videos as $k => $v): ?>
                                <li><a class="<?php echo $server == $k ? 'active' : '';?>" href="<?php echo $BASE_URL;?>/videos/detail/<?php echo $data['slug'];?>?ep=<?php echo $ep;?>&s=<?php echo $k;?>">Server #<?php echo $k+1;?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <label>Episodes</label>
                            <ul class="episodes">
                                <?php if (!empty($episodes)): ?>
                                <?php foreach ($episodes as $e): ?>
                                <li>
                                    <a class="<?php echo !empty($ep) && $ep == $e['id'] ? 'active' : '';?>" title="<?php echo $e['name'];?>" href="<?php echo $BASE_URL;?>/videos/detail/<?php echo $data['slug'];?>?ep=<?php echo $e['id'];?>"><?php echo $e['name'];?></a>
                                </li>
                                <?php endforeach;?>
                                <?php endif; ?>   
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget info">
                <div class="widget-title clear-top">
                    <div class="tabs" data-target=".widget-body .content">
                        <div class="tab active" data-name="content"><span>Comments</span></div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="content" data-name="content">
                        <div data-numposts="5" data-order-by="reverse_time" colorscheme="dark" data-colorscheme="dark" data-width="100%" width="100%" class="fb-comments" data-href="<?php echo $BASE_URL;?>" data-numposts="50"></div>
                    </div>
                </div> 
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=2074563556000505&autoLogAppEvents=1"></script>
            </div>
            <div id="fb-root"></div>
            
            <?php echo $this->element('Layout/related', array('movies' => $_newMovies));?>
        </div>
    </div>

    <?php echo $this->element('Layout/siderbar'); ?>
</div>
