<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko">
<head>
<title>검색어 :: 레뷰 - 세상 모든 것에 대한 리뷰</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="Subject" content="www.revu.co.kr" />
<meta name="verify-v1" content="c7qPZTfB1pUMtQBmsxdVRpF2Rn4M5+mypsJhQ1yQds4=" />
<meta name="Author" content="레뷰" />
<meta name="Publisher" content="http://www.revu.co.kr" />
<meta name="Other Agent" content="revu@revu.co.kr" />
<meta name="keywords" content="RevU,레뷰,블로그마케팅,소셜마케팅,SNS,마케팅,블로그,리뷰" />
<link rel="shortcut icon" href="http://www.revu.co.kr/images/common/favicon.ico" type="image/x-icon" />
<link rel="icon" href="http://www.revu.co.kr/images/common/favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" href="http://www.revu.co.kr/css/_global/_style.css" />
<!--link type="text/css" rel="stylesheet" href="http://www.revu.co.kr/css/_global/_common.css" /-->
<link type="text/css" rel="stylesheet" href="http://www.revu.co.kr/css/search.css" />
<link type="text/css" rel="stylesheet" href="http://www.revu.co.kr/extends/js.jquery.ui/css/blitzer/jquery-ui-1.8.13.custom.css">
<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery/jquery.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/search.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/common.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/layout.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/login.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/validation.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/jquery.init.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/context.js"></script>
<script type="text/javascript" src="http://www.revu.co.kr/js/_global/api.js"></script>
<script type="text/javascript"> 
var DOMAIN = "http://www.revu.co.kr";
var DOMAIN_FILE = "http://file.revu.co.kr";
var MOUDLE = "search";
var TODO = "";
var REQUEST_URI = "/search";
var IMAGES = "http://www.revu.co.kr/images";
</script>
<!-- 구글 log 스크립트 -->
<script type="text/javascript"> 
 
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5555634-2']);
  _gaq.push(['_setDomainName', 'revu.co.kr']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);
 
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- 구글 log 스크립트 /-->
 
</head>
<body>
<div id="dialog"></div>
<div id="dialog2"></div>
<div id="dialog-modal"></div>
<div id="progressbar"></div>
<div id="popuplayer"></div>
<div id="bglayer"></div>
<div id="context-user"></div>
<div id="helplayer"></div>
<ul class="hiding">
	<li><a href="#content">검색결과 바로가기</a></li>
	<li><a href="#aside">소셜 로그인, 인기검색어 및 주간베스트 리뷰 바로가기</a></li>
</ul>
<hr>
<body>
<div id="wrap"> 
	<!-- header -->
	<div id="header"><div class="header_wrap">
	<h1><a href="#"><img src="images/search/search_logo.gif" alt="레뷰" title="레뷰"></a></h1>
 
	<form name="searchForm" id="AKCFrm" method="get" onSubmit="return searchKwd(this);">
		<fieldset class="search_input">
			<legend>검색</legend>
			<div class="search_input_box">
				<span>
					<input type="text" title="검색" name="kwd" id="AKCKwd" maxlength="255" class="box_window" accesskey="s" autocomplete="off" value="">
					<a href="#" onfocus="this.blur();"><img id="AKCArrow" src="images/search/btn_atcmp_on.gif" alt="자동완성 펼치기" width="13" height="10" title="자동완성 펼치기"></a>
				</span>
			</div>
			<input type="image" src="images/search/btn_submit_search.gif" alt="검색">
			<span class="research_check"><input type="checkbox" name="reSrchFlag" id="reSrchFlag"  title="결과내 재검색"><label for="re_search">결과 내 재검색</label></span>
			
		<!--<div id="nautocomplete">
			<span class="btn_arw"><a href="#"><img class="triangleImg" id="AKCArrow" src="images/search/btn_atcmp_on.gif" alt="자동완성 펼치기" width="13" height="10" title="자동완성 펼치기"></a></span>
			</div>-->
