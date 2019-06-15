<div id="header">
    <div class="container">
        <div class="fixed">
            <i class="menu-trigger"></i>
            <a id="logo-nhandz" href="<?php echo $BASE_URL;?>" title="Anivsub - Xem anime online miễn phí chất lượng cao"><span><b>ANIVSUB</b>.<t>NET</t></span></a>
        </div>
        <div class="search-wapper">
            <form method="GET" action="<?php echo $BASE_URL;?>/videos/search" class="style2" id="search">
                <input type="text" class="keyword" name="s" placeholder="Search..." autocomplete="off">
                <input type="submit" class="submit" value="Search" title="Bấm nhẹ">
            </form>
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
                <a href="<?php echo $BASE_URL;?>/cates/detail/<?php echo $c['slug'];?>" title="<?php echo $c['name'];?>"><?php echo $c['name'];?></a>
            </li>
            <?php endforeach; ?>
        <?php endif; ?>
        
    </ul>
</div>
