$("#sidebar ul.nav li a.hasChild").click(function(){
    var obj = $(this);
    var child_ul = obj.next();
    var siblingsChildUl = obj.parent().siblings().children('ul');
    if(siblingsChildUl.hasClass('nav-sub'))
    {
        siblingsChildUl.parent().children('a').removeClass('selected');
        siblingsChildUl.addClass('nav-sub');
        siblingsChildUl.prev().children('span').removeClass('caret').addClass('right-caret');
    }
    obj.parent().children('a').addClass('selected');
    child_ul.removeClass('nav-sub');
    obj.children(':last').removeClass('right-caret').addClass('caret');
   
});