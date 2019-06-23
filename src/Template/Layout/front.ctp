<?php
$webTitle = 'NovelasTodayTV | Series Y Novelas Turcas';
$webDescription = 'NovelasTodayTV | Series Y Novelas Turcas';
$webKeyword = 'novelas, series';
$webImage = '';
$_description = !empty($pageDescription) ? strip_tags($pageDescription) : $webDescription;
$_keyword = !empty($pageKeyword) ? $pageKeyword : $webKeyword;
$_title = !empty($pageTitle) ? $pageTitle : $webTitle;
$_image = !empty($pageImage) ? $pageImage : $webImage;
$current_url = $BASE_URL;
$time = time();
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $_title; ?></title>
        <!-- for-mobile-apps -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="description" itemprop="description" content="<?php echo $_description; ?>" />
        <meta name="keywords" content="<?php echo $_keyword; ?>">

        <meta property="og:title" content="<?php echo $_title; ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php echo $current_url; ?>" />
        <meta property="og:image" content="<?php echo $_image; ?>" />
        <meta property="og:site_name" content="<?php echo $webTitle; ?>" />
        <meta property="og:description" content="<?php echo $_description; ?>" />

        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="<?php echo $_title; ?>" />
        <meta name="twitter:description" content="<?php echo $_description; ?>" />
        <meta name="twitter:image" content="<?php echo $_image; ?>" />
        <meta itemprop="image" content="<?php echo $_image; ?>" />

        <meta name="generator" content="NovelasTodayTV" />

        <link rel='dns-prefetch' href='//fonts.googleapis.com' />
        <link rel='dns-prefetch' href='//s.w.org' />

        <link rel="canonical" href="<?php echo $current_url; ?>" />

        <link type="text/css" href="<?php echo $BASE_URL;?>/css/style.css?<?php echo $time;?>" rel="stylesheet"/>
        <link type="text/css" href="<?php echo $BASE_URL;?>/css/main.css?<?php echo $time;?>" rel="stylesheet"/>
        <link type="text/css" href="<?php echo $BASE_URL;?>/css/owl.carousel.css" rel="stylesheet"/>
        <script type="text/javascript" src="<?php echo $BASE_URL;?>/js/jquery-2.2.3.min.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL;?>/js/actions.js?<?php echo $time;?>"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL;?>/js/functions.js"></script>
        <script type="text/javascript" src="<?php echo $BASE_URL;?>/js/owl.carousel.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
        <link rel="icon" href="https://i.imgur.com/SQ5D74B.png" />
          <!--<meta name="google-site-verification" content="<?php echo $google ?>"/>-->
        <script type="text/javascript" src="<?php echo $BASE_URL;?>/js/jquery.jpanelmenu.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".items").owlCarousel({
                    items: 5,
                    itemsTablet: [700, 3],
                    itemsMobile: [479, 2],
                    scrollPerPage: true,
                    lazyLoad: true,
                    navigation: true, // Show next and prev buttons
                    slideSpeed: 800,
                    paginationSpeed: 400,
                    stopOnHover: true,
                    pagination: false,
                    autoPlay: 8000,
                    navigationText: ['<div class="control prev"></div>', '<div class="control next"></div>']
                });
            });
        </script>
        <style>
            #hide_float_left a {
                background: #01AEF0;
                padding: 0px;
                color: #FFF;
                font-size: 15px;
            }
        </style>
    </head>

    <body id="<?php echo $controller . '-' . $action; ?>">
        <div id="fptplay-container" style="position: relative;">
            <?php echo $this->element('Layout/header');?>
            <?= $this->fetch('content') ?>
            <?php echo $this->element('Layout/footer');?>
        </div>
    </body>
</html>
