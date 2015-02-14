<!-- Include Form for Research or PageNavigation -->
<form name="historyForm" method="get">
<input type='hidden' name='category' value='<?=$srchParam->getCategory()?>'/>
<input type='hidden' name='kwd' value='<?=$srchParam->getKwd()?>'/>
<input type='hidden' name='pageNum' value='<?=$srchParam->getPageNum()?>'/>
<input type='hidden' name='pageSize' value='<?=$srchParam->getPageSize()?>'/>
<input type='hidden' name='reSrchFlag' value='<?=$srchParam->getReSrchFlag()?>'/>
<input type='hidden' name='sort' value='<?=$srchParam->getSort()?>'/>
<input type='hidden' name='startDate' value=''/>
<input type='hidden' name='endDate' value=''/>
<?= makeHtmlForPreKwd($srchParam)?>
</form>
