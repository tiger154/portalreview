<?php /* Template_ 2.2.4 2011/11/29 16:26:25 /www/revu39/engine/view/V3.9/manager/manager.review.best.htm 000002018 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.review.js"></script>
<script type="text/javascript">
var wno_now=<?php echo $TPL_VAR["wno"]?>; 
var wno_prev=<?php echo $TPL_VAR["wno_prev"]?>;
</script>
<h2>베스트리뷰 목록</h2>
<hr>
<table>
	<tr>
		<td width="440" valign="top">
			<ul>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<li style="height:30px;">
<?php if($TPL_VAR["wno"]==$TPL_V1["wno"]){?>	
				<strong><font color='red'><?php echo $TPL_V1["sdate"]?>일 ~ <?php echo $TPL_V1["edate"]?>일</font></strong>
<?php }elseif($TPL_VAR["wno_prev"]==$TPL_V1["wno"]){?>
				<strong><font color='blue'><?php echo $TPL_V1["sdate"]?>일 ~ <?php echo $TPL_V1["edate"]?>일</font></strong>
<?php }else{?>
				<?php echo $TPL_V1["sdate"]?>일 ~ <?php echo $TPL_V1["edate"]?>일
<?php }?>
				
				
<?php if($TPL_VAR["wno"]<=$TPL_V1["wno"]){?>				
				<input type="button" value="리뷰후보선정" onClick="mngreview.list(<?php echo $TPL_V1["wno"]?>, 'candlist');" />
<?php }elseif($TPL_VAR["wno_prev"]==$TPL_V1["wno"]){?>
				<input type="button" value="베스트리뷰" onClick="mngreview.list(<?php echo $TPL_V1["wno"]?>, 'list');" />
				<input type="button" value="추천중인리뷰" onClick="mngreview.list(<?php echo $TPL_V1["wno"]?>, 'votelist');" />
<?php }else{?>
				<input type="button" value="베스트리뷰" onClick="mngreview.list(<?php echo $TPL_V1["wno"]?>, 'list');" />
				<input type="button" value="리뷰후보" onClick="mngreview.list(<?php echo $TPL_V1["wno"]?>, 'votelist');" />
<?php }?>
				</li>
<?php }}?>
			</ul>
			<center><?php echo $TPL_VAR["link"]?></center>
		</td>
		<td valign="top">
			<h2>리뷰리스트</h2>
			<div id="reviewList"></div>
		</td>
	</tr>
</table>
<hr>