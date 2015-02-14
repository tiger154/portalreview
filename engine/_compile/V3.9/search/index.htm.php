<?php /* Template_ 2.2.4 2012/06/08 15:35:56 /www/revu39/engine/view/V3.9/search/index.htm 000012405 */ 
$TPL_reviewList_1=empty($TPL_VAR["reviewList"])||!is_array($TPL_VAR["reviewList"])?0:count($TPL_VAR["reviewList"]);
$TPL_frontierList_1=empty($TPL_VAR["frontierList"])||!is_array($TPL_VAR["frontierList"])?0:count($TPL_VAR["frontierList"]);
$TPL_bloggerList_1=empty($TPL_VAR["bloggerList"])||!is_array($TPL_VAR["bloggerList"])?0:count($TPL_VAR["bloggerList"]);
$TPL_blogList_1=empty($TPL_VAR["blogList"])||!is_array($TPL_VAR["blogList"])?0:count($TPL_VAR["blogList"]);?>
<?php if($TPL_VAR["TOTAL_ALL"]> 0){?>

	<!-- 리뷰 시작 -->
<?php if($TPL_VAR["categoryInfo"]=='review'||$TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["reviewResultCnt"]> 0){?>
		<div class="section revu_list">
			<div class="section_title">
				<h2>리뷰</h2>
<?php if($TPL_VAR["categoryInfo"]=="review"){?>
					<p class="section_tit_desc">(<?php echo $TPL_VAR["reviewFirstPage"]?>-<?php echo $TPL_VAR["reviewLastPage"]?> /  <b><?php echo $TPL_VAR["reviewResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
					<!-- 정렬 시작 -->
					<span class="search_order">
<?php if($TPL_VAR["sort"]=="d"){?>
						<a href="javascript:goSort('r');" class="order01">
						<img src="images/search/order01_or.gif" alt="정확도 높은 순"></a>
						<a href="javascript:goSort('d');" class="order02">
						<img src="images/search/order02_on.gif" alt="최근 작성된 순"></a>
<?php }else{?>
						<a href="javascript:goSort('r');" class="order01">
						<img src="images/search/order01_on.gif" alt="정확도 높은 순"></a>
						<a href="javascript:goSort('d');" class="order02">
						<img src="images/search/order02_or.gif" alt="최근 작성된 순"></a>
<?php }?>
					</span>
					<!-- //정렬 -->
<?php }else{?>
					<p class="section_tit_desc">(<b><?php echo $TPL_VAR["reviewResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
<?php }?>
			</div>
	
			<ul class="search_list">
<?php if($TPL_reviewList_1){foreach($TPL_VAR["reviewList"] as $TPL_V1){?>
				<li>
<?php if($TPL_V1["thumbimg_url"]!=''){?>
					<div class="thumnail">
						<a href="<?php echo $TPL_V1["review_url"]?>"><img src="<?php echo $TPL_V1["thumbimg_url"]?>" alt="<?php echo $TPL_V1["reTitle"]?>"></a>
					</div>
<?php }?>
					<dl>
						<dt><a href="<?php echo $TPL_V1["review_url"]?>" target="_blank"><?php echo $TPL_V1["title"]?></a></dt>
						<dd class="desc_txt"><?php echo $TPL_V1["contents"]?>..</dd>
						<!-- 태그정보
						<dd class="tag">
							<span class="tag_ico">tag</span>
							<span class="tag_link"><a href="#">비비드</a>, <a href="#">봄</a>, <a href="#">크리스마스</a>, <a href="#">눈</a></span>
						</dd>
						-->
						<dd class="info">
<?php if($TPL_V1["ftype"]=='0'){?>
							<span class="friend  friend1">서로친구</span>
<?php }elseif($TPL_V1["ftype"]=='1'){?>
							<span class="friend  friend2">내가등록한친구</span>
<?php }elseif($TPL_V1["ftype"]=='2'){?>
							<span class="friend  friend3">나를등록한친구</span>
<?php }?>
<?php if($TPL_V1["nickname"]!=null){?>
							<span><a href="javascript:context.load('<?php echo $TPL_V1["bloggerno"]?>')"><?php echo $TPL_V1["nickname"]?></a></span>
<?php }?>
							<span><?php echo $TPL_V1["regdate"]?></span>
							<span class="category_link"><?php echo $TPL_V1["category"]?></span>
							<em><img src="<?php echo $TPL_V1["blog_img_url"]?>" alt="<?php echo $TPL_V1["blog_type"]?>"></em>
						</dd>
					</dl>
				</li>
<?php }}?>
			</ul>
	
<?php if($TPL_VAR["categoryInfo"]=='review'){?>
			<div class="paging">
				<script>
					document.write(pageNav("gotoPage",<?php echo $TPL_VAR["pageNum"]?>,<?php echo $TPL_VAR["reviewPageSize"]?>,<?php echo $TPL_VAR["reviewResultCnt"]?>));	
				</script> 
			</div>
<?php }?>

<?php if($TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["reviewResultCnt"]>$TPL_VAR["reviewPageSize"]){?>
					<div class="search_more"><a href="javascript:goCategory('review');">결과 더보기</a></div>
<?php }?>
<?php }?>
		</div>
		<hr>
<?php }?>
<?php }?>
	<!-- // 리뷰 끝 -->

	<!-- 프론티어 시작 -->
<?php if($TPL_VAR["categoryInfo"]=='frontier'||$TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["frontierResultCnt"]> 0){?>
		<div class="section frontier">
			<div class="section_title">
				<h2>프론티어</h2>
<?php if($TPL_VAR["categoryInfo"]=="frontier"){?>
				<p class="section_tit_desc">(<?php echo $TPL_VAR["frontierFirstPage"]?>-<?php echo $TPL_VAR["frontierLastPage"]?> / <b><?php echo $TPL_VAR["frontierResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
<?php }else{?>
				<p class="section_tit_desc">(<b><?php echo $TPL_VAR["frontierResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
<?php }?>
			</div>
			<ul class="frontier_list">
<?php if($TPL_frontierList_1){foreach($TPL_VAR["frontierList"] as $TPL_V1){?>
				<li class="fli">
					<div class="thumnail">
						<a href="<?php echo $TPL_V1["frontier_url"]?>"><img src="<?php echo $TPL_V1["img_url"]?>" alt="<?php echo $TPL_V1["subject"]?>">
<?php if($TPL_V1["category1"]!=null){?>
							<span class="bg_txt"><?php echo $TPL_V1["category1"]?></span>
<?php }?>
						</a>
					</div>
						<dl>
							<dt>
<?php if($TPL_V1["ing_cd"]=='1'){?>
							<span class="cnt">모집중
<?php }elseif($TPL_V1["ing_cd"]=='2'){?>
							<span class="rev">리뷰중 
<?php }else{?>
							<span class="end">마감 
<?php }?> 
							</span>
							<a href="<?php echo $TPL_V1["frontier_url"]?>"><?php echo $TPL_V1["subject"]?></a>
							</dt>
							<dd>
								<ul class="first-child">
									<li class="first-child"><span>인원 : </span><?php echo $TPL_V1["limit"]?>명</li>
									<li><span>기간 : </span><?php echo $TPL_V1["start_date"]?> ~ <?php echo $TPL_V1["end_date"]?></li>
									<li><span>발표 : </span><?php echo $TPL_V1["notice_date"]?></li>
									<li><span>리뷰 : </span><?php echo $TPL_V1["due_sdate"]?> ~ <?php echo $TPL_V1["due_edate"]?></li>
								</ul>
								<ul class="last-child">
<?php if($TPL_V1["category"]!=''){?>
									<li class="first-child"><span>상품분류 : </span><em><a href="#"><?php echo $TPL_V1["category"]?></a></em></li>
<?php }?>
									<li><span>체험상품 : </span><em><?php echo $TPL_V1["frproduct"]?></em></li>
<?php if($TPL_V1["tel"]!=''){?>
									<li><span>전화번호 : </span><em><?php echo $TPL_V1["tel"]?></em></li>
<?php }?>
								</ul>
							</dd>
						</dl>
					</li>
<?php }}?>
				</ul>

<?php if($TPL_VAR["categoryInfo"]=='frontier'){?>
			<div class="paging">
				<script>
					document.write(pageNav("gotoPage",<?php echo $TPL_VAR["pageNum"]?>,<?php echo $TPL_VAR["frontierPageSize"]?>,<?php echo $TPL_VAR["frontierResultCnt"]?>));
				</script>
			</div>
<?php }?>
	
<?php if($TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["frontierResultCnt"]>$TPL_VAR["frontierPageSize"]){?>
					<div class="search_more"><a href="javascript:goCategory('frontier');">결과 더보기</a></div>
<?php }?>
<?php }?>
		</div>
		<hr>
<?php }?>
<?php }?>
	<!-- 프론티어 끝 -->

<!-- 블로거 시작 -->
<?php if($TPL_VAR["categoryInfo"]=='blogger'||$TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["bloggerResultCnt"]> 0){?>
		<div class="section blogger">
			<div class="section_title">
				<h2>블로거</h2>
<?php if($TPL_VAR["categoryInfo"]=="blogger"){?>
				<p class="section_tit_desc">(<?php echo $TPL_VAR["bloggerFirstPage"]?>-<?php echo $TPL_VAR["bloggerLastPage"]?> / <b><?php echo $TPL_VAR["bloggerResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
<?php }else{?>
				<p class="section_tit_desc">(<b><?php echo $TPL_VAR["bloggerResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
<?php }?>
			<span style="padding-left:25px">
				<img src="http://www.revu.co.kr/images/search/icon_friend.gif"/>
			</span>
			</div>
			<ul class="blogger_list">
			<!-- 1,6번째에는 class nth1 -->
<?php if($TPL_bloggerList_1){foreach($TPL_VAR["bloggerList"] as $TPL_V1){?>
				<li class="<?php echo $TPL_V1["fclass"]?>">	
				<a href="javascript:context.load('<?php echo $TPL_V1["bloggerno"]?>')" title="<?php echo $TPL_V1["ftext"]?>">
				<img src="<?php echo $TPL_V1["bloggerimg"]?>" width="80" height="80" alt="<?php echo $TPL_V1["nickname"]?>">
				<span><?php echo $TPL_V1["nickname"]?></span></a>
				</li>
<?php }}?>
			</ul>
	
<?php if($TPL_VAR["categoryInfo"]=='blogger'){?>
			<div class="paging">
				<script>
						document.write(pageNav("gotoPage",<?php echo $TPL_VAR["pageNum"]?>,<?php echo $TPL_VAR["bloggerPageSize"]?>,<?php echo $TPL_VAR["bloggerResultCnt"]?>));
				</script>
			</div>
<?php }?>

<?php if($TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["bloggerResultCnt"]>$TPL_VAR["bloggerPageSize"]){?>
					<div class="search_more"><a href="javascript:goCategory('blogger');">결과 더보기</a></div>
<?php }?>
<?php }?>
		</div>
		<hr>
<?php }?>
<?php }?>
	<!-- 블로거 끝 -->

	<!-- 블로그 시작 -->
<?php if($TPL_VAR["categoryInfo"]=='blog'||$TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["blogResultCnt"]> 0){?>
		<div class="section blog">
			<div class="section_title">
				<h2>블로그</h2>
<?php if($TPL_VAR["categoryInfo"]=="blog"){?>
				<p class="section_tit_desc">(<?php echo $TPL_VAR["blogFirstPage"]?>-<?php echo $TPL_VAR["blogLastPage"]?> / <b><?php echo $TPL_VAR["blogResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
<?php }else{?>
				<p class="section_tit_desc">(<b><?php echo $TPL_VAR["blogResultFormatCnt"]?></b>건이 검색되었습니다.)</p>
<?php }?>
			</div>
			<ul class="search_txt_list">
<?php if($TPL_blogList_1){foreach($TPL_VAR["blogList"] as $TPL_V1){?>
				<li>						
					<dl>
						<dt><a href="<?php echo $TPL_V1["blog_url"]?>" target="_blank"><?php echo $TPL_V1["blog_nm"]?></a></dt>
						<dd class="txt_inline"><a href="<?php echo $TPL_V1["blog_url"]?>" target="_blank"><?php echo $TPL_V1["blog_url"]?></a></dd>
						<dd class="txt_block">
							<?php echo $TPL_V1["nickname"]?>님의 블로그입니다.
						</dd>
					</dl>
				</li>
<?php }}?>
			</ul>
	
<?php if($TPL_VAR["categoryInfo"]=='blog'){?>
			<div class="paging">
			<script>
					document.write(pageNav("gotoPage",<?php echo $TPL_VAR["pageNum"]?>,<?php echo $TPL_VAR["blogPageSize"]?>,<?php echo $TPL_VAR["blogResultCnt"]?>));
			</script>
			</div>
<?php }?>
	
<?php if($TPL_VAR["categoryInfo"]=='TOTAL'){?>
<?php if($TPL_VAR["blogResultCnt"]>$TPL_VAR["blogPageSize"]){?>
					<div class="search_more"><a href="javascript:goCategory('blog');">결과 더보기</a></div>
<?php }?>
<?php }?>
		</div>
		<hr>
<?php }?>
<?php }?>
	<!-- 블로그 끝 -->

<?php }else{?>
<div class="section_t no_result">
	<div class="no_result_txt">
		<p><strong><?php echo $TPL_VAR["hilightTxt_s"]?></strong>에 대한 검색 결과가 없습니다.</p>
		<ul>
			<li>검색어가 제대로 쓰여진 것인지 확인해 보세요.</li>
			<li>좀 더 일반적인 단어로 검색해 보세요.</li>
			<li>두 개 이상의 단어를 검색하는 중이라면 띄어쓰기가 올바른지 다시 확인해 보세요.</li>
			<li>특수문자를 제외하고 다시 검색해 보세요.</li>
		</ul>
	</div>
</div>
<hr>

<div class="section revu_main">
	<div class="section_title">
		<h2>지금 레뷰에서 가장 인기 많은 리뷰들을 보여드립니다.</h2>
	</div>
	<div id="noticeReview1">
<?php if(is_array($TPL_R1=$TPL_VAR["noticeReview"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="m_focus_textbox">
			<ul>
				<li class="m_focus_thum fl">
					<img src="<?php echo $TPL_V1["thumbimage_url"]?>" width="80px;" height="80px;">
				</li>
				<li class="m_focus_text1 fl">					<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)"><span class="gray_du_text"><?php echo $TPL_V1["title"]?></span></a>
								&nbsp;
								<span class="red_text"></span>
				</li>
				<li class="m_focus_text2 fr" style="height:34px"><?php echo $TPL_V1["content"]?></li> 
				<li class="m_focus_text3 fr">
					<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revuhit.gif"><span class="red_b_text"><?php echo $TPL_V1["recom_cnt"]?></span>
								&nbsp;|&nbsp;
								<span class="gray11_l_text"><a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>)"><?php echo $TPL_V1["nickname"]?></a></span>
							</li>
			</ul>
		</div>	
<?php }}?>	
	</div>	
</div>
<hr>
<?php }?>