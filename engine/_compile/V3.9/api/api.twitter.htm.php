<?php /* Template_ 2.2.4 2012/01/05 13:53:45 /www/revu39/engine/view/V3.9/api/api.twitter.htm 000003140 */ ?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/api.js"></script>
<style>
#api-twitter-box { padding:15px; width:570px; height:240px; }
#api-twitter-box .top { padding-bottom:8px; width:570px; height:35px; border-bottom:#999999 solid 2px; margin-bottom:30px;}
#api-twitter-box .logo { width:82px; height:35px; padding-right:88px; }
#api-twitter-box .nickname { width:310px; height:20px; text-align:right;padding:12px 0 3px 9px; }
#api-twitter-box .logout { width:60px; height:20px; text-align:right;padding:10px 0 0 9px; }
#api-twitter-box .textbox { margin-bottom:20px; width:570px; height:120px; }
#api-twitter-box .textarea { padding:8px; width:550px; height:100px; font-size:12px; color:#666666; line-height:1.4;border:#cccccc solid 1px; background:#ffffff; }
#api-twitter-box .tweetbtn { width:570px; height:22px; }
#api-twitter-box .tweetnum { width:200px; height:22px; }
</style>
<?php if($TPL_VAR["todo"]=="tweet"){?>
<div id="api-twitter-box">
	<div class="top">
		<div class="logo fl"><img src="/images/common/small_logo.gif" alt="레뷰" title="레뷰" /></div>
		<div class="nickname fl"><span class="gray_d_text"><strong><?php echo $TPL_VAR["name"]?></strong> 님 안녕하세요!</div>
	</div>
	<div class="clear"></div>
	<div class="textbox">
		<textarea id="reviewTweet" class="textarea" cols="60" row="8" 
		onKeyPress="common.setTextLimit('reviewTweet', 'reviewTweetNum', 150);" 
		onKeyDown="common.setTextLimit('reviewTweet', 'reviewTweetNum', 150);" ><?php echo $TPL_VAR["review"]["title"]?> <?php echo $TPL_VAR["bitlyData"]["url"]?></textarea>
	</div>
	<div class="tweetbtn">
		<div class="fl">
			<span class="gray_num"><span id="reviewTweetNum">0</span> / 150 Byte</span>
		</div>
		<div class="fr">
			<img src="/images/common/but/but_b_tweet.gif" onClick="twitter.tweetProc(<?php echo $TPL_VAR["review"]["rno"]?>);" class="btn" alt="tweet" title="tweet" />
			<img src="/images/common/but/but_g_close.gif" onClick="self.close();" class="btn" alt="close" title="close" />
		</div>
	</div>
</div>
<script>common.popupResize("api-twitter-box"); common.setTextLimit('reviewTweet', 'reviewTweetNum', 150);</script>

<!--
<div id="api-twitter-box">
	<div style="border:1px solid #FF0000;">
	<textarea id="reviewTweet" cols="60" row="8" 
	onKeyPress="common.setTextLimit('reviewTweet', 'reviewTweetNum', 140);" 
	onKeyDown="common.setTextLimit('reviewTweet', 'reviewTweetNum', 140);" ><?php echo $TPL_VAR["bitlyData"]["url"]?> <?php echo $TPL_VAR["review"]["title"]?></textarea><br />
	<input type="text" id="reviewTweetNum" size="4" value=0 readonly> / 140byte <br />
	<span id="reviewTweetNum"></span>/140byte <br />
	<input type="button" value="트윗" onClick="twitter.tweetProc(<?php echo $TPL_VAR["review"]["rno"]?>);" />
	<input type="button" value="닫기" onClick="self.close();" />
	<script>common.popupResize('api-twitter-box'); common.setTextLimit('reviewTweet', 'reviewTweetNum', 140);</script>
	</div>
</div>
-->
<?php }?>