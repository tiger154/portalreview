<?php /* Template_ 2.2.4 2012/05/31 10:22:42 /www/revu39/engine/view/V3.9/frontier/index.htm 000009244 */ 
$TPL_toplist_1=empty($TPL_VAR["toplist"])||!is_array($TPL_VAR["toplist"])?0:count($TPL_VAR["toplist"]);
$TPL_mainlist_1=empty($TPL_VAR["mainlist"])||!is_array($TPL_VAR["mainlist"])?0:count($TPL_VAR["mainlist"]);?>
<div id="sub_content">

      <div class="title_line gray_l_text"><img src="/images/frontier/title_frontier_all.gif"  align="left"/><span class="ln23"><strong><?php echo $TPL_VAR["nowmonth"]?></strong>월 <strong><?php echo $TPL_VAR["nowday"]?></strong>일 현재, 총 <strong><?php echo $TPL_VAR["frontierCount"]?></strong>개 체험 신청 가능</span></div>
      <!-- 스페셜 박스 시작  / 있으면 최소 2개-->
<?php if($TPL_VAR["cssblank"]!="Y"){?>


	  
	  <div class="frontier_sbox">
        <!-- ###리스트 묶음 박스 시작 ###-->
<?php if($TPL_toplist_1){foreach($TPL_VAR["toplist"] as $TPL_V1){?>
        <div class="frontier_list">
          <!-- 프론티어 이미지 background 처리 / 해당 카데고리명 입력 -->
         <!--  <div class="thum110_box" style="background:url(<?php echo $TPL_V1["toplistimg"]?>) no-repeat; float:left; display:inline;">
            <div  class="them_text_r white11_text" style="text-align:center;"><?php echo $TPL_V1["b_cate"]?></div>
          </div> -->

		<!-- <div class="thum110_box" style="background:url(/images/common/thum/thum_list_110110_1.gif) no-repeat; float:left; display:inline;">
            <div  class="them_text_r white11_text" style="text-align:center;">패션</div>
          </div> -->

			<div class="thum110_nbox">
				<div class="them_text_nr white11_text" style="text-align:center;"><?php echo $TPL_V1["b_cate"]?></div>
					<img src="<?php echo $TPL_V1["toplistimg"]?>" width="110" height="110" />
				</div>
          <!-- 프론티어 내용 박스 -->
				

          <div class="frontier_text_box2 fl">
            <div class="gray_title list_title_line_index"><a href="/frontier/detailview/1/<?php echo $TPL_V1["frno"]?>/A/"><?php echo $TPL_V1["subject"]?></a></div>
            <div class="frontier_text_sl fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">인원:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="red11_text"> <?php echo $TPL_V1["peoplelimit"]?>명</span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">기간:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="red11_text"> <?php echo $TPL_V1["start_date"]?> ~ <?php echo $TPL_V1["end_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">발표:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"> <?php echo $TPL_V1["notice_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">리뷰:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"> <?php echo $TPL_V1["due_sdate"]?> ~ <?php echo $TPL_V1["due_edate"]?></span></li>
              </ul>
            </div>
			

            <div class="frontier_text_sr2 fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">상품 분류:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"><?php echo $TPL_V1["cate"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">체험 상품:&nbsp;</span></li>
                <li class="text_sr_180 fl"><span class="red11_text"> <?php echo $TPL_V1["frproduct"]?></span></li>
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
         <!--  <div class="frontier_sns_box fl">
            <ul>
              <li class="pt28"><img src="/images/common/but/but_facebook.gif" /></li>
              <li class="pt20"><img src="/images/common/but/but_twitter.gif" /></li>
            </ul>
          </div> -->
          <!-- 프론티어 sns 박스 끝-->
        </div>
		<div  class="sbox_line"></div>
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
          <div class="frontier_text_box2 fl">
            <div class="gray_title list_title_line_index"><a href="/frontier/detailview/1/<?php echo $TPL_V1["frno"]?>/A/"><?php echo $TPL_V1["subject"]?></a></div>
            <div class="frontier_text_sl fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">인원:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="gray11_d_text"> <?php echo $TPL_V1["peoplelimit"]?>명</span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">기간:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="gray11_d_text"> <?php echo $TPL_V1["start_date"]?> ~ <?php echo $TPL_V1["end_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">발표:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"> <?php echo $TPL_V1["notice_date"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">리뷰:&nbsp;</span></li>
                <li class=" frontier_text_line fl"><span class="common11_text"> <?php echo $TPL_V1["due_sdate"]?> ~ <?php echo $TPL_V1["due_edate"]?></span></li>
              </ul>
            </div>
            <div class="frontier_text_sr2 fl">
              <ul>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">상품 분류:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"><?php echo $TPL_V1["cate"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">체험 상품:&nbsp;</span></li>
                <li class="text_sr_180 fl"><span class="gray11_d_text"> <?php echo $TPL_V1["frproduct"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">위치 정보:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"> <?php echo $TPL_V1["address"]?></span></li>
                <li class="clear"></li>
                <li class=" frontier_text_line fl"><span class="gray11_l_text">전화 번호:&nbsp;</span></li>
                <li class="text_sr_150 fl"><span class="common11_text"><?php echo $TPL_V1["tel"]?></span></li>
              </ul>
            </div>
          </div>
          <!-- 프론티어 sns 박스 -->
          <!-- <div class="frontier_sns_box fl">
            <ul>
              <li class="pt28"><img src="/images/common/but/but_facebook.gif" /></li>
              <li class="pt20"><img src="/images/common/but/but_twitter.gif" /></li>
            </ul>
          </div> -->
          <!-- 프론티어 sns 박스 끝-->
        </div>
        <div class="clear"> </div>
        <div  class="cbox_line"></div>
        

<?php }}?>
        <!-- 리스트 묶음 박스 끝 -->



      </div>
      <!-- 일반 박스 끝 -->
    </div>