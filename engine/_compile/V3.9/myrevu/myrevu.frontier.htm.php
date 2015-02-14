<?php /* Template_ 2.2.4 2012/10/11 16:37:25 /www/revu39/engine/view/V3.9/myrevu/myrevu.frontier.htm 000004279 */ 
$TPL_myfron_winlist_1=empty($TPL_VAR["myfron_winlist"])||!is_array($TPL_VAR["myfron_winlist"])?0:count($TPL_VAR["myfron_winlist"]);?>
<div id="sub_content ">
<div class="title_line gray_l_text"><img src="/images/myrevu/title_myfrontier.gif"  align="left"/></div>


<br>		
<iframe src="http://www.revu.co.kr/myrevu/frontier.slider" frameborder="0" width="100%" height="310" scrolling="no" align="center" name="iframe_test" align="center"></iframe>


<div class="clear"></div>
<div class="title_line gray_l_text"><img src="/images/myrevu/title_winfrontier.gif"  align="left"/></div>
<div class="frontier_cbox">
<?php if($TPL_myfron_winlist_1){foreach($TPL_VAR["myfron_winlist"] as $TPL_V1){?> 
	
	<!-- 리스트 묶음 박스 시작 / 디폴트 5줄 -->
	<div class="frontier_list">
			<!-- 프론티어 이미지 background 처리 -->
			<div class="thum110_box" style="background:url(<?php echo $TPL_V1["winimg"]?>) no-repeat; float:left; display:inline;"></div>
			<!-- 프론티어 내용 박스 -->
			<div class="frontier_myrevw_box" style="float:left; display:inline;">
					<div class="gray_title list_title_line"><a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/B"><?php echo $TPL_V1["subject"]?></a></div>
					<div class="list_count_line orange11_text">
<?php if($TPL_V1["reviewcnt"]< 1){?>
		
					<span style="text-decoration"><font color="#669966">등록리뷰없음</font></span>(<?php echo $TPL_V1["reviewcnt"]?>)</div>
<?php }else{?>
					<!-- <a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>//"><span style="text-decoration:underline;">리뷰 더보기</span></a> (<?php echo $TPL_V1["reviewcnt"]?>)</div> -->
					<span>등록 리뷰</span>(<?php echo $TPL_V1["reviewcnt"]?>)</div>
<?php }?>
					

					<div class="list_dday_line red11_text"><a href='javascript:reviewManager.setFrontier(<?php echo $TPL_V1["frno"]?>,"<?php echo $TPL_V1["subject"]?>");common.openCenterLayer("entrylayer2", -1, -1, 90);'><span style="text-decoration:underline;">리뷰등록 </span></a>D-<?php echo $TPL_V1["due_edate"]?></div>
					<div class="clear"></div>

<?php if($TPL_V1["view"]=="Y"){?> 

					<!-- 해당 프론티어 리뷰 리스트 -->
					<div class="frontier_myrevw_text">
							<ul>
									<li class="frontier_myrevw_titleline"><span class="common_text pl20"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)"><strong><?php echo $TPL_V1["content"]["title"]?></strong></a></li>
									<li style="height:8px;"></li>
									<li class="frontier_myrevw_textline"><?php echo $TPL_V1["content"]["content"]?></li>
							</ul>
					</div>
					<!-- 해당 프론티어 리뷰 리스트 끝-->
<?php }else{?>

					<div class="frontier_myrevw_text">
							<ul>
									<li style="height:8px;"></li>
									<li class="frontier_myrevw_textline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#977EB6">등록된 리뷰가 없습니다.</font></li>
							</ul>
					</div>

<?php }?>

			</div>
	</div>
	
	<div class="clear"> </div>
	<div  class="cbox_line"></div>
	<!-- 리스트 묶음 박스 끝 -->
<?php }}?>	
			
</div>
 
 <!-- 페이지 넘버링 박스 시작 -->
<?php if($TPL_VAR["size"]> 0){?> 
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
<div class="nolist">
<table>
		<tr>
			<td width='720' height='35' colspan='5' align='center'><img src='/images/myrevu/img_nonewinner.gif'  width='230' height='189'></td>
		</tr>
		<tr>
			<td width='720' height='80' colspan='5' align='center'></td>
		</tr>
</table>
</div>
<?php }?>
<!-- 페이지 넘버링 박스 끝 -->
  </div>
  </body>

<div id="entrylayer2" style="display:none; position:absolute; "><?php $this->print_("entrylayer2",$TPL_SCP,1);?></div>
<div id="reviewlayer" style="display:none; position:absolute; "><?php $this->print_("reviewlayer",$TPL_SCP,1);?></div>