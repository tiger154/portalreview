<?
	if ($rsbCATEGORY5->getTotal()>0) {
				$myCategoryCode = "CATEGORY5";
?>
					<div class="data section">
						<h2>전문자료</h2> <span class="title_num">(<?=formatMoney($rsbCATEGORY5->getTotal())?> 건)</span>
						<ul class="type01">
<?                
                		for( $idx=0; $idx<$rsbCATEGORY5->getRows(); $idx++ ) {
                			$fData = $rsbCATEGORY5->getFdata();
                			$rowIdSet = $rsbCATEGORY5->getRowIds();
?>							
							<li>
								<dl>
									<dt><a href="#"><?=$fData[$idx][0]?></a><span class="ml10">[<?=$fData[$idx][5]?>]</span><span class="bar"> | </span><?=formatDateStr($fData[$idx][3],"-")?></dt>
									<dd class="desc"><?=$fData[$idx][1]?>...					
									</dd>
<?
									$fileName = split("[|]", $fData[$idx][7]);
								
									for($j=0;$j< sizeof($fileName);$j++){
  										$tmp[$j] = $fileName[$j];
  										if (sizeof($tmp)>0) {
?>
									<dd><img src="image/<?=getAttachFileImage($tmp[$j])?>" alt="포맷" class="mr5"/><a href="javascript:fileView('<?=$rowIdSet[$idx]?>','<?=$j?>')" class="file_name"><?=$tmp[$j]?></a>
										<a href="javascript:fileView('<?=$rowIdSet[$idx]?>','<?=$j?>')"><img src="image/btn_window.gif" alt="새창으로 첨부파일 열기" /></a><span class="bar"> | </span>
										<a href="javascript:konan_preview('preview_<?=$myCategoryCode?>_<?=$idx?>_<?=$j?>', '<?=$rowIdSet[$idx]?>', '<?=$j?>')">미리보기</a><img src="image/ico_down.gif" alt="미리보기" class="ml3"/> 
	
										<?// 미리보기 --?>
										<div class="preview" id="preview_<?=$myCategoryCode?>_<?=$idx?>_<?=$j?>_box" style="display:none">
											<div class="preview_head">미리보기<span><a href="javascript:konan_preview('preview_<?=$myCategoryCode?>_<?=$idx?>_<?=$j?>', '<?=$rowIdSet[$idx]?>', '<?=$j?>')">닫기<img src="image/btn_close.gif" class="ml3"></a></span>
											</div>
											<div class="preview_inner" id="preview_<?=$myCategoryCode?>_<?=$idx?>_<?=$j?>">
											</div>
										</div>
										<?// 미리보기 --?>
									</dd>								
<?								

  									} // end of if
								
								} // end of for
											
?>									
								</dl>
							</li>
<?
							} // end of for
?>							
						</ul>
					</div>
<?
				if ($srchParam->getCategory() == "TOTAL" && $rsbCATEGORY5->getTotal() > 3) {
?>					
					<div class="section_more"><a class="go_more" href="javascript:goCategory('CATEGORY5')">전문자료 더보기</a></div>
<?
				} else if ($srchParam->getCategory() != "TOTAL") {
?>			
	 			<?// 페이지 구성 시작 --?>
          		<div class="paging">
					<script>
						document.write( pageNav( "gotoPage", <?=$srchParam->getPageNum()?>, <?=$srchParam->getPageSize()?>, <?=$rsbCATEGORY5->getTotal()?> ) );
					</script>
				</div>
				<?// 페이지 구성  끝 --?>
<?
				}
?>
				<div class="content_inner_line"></div>
<?
			}
?>	

