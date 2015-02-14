<?php /* Template_ 2.2.4 2012/01/16 16:41:20 /www/revu39/engine/view/V3.9/info/info.frame.htm 000004593 */ ?>
<div class="helplayer-info">
<?php if($TPL_VAR["type"]=="review1"){?>	
	<div class="title_guidereview1">
<?php }elseif($TPL_VAR["type"]=="review7"){?>
	<div class="title_guidereview7">
<?php }elseif($TPL_VAR["type"]=="cash1"){?>
	<div class="title_guidecash1">
<?php }elseif($TPL_VAR["type"]=="frontier1"){?>
	<div class="title_guidefrontier1">
<?php }elseif($TPL_VAR["type"]=="myrevu1"){?>
	<div class="title_guidemyrevu1">
<?php }elseif($TPL_VAR["type"]=="social1"){?>
	<div class="title_guidesocial1">
<?php }elseif($TPL_VAR["type"]=="social2"){?>
	<div class="title_guidesocial2">
<?php }else{?>
	<div>
<?php }?>	
		<div style="width:26px; height:26px; padding:23px 19px 0 0;" class="fr">
			<img src="/images/common/but/but_gb_xclose.gif" alt="닫기" title="닫기" onClick="parent.info.close('<?php echo $TPL_VAR["type"]?>')" class="btn" />
		</div>
	</div>

	<div class="clear"></div>
	
	<div class="helplayer-box">
<?php if($TPL_VAR["type"]=="review1"){?>
		<!-- 리뷰가이드1_블로그등록이란? -->
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/info/img1_guidereview1.gif" width="748" height="907" />
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/info/img1_guidereview2.gif" width="748" height="936" />
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/info/img1_guidereview3.gif" width="748"  height="624" />
<?php }elseif($TPL_VAR["type"]=="review7"){?>
		<!-- 리뷰가이드7_인기글이란 -->
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/info/img7_guidereview1.gif"  width="748" height="488" />
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/info/img7_guidereview2.gif"  width="748" height="406" />
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/info/img7_guidereview3.gif"  width="748" height="306" />
<?php }elseif($TPL_VAR["type"]=="cash1"){?>
		<div class="bg_guidecash1">
			<div style="width:125px; height:33px; padding:300px 0 0 338px;"><a href="http://revu.co.kr/myrevu/cash" target="_blank"><img src="/images/common/but/but_bb_revucash.gif" alt="캐쉬보러가기" title="캐쉬보러가기"/></a></div>
		</div>
		<img src="/images/info/img1_guidecash2.gif"  width="748" height="346"/>
		<div style="width:160px; height:30px;padding-left:72px;">
			<a href="http://www.revu.co.kr/review/best" target="_blank"><img src="/images/common/but/but_gb_bestreview.gif" width="160" height="30" alt="주간베스트리뷰보러가기" title="주간베스트리뷰보러가기" /></a>
		</div>
		<img src="/images/info/img1_guidecash3.gif"  width="748" height="109"/>
		<div style="width:129px; height:30px;padding-left:72px;">
			<a href="http://www.revu.co.kr/frontier" target="_blank"><img src="/images/common/but/but_gb_frontier.gif" width="129" height="30" alt="프론티어보러가기" title="프론티어보러가기"/></a>
		</div>
		<img src="/images/info/img1_guidecash4.gif"  width="748" height="225"/>
		<div style="width:148px; height:30px;padding-left:72px;">
			<a href="http://www.revu.co.kr/myrevu/cash.withdraw" target="_blank"><img src="/images/common/but/but_gb_revucash.gif" width="148" height="30" alt="캐쉬지급신청하러가기" title="캐쉬지급신청하러가기" /></a>
		</div>
		<img src="/images/info/img1_guidecash5.gif"  width="748" height="453"/>
<?php }elseif($TPL_VAR["type"]=="frontier1"){?>
		<div class="bg_guidefrontier1">
			<div style="width:114px; height:33px;padding:400px 0 0 310px;"><a href="http://revu.co.kr/frontier" target="_blank"><img src="/images/common/but/but_bb_frontier.gif" alt="프론티어보러가기" title="프론티어보러가기"/></a></div> 
		</div>
		<img src="/images/info/img1_guidefrotier2.gif"  width="748" height="507"/>
<?php }elseif($TPL_VAR["type"]=="myrevu1"){?>
		<img src="/images/info/img1_guidemyrevu1.gif" width="748" height="525" />
		<img src="/images/info/img1_guidemyrevu2.gif" width="748" height="705" />
		<img src="/images/info/img1_guidemyrevu3.gif" width="748" height="575" />
<?php }elseif($TPL_VAR["type"]=="social1"){?>
		<img src="/images/info/img1_guidesocial1_1.gif" width="748" height="486" />
		<img src="/images/info/img1_guidesocial1_2.gif" width="748" height="643" />
		<img src="/images/info/img1_guidesocial1_3.gif" width="748" height="552" />
<?php }elseif($TPL_VAR["type"]=="social2"){?>		
		<img src="/images/info/img1_guidesocial2_1.gif" width="748" height="543" />
		<img src="/images/info/img1_guidesocial2_2.gif" width="748" height="452" />
		<img src="/images/info/img1_guidesocial2_3.gif" width="748" height="722" />
<?php }else{?>
<?php }?>
	</div>
</div>