<div id="header">
    <div class="container">
        <div class="fixed">
            <i class="menu-trigger"></i>
            <a id="logo-nhandz" href="http://autofb.localhost" title="Anivsub - Xem anime online miễn phí chất lượng cao"><span><b>ANIVSUB</b>.<t>NET</t></span></a>
        </div>
        <div class="search-wapper">
            <form method="post" onsubmit="return false;" action class="style2" id="search">
                <input type="text" class="keyword" name="keyword" placeholder="Gõ tên phim, diễn viên cần tìm..." autocomplete="off">
                <input type="submit" class="submit" value="Tìm" title="Bấm nhẹ">
            </form>
        </div>
        <div class="box-favorite">
            <div class="toggle"><i></i> Box phim</div>
            <div class="list"></div>
        </div>
        <div class="request-film">
            <a rel="nofollow" href="https://goo.gl/QeJjXk" target="_blank"><span ><i></i> Yêu cầu phim</span></a>
        </div>
        <div class="user">
            <a rel="nofollow" href="javascript:alert('Chức năng đang được hoàn thiện. Bạn vui lòng thử lại sau !')" class="btn btn-login">Đăng nhập</a>
            <a rel="nofollow" href="javascript:alert('Chức năng đang được hoàn thiện. Bạn vui lòng thử lại sau !')" class="register">Chưa có tài khoản ?<span>Đăng ký ngay<i></i></span></a>
        </div>
    </div>
</div>
<div id="menu">
    <ul class="container">
        <li class="active home">
            <a href="<?php echo $BASE_URL;?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
        </li>
        <?php if (!empty($_countries)): ?>
            <?php foreach ($_countries as $c): ?>
            <li>
                <a href="<?php echo $BASE_URL;?>/cate/<?php echo $c['slug'];?>" title="<?php echo $c['name'];?>"><?php echo $c['name'];?></a>
            </li>
            <?php endforeach; ?>
        <?php endif; ?>
        
    </ul>
</div>
