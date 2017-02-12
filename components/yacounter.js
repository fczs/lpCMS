$(document).ready(function (){
    setTimeout(function (){
    if(typeof(yaCounterId) != "undefined")
        yaCounterId.reachGoal('minute');
    }, 60000);

    var scrollDownTrigger = false;
    $(document).scroll(function (){
        if( (!scrollDownTrigger) && ($(document).scrollTop() >= $(document).height() - $(window).height()*1.5) ){
            scrollDownTrigger = true;
        if(typeof(yaCounterId) != "undefined")
	yaCounterId.reachGoal('scrolldown');
        }

    });

    $("[data-yandex-target]").click(function (){
    if(typeof(yaCounterId) !== "undefined"){
        yaCounterId.reachGoal($(this).attr("data-yandex-target"));
    }
    });

    $("[data-yandex-target-submit]").submit(function (){
    if(typeof(yaCounterId) !== "undefined"){
        yaCounterId.reachGoal($(this).attr("data-yandex-target-submit"));
    }
    });
});
