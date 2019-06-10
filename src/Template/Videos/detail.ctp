<div class="wrapper home container">
    <div class="main">
        <div class="breadcrumb">
            <div class="item">
                <a href="http://autofb.localhost">
                    <span>Trang chủ</span>
                </a>
            </div>
            <div class="item">
                <a href="http://autofb.localhost/danh-sach/Anime">
                    <span>Anime</span>
                </a>
            </div>
            <div href="http://autofb.localhost/phim/ame-iro-cocoa-side-g" title="Ame-iro Cocoa: Side G" class="item">
                <span>Ame-iro Cocoa: Side G</span>
            </div>
            <div class="item">
                <span>Tập 1</span>
            </div>
        </div>

        <div id="media">
            <div class="player-wrapper">
                <script type="text/javascript" src="<?php echo $BASE_URL; ?>/js/jwplayer.js"></script>
                <div id="moviePlayer"></div>
                <script>
                    jwplayer("moviePlayer").setup({
                        "file": "http://techslides.com/demos/sample-videos/small.mp4",
                        "height": '100%',
                        "width": '100%',
                    });
                </script>
                <div class="controls" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
                    <a target="_blank" href="<?php echo $BASE_URL; ?>"><div class="download"><i></i><span>Download</span></div></a>
                    <div class="light"><i></i></div>
                    <div class="autonext active"><i></i></div>
                    <div class="toggle-size playermini" data-on="Thu nhỏ" data-off="Phóng to">
                        <i class="fa fa-exchange"></i> <span>Phóng to</span>
                    </div>

                </div>
            </div>
            <div class="main-controls">
                <div class="server-list" style="margin-left: 0px !important;">
                    <div class="server-wrapper">
                        <h3 class="watch">Danh sách tập phim</h3>
                        <div class="server" data-type="watch">
                            <label>Server chính (Animehay)</label>
                            <ul class="episodes">
                                <li>
                                    <a class="active" id="ep_1" title="Xem Tập 1" href="http://autofb.localhost/xem/ame-iro-cocoa-side-g/1" data-id="1">1</a>
                                </li>	                    
                                <li>
                                    <a class="" id="ep_2" title="Xem Tập 2" href="http://autofb.localhost/xem/ame-iro-cocoa-side-g/2" data-id="2">2</a>
                                </li>                  
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="widget info">
                <div class="widget-title clear-top">
                    <div class="tabs" data-target=".widget-body .content">
                        <div class="tab active" data-name="content"><span>Bình luận về phim</span></div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="content" data-name="content">
                        <div data-numposts="5" data-order-by="reverse_time" colorscheme="dark" data-colorscheme="dark" data-width="100%" width="100%" class="fb-comments" data-href="<?php echo $BASE_URL;?>" data-numposts="50"></div>
                    </div>
                </div> 
                <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.2&appId=2074563556000505&autoLogAppEvents=1"></script>
            </div>
            <div id="fb-root"></div>
        </div>
    </div>

    <?php echo $this->element('Layout/siderbar'); ?>
</div>
