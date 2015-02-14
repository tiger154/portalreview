<?
	$arrKre = getRecommendKwd($srchParam->getKwd(), 0, 10);
			
	if ( $arrKre != null ) {
?>
		<div class="ranking" style="display:block">
        <h3>추천검색어 </h3>
            <div class="rank_list">
            <ul class="itemlists rank">

<?
				for ($k=0; $k<sizeof($arrKre); $k++) {
					if ($k < 9) {
						$rank = "0" . ($k + 1);
					} else {
						$rank = $k+1;
					}					
?>            	
                <li id="" class="no b1" style="position: relative; top: 0pt;">
                    <div>
                    	<img src="./image/no_<?=$rank?>.gif" alt="no" align="absmiddle" class="mr5"/>
                    	<a href="javascript:goKwd('<?=$arrKre[$k]?>');" ><?=$arrKre[$k]?></a>
                    </div>
                </li>
<?	
				}
?>                    
                </ul>
            </div>
        </div>
<?
	}
?>
