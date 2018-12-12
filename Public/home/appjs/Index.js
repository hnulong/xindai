var config={}
function getYuegong (str){
	// 重新获取money存储设置其他值
	var money = parseInt(str);
	var benjin=0;
	xianshi();
}
function xianshi () {
    $.each($(".timeBtn"), function(index, val) {
    	var spanval = $("#timeSpanVal_"+index).html();
    	if(spanval == definamonth){
    		$('#'+index+'m').addClass('act').siblings('.timeBtn').removeClass('act');
    	}
    });
}
function changeslider(isPlus) {
    if (isPlus) {
        //加
        scale = parseInt($('.jslider-pointer-to').css('left')) + STEP;
        scale = (scale >= 100) ? '100' : parseInt(scale);
        scale= scale+'%'
        $('.jslider div:nth-child(3)').css('left', scale);
        $('#tap1 i:nth-child(3)').css('width', scale);
        SliderSingle1.slider('value', MINMONEY, (parseInt(nowmoney.money) + 100))
        reset();
    } else {
        //减
        scale = parseInt($('.jslider-pointer-to').css('left')) - STEP;
        scale = (scale <= 0) ? '0' : parseInt(scale);
        scale= scale+'%'
        $('.jslider div:nth-child(3)').css('left', scale);
        $('#tap1 i:nth-child(3)').css('width', scale);
        SliderSingle1.slider('value', MINMONEY, (parseInt(nowmoney.money) - 100))
        reset()
    }
}
function reset() {
	var money = $('#money_str').html();
	money = new Number(money).toFixed(2);
	var month = parseInt($('.timeBtn.act span').html());
	var fuwufei = money * feilv[month - 1] / 100;
	fuwufei = fuwufei.toFixed(2);
	var tmpval = feilv[month - 1] / 30; //利息
	tmpval = new Number(tmpval).toFixed(2);
	$("#rixi").html(tmpval);
	var benjin = money;
	//benjin = benjin.toFixed(2);
	$('#benjin').html('¥' + benjin);
	var yuegong = new Number(benjin);
	yuegong = yuegong.toFixed(2);
	$('#yuegong').html(yuegong);
	$('#rixi').html(fuwufei);
	var fee = yuegong-fuwufei;
    fee = fee.toFixed(2);
    $('#fuwufei').html(fee);
    $('#total').html('¥' + yuegong);
    nowmoney['money'] = money;
    $("#order_money").val(money);
    nowmoney['month'] = month;
    $("#order_month").val(month);
    nowmoney['fuwufei'] = fuwufei;
    nowmoney['benjin'] = benjin;
    nowmoney['yuegong'] = yuegong;
    nowmoney['total'] = parseFloat(benjin) + parseFloat(fuwufei);
}
$(function () {
        SliderSingle1.slider({
            from: MINMONEY,
            to: MAXMONEY,
            step: 100,
            round: 0,
            dimension: '',
            skin: "round",
            onstatechange: function (a) {
                // console.log(a);
                var t = a.split(';');
                t[1] = parseInt(t[1]).toFixed(2);
                $('#money_str').html(t[1]);
                getYuegong(t[1]);
                reset();
            },
            callback: function (a) {
                if (num % 2 == 0) {
                    $(".jslider-pointer").css({
                        animation: 'myfirst .5s',
                        '-webkit-animation': 'myfirst .5s'
                    });
                } else {
                    $(".jslider-pointer").css({
                        animation: 'mysecond .5s',
                        '-webkit-animation': 'mysecond .5s'
                    })
                }
                num++
            }
        });
        var flag = null;
        //减按钮
        $('#subtract').click(function () {
            if (!flag) {
                if (parseInt(nowmoney.money) > MINMONEY) {
                    changeslider();
                } else {
                    $(".subtractmore").fadeIn('slow')
                    flag = setTimeout(showTime, 2000);
                    function showTime() {
                        $(".subtractmore").fadeOut('slow')
                        flag = null;
                    }
                }
            }
        });
        //加按钮
        $('#plus').click(function () {
            if (!flag) {
                if (parseInt(nowmoney.money) < MAXMONEY) {
                    changeslider(true);
                } else {
                    $(".plusmore").fadeIn('slow')
                    flag = setTimeout(showTime, 2000);
                    function showTime() {
                        $(".plusmore").fadeOut('slow')
                        flag = null;
                    }
                }
            }

        });
        //随机生成 jslider-pointer 样式
        function pointer() {
            var random = Math.ceil(Math.random() * 3);
            switch (random) {
                case 1:
                    $(".jslider-pointer").css('background-image', "url("+PublicUrl+"/home/imgs/coin.png)");
                    break;
                case 2:
                    $(".jslider-pointer").css('background-image', "url("+PublicUrl+"/home/imgs/pig.png)");
                    break;
            }
        }
        pointer();
        //借款期限
        $('.timeBtn').click(function () {
            $(this).addClass('act').siblings('.timeBtn').removeClass('act');
            reset()
            return false
        });
        

    	middle33();
	    function middle33(){
	        var h = $('#deowin33').height();
	        var t = -h/2 + "px";
	        $('#deowin33').css('marginTop',t);
	    }
    	$('#winbtn4').click(function(){
        	$('#deowin4').hide();
        	$('#mask3').hide();
        	$('#deowin4 iframe').attr('src',''); 
      	});
    	middle1();
    	function middle1(){
        	var h = $('#deowin4').height();
        	var t = -h/2 + "px";
        	$('#deowin4').css('marginTop',t);
    	}
    	$('#winbtn5').click(function(){
        	$('#deowin5').hide();
        	$('#mask3').hide();
        	$('#deowin5 iframe').attr('src',''); 
    	});
    	middle2();
    	function middle2(){
        	var h = $('#deowin5').height();
        	var t = -h/2 + "px";
        	$('#deowin5').css('marginTop',t);
    	}
    	//提示关闭
        $("#winbtn3").click(function() {
            $('#deowin31').hide();
            $('#mask3').hide();
        });
        middle();
        function middle() {
            var w = $('#deowin3').width();
            var h = w / 0.64;
            $('.deocon11').css('height', h);
            var t = -h / 2 + "px";
            $('#deowin3').css('marginTop', t);
        }
});