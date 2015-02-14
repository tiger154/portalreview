<?php /* Template_ 2.2.4 2012/06/07 19:03:08 /www/revu39/engine/view/V3.9/_global/top.htm 000003211 */ ?>
<!-- top 메뉴영역 시작 -->
<script>
function checkId(form) {
  form.action = "/search";
  form.submit();
}
</script>

<div id="top-logo">
<?php if(date('Ymd')>='20120102'){?>
	<img src="<?php echo $TPL_VAR["IMAGES"]?>/include/gnb/gnb_logo.gif" id="logo" alt="레뷰" title="레뷰" class="btn" />
<?php }else{?>
	<img src="<?php echo $TPL_VAR["IMAGES"]?>/include/gnb/gnb_logo_new2012.gif" id="logo" alt="레뷰" title="레뷰" class="btn" />
<?php }?>
</div>
<div id="top-menu">		
	<ul id="top-mmenu">
    	<li id="top-mmenu1" class="menu-off1"></li>
    	<li id="top-mmenu2" class="menu-off2" style="display:none;"></li>
    	<li id="top-mmenu3" class="menu-off3"></li>
    	<li id="top-mmenu4" class="menu-off4"></li>
    </ul>
    <div class="clear"></div>
</div>
<div id="top-search">
	<ul>
		<li class="top-link">
			<a href="http://blog.revu.co.kr/category/RevU 공지사항" target="_blank"><img src="<?php echo $TPL_VAR["IMAGES"]?>/include/gnb/gnb_notice.gif" alt="공지사항" title="공지사항" /></a>
			<div class="clear"></div>
		</li>
		
		<form name="form" method="get" action="/search">
	 		<li class="top-keyword">
				<input name="kwd" type="text" class="input_gnb" id="keyword" /><a href="javascript:checkId(this.form);" >
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/include/gnb/search_but.gif" id="keywordSearchBtn" alt="검색" title="검색" class="btn" style="margin:0 0 -1px -4px;" /></a>
			</li>
		</form>
		

		<!--li class="top-keyword">
			<input name="keyword" type="text" class="input_gnb" id="keyword" /><a href="#">
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/include/gnb/search_but.gif" id="keywordSearchBtn" alt="검색" title="검색" class="btn" style="margin:0 0 -1px -4px;" /></a>
		</li-->
	</ul>
	<div class="clear"></div>
</div>	
<div class="clear"></div>
<div id="top-submenu">
	<ul id="top-smenu1">			
		<li id="top-smenu11" class="smenu-off11"></li>
		<li id="top-smenu12" class="smenu-off12"></li>
		<li id="top-smenu13" class="smenu-off13"></li>
		<li id="top-smenu14" class="smenu-off14"></li>
		<li id="top-smenu15" class="smenu-off15"></li>
		<li id="top-smenu16" class="smenu-off16"></li>
		<li id="top-smenu17" class="smenu-off17"></li>
		<li id="top-smenu18" class="smenu-off18"></li>
		<li id="top-smenu19" class="smenu-off19"></li>
		<li id="top-smenu110" class="smenu-off110"></li>
	</ul>
	<ul id="top-smenu2">			
		<li id="top-smenu21" class="smenu-off21"></li>
	</ul>
	<ul id="top-smenu3">			
		<li id="top-smenu31" class="smenu-off31"></li>
		<li id="top-smenu32" class="smenu-off32"></li>
		<li id="top-smenu33" class="smenu-off33"></li>
		<li id="top-smenu34" class="smenu-off34"></li>
	</ul>		
	<ul id="top-smenu4">			
		<li id="top-smenu41" class="smenu-off41"></li>
		<li id="top-smenu42" class="smenu-off42"></li>
		<li id="top-smenu43" class="smenu-off43"></li>
		<li id="top-smenu44" class="smenu-off44"></li>
		<li id="top-smenu45" class="smenu-off45"></li>
		<li id="top-smenu46" class="smenu-off46"></li>
		<li id="top-smenu47" class="smenu-off47"></li>
	</ul>
</div>
<div class="clear"></div>
<!-- top 메뉴영역 끝 -->