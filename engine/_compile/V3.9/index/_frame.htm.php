<?php /* Template_ 2.2.4 2012/12/11 15:46:31 /www/revu39/engine/view/V3.9/index/_frame.htm 000007983 */ 
$TPL_notice_1=empty($TPL_VAR["notice"])||!is_array($TPL_VAR["notice"])?0:count($TPL_VAR["notice"]);
$TPL_chart1_1=empty($TPL_VAR["chart1"])||!is_array($TPL_VAR["chart1"])?0:count($TPL_VAR["chart1"]);
$TPL_chart2_1=empty($TPL_VAR["chart2"])||!is_array($TPL_VAR["chart2"])?0:count($TPL_VAR["chart2"]);
$TPL_frontierbannerlist_1=empty($TPL_VAR["frontierbannerlist"])||!is_array($TPL_VAR["frontierbannerlist"])?0:count($TPL_VAR["frontierbannerlist"]);?>
<style>
.clsBannerScreen {overflow: hidden;position: relative;height: 150px;width: 224px; border:1px solid #e1e1e1; cursor:pointer; clear:both;}
.clsBannerScreen .images {position:absolute; display:none; }
ul, li {list-style:none; margin:0; padding:0; font-size:10pt; }
</style>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/jquery.banner.js"></script>
<script type="text/javascript">
var DDOOMMAAIINN = '';
</script>
<script type="text/javascript">
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

</script>
<div id="container"><?php $this->print_("container",$TPL_SCP,1);?></div>
<div id="sidebar">
<?php $this->print_("sidebar",$TPL_SCP,1);?>


<!-- 외부배너 225172 -->
<?php if($TPL_VAR["banner_right_img"]!="N"){?>
	<div class="s_banner_225172"><?php echo $TPL_VAR["banner_right_link"]?><img src="<?php echo $TPL_VAR["banner_right_img"]?>" alt="레뷰 광고로 링크됩니다."></a></div>
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
	
	<!-- 리뷰차트-->
	<div class="s_chart_box">
		<ul>
			<li class="s_chart_title"></li>
			<li class="s_chart_tab1"><img src="<?php echo $TPL_VAR["IMAGES"]?>/include/side/tab_manyhiton.gif" id="chartRecomTab1" alt="추천 많은 순" title="추천 많은 순" class="btn" /></li>
			<li class="s_chart_tab2"><img src="<?php echo $TPL_VAR["IMAGES"]?>/include/side/tab_newhitoff.gif" id="chartRecomTab2" alt="방금 추천 순" title="방금 추천 순" class="btn"/></li>
			<li class="clear"></li>
		</ul>		
		<ul id="chartRecomList1">
			<li>
				<!-- 한묶음 시작 -->
<?php if($TPL_chart1_1){foreach($TPL_VAR["chart1"] as $TPL_V1){?>
				<div class="s_chart_list">
					<ul>
						<!-- 리뷰이미지 비례축소  / 없으면 thum_list_dummy.gif 대체-->
						<li class="s_profile_thum fl">
							<img src="<?php echo $TPL_V1["thumbimage110_url"]?>" width="45px;" height="45px;"/>
						</li>
						<li class="s_chart_text1l">
							<!-- 추천 스펙트럼 조절 -->
							<div><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/bg/bg_chart.gif" width="<?php echo $TPL_V1["size"]?>%" height="20px"/></div>
						</li>
						<li class="s_chart_text1r">
							<!-- 추천 카운터 표시 -->
							<div class="red11_text"><span class="s_chart_text1r_red"><?php echo $TPL_V1["recom_cnt"]?></span></div>
						</li>
						<li class="s_chart_text2 common11_text">
							<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["title"]?></a>
						</li>
					</ul>
				</div>
<?php }}?>
				<!-- 한묶음 끝 -->
			</li>
		</ul>	
		<ul id="chartRecomList2">
			<li>
				<!-- 한묶음 시작 -->
<?php if($TPL_chart2_1){foreach($TPL_VAR["chart2"] as $TPL_V1){?>
				<div class="s_chart_list">
					<ul>
						<!-- 리뷰이미지 비례축소  / 없으면 thum_list_dummy.gif 대체-->
						<li class="s_profile_thum fl">
							<img src="<?php echo $TPL_V1["thumbimage110_url"]?>" width="45px;" height="45px;"/>
						</li>
						<li class="s_chart_text1l">
							<!-- 추천 스펙트럼 조절 -->
							<div><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/bg/bg_chart.gif" width="<?php echo $TPL_V1["size"]?>%" height="20px"/></div>
						</li>
						<li class="s_chart_text1r">
							<!-- 추천 카운터 표시 -->
							<div class="red11_text"><span class="s_chart_text1r_red"><?php echo $TPL_V1["recom_cnt"]?></span></div>
						</li>
						<li class="s_chart_text2 common11_text">
							<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["title"]?></a>
						</li>
					</ul>
				</div>
<?php }}?>
				<!-- 한묶음 끝 -->
			</li>
		</ul>
	</div>

	<!-- 모집중인 프론티어 배너 롤링(프론티어 배너) -->
<?php if($TPL_VAR["frontierbannerlistcnt"]>"1"){?>
	<div id="image_list_1">
	<div class="clsBannerScreen">
<?php if($TPL_frontierbannerlist_1){foreach($TPL_VAR["frontierbannerlist"] as $TPL_V1){?>   
	<div class="images">
	<a href="/frontier/detailview/1/<?php echo $TPL_V1["frno"]?>/"><img src="<?php echo $TPL_V1["bannerimg"]?>" alt="프론티어 상세보기로 이동" title="프론티어 상세보기로 이동"  width="224" height="90"></a>
	</div>
<?php }}?>
	</div>		
	</div>
<?php }else{?>
<?php if($TPL_frontierbannerlist_1){foreach($TPL_VAR["frontierbannerlist"] as $TPL_V1){?>   
	<div class="images">
	<a href="/frontier/detailview/1/<?php echo $TPL_V1["frno"]?>/"><img src="<?php echo $TPL_V1["bannerimg"]?>" alt="프론티어 상세보기로 이동" title="프론티어 상세보기로 이동"  width="224" height="90"></a>
	</div>
<?php }}?>
<?php }?>		
	<div style="margin-bottom:40px;"></div>
	<!-- 모집중인 프론티어 배너 롤링(프론티어 배너) //끝-->

	<!-- 레뷰연결배너 -->
	<div class="s_revuico_box">
		<div class="s_revuico_line1">
			<ul>
				<li class="fl pr10">
					<a href="http://www.facebook.com/revulove" target="_blank"><img src="/images/common/ico/ico_s_fb.gif" alt="레뷰페이스북" title="레뷰페이스북" /></a>
				</li>
				<li class="fl pr10">
					<a href="http://twitter.com/#!/revulove" target="_blank"><img src="/images/common/ico/ico_s_tw.gif" alt="레뷰트위터" title="레뷰트위터" /></a>
				</li>
				<li class="fl pr10">
					<a href="mailto:revu@revu.co.kr"><img src="/images/common/ico/ico_s_mail.gif" alt="레뷰메일" title="레뷰메일" /></a>
				</li>
				<li class="fl pr10">
					<a href="http://blog.revu.co.kr" target="_blank"><img src="/images/common/ico/ico_s_blog.gif" alt="레뷰블로그" title="레뷰블로그" /></a>
				</li>
				<li class="fl">
					<a href="http://blog.revu.co.kr/rss" target="_blank"><img src="/images/common/ico/ico_s_rss.gif" alt="레뷰RSS" title="레뷰RSS" /></a>
				</li>
			</ul>
		</div>
		<div class="s_revuico_line2">
			<a href="mailto:revu@revu.co.kr"><img src="/images/common/ico/ico_s_mail2.gif" alt="레뷰메일" title="레뷰메일" /></a>
		</div>
	</div>
	
	<img src="/images/common/banner/banner_powerblog_224090.gif" alt="파워블로거지원" title="파워블로거지원" onClick="common.redirect('/info/powerblog')" class="btn" />
</div>