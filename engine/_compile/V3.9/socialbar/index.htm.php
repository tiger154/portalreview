<?php /* Template_ 2.2.4 2012/08/24 23:00:17 /www/revu39/engine/view/V3.9/socialbar/index.htm 000007242 */ 
$TPL_talk_1=empty($TPL_VAR["talk"])||!is_array($TPL_VAR["talk"])?0:count($TPL_VAR["talk"]);?>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/api.js"></script>
<script>
//var iconType = "<?php echo $TPL_VAR["iconType"]?>"; 
var loginFlag = new Array();
var shortUrl = "<?php echo $TPL_VAR["shortUrl"]?>";
var reviewTitle = "<?php echo addslashes($TPL_VAR["review"]["title"])?>";
loginFlag['R'] = "<?php echo $TPL_VAR["login"]["R"]?>";
loginFlag['T'] = "<?php echo $TPL_VAR["login"]["T"]?>";
loginFlag['F'] = "<?php echo $TPL_VAR["login"]["F"]?>"; 
loginFlag['FFFF'] = "<?php echo $TPL_VAR["login"]["FFFF"]?>"; 
socialbar._tno = "<?php echo $TPL_VAR["tno"]?>";
socialbar._rno = "<?php echo $TPL_VAR["rno"]?>";
</script>
<div id="socialbar">
	<div class="content">
		<!-- 레뷰추천버튼 / 오버시class="bar_but_over"로 표시 -->
		<div id="recom_btn" class="recom_on btn">
			<div class="recom_box" onClick="<?php if($TPL_VAR["review"]["flag_cand"]==true){?>socialbar.candRecom(<?php echo $TPL_VAR["review"]["wno"]?>,<?php echo $TPL_VAR["review"]["rno"]?>);<?php }else{?>socialbar.recom(<?php echo $TPL_VAR["review"]["rno"]?>);<?php }?>">				
				<span id="recom_cnt"> <?php echo $TPL_VAR["review"]["recom_cnt"]?></span>
			</div>
		</div>
		<div id="review-position"></div>
		<div class="review">
			<ul>
				<li class="title">
					<span class="gray_d_text btn" onClick="socialbar.review(<?php echo $TPL_VAR["user"]["userno"]?>);" >
						<strong><?php echo $TPL_VAR["review"]["title"]?></strong>
					</span>
				</li>
				<li class="user">
