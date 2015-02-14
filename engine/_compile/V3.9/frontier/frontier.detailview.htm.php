<?php /* Template_ 2.2.4 2013/01/29 17:07:31 /www/revu39/engine/view/V3.9/frontier/frontier.detailview.htm 000015733 */ 
$TPL_frontierOptionList_1=empty($TPL_VAR["frontierOptionList"])||!is_array($TPL_VAR["frontierOptionList"])?0:count($TPL_VAR["frontierOptionList"]);
$TPL_talkData_1=empty($TPL_VAR["talkData"])||!is_array($TPL_VAR["talkData"])?0:count($TPL_VAR["talkData"]);
$TPL_reviewData_1=empty($TPL_VAR["reviewData"])||!is_array($TPL_VAR["reviewData"])?0:count($TPL_VAR["reviewData"]);?>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data" action="">
<link href="<?php echo $TPL_VAR["CSS"]?>/myrevu.css" rel="stylesheet" type="text/css" />
<?php echo $TPL_VAR["scroll"]?>

      <!-- 프론티어 상세보기 시작-->
      <div id="frontier_view_warp">
        <!-- 프론티어 / guid.jpg 이미지 노출 -->
       <div class="frontier_view_img">
        	<div class="clear"></div>        	
        	<img src="<?php echo $TPL_VAR["topimg"]?>">
        	<div class="etc"><?php echo $TPL_VAR["etc_table"]?></div>
        </div>		
        <!-- 프론티어 타이틀 입력 -->
        <div class="frontier_view_title"></div>
        <div class="frontier_view_title_text">
          <ul>
            <li class="fl"><span class="white_title"><?php echo $TPL_VAR["subject"]?></span></li>
            <li class="fr pt02"><span class="white_text"><?php echo $TPL_VAR["remain_message"]?></span></li>
          </ul>
        </div>
        <!-- 프론티어 기본정보박스 -->
        <div class="frontier_info_box">
          <ul>
            <li class="frontier_info_bg1"></li>
            <li class="frontier_info_bg2">
              <div class="frontier_info_textbox">
              <ul>
                  <!-- 기본정보 버튼  / 응모하기형은 but_frontier_entry.gif-->
                <li class="frontier_info_text_r"><?php echo $TPL_VAR["etype"]?></li>
                    <li class="frontier_detailview1">
                      <div class="detailview_text"><?php echo $TPL_VAR["cate"]?></div>
                    </li>
                    <li class="frontier_detailview2">
                      <div class="detailview_text"><font color=red><?php echo $TPL_VAR["frproduct"]?></font></div>
                    </li>
                    <li class="frontier_detailview3">
                      <div class="detailview_text"><?php echo $TPL_VAR["jstart_date"]?> ~ <?php echo $TPL_VAR["jend_date"]?></div>
                    </li>
                    <li class="frontier_detailview4">
                      <div class="detailview_text"><?php echo $TPL_VAR["peoplelimit"]?><?php if($TPL_VAR["frno"]== 1270){?> 팀(각 팀당 20명이내) <?php }else{?>명 <?php }?></div>
                    </li>
                    <li class="frontier_detailview5">
                      <div class="detailview_text"><?php echo $TPL_VAR["noticedate"]?></div>
                    </li>
                    <li class="frontier_detailview6">
                      <div class="detailview_text"><?php echo $TPL_VAR["due_sdate"]?> ~ <?php echo $TPL_VAR["due_edate"]?></div>
                    </li>
					<?php echo $TPL_VAR["bestrview_notice_date"]?>


<?php if($TPL_VAR["bestrview_prise"]!=""){?>

                  <li class="frontier_detailview8">
                      <div class="detailview_text2"><?php echo $TPL_VAR["bestrview_prise"]?></div>
                  </li>
<?php }?>

                </ul>
              </div>               
            </li>
            
            <li class="clear"></li>
            <li class="frontier_info_bg3"></li>
          </ul>
        </div>
        <!-- 프론티어 기본정보박스 끝 -->
        <div style="width:714px; height:35px;"></div>
        <!-- 체험정보 시작 -->
        <div class="frontier_detail_box">
          <div class="frontier_detail_title"><img src="/images/frontier/title_detailview9.gif" /></div>
          <div class="pt20"></div>
          <table width="670" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="frontier_table_l gray_d_text">- 체험 상품</td>
              <td class="frontier_table_r"><?php echo $TPL_VAR["frproduct"]?> </td>
            </tr>
            <?php echo $TPL_VAR["price"]?>



