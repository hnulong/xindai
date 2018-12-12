(function(win,doc,$){
    var maxGetCount = 150;
    var counter = 0;

    var dove = {
        pull:function(url,param,success,error,heartbeat){
            counter = 0
            var loopGet = function(){
                if(counter>maxGetCount){
                    error();
                    return;
                }
                win.setTimeout(function(){
                    counter++;
                    $.post(url,param,function(data) {
                        if(!success(data)){
                            loopGet();
                        }
                    });
                }, heartbeat|3000);
            }
            loopGet();
        },
        showCommonErrDiv:function(msg){
            $("#divCommonErr").css('display','block');
            dove.err('divCommon',msg);
        },
        hideCommonErrDiv:function(){
            $("#divCommonErr").css('display','none');
            dove.err('divCommon','');
        },
        err:function(id,msg) {
            $('#' + id).addClass('Input error');
            $('#' + id +'Err').html(msg);
        },
        ajaxSetup:function(timeoutUrl){
            $.ajaxSetup({
                complete:function(XMLHttpRequest){
                    var sessionstatus=XMLHttpRequest.getResponseHeader("sessionstatus");
                    if(sessionstatus=="timeout"){
                        win.location.replace(timeoutUrl);         //跳转到登录界面，待改进
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('.loding').hide();
                    dove.showCommonErrDiv("操作超时，请稍后重试。");

                }
            });
            return this;
        },
        bingEnter:function(c1,c2){
            $(doc).keydown(function(event){
                if(event.keyCode == 13){    //绑定回车
                    if($(".mask_box").is(':visible')){
                        c2();
                    }else{
                        c1();
                    }
                }
            });
        }
    };
    win.Dove = dove;
})(window,document,jQuery);
/**
 * Created by Shinelon on 2017/2/23.
 */
