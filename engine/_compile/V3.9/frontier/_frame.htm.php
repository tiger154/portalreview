<?php /* Template_ 2.2.4 2012/01/25 15:10:15 /www/revu39/engine/view/V3.9/frontier/_frame.htm 000005859 */ 
$TPL_notice_1=empty($TPL_VAR["notice"])||!is_array($TPL_VAR["notice"])?0:count($TPL_VAR["notice"]);
$TPL_right_toplist_1=empty($TPL_VAR["right_toplist"])||!is_array($TPL_VAR["right_toplist"])?0:count($TPL_VAR["right_toplist"]);
$TPL_right_mainlist_1=empty($TPL_VAR["right_mainlist"])||!is_array($TPL_VAR["right_mainlist"])?0:count($TPL_VAR["right_mainlist"]);
$TPL_frontierbannerlist_1=empty($TPL_VAR["frontierbannerlist"])||!is_array($TPL_VAR["frontierbannerlist"])?0:count($TPL_VAR["frontierbannerlist"]);?>
<style>
.clsBannerScreen {overflow: hidden;position: relative;height: 150px;width: 224px; border:1px solid #e1e1e1; cursor:pointer; clear:both;}
.clsBannerScreen .images {position:absolute; display:none; }
ul, li {list-style:none; margin:0; padding:0; font-size:10pt; }
</style>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/jquery.banner.js"></script>
<script type="text/javascript">
<!--
$(function() {
	$("#image_list_1").jQBanner({	//롤링을 할 영역의 ID 값
		nWidth:224,					//영역의 width
		nHeight:90,				//영역의 height
		nCount:<?php echo $TPL_VAR["frontierbannerlistcnt"]?>,					//돌아갈 이미지 개수
		isActType:"up",				//움직일 방향 (left, right, up, down)
		nOrderNo:1,					//초기 이미지
		nDelay:5000					//롤링 시간 타임 (1000 = 1초)
		/*isBtnType:"li"*/			//라벨(버튼 타입) - 여기는 안쓰임
		}
	);
	
});
//-->
</script>

<div id="container"><?php $this->print_("container",$TPL_SCP,1);?></div>
<div id="sidebar"><?php $this->print_("sidebar",$TPL_SCP,1);?>

	
<!-- 외부배너 225172 -->
<?php if($TPL_VAR["banner_right_img"]!="N"){?>
	<div class="s_banner_225172"><?php echo $TPL_VAR["banner_right_link"]?><img src="<?php echo $TPL_VAR["banner_right_img"]?>" alt="레뷰 광고로 링크됩니다." title="레뷰 광고로 링크됩니다." width='225' height="172"></a></div>
<?php }?>
<!-- 공지사항 -->
	<div class="s_notice_box">
		<ul>
			<li class="s_notice_title">
				<a href="http://<?php echo $TPL_VAR["conf"]["BLOGDOMAIN"]?>" target="_blank"><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_more.gif" align="right" alt="more" title="more" class="pb15"/></a>
			</li>
			<li style="height:10px;"></li>
<?php if($TPL_notice_1){foreach($TPL_VAR["notice"] as $TPL_V1){?>
			<li class="s_text_line">
				<a href="<?php echo $TPL_V1["url"]?>" target="_blank" class="common_text"> <?php echo $TPL_V1["title"]?></a>
			</li>
			<li class="gray11_l_text"><?php echo $TPL_V1["pubdate"]?></li>
			<li class="dot18_line"></li>
<?php }}?>
			<li class="s_space_line"><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/space.gif"  height="1px;"/></li>
		</ul>
	</div>
		<!-- 현재모집중인 프론티어 리뷰 -->
		<div class="s_frontier2_box">
		  <ul>
			<li class="s_frontier2_title"></li>
			<li style="height:15px;"></li>
		   <li>
			<!--  한 묶음 시작-->
<?php if($TPL_right_toplist_1){foreach($TPL_VAR["right_toplist"] as $TPL_V1){?>   
			<div class="s_frontier2_textbox">
			  <ul>
				<!-- 프론티어 110110 이미지 비례축소 -->
				<li class="s_frontier_thum fl"><a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/"><img src="<?php echo $TPL_V1["toplistimg"]?>"  alt="이 프론티어 상세보기로 이동" title="프론티어 상세보기로 이동"  width="66px;" height="66px;"/></a></li>
				<li class="s_frontier_text1 fl"><a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/"><span class="gray_stitle"><font color="#999933"><?php echo $TPL_V1["subject"]?></font></span></a></li>
				 <li class="s_frontier_text2 fr"><span class="gray11_l_text">모집인원 :</span><span class="gray11_d_text"> <?php echo $TPL_V1["peoplelimit"]?></span></li>
				<li class="s_frontier_text2 fr"><span class="gray11_l_text">체험단발표 :</span><span class="gray11_d_text"> <?php echo $TPL_V1["notice_date"]?></span></li>
			  </ul>
			</div>
<?php }}?>
			</li>
			<!--  한 묶음 끝-->
			<li class="clear"></li>
			<li class="gray21_line"></li>
			
<?php if($TPL_right_mainlist_1){foreach($TPL_VAR["right_mainlist"] as $TPL_V1){?>   
			<li class="s_text_line"><a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/" target="_blank" class="common_text"><?php echo $TPL_V1["subject"]?></a></li>
			<li class="dot18_line"></li>
<?php }}?>
		  </ul>
		</div>
		<!-- 프론티어배너 225090 -->
<?php if($TPL_VAR["frontierbannerlistcnt"]>"1"){?>
		<div id="image_list_1">
		<div class="clsBannerScreen">
<?php if($TPL_frontierbannerlist_1){foreach($TPL_VAR["frontierbannerlist"] as $TPL_V1){?>   
		<div class="images">
		<a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/"><img src="<?php echo $TPL_V1["bannerimg"]?>" alt="프론티어이름" title="프론티어이름"  width="224" height="90"></a>
		</div>
<?php }}?>
		</div>		
		</div>
<?php }else{?>
<?php if($TPL_frontierbannerlist_1){foreach($TPL_VAR["frontierbannerlist"] as $TPL_V1){?>   
		<div class="images">
		<a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/"><img src="<?php echo $TPL_V1["bannerimg"]?>" alt="프론티어이름" title="프론티어이름"  width="224" height="90"></a>
		</div>
<?php }}?>
<?php }?>		
		<div style="margin-bottom:40px;"></div>

		<!-- 제휴문의배너 225102 -->
		<div class="s_banner_revu"><a href="/frontier/alliance" target="_blank"><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/banner/banner_revu_225102.gif" alt="제휴문의" title="제휴문의" /></a></div>
		
		<img src="/images/common/banner/banner_powerblog_224090.gif" alt="파워블로거지원" title="파워블로거지원" onClick="common.redirect('/info/powerblog')" class="btn" />
</div>

</body>