<?php if($TPL_VAR["address"]!=""){?>

			<tr>
			  <td class='frontier_table_l gray_d_text'>- 주소</td>
			  <td class='frontier_table_r'><?php echo $TPL_VAR["address"]?>&nbsp;
			  
<?php if($TPL_VAR["map"]!=""){?>

				<a href='<?php echo $TPL_VAR["map"]?>' target='_blank' class='w_space'><img src='/images/common/but/but_g_map.gif' alt='약도보기'  title='약도보기' class='imgb_space'/></a>
<?php }?>
			  
			  </td>
			</tr>
<?php }?>

<?php if($TPL_VAR["telcheck"]=="F"&&$TPL_VAR["mobilecheck"]!="F"){?>
            <tr>
          <td class="frontier_table_l gray_d_text">- 휴대폰번호</td>
          <td class="frontier_table_r"><?php echo $TPL_VAR["mobile"]?></td>
        </tr>
<?php }?>


<?php if($TPL_VAR["telcheck"]!="F"&&$TPL_VAR["mobilecheck"]=="F"){?>
            <tr>
          <td class="frontier_table_l gray_d_text">- 전화번호</td>
          <td class="frontier_table_r"><?php echo $TPL_VAR["tel"]?></td>
        </tr>
<?php }?>

<?php if($TPL_VAR["telcheck"]!="F"&&$TPL_VAR["mobilecheck"]!="F"){?>
            <tr>
          <td class="frontier_table_l gray_d_text">- 전화번호/휴대폰</td>
          <td class="frontier_table_r"><?php echo $TPL_VAR["tel"]?>&nbsp;&nbsp;<?php echo $TPL_VAR["mobile"]?></td>
        </tr>
<?php }?>

			<?php echo $TPL_VAR["sitelink"]?>

<?php if($TPL_VAR["froption"]!=""){?>

            <tr>
          <td class="frontier_table_l gray_d_text">- 모집 옵션</td>
          <td class="frontier_table_r">
<?php if($TPL_frontierOptionList_1){foreach($TPL_VAR["frontierOptionList"] as $TPL_V1){?>     

		   <?php echo $TPL_V1["froption"]?><br />
           
<?php }}?>
   
			   </td>
        </tr>
<?php }?>
			<?php echo $TPL_VAR["filelink"]?>


<?php if($TPL_VAR["cashpolicy"]!=""){?>

            <tr>
          <td class="frontier_table_l gray_d_text">- 캐쉬 지급 여부</td>
          <td class="frontier_table_r"><?php echo $TPL_VAR["cashpolicy"]?><br />
            <img src="/images/frontier/img_detailview_cash.gif" /></td>
        </tr>
<?php }?>
<?php if($TPL_VAR["message"]!=""){?>


            <tr>
          <td class="frontier_table_l gray_d_text">- 비고</td>
          <td class="frontier_table_r"><?php echo $TPL_VAR["message"]?><br /></td>
        </tr>

<?php }?>
          </table>
          <div class="frontier_detail_line"></div>
        </div>
        <!-- 리뷰미션시작 -->
        <div class="frontier_detail_box">
          <table width="670" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="frontier_table_l"><img src="/images/frontier/title_detailview10.gif" /></td>
              <td class="frontier_table_r"><?php echo $TPL_VAR["mission"]?><br /></td>
            </tr>
          </table>
          <div class="pt40"></div>
        </div>
        <!-- 리뷰키워드시작 -->
        <div class="frontier_detail_box">
          <table width="670" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="frontier_table_l"><img src="/images/frontier/title_detailview11.gif" /></td>
              <td class="frontier_table_r2"><img src="/images/frontier/img_detailview_keyword1.gif" /></td>
              <td class="frontier_table_r3"><?php echo $TPL_VAR["keyword"]?></td>
            </tr>
            <tr>
              <td class="frontier_table_l"></td>
              <td class="frontier_table_r2"><img src="/images/frontier/img_detailview_keyword2.gif" /></td>
              <td class="frontier_table_r3"><?php echo $TPL_VAR["tagword"]?></td>
            </tr>
          </table>
          <div class="pt40"></div>
        </div>

        <!-- 리뷰당첨 팁시작 -->
