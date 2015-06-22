
var reveal_tab = "<div class='reveal_tab'><div>+</div></div>";
var container = "<div id='sub_menu' class='menu'></div>";
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
	$('#sub_menu').slideToggle();
}