$(document).ready( function() {	
	$('#logo').bind({ click: function(){ layout.initMenu(); common.redirect('/'); } });
	$('#top-mmenu1').bind({ mouseover: function(){layout.overMenu(1);}, click: function(){common.setCookie('cookieMMenu','1',1); common.deleteCookie('cookieSMenu',1); common.redirect('/review'); } });
	$('#top-mmenu2').bind({ mouseover: function(){layout.overMenu(2);}, click: function(){common.setCookie('cookieMMenu','2',1); common.deleteCookie('cookieSMenu',1); common.redirect('/thema');} });
	$('#top-mmenu3').bind({ mouseover: function(){layout.overMenu(3);}, click: function(){common.setCookie('cookieMMenu','3',1); common.deleteCookie('cookieSMenu',1); common.redirect('/frontier');} });
	$('#top-mmenu4').bind({ mouseover: function(){layout.overMenu(4);}, click: function(){common.setCookie('cookieMMenu','4',1); common.deleteCookie('cookieSMenu',1); common.redirect('/myrevu');} });	
	$('#top-smenu11').bind({ mouseover: function(){layout.overSubmenu(1,1);}, click: function(){common.setCookie('cookieSMenu','11',1); common.redirect('/review/list');} });
	$('#top-smenu12').bind({ mouseover: function(){layout.overSubmenu(1,2);}, click: function(){common.setCookie('cookieSMenu','12',1); common.redirect('/review/list/1/11005');} });
	$('#top-smenu13').bind({ mouseover: function(){layout.overSubmenu(1,3);}, click: function(){common.setCookie('cookieSMenu','13',1); common.redirect('/review/list/1/13');} });
	$('#top-smenu14').bind({ mouseover: function(){layout.overSubmenu(1,4);}, click: function(){common.setCookie('cookieSMenu','14',1); common.redirect('/review/list/1/12016');} });
	$('#top-smenu15').bind({ mouseover: function(){layout.overSubmenu(1,5);}, click: function(){common.setCookie('cookieSMenu','15',1); common.redirect('/review/list/1/11010');} });
	$('#top-smenu16').bind({ mouseover: function(){layout.overSubmenu(1,6);}, click: function(){common.setCookie('cookieSMenu','16',1); common.redirect('/review/list/1/12017');} });
	$('#top-smenu17').bind({ mouseover: function(){layout.overSubmenu(1,7);}, click: function(){common.setCookie('cookieSMenu','17',1); common.redirect('/review/list/1/10');} });
	$('#top-smenu18').bind({ mouseover: function(){layout.overSubmenu(1,8);}, click: function(){common.setCookie('cookieSMenu','18',1); common.redirect('/review/list/1/14008');} });
	$('#top-smenu19').bind({ mouseover: function(){layout.overSubmenu(1,9);}, click: function(){common.setCookie('cookieSMenu','19',1); common.redirect('/review/best');} });
	$('#top-smenu110').bind({ mouseover: function(){layout.overSubmenu(1,10);}, click: function(){common.setCookie('cookieSMenu','110',1); common.redirect('/review/frontier');} });	
	$('#top-smenu31').bind({ mouseover: function(){layout.overSubmenu(3,1);}, click: function(){common.setCookie('cookieSMenu','31',1); common.redirect('/frontier');} }); //모집중인 프론티어
	$('#top-smenu32').bind({ mouseover: function(){layout.overSubmenu(3,2);}, click: function(){common.setCookie('cookieSMenu','32',1); common.redirect('/frontier/inglist');} }); //리뷰등록중인 프론티어
	$('#top-smenu33').bind({ mouseover: function(){layout.overSubmenu(3,3);}, click: function(){common.setCookie('cookieSMenu','33',1); common.redirect('/frontier/endlist');} }); //종료된 프론티어
	$('#top-smenu34').bind({ mouseover: function(){layout.overSubmenu(3,4);}, click: function(){common.setCookie('cookieSMenu','34',1); common.redirect('/frontier/alliance');} });	 //제휴문의
	$('#top-smenu41').bind({ mouseover: function(){layout.overSubmenu(4,1);}, click: function(){common.setCookie('cookieSMenu','41',1); common.redirect('/myrevu/review');} });
	$('#top-smenu42').bind({ mouseover: function(){layout.overSubmenu(4,2);}, click: function(){common.setCookie('cookieSMenu','42',1); common.redirect('/myrevu/talk');} });
	$('#top-smenu43').bind({ mouseover: function(){layout.overSubmenu(4,3);}, click: function(){common.setCookie('cookieSMenu','43',1); common.redirect('/myrevu/blog');} });
	$('#top-smenu44').bind({ mouseover: function(){layout.overSubmenu(4,4);}, click: function(){common.setCookie('cookieSMenu','44',1); common.redirect('/myrevu/friend');} });
	$('#top-smenu45').bind({ mouseover: function(){layout.overSubmenu(4,5);}, click: function(){common.setCookie('cookieSMenu','45',1); common.redirect('/myrevu/frontier');} });
	$('#top-smenu46').bind({ mouseover: function(){layout.overSubmenu(4,6);}, click: function(){common.setCookie('cookieSMenu','46',1); common.redirect('/myrevu/cash');} });
	$('#top-smenu47').bind({ mouseover: function(){layout.overSubmenu(4,7);}, click: function(){common.setCookie('cookieSMenu','47',1); common.redirect('/myrevu/info');} });	
	$('#footer-family-combobox').bind('click', function() { $('#footer-family-layer').toggle('fast', function() {}); });
	$('#footer-cate-view-on').bind('click', function() { 
		$('#footer-cate-layer').toggle('fast', function() {});
		$('#footer-cate-off').hide();
		$('#footer-cate-on').show(); 
	});
	$('#footer-cate-view-off').bind('click', function() { 
		$('#footer-cate-layer').toggle('fast', function() {});		
		$('#footer-cate-on').hide(); 
		$('#footer-cate-off').show();
	});
	layout.showMenu();	
	//$('#keywordSearchBtn').bind('click', function() { common.dialog('키워드검색', '현재 준비중입니다.') });
});

