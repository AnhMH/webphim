<?php echo $this->element('Layout/sliders'); ?>
<div class="wrapper home container">
    <div class="main">
        <div class="widget update">
            <div class="widget-title">
                <h3 class="title">Phim mới cập nhật</h3>
                <div class="tabs" data-target=".widget.update .widget-body .content">
                    <div class="tab active" data-name="all"><span>Tất cả anime</span></div>
                    <div class="tab" data-name="movies">
                        <span>Sắp chiếu</span>
                    </div>
                    <div class="tab" data-name="serials">
                        <span>Hentai</span>
                    </div>
                </div>
            </div>

            <div class="widget-body">
                <div class="content" id="all" data-name="all">
                    <ul class="list-film">
                        <li class="nhan-anime">
                            <div class="poster">
                                <a title="Một hôm, một nút ấn bí ẩn đột nhiên xuất hiện. Khi ấn, mọi người sẽ bị đưa đến một thế giới khác!! Ngoài ra, những người đến từ các thế giới khác nhau cũng tập trung tại đây…!?" href="/phim/isekai-quartet">
                                    <img alt="Isekai Quartet" src="https://i.imgur.com/sLdwOcI.jpg">
                                </a>
                                <span class="mli-eps">TẬP<i>4</i></span>
                            </div>
                            <div class="name">
                                <h4>
                                    <a title="Một hôm, một nút ấn bí ẩn đột nhiên xuất hiện. Khi ấn, mọi người sẽ bị đưa đến một thế giới khác!! Ngoài ra, những người đến từ các thế giới khác nhau cũng tập trung tại đây…!?" href="/phim/isekai-quartet">Isekai Quartet (2019)</a>
                                </h4>
                                <dfn>Isekai Quartet</dfn>
                            </div>
                        </li>
                    </ul>
                    <script type="text/javascript" src="http://autofb.localhost/assets/js/loadmore.js"></script>
                </div>
            </div>
        </div>
    </div>
    
    <?php echo $this->element('Layout/siderbar');?>
</div>
