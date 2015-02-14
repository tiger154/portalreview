<?php /* Template_ 2.2.4 2012/01/18 16:58:52 /www/revu39/engine/view/V3.9/myrevu/_frame.htm 000002881 */ 
$TPL_notice_1=empty($TPL_VAR["notice"])||!is_array($TPL_VAR["notice"])?0:count($TPL_VAR["notice"]);?>
<div id="container"><?php $this->print_("container",$TPL_SCP,1);?></div>
<div id="sidebar">
<?php $this->print_("sidebar",$TPL_SCP,1);?>

	<!-- 외부배너 225172 -->
<?php if($TPL_VAR["banner_right_img"]!="N"){?>
	
		<div class="s_banner_225172"><?php echo $TPL_VAR["banner_right_link"]?><img src="<?php echo $TPL_VAR["banner_right_img"]?>" alt="레뷰 광고로 링크됩니다." title="레뷰 광고로 링크됩니다." width='225' height="172"></a></div>
	
<?php }?>
	<!-- 공지사항 -->
	<div class="s_notice_box">
		<ul>
			<li class="s_notice_title">
				<a href="http://<?php echo $TPL_VAR["conf"]["BLOGDOMAIN"]?>" target="_blank"><img src="/images/common/ico/ico_more.gif" align="right" alt="more" title="more" class="pb15"/></a>
			</li>
			<li style="height:10px;"></li>
<?php if($TPL_notice_1){foreach($TPL_VAR["notice"] as $TPL_V1){?>
			<li class="s_text_line">
				<a href="<?php echo $TPL_V1["url"]?>" target="_blank" class="common_text"> <?php echo $TPL_V1["title"]?></a>
			</li>
			<li class="gray11_l_text"><?php echo $TPL_V1["pubdate"]?></li>
			<li class="dot18_line"></li>
<?php }}?>
			<li class="s_space_line"><img src="/images/common/space.gif"  height="1px;"/></li>
		</ul>
	</div>
	
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