var layout = {
	overMenu: function(num) {
		var length = $('#top-mmenu').children('li').size();
		for (var i=1; i<=length; i++) {
			var obj = $("#top-mmenu" + i);
			if (i == num) {
				obj.removeClass("menu-off" + i).addClass("menu-on" + i);				
			} else {
				obj.removeClass("menu-on" + i).addClass("menu-off" + i);				
			}
		}
		this.showSubmenu(num, length);
	},
	showSubmenu: function(num, length) {
		for (var i=1; i <= length; i++) {
			if (i == num) $("#top-smenu" + i).show();
			else $("#top-smenu" + i).hide();
		}
	},
	overSubmenu: function(num1, num2) {
		var length = $('#top-smenu'+num1).children('li').size();
		for (var i=1; i<=length; i++) {
			var obj = $("#top-smenu" + num1 + i);
			if (i == num2) {				
				obj.removeClass("smenu-off" + num1 + i).addClass("smenu-on" + num1 + i);				
			} else { 
				obj.removeClass("smenu-on" + num1 + i).addClass("smenu-off" + num1 + i);				
			}
		}
	},	
	initMenu: function() {
		common.deleteCookie('cookieMMenu',1);
		common.deleteCookie('cookieSMenu',1);
		this.showMenu();
	},	
	showMenu: function() {
		var _cookieMMenu = common.getCookie('cookieMMenu');
		var _cookieSMenu = common.getCookie('cookieSMenu');
		if(_cookieSMenu != false) {
			layout.overMenu(_cookieSMenu.substring(0,1)); 
			layout.overSubmenu(_cookieSMenu.substring(0,1), _cookieSMenu.substring(1));	
		} else {
			if(_cookieMMenu != false) layout.overMenu(_cookieMMenu); 
		}
	}
};