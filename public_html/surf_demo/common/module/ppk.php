<?
	//등락폭 정보(태그) 있음
	//등락폭 정보를 사용하지 않을 경우 25라인의 span태그를 삭제하여 사용해 주세요.
	$arrPpk = getPopularKwdAndTag(0, 10);
			
	if ( $arrPpk != null ) {
?>
		<div class="ranking" style="display:block">
        <h3>인기검색어 </h3>
            <div class="rank_list">
            <ul class="itemlists rank">
<?			
				for ($k=0; $k<sizeof($arrPpk); $k++) {
					// 인기검색어 순위
					if ($k < 9) {
						$rank = "0" . ($k + 1);
					} else {
						$rank = $k+1;
					}
					
					// 등락폭 정보 표현
					if (substr($arrPpk[$k][1], 0, 1) == "-") {
						$tagImage = "rank_down";
						$tagNum = str_replace("-", "", $arrPpk[$k][1]);
					} else if (substr($arrPpk[$k][1], 0, 1) == "" 
							|| strtolower(substr($arrPpk[$k][1], 0, 1)) == "0") {
						$tagImage = "";
						$tagNum = $arrPpk[$k][1];
					} else if (strtolower(substr($arrPpk[$k][1], 0, 1)) == "n") {
						$tagImage = "rank_new";
						$tagNum = "&nbsp;";
					} else {
						$tagImage = "rank_up";
						$tagNum = $arrPpk[$k][1];
					}
?>
                <li id="" class="no b1" style="position: relative; top: 0pt;">

                    <div>
                    	<?//등락폭 태그 시작?><span class="rv <?=$tagImage?>"><?=$tagNum?></span><?//등락폭 태그 끝?>
                    	<img src="./image/no_<?=$rank?>.gif" alt="no" align="absmiddle" class="mr5"/>
                    	<a href="javascript:goKwd('<?=$arrPpk[$k][0]?>');" ><?=$arrPpk[$k][0]?></a>
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

