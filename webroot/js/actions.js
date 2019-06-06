$(document).ready(function(){
	// Menu mobile
	$("#header .fixed .menu-trigger").click(function(){
		var jPM = $.jPanelMenu({
		menu: '#menu',
		trigger: '.menu-trigger',
		duration: 300
		});
		jPM.on();
	});
	/*==Đăng Nhập==*/
	$('.btn-login').click(function(){
		$('.popup.login').css("display", "block");
		$('.popup.login').css("margin-left", "-200px");
	});
	$('.request-film').click(function(){
		$('.popup.request-film').css("display", "block");
		$('.popup.request-film').css("margin-top", "-300px");
	});
	/*==Auto Chuyển Tập==*/
	$('.autonext').click(function(){
		var $this = $(this);
		if($this.hasClass('active')){
			$this.removeClass('active');
            $this.attr('title','Tự chuyển tập: ON');

		}else{
			$this.addClass('active');
			$this.attr('title','Tự chuyển tập: OFF');
		}
	});

    /*==Phóng To==*/
    if (!resizePlayer) var resizePlayer = false;
    $('.toggle-size').on('click', function() {
        var resizePlayeron = $(this).attr("data-on");
        var resizePlayeroff = $(this).attr("data-off");
        if (resizePlayer == false) {
            var newWidth = 979;
            var largeSize = {
                'width': newWidth,
                'height': Math.ceil(newWidth * 9 / 16)
            };
            jQuery('.breadcrumb').animate({
                'width': largeSize.width
            });
            jQuery('.sidebar').animate({
                marginTop: '1020px'
            });
            jQuery('.player').animate({
                width: largeSize.width,
                height: largeSize.height
            });
            jQuery('#media, #player-vtv, #NhanPlay').animate({
                width: largeSize.width,
            });
            jQuery('.main-controls').animate({
                marginTop: 20
            });
            $('html, body').animate({
                scrollTop: $(".breadcrumb, .controls").offset().top
            }, 1000);
            $("div.toggle-size.playermini span").html(resizePlayeron);
            resizePlayer = true
        } else{
            var newWidth = 666
            $(".player").css('width', '100%');
            jQuery('#media, #player-vtv, #NhanPlay').animate({
                "width": "100%"
            });
            jQuery('.player').animate({
                height: Math.ceil(newWidth * 9 / 16)
            });
            jQuery('.sidebar').animate({
                marginTop: 0
            });
            jQuery('.breadcrumb').animate({
                'width': '100%'
            });
            $('html, body').animate({
                scrollTop: $(".breadcrumb").offset().top
            }, 1000);
            $("div.toggle-size.playermini span").html(resizePlayeroff);
            resizePlayer = false
        }
        return false
    });
    /*==Bật Đèn==*/
    $(".light").click(function(){
        var $this = $(this);
        var $overlay = '<div id="background_lamp"></div>';
        if($this.hasClass('off')){
            $this.removeClass('off');
            $this.attr('title','Tắt đèn');
            $("#background_lamp").remove();
        }else{
            $this.addClass('off');
            $this.attr('title','Bật đèn');
            $('body').append($overlay);
        }
        $('html, body').animate({
            scrollTop: $(".breadcrumb").offset().top
        }, 1000);
    });

	/*==Tab home==*/
	$(".sidebar .tabs .tab").click(function(){
		$(".sidebar .tabs .tab").removeClass("active");
		$(this).addClass("active");
		var data_name = $(this).attr("data-name");
		if(data_name == 'le'){
			target_class = '#le';
			target_class_last = '#bo';
		}else if(data_name == 'bo'){
			target_class = '#bo';
			target_class_last = '#le';
		}
		$(".sidebar .widget-body .content").removeClass("active");
		$(".sidebar .widget-body .content").removeClass("hide");
		$(target_class).addClass("active");
		$(target_class_last).addClass("hide");
	});
	$(".widget.update .tabs .tab").click(function(){
		$(".widget.update .tabs .tab").removeClass("active");
		$(this).addClass("active");
		var data_name = $(this).attr("data-name");
		if(data_name == 'all'){
			target_class = '#all';
			target_class_last = '#movies';
			target_class_last_2 = '#serials';
		}else if(data_name == 'movies'){
			target_class = '#movies';
			target_class_last = '#all';
			target_class_last_2 = '#serials';
		}else if(data_name == 'serials'){
			target_class = '#serials';
			target_class_last = '#all';
			target_class_last_2 = '#movies';
		}
		$(".widget.update .widget-body .content").removeClass("active");
		$(".widget.update .widget-body .content").removeClass("hide");
		$(target_class).addClass("active");
		$(target_class_last).addClass("hide");
		$(target_class_last_2).addClass("hide");
	});
	$(".widget-title .xtabs .tab").click(function(){
		$(".widget-title .xtabs .tab").removeClass("active");
		$(this).addClass("active");
		var data_name = $(this).attr("data-name");
		if(data_name == 'new'){
			target_class = '#new';
			target_class_last = '#completed';
		}else if(data_name == 'completed'){
			target_class = '#completed';
			target_class_last = '#new';
		}
		$(".widget.serial-list .item").removeClass("active");
		$(".widget.serial-list .item").removeClass("hide");
		$(target_class).addClass("active");
		$(target_class_last).addClass("hide");
	});
	var fixKeyword = function(str) {
				str = str.toLowerCase();
				return str;
			}
			
	$('#search').submit(function() {
		var keywordObj = $(this).find('input[name=keyword]')[0];
		if (typeof keywordObj != 'undefined' && keywordObj != null) {
			var keyword = $(keywordObj).val();
			keyword = fixKeyword(keyword);
			keyword = $.trim(keyword);
			if (keyword == '') {
				$(keywordObj).focus();
				return false;
			}
			window.location.replace('/tim-kiem-phim/' + keyword + '');
		}
	})

    var timer = null;

    function suggesstionFunc() {
        $.ajax({
            url: "/suggest",
            data: {
                keyword: $(".keyword").val()
            }
        }).done(function (data) {
            $("#suggestions").html(data).show();
        });
    }

    $('.search-wapper .keyword').blur(function (event) {
        setTimeout("$('#suggestions').fadeOut(50);", 300);
    });
    $('.search-wapper .keyword').keyup(function (e) {
        if (e.keyCode == 38 || e.keyCode == 40 || e.keyCode == 13) {
            var allItem = $('#suggestions li a');
            var activeItem = $('#suggestions li a.active');
            var totalItem = allItem.size();
            var firstItem = allItem.eq(0);
            var lastItem = allItem.eq(totalItem - 1);
            var idx = allItem.index(activeItem);

            if (!totalItem) {
                return;
            }
            switch (e.keyCode) {
                case 38:
                    if (idx == -1) {
                        lastItem.addClass('active');
                    } else {
                        var prevItem = allItem.eq(idx - 1);
                        activeItem.removeClass('active');
                        prevItem.addClass('active');
                    }
                    break;
                case 40:
                    if (idx == -1) {
                        firstItem.addClass('active');
                    } else if (idx == (totalItem - 1)) {
                        // Item cuoi cung
                        activeItem.removeClass('active');
                        firstItem.addClass('active');
                    } else {
                        var nextItem = allItem.eq(idx + 1);
                        activeItem.removeClass('active');
                        nextItem.addClass('active');
                    }

                    break;
                case 13:
                    if (idx >= 0 && activeItem.attr('href') != "") {
                        $(location).attr('href', activeItem.attr('href'));
                    } else {
                        return true;
                    }
            }
            return false;
        } else {
            var timerCallback = function () {
                //suggesstionFunc();
            };
            clearTimeout(timer);
            timer = setTimeout(timerCallback, 200);
        }

    });
});