<?php if($TPL_VAR["tip"]!=""){?>

        <div class="frontier_detail_box">
          <table width="670" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="frontier_table_l"><img src="/images/frontier/title_detailview12.gif" /></td>
              <td class="frontier_table_r"><?php echo $TPL_VAR["tip"]?> </td>
            </tr>
          </table>
          <div class="frontier_detail_line"><!-- <img src="/images/frontier/img_detailview_revu.gif" align="right"  style="padding-top:47px;"/> --></div>
        </div>
<?php }?>
	  <?php echo $TPL_VAR["bannercode"]?>


	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">토크보기</a></li>
			<li><a href="#tabs-2">리뷰보기</a></li>
		</ul>

		<div id="tabs-1">
		<!-- ##### 토크시작 #####-->


		<div class="frontier_talk_box">
        <div class="frontier_tab_info common11_text">전체<span class="orange11_text"><strong><?php echo $TPL_VAR["talkDataCnt"]?></strong></span>개의 토크가 있습니다. </div>
        
		<input type="hidden" name="user_num" id="user_num" value='<?php echo $TPL_VAR["user_num"]?>'>
		<input type="hidden" name="frno" id="frno" value='<?php echo $TPL_VAR["frno"]?>'>
		<input type="hidden" name="replyno" id="replyno" value=''>
		<input type="hidden" name="replyeditno" id="replyeditno" value=''>
		<input type="hidden" name="delreplyno" id="delreplyno" value=''>



		<!--  토크리스트 시작-->
<?php if($TPL_talkData_1){foreach($TPL_VAR["talkData"] as $TPL_V1){
$TPL_replytalk_2=empty($TPL_V1["replytalk"])||!is_array($TPL_V1["replytalk"])?0:count($TPL_V1["replytalk"]);?>
		<div class="frontier_talk_line">
          <ul>
            <!-- 유저 프로필이미지 비례축소 / 없을시 더미이미지 노출thum_profile_dummy1~3.gif -->
            <li class="s_profile_thum fl"><img src="<?php echo $TPL_V1["userimg"]?>"  alt="유저이름" title="유저이름"  width="45px;" height="45px;"/></li>
            <li class="frontier_talk_text1 fl"><span class="gray11_db_text"><a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>)"><?php echo $TPL_V1["nickname"]?></a></span> <span class="gray11_l_text"><?php echo $TPL_V1["regdate"]?></span>
			<?php echo $TPL_V1["talk_button"]?></li>
			<div class="frontier_reply_text2"  id='typeview5<?php echo $TPL_V1["no"]?>'  style="display: inline"><span class="common11_text"><?php echo $TPL_V1["content"]?></span></div>
			<div class="frontier_reply_text2"  id='typeview4<?php echo $TPL_V1["no"]?>'  style="display: none"><input type="text" id="replyedit<?php echo $TPL_V1["no"]?>" name="replyedit<?php echo $TPL_V1["no"]?>" value="<?php echo $TPL_V1["content"]?>" class="input_reply">&nbsp;<img src="/images/common/but/but_g_ok.gif"  alt="토크수정" title="토크수정" style="margin:0 0 -6px 10px; cursor:hand;" onclick="talkreplyedit(<?php echo $TPL_V1["no"]?>)"/></div>
			<li class="clear"></li>
            <li style="text-align:right;"><a href="javascript:replytoggle('<?php echo $TPL_V1["no"]?>')"><img src="/images/frontier/img_reply2.gif" /></a></li>
          </ul>
        </div>

		<div class="frontier_reply_box" id='typeview<?php echo $TPL_V1["no"]?>' style="display: none">
		<!-- 댓글 시작 -->
			<div class="frontier_reply_line1">
			<ul>
			<li class="fl" style="width:57px; height:22px;"><img src="/images/frontier/img_talk.gif" /></li>
			<li class="fl" style="width:485px;height:22px;"><input name="reply<?php echo $TPL_V1["no"]?>" type="text" class="input_reply" id="reply<?php echo $TPL_V1["no"]?>"></li>
			<li class="fl" style="width:45px; height:19px; padding-top:1px;"><img src="/images/common/but/but_g_ok.gif"  alt="댓글입력" title="댓글입력" align="right" style="cursor:hand" onclick="talkreplyRegist(<?php echo $TPL_V1["no"]?>)"></li>
			</ul>
			</div>
			<div class="frontier_reply_linebg"></div>
		<!-- 댓글 끝-->


			<!-- 입력된 댓글 노출 시작-->
<?php if($TPL_replytalk_2){foreach($TPL_V1["replytalk"] as $TPL_V2){?>
			<div class="frontier_reply_text1">
				<span class="gray11_db_text"><a href="javascript:context.load(<?php echo $TPL_V2["userno"]?>)"><?php echo $TPL_V2["nickname"]?></a></span><span class="gray11_l_text"><?php echo $TPL_V2["regdate"]?></span>
				<?php echo $TPL_V2["reply_button"]?>

			</div>
			<div class="frontier_reply_text2"  id='typeview3<?php echo $TPL_V2["no"]?>'  style="display: inline"><span class="common11_text"><?php echo $TPL_V2["content"]?></span></div>
			<div class="frontier_reply_text2"  id='typeview2<?php echo $TPL_V2["no"]?>'  style="display: none"><input type="text" id="replyedit<?php echo $TPL_V2["no"]?>" name="replyedit<?php echo $TPL_V2["no"]?>" value="<?php echo $TPL_V2["content"]?>" class="input_reply">&nbsp;<img src="/images/common/but/but_g_ok.gif"  alt="확인" title="확인" style="margin:0 0 -6px 10px; cursor:hand" onclick="talkreplyedit(<?php echo $TPL_V2["no"]?>)"/></div>

			<div class="frontier_reply_linebg"></div>

<?php }}?>
			  <!-- 입력된 댓글 노출 끝-->  
        </div>
		 <div style="padding-bottom:10px;"></div> 
<?php }}?>
        <!--  토크리스트 끝-->



        <div class="frontier_tab_info"></div>
        <!--  한 묶음 시작-->

		</div>
