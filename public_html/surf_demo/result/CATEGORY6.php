<?
if ($rsbCATEGORY6->getTotal()>0) {
	
					$myCategoryCode = "CATEGORY6";
?>
					<div class="shopping section">
						<h2>쇼핑</h2> <span class="title_num">(<?=formatMoney($rsbCATEGORY6->getTotal())?> 건)</span>
						<ul class="type01">
<?                
                		for( $idx=0; $idx<$rsbCATEGORY6->getRows(); $idx++ ) {
                			$fData = $rsbCATEGORY6->getFdata();
?>							
							<li>
								<dl>
									<div class="thumImg_shopping"><img src="image/thumImg_shopping.gif" alt="뉴스썸네일" /></div>
									<dt><a href="#"><?=$fData[$idx][0]?></a>
									</dt>
									<dd class="shop_cont"><span class="price">260,000원</span><span class="bar">|</span> 등록일 : <?=formatDateStr($fData[$idx][3],"-")?>
									</dd>
									<dd class="shop_cont"><?=$fData[$idx][1]?>.. 
									</dd>
								</dl>
							</li>
<?								
						} //end of for			
?>  
						</ul>
					</div>
<?
					if ($srchParam->getCategory() == "TOTAL" && $rsbCATEGORY6->getTotal() > 3) {
?>					
						<div class="section_more"><a class="go_more" href="javascript:goCategory('CATEGORY6')">쇼핑 더보기</a></div>
<?
					} else if ($srchParam->getCategory() != "TOTAL") {
?>			
	 				<?// 페이지 구성 시작 ?>
          			<div class="paging">
						<script>
							document.write( pageNav( "gotoPage", <?=$srchParam->getPageNum()?>, <?=$srchParam->getPageSize()?>, <?=$rsbCATEGORY6->getTotal()?> ) );
						</script>
					</div>
					<?// 페이지 구성 끝 ?>
<?
					} //end of if
?>
					<div class="content_inner_line"></div>
<?
				} //end of if
?>						

