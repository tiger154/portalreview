<?php /* Template_ 2.2.4 2011/12/01 20:05:05 /www/revu39/engine/view/V3.9/myrevu/myrevu.frontier.slider.htm 000004910 */ 
$TPL_myfron_entrylist_1=empty($TPL_VAR["myfron_entrylist"])||!is_array($TPL_VAR["myfron_entrylist"])?0:count($TPL_VAR["myfron_entrylist"]);?>
<!-- Slider Kit scripts -->
	<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.slider/jquery.sliderkit.1.8.min.js"></script>		

	<!-- Slider Kit launch -->
	<script type="text/javascript">
		$(document).ready(function(){ //$(window).load() must be used instead of $(document).ready() because of Webkit compatibility				
			// Carousel > Demo #5
			$("#carousel-demo5").sliderkit({
				auto:true,
				autospeed:4000,
				shownavitems:4,  //5로 하면 스크립트 오류가 남
				circular:false,
				fastchange:false,
				scrolleasing:"easeOutExpo", //"easeOutBounce, easeOutBack"
				scrollspeed:1000
			});	
		});	
	</script>
	
	<!-- Slider Kit styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["EXTENDS"]?>/js.slider/sliderkit-core.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["EXTENDS"]?>/js.slider/sliderkit-demos.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["EXTENDS"]?>/js.slider/sliderkit-site.css" media="screen, projection" />
	
	<!-- Slider Kit compatibility -->	
	<!--[if IE 6]><link rel="stylesheet" type="text/css" href="./lib/css/sliderkit-demos-ie6.css" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="./lib/css/sliderkit-demos-ie7.css" /><![endif]-->
	<!--[if IE 8]><link rel="stylesheet" type="text/css" href="./lib/css/sliderkit-demos-ie8.css" /><![endif]-->

	<!-- Site styles -->
	
<body>
<div id="carousel-demo5" class="sliderkit">
<div class="sliderkit-nav">
<table width="714" border="0" cellspacing="0" cellpadding="0">
	<!-- <tr>
		<td colspan="5"><img src="/images/myrevu/bg_myfrontier1.gif" width="714" height="23" /></td>
	</tr> -->
	
	<tr>
		<!-- <td width="35" height="244" style="background:url(/images/myrevu/bg_myfrontier_sidel.gif) repeat-y; text-align:right;"> -->
		<td width="35" height="244"><!-- <div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-prev"><a href="#" title="이전보기"><span><img src="/images/common/but/but_frontier_pre.gif" alt="이전보기" width="32" height="61" title="이전보기"></span></a></div> --><?php echo $TPL_VAR["leftbutton"]?></td>
		<td width="11" height="244"><img src="/images/common/space.gif" width="11" /></td>
		<td width="650" style="padding:0; margin:0;">
		<!-- 슬라이드 묶음테이블 -->

	

			<table width="620" border="0" cellspacing="0" cellpadding="0">
				<!-- <tr>
					<td width="620" height="35" colspan="5" align="center"><img src="/images/myrevu/title_myentry.gif" width="623" height="35" /></td>
				</tr> -->
				<?php echo $TPL_VAR["headimg"]?>

				<!-- <tr>
					<td width="620" height="35" colspan="5" align="center"><img src="/images/myrevu/img_nonefrontier.gif"></td>
				</tr> -->


				<tr>
					<td width="620" height="20" colspan="5"><img src="/images/common/space.gif" width="20" /></td>
				</tr>

				<tr>
					<td width="124" height="189" style="text-align:center;">

					<div class="sliderkit-nav-clip">
					<ul>
<?php if($TPL_myfron_entrylist_1){foreach($TPL_VAR["myfron_entrylist"] as $TPL_V1){?> 
								<li>
									<a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/B" target="_blank"><img src="<?php echo $TPL_V1["Entryimg"]?>"  width="110" height="110"/></a>
									<h3><a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>/B" target="_blank"><span class="gray_du_text"><?php echo $TPL_V1["subject"]?></span></a></h3>
									<p><div class="frontier_piecetext1 gray11_l_text">모집인원 : <span class="common11_text"><?php echo $TPL_V1["peoplelimit"]?>명</span></div><div class="frontier_piecetext2 gray11_l_text">당첨자발표 : <span class="common11_text"><?php echo $TPL_V1["remainday"]?></span></div></p>
								</li>
<?php }}?>
					</ul>
					</div>
					</td>
				</tr>

			</table>






		</td>
		<td width="10" height="200"><img src="/images/common/space.gif" width="10" /></td>
			<td width="11" height="244" style="background:url(/images/myrevu/bg_myfrontier_sider.gif) repeat-y;text-align:left;">
				<!-- <div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-next"><a href="#" title="다음보기">
				<span><img src="/images/common/but/but_frontier_next.gif" alt="다음보기" width="32" height="61" title="다음보기" ></span></a>
				</div> --><?php echo $TPL_VAR["rightbutton"]?>

			</td>
		</td>

	</tr>
	

	<!-- <tr>
			<td colspan="5"><img src="/images/myrevu/bg_myfrontier2.gif" width="714" height="23" /></td>
	</tr> -->

</table>
</div>
</div>
</body>