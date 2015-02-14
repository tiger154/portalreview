<?
	if ($rsbCATEGORY3->getTotal() > 0) { 
?>
				
				<div class="site section">
					<h2>사이트</h2> <span class="title_num">(<?=formatMoney($rsbCATEGORY3->getTotal())?> 건)</span>
					<ul class="category">
						<li>
							<span class="cate">
								<a href="">인물,사람들 </a>>
								<a href="">스포츠</a>>
								<a class="last_link" href=""><strong>김연아</strong> 코치</a>
						  </span>(20)
						</li>
						<li>
							<span class="cate">
							<a href="">인물,사람들 </a>>
							<a href="">스포츠</a>>
							<a class="last_link" href=""><strong>김연아</strong> 코치</a>
							</span>(20)
						</li>
						<li>
							<span class="cate">
							<a href="">인물,사람들 </a>>
							<a href="">스포츠</a>>
							<a class="last_link" href=""><strong>김연아</strong> 코치</a>
							</span>(20)
						</li>
						<li>
							<span class="cate">
							<a href="">인물,사람들 </a>>
							<a href="">스포츠</a>>
							<a class="last_link" href=""><strong>김연아</strong> 코치</a>
							</span>(20)
						</li>
						<li>
							<span class="cate">
							<a href="">인물,사람들 </a>>
							<a href="">스포츠</a>>
							<a class="last_link" href=""><strong>김연아</strong> 코치</a>
							</span>(20)
						</li>
						<li>
							<span class="cate">
							<a href="">인물,사람들 </a>>
							<a href="">스포츠</a>>
							<a class="last_link" href=""><strong>김연아</strong> 코치</a>
							</span>(20)
						</li>
						<li>
							<span class="cate">
							<a href="">인물,사람들 </a>>
							<a href="">스포츠</a>>
							<a class="last_link" href=""><strong>김연아</strong> 코치</a>
							</span>(20)
						</li>
					</ul>
					<?// 사이트 카테고리 ?>	
					<ul class="type01">
<?
						for( $idx=0; $idx<$rsbCATEGORY3->getRows(); $idx++ ) {
							$fData = $rsbCATEGORY3->getFdata();
?>						
						<li>
							<dl>
								<dt><a href="#"><?=$fData[$idx][0]?></a>
								</dt>
								<dd><?=$fData[$idx][1]?>
								</dd>
								<dd><a href="http://www.cyworld.com/figureyuna" class="url">http://www.cyworld.com/figureyuna</a>
								</dd>
								<dd><a href="#">인물</a><span class="breadcrumb">></span><a href="#">스포츠인</a><span class="breadcrumb">></span><a href="#">스케이트선수</a><span class="breadcrumb">></span><a href="#">피겨스케이팅 선수</a><span class="breadcrumb">></span> <a href="#">김연아</a>
								</dd>
							</dl>
						</li>
<?
						} //end of for
?>						
					</ul>
					</div>
					
<?
				if ($srchParam->getCategory() == "TOTAL" && $rsbCATEGORY3->getTotal() > 3) {
?>					
					<div class="section_more"><a class="go_more" href="javascript:goCategory('CATEGORY3')">사이트더보기</a></div>
<?
				} else if ($srchParam->getCategory() != "TOTAL") {
?>			
	 			<?// 페이지 구성 시작 ?>
          		<div class="paging">
					<script>
						document.write( pageNav( "gotoPage", <?=$srchParam->getPageNum()?>, <?=$srchParam->getPageSize()?>, <?=$rsbCATEGORY3->getTotal()?> ) );
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