<?php if($TPL_VAR["size"]> 0){?> 
		<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
		<!-- <div class="nolist">등록된 토크가 없습니다.</div> -->
<?php }?>


		<!--##### 토크끝 #####-->
		</div>



		<div id="tabs-2">

		<!--##### 리뷰시작 #####-->
        <div class="frontier_tab_info common11_text">전체<span class="orange11_text"><strong><?php echo $TPL_VAR["reviewDataCnt"]?></strong></span>개의 리뷰가 있습니다. </div>
        <!--  한 묶음 시작 / 이미지 있을시-->
<?php if($TPL_reviewData_1){foreach($TPL_VAR["reviewData"] as $TPL_V1){?>
		<div class="frontier_review_line">
          <ul>
            <!-- 리뷰 리스트 이미지 비례축소  / 엑박뜰때엔 thum_list_dummy.gif 노출-->
            <li class="frontier_review_thum fl"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)"><img src="<?php echo $TPL_V1["imgurl"]?>" width="80px;" height="80px;"/></a></li>
            <li class="frontier_review_title fl"><span class="orange_title"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["review"]["title"]?></a></span></li>
            <li class="frontier_review_text1 fl"><span class="gray11_db_text"><a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>)"><?php echo $TPL_V1["review_nickname"]?></a></span><span class="gray11_l_text"> | 라이프 | <?php echo $TPL_V1["regdate"]?></span>
            <img src="/images/common/ico/ico_new.gif"  class="img_space"/></li>
            <li class="frontier_review_text2 fl"><span class="common_text"><?php echo $TPL_V1["review"]["content"]?> </span></li>
            <li class="clear"></li>
            <li style="text-align:right;"></li>
          </ul>
        </div>
		<div class="frontier_tab_info"></div>
<?php }}?>

		  <div id="pageNaviArea" class="pageno">
<?php if($TPL_VAR["size2"]> 0){?> 
			<div class="pageno"><?php echo $TPL_VAR["link2"]?></div>
<?php }else{?>
			<!-- <div class="nolist">등록된 토크가 없습니다.</div> -->
<?php }?>    
          </div>

		<!--##### 리뷰 끝#####-->
		</div>
	</div>

	<script>
	$( "#tabs" ).tabs({ selected: common.getCookie('cookieTab') });
	</script>

	<table><tr><td height='60'></td></tr></table>
<div id="entrylayer" style="display:none; position:absolute; "><?php $this->print_("entrylayer",$TPL_SCP,1);?></div>
<div id="entrylayer2" style="display:none; position:absolute; "><?php $this->print_("entrylayer2",$TPL_SCP,1);?></div>
<div id="reviewlayer" style="display:none; position:absolute; "><?php $this->print_("reviewlayer",$TPL_SCP,1);?></div>

</form>