<!-- 닫을때 btn_atcmp_off.gif -->
			
			<!--<div class="ly_atcmp">
			<iframe id="atcm" title="자동완성" src="atcm_iframe.html" frameborder="0" width="334" height="169" marginwidth="0" marginheight="0" scrolling="no" style="display: none;"></iframe>
			</div>-->
<!-- display:block로 변경하여 사용 -->
		<input type="hidden" name="category" value="TOTAL"/>
		<input type="hidden" name="pageSize" value="10"/>
		<input type="hidden" name="sort" value="r"/>
		
		</fieldset>
	</form>
 
	<ul class="gnb">
		<li class="first-child"><a href="#" title="홈"><img src="images/search/sgnb01.gif" alt="홈"></a></li>
		<li><a href="#" title="리뷰"><img src="images/search/sgnb02.gif" alt="리뷰"></a></li>
		<li><a href="#" title="스타일"><img src="images/search/sgnb03.gif" alt="스타일"></a></li>
		<li><a href="#" title="프론티어"><img src="images/search/sgnb04.gif" alt="프론티어"></a></li>
		<li><a href="#" title="마이레뷰"><img src="images/search/sgnb05.gif" alt="마이레뷰"></a></li>
		<li><a href="#" title="공지사항"><img src="images/search/sgnb06.gif" alt="공지사항"></a></li>
	</ul>
 
</div>
 
<!-- 자동완성 레이어-->
<div id="AKCDiv" style="display:none;z-index:300;position:absolute;">
	<iframe id="AKCIfrm" style="width:100%;height:0px" name="AKCIfrm" marginwidth="0" marginheight="0" src="http://www.revu.co.kr/search/akc" frameborder="0" scrolling="no">
	</iframe>
</div>
<!-- //자동완성 레이어--></div>
	<hr>
	<div id="container">	
		<!-- snb -->
		<div class="snb" id="snb"><ul class="snb_link">
	<li class="first-child focus"><a href="javascript:goCategory('TOTAL');">통합검색</a></li>
	<li ><a href="javascript:goCategory('review');">리뷰</a></li>
	<!--<li ><a href="javascript:goCategory('style');">스타일</a></li>-->
	<li ><a href="javascript:goCategory('frontier');">프론티어</a></li>
	<li ><a href="javascript:goCategory('blogger');">블로거</a></li>
	<li ><a href="javascript:goCategory('blog');">블로그</a></li>
</ul>
 
<form name="historyForm" method="get">
<input type="hidden" name="category" value="TOTAL"/>
<input type="hidden" name="kwd" value=""/>
<input type="hidden" name="pageNum" value="1"/>
<input type="hidden" name="pageSize" value="10"/>
<input type="hidden" name="reSrchFlag" value="false"/>
<input type="hidden" name="sort" value="r"/>
 
</form></div>
		<!-- // snb -->
		<hr>
		<div id="content"> 
		    <!-- middletop : 검색어제안,유사검색어,스폰서링크-->
<!--<div class="s">가변대응을위한영역으로꼭필요합니다</div>-->
 
<!-- ad -->
<div class="section sps_ad">
	<div class="section_title">
		<h2>스폰서링크</h2>
		<p class="ad_desc"><img src="images/search/icon_ad.gif" alt="AD" width="17" height="11"></p>
	</div>
	<ul class="search_txt_list">	
		<li>
			<dl>
				<dt><a href="#" target="_blank"><strong>SUPERDRY</strong>구매대행 스톰</a></dt>
				<dd class="txt_inline"><a href="#" target="_blank">www.storm.co.kr/</a></dd>
				<dd class="txt_block"><a href="" target="_blank"><strong>SUPERDRY</strong>, 정품! 2012 S/S신상, UpTo70%, 회원가입시 1만원</a></dd>
			</dl>
		</li>
		<li>
			<dl>
				<dt><a href="#" target="_blank"><strong>SUPERDRY</strong>구매대행 스톰</a></dt>
				<dd class="txt_inline"><a href="#" target="_blank">www.storm.co.kr/</a></dd>
				<dd class="txt_block"><a href="" target="_blank"><strong>SUPERDRY</strong>, 정품! 2012 S/S신상, UpTo70%, 회원가입시 1만원</a></dd>
			</dl>
		</li>
		<li>
			<dl>
				<dt><a href="#" target="_blank"><strong>SUPERDRY</strong>구매대행 스톰</a></dt>
				<dd class="txt_inline"><a href="#" target="_blank">www.storm.co.kr/</a></dd>
				<dd class="txt_block"><a href="" target="_blank"><strong>SUPERDRY</strong>, 정품! 2012 S/S신상, UpTo70%, 회원가입시 1만원</a></dd>
			</dl>
		</li>
		<li>
			<dl>
				<dt><a href="#" target="_blank"><strong>SUPERDRY</strong>구매대행 스톰</a></dt>
				<dd class="txt_inline"><a href="#" target="_blank">www.storm.co.kr/</a></dd>
				<dd class="txt_block"><a href="" target="_blank"><strong>SUPERDRY</strong>, 정품! 2012 S/S신상, UpTo70%, 회원가입시 1만원</a></dd>
			</dl>
		</li>
	</ul>
