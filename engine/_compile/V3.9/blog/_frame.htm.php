<?php /* Template_ 2.2.4 2011/11/09 17:49:06 /www/revu39/engine/view/V3.9/blog/_frame.htm 000001113 */ 
$TPL_notice_1=empty($TPL_VAR["notice"])||!is_array($TPL_VAR["notice"])?0:count($TPL_VAR["notice"]);?>
<div id="container"><?php $this->print_("container",$TPL_SCP,1);?></div>
<div id="sidebar">
<?php $this->print_("sidebar",$TPL_SCP,1);?>

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
</div>