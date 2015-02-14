<?php /* Template_ 2.2.4 2011/11/18 10:10:59 /www/revu39/engine/view/V3.9/frontier/frontier.entrywinner.layer.htm 000001862 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript">

        function copyHtml(text) {
            if( window.clipboardData && clipboardData.setData )
            {
             
             clipboardData.setData("Text", text);
             alert("복사완료");
            }
        }

</script> 


<!-- 당첨자팝업 /사이즈500가변 -->

<div class="pop_frontier_box">당첨자는 <font color='blue'><?php echo $TPL_VAR["cnt"]?></font>명 입니다.
<div class="pop_frontier_tbox">
<ul>
<li class="pop_frontier_title1">
<div class="pop_frontier_titlebox1 gray_d_text"><?php echo $TPL_VAR["subject"]?>&nbsp;&nbsp;&nbsp;</div>
<div  class="fr" style="width:19px; height:26px; padding-bottom:9px;"><!-- <img src="/images/common/but/but_xclose.gif" align="right" alt="닫기" title="닫기" onclick="common.closeLayer('entrylayer')"> --></div>
</li>
<li class="pb25"></li>
<!-- 이벤트일때는 / img_event_winner 로 변경 -->
<li class="img_frontier_winner"></li>
<li class="pb25"></li>
<li class="pop_winner_box">
<!-- 당첨자 명단 테이블 -->
<table width="400" border="0" cellspacing="0" cellpadding="0"  class="gray_d_text">
  <tr>
  
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
    <td class="pop_winner_tableline"><?php echo $TPL_V1["nickname"]?></td>

<?php if($TPL_I1% 4== 3){?>
	</tr>	<tr>
<?php }?>

<?php }}?>
  </tr>
</table>
</li>
<li class="pb25"></li>
<li class="img_bancode"></li>
<li class="pb25">
<div class="bancode_box"><?php echo $TPL_VAR["bannercode"]?></div>
</li>
<li style="width:448px; height:30px; text-align:center;"><?php echo $TPL_VAR["codecopy"]?></li>
</ul>
</div>
</div>