<?php if($TPL_VAR["review"]["flag_best"]=="1"){?><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_bestreview.gif" alt="베스트리뷰" title="베스트리뷰" />&nbsp;<?php }?>
<?php if($TPL_VAR["user"]["flag_powerblog"]=="1"){?><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revupower.gif" alt="파워블로거" title="파워블로거" />&nbsp;<?php }?>
					<!--<span class="common11_text btn" onClick="context.load(<?php echo $TPL_VAR["user"]["userno"]?>);"><?php echo $TPL_VAR["user"]["nickname"]?></span>&nbsp;-->
					<a href="javascript:context.load(<?php echo $TPL_VAR["user"]["userno"]?>);"><?php echo $TPL_VAR["user"]["nickname"]?></a>&nbsp;
					<span class="gray11_l_text"> ㅣ&nbsp;<?php echo $TPL_VAR["review"]["regdate"]?>&nbsp;ㅣ&nbsp;<?php echo $TPL_VAR["review"]["catedesc"]?></span>
				</li>
			</ul>
		</div>
	</div>
	<div class="close">
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/socialbar/socialbar_close.gif" onClick="socialbar.close('<?php echo $TPL_VAR["review"]["url"]?>');" class="btn" alt="닫기" title="닫기" />
	</div>
	<div class="talk" id="talk-location">
		<!--소셜댓글 카운터 박스 -->
		<div class="talk_box">
			<ul>
				<li id="talk_cnt"><?php echo $TPL_VAR["review"]["talk_cnt"]?></li>
				<li>
					<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/space.gif" width="66" height="25" onClick="socialbar.viewTalk();" class="btn" alt="소셜토크" title="소셜토크"/>
				</li>
			</ul>
		</div>
		<!-- 소셜플러그인-->
		<div class="talk_textbox">
			<ul>
				<li class="talk_sns">
					<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_b_tweet.gif" onClick="socialbar.setTalk('T');" class="btn" />
					<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_b_facebook.gif" onClick="socialbar.setTalk('F');" class="btn" />
				</li>
				<li class="talk_msg">
					<span class="talk_msg_last">
						<strong>최신토크 : </strong><span id="talk-last" class="common11_text"></span>
					</span>
				</li>
			</ul>
		</div>
	</div>	
</div>

<div id="socialbar-talk">
	<div class="list_box">
		<div class="list_tbox">
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/socialbar/title_pop_social.gif" />
			<div class="fl">
				<textarea id="msg" onkeydown="common.setTextLimit('msg', 'msgnum', 150);" onkeypress="common.setTextLimit('msg', 'msgnum', 150);" class="msg"></textarea>
			</div>
			<div class="fl">				
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_big_reply.gif" onClick="socialbar.talk();" class="btn" alt="댓글쓰기" title="댓글쓰기" />
			</div>
			<div class="clear"></div>
			<div class="pa05">	
				<ul class="iconlist">
					<li class="fl">
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_check.png" id="checkR" class="check" />
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_R<?php if($TPL_VAR["login"]["R"]!=true){?>2<?php }?>.gif" id="iconR" onClick="socialbar.todoIcon('R');" class="w_space h_space btn" />						
					</li>
					<li class="fl">
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_check.png" id="checkT" class="check" />
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_T<?php if($TPL_VAR["login"]["T"]!=true){?>2<?php }?>.gif" id="iconT" onClick="socialbar.todoIcon('T');" class="w_space h_space btn" />
					</li>
					<li class="fl">
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_check.png" id="checkF" class="check" />
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_F<?php if($TPL_VAR["login"]["F"]!=true){?>2<?php }?>.gif" id="iconF" onClick="socialbar.todoIcon('F');" class="w_space h_space btn" />
					</li>
				</ul>
				<span class="gray11_l_text">
					<span id="msgnum">0</span>/150 byte 
					<a href="javascript:socialbar.logout();" class="w_space"><strong>전체로그아웃</strong></a>
				</span>
			</div>	
			<div class="pt05"></div>
			<div class="list">
				<table id="talk-list" width="370" border="0" cellspacing="0" cellpadding="0">
					<tbody>
					<tr>
						<td width="30" height="0"></td>
						<td width="340" height="0"></td>
					</tr>
<?php if($TPL_talk_1){foreach($TPL_VAR["talk"] as $TPL_V1){?>
					<tr id="talk<?php echo $TPL_V1["tno"]?>">
						<td align="center" class="line" valign="top">
							<img src="<?php echo $TPL_V1["icon"]?>" />
						</td>
						<td class="line">
							<div class="gray11_l_text text_overlay17">
								<?php echo $TPL_V1["ref"]?> <img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_del.gif" onClick="socialbar.deleteTalk(<?php echo $TPL_V1["tno"]?>);" class="btn" align="absmiddle" />
							</div>
							<div class="common11_text"><strong><?php echo $TPL_V1["talk"]?></strong></div>
						</td>
					</tr>
<?php }}?>
					</tbody>
				</table>
			</div>
<?php if($TPL_VAR["tno"]!=""){?>
			<div id="talk-more">
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_morebar.gif" onClick="socialbar.moreTalk();" class="btn" alt="더보기" title="더보기" />
			</div>
<?php }?>
		</div>
	</div>
	<div class="close">
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_g_arrowbox.gif" onClick="socialbar.closeTalk();" class="btn" alt="닫기" title="닫기" />
	</div>
</div>
<iframe id="socialbar-frame" name="socialbar-frame" width="100%" src="<?php echo $TPL_VAR["review"]["url"]?>" frameborder="0"></iframe>