<div class="notfound_title">
           		검색어 <span class="alert_orange">‘<?=$kwd?>’</span>에 대한 검색결과가 없습니다.
            </div>
			<ul class="notfound">
            	<li>단어의 철자가 정확한지 확인해 주세요.</li>
				<li>검색어의 단어 수를 줄이거나, 다른 검색어로 검색해 보세요.</li>
               	<li>보다 일반적인 검색어로 다시 검색해 보세요.</li>
<?
			if ($kwd != "") {
				$arrCorrectedKwd = getCorrectedKwd($kwd);
				if (sizeof($arrCorrectedKwd) > 0) {
					echo "<li>오타 교정 결과로 " ;
					for ($c=0; $c<sizeof($arrCorrectedKwd); $c++) {
						echo "<a href=\"javascript:goKwd('$arrCorrectedKwd');\">" . $arrCorrectedKwd . "</a> ";
					}
					echo "(이)가 있습니다.</li>"; 
				}
			}
?>               	
            </ul>
