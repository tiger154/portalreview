<?php /* Template_ 2.2.4 2012/01/13 15:18:53 /www/revu39/engine/view/V3.9/blog/index.htm 000003145 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/myrevu.css" />

<!-- 타이틀라인 -->
<div class="title_line">
	<span class="title_nick"><?php echo $TPL_VAR["nickname"]?></span>&nbsp;&nbsp;<span class="title_text">님의 리뷰 입니다.</span>
</div>
<br />
<!-- 마이프렌즈 리스트 한묶음 시작  / 디폴트 10줄-->
<?php if($TPL_VAR["blog"]){?><span class="title_text"><?php echo $TPL_VAR["blog"]["name"]?>(<a href="<?php echo $TPL_VAR["blog"]["url"]?>" target="_blank"><?php echo $TPL_VAR["blog"]["url"]?></a>)</span><br /><br /><?php }?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<div class="review_list">

	<!-- 리뷰의 썸네일 110110이상일경우 잘라내기 -->
	<div class="thum110_box">
		<img src="<?php echo $TPL_V1["thumbimage_url"]?>" width="110" height="110" />
	</div>
	<!-- 블로그별 포스트 박스 시작 -->
	<div class="friend_text_box">
		<ul>
			<li style="width:426px; height:32px;">
				<div class="review_title_ico"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
				<div class="friend_title_line gray_title">
					<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a> 
				</div>
			</li>
			<li style="width:426px; height:24px;">
				<div class="friend_cate_name gray_d_text">
					<a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>)"><?php echo $TPL_V1["nickname"]?></a>&nbsp;
				</div>
				<div class="friend_cate_line gray11_l_text">
					<?php echo $TPL_V1["cate_desc"]?>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo $TPL_V1["regdate"]?>

				</div>
			</li>
			<li style="width:426px; height:54px;">
				<div class="friend_text"><?php echo $TPL_V1["content"]?></div>
			</li>
		</ul>
	</div>
	<!-- 블로그별 포스트 박스 끝 -->
	
	<!-- sns 박스 시작-->
	<div class="review_sns_box">
		<ul>
			<!-- 페이스북 버튼 삽입  / 보류 -->
			<li class="pt10" style="height:20px;"></li>
			<!-- 레뷰추천 버튼 삽입 / 최대999  -->
			<li class="pt20">
				<div class="revu_hit_box">
					<div class="revu_hit_boxl">
						<img src="/images/common/but/but_revuhit.gif" alt="추천" title="추천" class="btn" onClick="socialbar.recomView(<?php echo $TPL_V1["rno"]?>)"/>
					</div>
					<div class="revu_hit_boxr">
						<div class="revu_hit_text" style="display:block;">
							<span class="red11t_text"><?php echo $TPL_V1["recom_cnt"]?></span>
						</div>
					</div>
				</div>
			</li>
			<!-- 트워터 버튼 삽입 / 보류 -->
			<li class="pt10" ></li>
		</ul>
	</div>
	<!-- sns 박스 끝-->
	<div class="review_dot_line"></div>
</div>
<?php }}?>
<!-- 마이프렌즈 리스트 한묶음 끝 -->
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php if($TPL_VAR["cnt"]< 1){?> <center>등록된 리뷰가 없습니다.</center><?php }?>