</div>
<!-- // ad -->
 
			<!--// middletop-->
			<hr>
			<!-- container : 검색결과-->
<div class="section_t no_result">
	<div class="no_result_txt">
		<p><strong></strong>에 대한 검색 결과가 없습니다.</p>
		<ul>
			<li>검색어가 제대로 쓰여진 것인지 확인해 보세요.</li>
			<li>좀 더 일반적인 단어로 검색해 보세요.</li>
			<li>두 개 이상의 단어를 검색하는 중이라면 띄어쓰기가 올바른지 다시 확인해 보세요.</li>
			<li>특수문자를 제외하고 다시 검색해 보세요.</li>
		</ul>
	</div>
</div>
<hr>
 
 
 
            <!-- //container -->		
        </div>
		<hr>
		<!-- aside : 우측 프레임-->
		<div class="aside" id="aside">
<form name="loginForm" id="loginForm">
 
<!-- 로그인 박스 -->
<div class="login_box">
	<ul>
		<li style="height:31px;"><img src="http://www.revu.co.kr/images/join/title_login.gif" /></li>
		<li style="height:10px;"></li>
		<li style="height:19px;">			
			<img src="http://www.revu.co.kr/images/join/title_snsin.gif" /><img src="http://www.revu.co.kr/images/join/title_twitterin.gif" id="twitterBtn" alt="트위터" title="트위터" class="btn" /><img src="http://www.revu.co.kr/images/join/title_facebookin.gif" id="facebookBtn" alt="페이스북" title="페이스북" class="btn" />					
		</li>
		<li style="height:17px; background:url(http://www.revu.co.kr/images/common/bg/line_log17.gif) repeat-x;"></li>
		<li class="login_input">
			<div class="login_input_line">
				<ul>
					<li style="padding:6px 0 3px 37px;">
						<input type="text" class="input_trans" name="login_userid" id="login_userid" value="" />
					</li>
					<li style="padding:10px 0 3px 37px;">
						<input type="password" class="input_trans" name="login_passwd" id="login_passwd" value="" />
					</li>
				</ul>
			</div>
			<div class="login_but">
				<a href="#"><img src="http://www.revu.co.kr/images/common/but/but_login.gif" id="loginBtn" alt="로그인" title="로그인" /></a>
			</div>
		</li>
		<li class="clear"></li>
		<li style="height:15px; background:url(http://www.revu.co.kr/images/common/bg/line_log15.gif) repeat-x;"></li>
		<li style="height:29px;">
			<img src="http://www.revu.co.kr/images/join/title_joinin.gif" id="joinSiteBtn" alt="회원가입" title="회원가입" class="btn" /><img src="http://www.revu.co.kr/images/join/title_idpwin.gif" id="searchInfoBtn" alt="ID/PW찾기" title="ID/PW찾기" class="btn" /><a href="http://blog.revu.co.kr/2137" target="blank"><img src="http://www.revu.co.kr/images/join/title_socialinfo.gif" id="snsInfoBtn" alt="소셜로그인안내" title="소셜로그인안내" class="btn" /></a>
		</li>
	</ul>
