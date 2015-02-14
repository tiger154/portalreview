<?php /* Template_ 2.2.4 2012/07/11 09:17:57 /www/revu39/engine/view/V3.9/frontier/frontier.alliance.htm 000003603 */ ?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/button_action.js"></script>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data" action="">
    <div id="sub_content">
    
      <div class="title_line gray_l_text">
			<img src="/images/frontier/title_frontier_ad.gif"  align="left"/>
			<p class="ad_btn"><a href="/frontier/alliance_proc"><img src="/images/frontier/btn_alliance_site.gif" alt="제휴문의"/></a></p>
	  </div>
	
      <!-- 제휴문의 박스 -->
      <div class="frontier_ad_box">
      <div class="frontier_ad_img"></div>
      <div class="frontier_ad_input">
      <ul>
      <li class="frontier_ad_text">회사명</li>
       <li class="frontier_ad_text2"><input name="company" type="text" class="input_ad" id="company"  style="margin-bottom:-4px;"/></li>
      </ul>
      </div>
      <div class="frontier_ad_input">
      <ul>
      <li class="frontier_ad_text">홈페이지</li>
       <li class="frontier_ad_text2"><input name="homepage" type="text" class="input_ad" id="homepage"  style="margin-bottom:-4px;"/></li>
      </ul>
      </div>
      <div class="frontier_ad_input">
      <ul>
      <li class="frontier_ad_text">담당자명</li>
       <li class="frontier_ad_text2"><input name="rname" type="text" class="input_ad" id="rname"  style="margin-bottom:-4px;"/></li>
      </ul>
      </div>
      <div class="frontier_ad_input">
      <ul>
      <li class="frontier_ad_text">전화번호</li>
       <li class="frontier_ad_text2"><input name="company_tel" type="text" class="input_ad" id="company_tel"  style="margin-bottom:-4px;"/></li>
      </ul>
      </div>
      <div class="frontier_ad_input">
      <ul>
      <li class="frontier_ad_text">이메일</li>
       <li class="frontier_ad_text2"><input name="company_mail" type="text" class="input_ad" id="company_mail"  style="margin-bottom:-4px;"/></li>
      </ul>
      </div>
      <div class="frontier_ad_area">
      <ul>
      <li class="frontier_ad_area_r">제휴내용</li>
      <li class="frontier_ad_area_l"><textarea name="company_say"  class="input_ad_area" id="company_say" ></textarea></li>
      </ul>
      </div>
      <div class="frontier_ad_input2">
      <ul>
      <li class="frontier_ad_text">파일첨부</li>
      <li class="frontier_ad_text2"><!-- <input name="company_file" type="text" class="input_ad2" id="company_file"  style="margin-bottom:-4px;"/><a href="#" target="_blank"><img src="/images/common/but/but_g_found.gif" alt="찾아보기" title="찾아보기" style="margin: 0 0 -8px 15px;"/></a> -->
		<input type="file" name="file" id="file" value="" class="input_ad2" style="margin-bottom:-4px;"><!-- <img src="/images/common/but/but_g_found.gif" alt="찾아보기" title="찾아보기" style="margin: 0 0 -8px 15px;"/> --><br>
		<input type="hidden" name="relfile" id="relfile" value="">
	  </li>
      </ul>
      </div>
      <div class="but_box">
      <img src="/images/common/but/but_big_ok.gif"  id="allianceCheck" alt="확인" title="확인" style="margin-right:20px;cursor:hand">
	  <!-- <img src="/images/common/but/but_big_ok.gif" alt="확인" title="확인"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --><a href="#"><img src="/images/common/but/but_big_esc.gif" alt="취소" title="취소"/></a>
      </div>
      </div>
      <!-- 제휴문의 박스 끝-->
    </div>
</form>