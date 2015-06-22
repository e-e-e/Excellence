
var reveal_tab = "<div class='reveal-tab'><div class='reveal-button>+</div></div>";
var container = "<div id='sub_menu'></div>";
$(document).ready(function () {
	console.log('READY');
	init();
});

function init () {
	var r = $(reveal_tab).insertAfter('#p-navigation').click(menu_show);
	var c = $(container).insertAfter(r);
	$('#mw-navigation').children('div.mw-portlet').not('#p-navigation').appendTo(c);
	c.hide();
}

function menu_show () {
	console.log('click');
	var t = $(this).find('.reveal-button');
	if (t.text() === '+')
		t.text('-');
	else 
		t.text('+');
	$('#sub_menu').slideToggle();
}