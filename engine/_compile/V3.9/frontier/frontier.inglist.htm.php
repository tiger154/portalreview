<?php /* Template_ 2.2.4 2012/12/26 11:29:39 /www/revu39/engine/view/V3.9/frontier/frontier.inglist.htm 000010386 */ 
$TPL_toplist_1=empty($TPL_VAR["toplist"])||!is_array($TPL_VAR["toplist"])?0:count($TPL_VAR["toplist"]);
$TPL_mainlist_1=empty($TPL_VAR["mainlist"])||!is_array($TPL_VAR["mainlist"])?0:count($TPL_VAR["mainlist"]);?>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data" action="">

    <div id="sub_content">
      <div class="title_line gray_l_text"><img src="/images/frontier/title_frontier_ing.gif"  align="left"/></div>
      <!-- 스페셜 박스 시작  / 있으면 최소 2개-->


<?php if($TPL_VAR["cssblank"]!="Y"){?>

	  
	  <div class="frontier_sbox_inglist">
        <!-- ###리스트 묶음 박스 시작 ###-->
<?php if($TPL_toplist_1){foreach($TPL_VAR["toplist"] as $TPL_V1){?>
        <div class="frontier_list">
          <!-- 프론티어 이미지 background 처리 / 해당 카데고리명 입력 -->
         <!--  <div class="thum110_box" style="background:url(<?php echo $TPL_V1["toplistimg"]?>) no-repeat; float:left; display:inline;">
            <div  class="them_text_r white11_text" style="text-align:center;"><?php echo $TPL_V1["b_cate"]?></div>
          </div> -->
			<div class="thum110_nbox">
				<div class="them_text_nr white11_text" style="text-align:center;"><?php echo $TPL_V1["b_cate"]?></div>
					<img src="<?php echo $TPL_V1["toplistimg"]?>" width="110" height="110" />
				</div>
          <!-- 프론티어 내용 박스 -->
          <div class="frontier_text_box fl">
            <div class="gray_title list_title_line_index"><a href="/frontier/detailview/1/<?php echo $TPL_V1["frno"]?>/B/"><font color="#FF6633"><?php echo $TPL_V1["subject"]?></font></a></div>
            <!-- <div id="but_winner" style="width:72px; height:19px; padding:2px 0 6px 0; float:right; display:inline;"><a href="#" target="_blank"><img src="/images/common/but/but_g_winner.gif" align="right" alt="당첨자보기" title="당첨자보기"/></a></div> -->
            <div class="frontier_text_sl fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">인원:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="red11_text"> <?php echo $TPL_V1["peoplelimit"]?>명</span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">기간:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="red11_text"> <?php echo $TPL_V1["start_date"]?> ~ <?php echo $TPL_V1["end_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">발표:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"><?php echo $TPL_V1["notice_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">리뷰:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"><?php echo $TPL_V1["due_sdate"]?> ~ <?php echo $TPL_V1["due_edate"]?></span></li>
              </ul>
            </div>
            <div class="frontier_text_sr fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">상품 분류:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"><?php echo $TPL_V1["cate"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">체험 상품:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="red11_text"> <?php echo $TPL_V1["frproduct"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">위치 정보:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"> <?php echo $TPL_V1["address"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">전화 번호:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"> <?php echo $TPL_V1["tel"]?></span></li>
              </ul>
            </div>
          </div>
          <!-- 프론티어 sns 박스 -->
          <div class="frontier_sns_box fl">
            <ul>
              <!-- 페이스북 버튼 삽입  / 이미지제거 -->
              <div id="but_winner" style="width:72px; height:19px; padding:2px 0 6px 0; float:right; display:inline;"><!-- <a href="#" target="_blank"><img src="/images/common/but/but_g_winner.gif" align="right" alt="당첨자보기" title="당첨자보기"/></a> --><?php echo $TPL_V1["winnerbutton"]?></div>
            </ul>
          </div>
          <!-- 프론티어 sns 박스 끝-->
        </div>
		<div  class="sbox_line_inglist"></div>
<?php }}?>
        <!-- ###리스트 묶음 박스 끝 ###-->

      </div>
<?php }?>


       <div class="clear"> </div>
      <!-- 일반 박스 시작  / 있는 프론티어는 전부 나열-->
      <div class="frontier_cbox">
       
	   <!-- 리스트 묶음 박스 시작 -->
<?php if($TPL_mainlist_1){foreach($TPL_VAR["mainlist"] as $TPL_V1){?>   
        <div class="frontier_list">
          <!-- 프론티어 이미지 background 처리 / 해당 카데고리명 입력 -->
          <!-- <div class="thum110_box" style="background:url(<?php echo $TPL_V1["mainlistimg"]?>) no-repeat; float:left; display:inline;">
            <div  class="them_text_g white11_text" style="text-align:center;"><?php echo $TPL_V1["b_cate"]?></div>
          </div> -->
          <div class="thum110_nbox">
			<div class="them_text_ng white11_text" style="text-align:center;"><?php echo $TPL_V1["b_cate"]?></div>
			<img src="<?php echo $TPL_V1["mainlistimg"]?>" width="110" height="110" />
			</div>
          <!-- 프론티어 내용 박스 -->
          <div class="frontier_text_box fl">
            <div class="gray_title list_title_line_index"><a href="/frontier/detailview/1/<?php echo $TPL_V1["frno"]?>/B/"><?php echo $TPL_V1["subject"]?></a></div>
            
            <div class="frontier_text_sl fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">인원:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="gray11_d_text"> <?php echo $TPL_V1["peoplelimit"]?>명</span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">기간:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="gray11_d_text"> <?php echo $TPL_V1["start_date"]?> ~ <?php echo $TPL_V1["end_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">발표:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"><?php echo $TPL_V1["notice_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">리뷰:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"><?php echo $TPL_V1["due_sdate"]?> ~ <?php echo $TPL_V1["due_edate"]?></span></li>
              </ul>
            </div>
            <div class="frontier_text_sr fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">상품 분류:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"><?php echo $TPL_V1["cate"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">체험 상품:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="gray11_d_text"> <?php echo $TPL_V1["frproduct"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">위치 정보:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"> <?php echo $TPL_V1["address"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">전화 번호:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"> <?php echo $TPL_V1["tel"]?></span></li>
              </ul>
            </div>
          </div>
          <!-- 당첨자 보기 -->
          <div class="frontier_sns_box fl">
            <ul>
             <div id="but_winner" style="width:72px; height:19px; padding:2px 0 6px 0; float:right; display:inline;"><!-- <a href="#" target="_blank"><img src="/images/common/but/but_g_winner.gif" align="right" alt="당첨자보기" title="당첨자보기"/></a> --><?php echo $TPL_V1["winnerbutton"]?></div>
            </ul>
          </div>
          <!-- 당첨자 보기 끝-->
        </div>
           <div class="clear"> </div>
	        <div  class="cbox_line"></div>
        

<?php }}?>
        <!-- 리스트 묶음 박스 끝 -->
       
      </div>
      <!-- 일반 박스 끝 -->
      
     <!-- 페이지 넘버링 박스 시작 -->
         <!-- <div id="pageNaviArea" class="pageno">
         <a href="#" class="pre" onfocus="this.blur()"><img src="/images/common/ico/text_pre.gif" alt="이전" title="이전"/></a>
         <a href="#">1</a>
         <a href="#">2</a>
         <a href="#">3</a>
         <a href="#">4</a>
         <a href="#">5</a>
         <strong>6</strong>
         <a href="#">7</a>
         <a href="#">8</a>
         <a href="#">9</a>
         <a href="#">10</a>
         <a href="#" class="next"onfocus="this.blur()"><img src="/images/common/ico/text_next.gif" alt="다음" title="다음"/></a>        
          </div> -->

<?php if($TPL_VAR["size"]> 0){?> 
		<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
		<div class="nolist"><!-- 리뷰등록중인 프론티어가 없습니다. --></div>
<?php }?>
	<!-- 페이지 넘버링 박스 끝 -->

    </div>
<div id="entrylayer" style="display:none; position:absolute; "><?php $this->print_("entrylayer",$TPL_SCP,1);?></div>
</form>