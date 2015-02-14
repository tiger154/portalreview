<?
	if ($rsbCATEGORY4->getTotal()>0) {
				
					$myCategoryCode = "CATEGORY4";
?>
					<div class="news section">
						<h2>뉴스</h2>
<?
						if ($srchParam->getCategory() == "CATEGORY4") { 
?>
						<div class="sort"><strong>정확도</strong> | <a href="">최신순</a></div>
<?
						} else { 
?>		
						<span class="title_num">(<?=formatMoney($rsbCATEGORY4->getTotal())?> 건)</span>				
<?
						} 
?>						
						<ul class="type01">
<? 
						for( $idx=0; $idx<$rsbCATEGORY4->getRows(); $idx++ ) {
	        	        	//$crz_A->GetResult_Row( $hc_A, $fData_A, $idx );
    		            	$fData = $rsbCATEGORY4->getFdata();
?>						
							<li>
								<dl>
									<div class="thumb"><img src="image/thumImg02.gif" alt="뉴스썸네일" /></div>
									<dt><a href="#"><?=$fData[$idx][0]?></a><span class="bar"> | </span>2010.03.10 (월) 오후 2:36                           </dt>
									<dd><?=$fData[$idx][1] ?>...
									</dd>
									<dd><a href="http://www.cyworld.com/figureyuna" class="url">http://www.cyworld.com/figureyuna</a>
									 </dd>
									 <dd><a href="#">인물</a><span class="breadcrumb">></span><a href="#">스포츠인</a><span class="breadcrumb">></span>
										 <a href="#">스케이트선수</a><span class="breadcrumb">></span><a href="#">피겨스케이팅 선수</a><span class="breadcrumb">></span> <a href="#">김연아</a>
									 </dd>
								</dl>
							</li>
<?							
						} //end of for
?>								
						</ul>
					</div>
<?
				if ($srchParam->getCategory() == "TOTAL" && $rsbCATEGORY4->getTotal() > 3) {
?>					
					<div class="section_more"><a class="go_more" href="javascript:goCategory('CATEGORY4')">뉴스더보기</a></div>
<?
				} else if ($srchParam->getCategory() != "TOTAL") {
?>			
	 			<?// 페이지 구성 시작 ?>
          		<div class="paging">
					<script>
						document.write( pageNav( "gotoPage", <?=$srchParam->getPageNum()?>, <?=$srchParam->getPageSize()?>, <?=$rsbCATEGORY4->getTotal()?> ) );
					</script>
				</div>
				<?// 페이지 구성 끝 ?>
<?
				} //end of if
?>
				<div class="content_inner_line"></div>
<?
			}//end of if
?>	
	
	
	
	
