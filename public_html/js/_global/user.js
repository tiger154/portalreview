$(document).ready( function() {	
});
var user = {
	showSubmenu: function(obj, num, length) {
		for (var i=1; i <= length; i++) {
			if (i == num) $("#top-smenu" + i).show();
			else $("#top-smenu" + i).hide();
		}
	},
	setHomePage: function(url) {
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);
	}
};