$(document).ready(function () {
	console.log('READY');
	init();
});

function init () {
	$('#mw-navigation').children('div').not('#p-navigation').click(menu_show);
}

function menu_show () {
	$(this).children('li').toggle();
}