</div>
</form> <!-- 로그인레이어 -->
<style> 
.clsBannerScreen {overflow: hidden;position: relative;height: 150px;width: 224px; border:1px solid #e1e1e1; cursor:pointer; clear:both;}
.clsBannerScreen .images {position:absolute; display:none; }
ul, li {list-style:none; margin:0; padding:0; font-size:10pt; }
</style>
<script type="text/javascript" src="http://www.revu.co.kr/js/jquery.banner.js"></script>
<script type="text/javascript"> 
<!--
$(function() {
	$("#image_list_1").jQBanner({	//롤링을 할 영역의 ID 값
		nWidth:224,					//영역의 width
		nHeight:90,				//영역의 height
		nCount:2,					//돌아갈 이미지 개수
		isActType:"up",				//움직일 방향 (left, right, up, down)
		nOrderNo:1,					//초기 이미지
		nDelay:5000					//롤링 시간 타임 (1000 = 1초)
		/*isBtnType:"li"*/			//라벨(버튼 타입) - 여기는 안쓰임
		}
	);
	
});
//-->
</script>
			<!-- pop_keyword -->
			<div class="rank">
				<h3><img src="images/search/search_rank_tit.gif" alt="인기검색어"></h3>
				<ul>
				<li class="rnp">
				<a href="javascript:goKwd('방사능');">
					<em>1</em>방사능
					<span class="up state">
						<span class="rnum">
10						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rnp">
				<a href="javascript:goKwd('레뷰');">
					<em>2</em>레뷰
					<span class="down state">
						<span class="rnum">
20						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rnp">
				<a href="javascript:goKwd('revu');">
					<em>3</em>revu
					<span class="eq state">
						<span class="rnum">
0						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rnp">
				<a href="javascript:goKwd('검색');">
					<em>4</em>검색
					<span class="new state">
						<span class="rnum">
&nbsp;						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rnp">
				<a href="javascript:goKwd('검색엔진');">
					<em>5</em>검색엔진
					<span class="new state">
						<span class="rnum">
&nbsp;						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rng">
				<a href="javascript:goKwd('코난테크놀로지');">
					<em>6</em>코난테크놀로지
					<span class="new state">
						<span class="rnum">
&nbsp;						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rng">
				<a href="javascript:goKwd('konan');">
					<em>7</em>konan
					<span class="new state">
						<span class="rnum">
&nbsp;						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rng">
				<a href="javascript:goKwd('일요일');">
					<em>8</em>일요일
					<span class="new state">
						<span class="rnum">
&nbsp;						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rng">
				<a href="javascript:goKwd('ganada');">
					<em>9</em>ganada
					<span class="new state">
						<span class="rnum">
&nbsp;						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				<li class="rng">
				<a href="javascript:goKwd('코난');">
					<em>10</em>코난
					<span class="new state">
						<span class="rnum">
&nbsp;						</span>
						<!--<span class="hiding">상승</span>-->
					</span>
				</a>
				</li>
				</ul>
				<p class="rank_time"><span>2012.05.31 08:56</span></p>
			</div>
			<!-- // pop_keyword -->
			<hr>
 
 
			<!-- best_revu -->
			<div class="rank" id="bestrank">
				<h3><img src="images/search/best_revu_tit.gif" alt="주간 베스트리뷰"></h3>
				<ul>
					<li class="rnp"><a href="javascript:common.socialbar(1279889)"><em>1</em>[코멕스] Stylish Tab...</a></li>	
					<li class="rnp"><a href="javascript:common.socialbar(1278535)"><em>2</em>[라떼킹]서울숲 라떼킹에서 수다를</a></li>	
					<li class="rnp"><a href="javascript:common.socialbar(1278534)"><em>3</em>스마트족을 위한 내 손안에 작은...</a></li>	
					<li class="rnp"><a href="javascript:common.socialbar(1279627)"><em>4</em>여름철 식중독 예방을 위한 주방...</a></li>	
					<li class="rnp"><a href="javascript:common.socialbar(1278331)"><em>5</em>소백산자락길, 1800년의 역사...</a></li>	
					<li class="rnp"><a href="javascript:common.socialbar(1278309)"><em>6</em>찌질왕 유아인 죽음 예고한 비극...</a></li>	
					
				</ul>
				<p class="rank_date"><button class="prev_week" onclick="javascript:common.weekBestChange(131)"><span class="hiding">이전 주 보기<span></button><em>2012.05.23 - 2012.05.29</em><button class="next_week" onclick="javascript:common.weekBestChange(133)"><span class="hiding">다음주 보기<span></button></p>
			</div>
			<!-- // best_revu -->
			<hr>
 
 
 
			<!-- notice -->
			<div class="s_notice_box">
				<ul>
					<li class="s_notice_title">
						<a href="http://" target="_blank"><img src="http://www.revu.co.kr/images/common/ico/ico_more.gif" align="right" alt="more" title="more" class="pb15"></a>
					</li>
					<li style="height:10px;"></li>
					<li class="s_text_line">
						<a href="http://blog.revu.co.kr/2246" target="_blank" class="common_text"> 모로코 왕국에서 즐기는 맛있는 수다 라바트 프론티어 당첨자를 발표합니다!</a>
					</li>
					<li class="gray11_l_text">2012-05-29 20:21:23</li>
					<li class="dot18_line"></li>
					<li class="s_text_line">
						<a href="http://blog.revu.co.kr/2245" target="_blank" class="common_text"> [공지] 레뷰 시스템 긴급 점검</a>
					</li>
					<li class="gray11_l_text">2012-05-29 18:09:01</li>
					<li class="dot18_line"></li>
					<li class="s_text_line">
						<a href="http://blog.revu.co.kr/2244" target="_blank" class="common_text"> [프론티어] 로코퀸 김선아의 7천만원치 슈어홀릭을 구경하며, "JINNY KIM"을 찾으세요.</a>
					</li>
					<li class="gray11_l_text">2012-05-29 18:07:30</li>
					<li class="dot18_line"></li>
					<li class="s_text_line">
						<a href="http://blog.revu.co.kr/2243" target="_blank" class="common_text"> [프론티어] 프리미엄진 전문 온라인 스토어 데님스퀘어 베스트 리뷰어를 발표합니다.</a>
					</li>
					<li class="gray11_l_text">2012-05-29 17:48:58</li>
					<li class="dot18_line"></li>
					<li class="s_space_line"><img src="http://revu.co.kr/images/common/space.gif" height="1px;"></li>
				</ul>
			</div>
			<!-- notice -->
			<hr>
 
			<!-- frontier -->
			<div class="s_frontier2_box">
				<ul>
				<li class="s_frontier2_title"></li>
				<li style="height:15px;"></li>
				<li>
  			     <!--  한 묶음 시작-->
   
					<div class="s_frontier2_textbox">
					  <ul>
						<!-- 프론티어 110110 이미지 비례축소 -->
						<li class="s_frontier_thum fl"><a href="/frontier/detailview//1226/"><img src="http://file.revu.co.kr/frontier/list_img/2012/1226.gif"  alt="이 프론티어 상세보기로 이동" title="프론티어 상세보기로 이동"  width="66px;" height="66px;"/></a></li>
						<li class="s_frontier_text1 fl"><a href="/frontier/detailview//1226/"><span class="gray_stitle"><font color="#999933">20시간이면 가능한 영어학습, 영어단기학교에 입학하세요!</font></span></a></li>
						 <li class="s_frontier_text2 fr"><span class="gray11_l_text">모집인원 :</span><span class="gray11_d_text"> 50</span></li>
						<li class="s_frontier_text2 fr"><span class="gray11_l_text">체험단발표 :</span><span class="gray11_d_text"> 2012년6월4일</span></li>
					  </ul>
					</div>
					
				</li>
				<!--  한 묶음 끝-->
				<li class="clear"></li>
				<li class="gray21_line"></li>
 
   
					<li class="s_text_line"><a href="/frontier/detailview//1227/" target="_blank" class="common_text">로코퀸 김선아의 드라마 신작 아이두아이두 속 "지니킴(JINNY KIM)"을 찾아라!</a></li>
					<li class="dot18_line"></li>
				</ul>
			</div>
			<!-- 프론티어배너 225090 -->
					<div id="image_list_1">
					<div class="clsBannerScreen">
   
					<div class="images">
					<a href="/frontier/detailview//1227/"><img src="http://file.revu.co.kr/frontier/banner_img/2012/1227.gif" alt="프론티어이름" title="프론티어이름"  width="224" height="90"></a>
					</div>
   
					<div class="images">
					<a href="/frontier/detailview//1226/"><img src="http://file.revu.co.kr/frontier/banner_img/2012/1226.gif" alt="프론티어이름" title="프론티어이름"  width="224" height="90"></a>
					</div>
					</div>		
					</div>
		
					<div style="margin-bottom:40px;"></div>
 
					<!-- 제휴문의배너 225102 -->
					<div class="s_banner_revu"><a href="/frontier/alliance" target="_blank"><img src="http://www.revu.co.kr/images/common/banner/banner_revu_225102.gif" alt="제휴문의" title="제휴문의" /></a></div>
					
					<img src="/images/common/banner/banner_powerblog_224090.gif" alt="파워블로거지원" title="파워블로거지원" onClick="common.redirect('/info/powerblog')" class="btn" /> <!-- 기타 노출정보 -->
		</div>
		<!-- // aside -->
	</div>
	<!-- // container -->
	<hr>
	<!-- footer -->
	<div id="footer"><div class="footer_wrap">
	<ul class="info_link">
		<li><a href="http://company.wizwid.com/" target="_blank"><img src="http://www.revu.co.kr/images/include/footer/footer_info1.gif" alt="회사소개" title="회사소개"></a></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info3.gif" alt="광고및제휴안내" title="광고및제휴안내" onClick="common.redirect('/frontier/alliance');" class="btn"></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info4.gif" alt="이용약관" title="이용약관" onClick="common.redirect('/info/agree')" class="btn"></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info5.gif" alt="개인정보취급방침" title="개인정보취급방침" onClick="common.redirect('/info/privacy')" class="btn"></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info6.gif" alt="레뷰도움말" title="레뷰도움말" onClick="common.redirect('/info/help')" class="btn"></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info7.gif" alt="OPENAPI" title="OPENAPI" onClick="common.dialog('준비중', '준비중입니다.');" class="btn"></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info8.gif" alt="채용정보" title="채용정보" onClick="common.dialog('채용정보', '현재 채용중이 아닙니다.');" class="btn"></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info8_1.gif" alt="파워블로거모집" title="파워블로거모집" onClick="common.redirect('/info/powerblog');" class="btn"></li>
		<li><a href="http://blog.revu.co.kr" target="_blank"><img src="http://www.revu.co.kr/images/include/footer/footer_info9.gif" alt="공식블로그" title="공식블로그" align="left"></a></li>
		<li><img src="http://www.revu.co.kr/images/include/footer/footer_info10.gif" alt="위젯" title="위젯" onClick="common.dialog('준비중', '준비중입니다.');" class="btn"></li>
		<li><a href="http://blog.revu.co.kr/1176" target="_blank"><img src="http://www.revu.co.kr/images/include/footer/footer_info11.gif" alt="배너" title="배너" align="left"></a></li>
	</ul>
</div>
 
<div class="company_info">
	<div class="company_info_wrap">
		<h1><img src="http://www.revu.co.kr/images/include/footer/footer_logo.gif"></h1>
		<address><img src="http://www.revu.co.kr/images/include/footer/footer_info.gif" alt=""></address>
		<span><a href="mailto:revu@revu.co.kr" onFocus="this.blur()"><img src="http://www.revu.co.kr/images/include/footer/footer_mail.gif" alt="대표메일" title="대표메일"></a></span>
	</div>
</div></div>
	<!-- // footer -->
</div>
<!-- // wrap -->
</body>
</html>
