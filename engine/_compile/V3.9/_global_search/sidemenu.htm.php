<?php /* Template_ 2.2.4 2012/05/30 15:42:24 /www/revu39/engine/view/V3.9/_global_search/sidemenu.htm 000001631 */ ?>
<ul class="snb_link">
	<li <?php if($TPL_VAR["categoryInfo"]=="TOTAL"){?>class="first-child focus"<?php }?>><a href="javascript:goCategory('TOTAL');">통합검색</a></li>
	<li <?php if($TPL_VAR["categoryInfo"]=='review'){?>class="first_child focus"<?php }?>><a href="javascript:goCategory('review');">리뷰</a></li>
	<!--<li <?php if($TPL_VAR["categoryInfo"]=='style'){?>class="first_child focus"<?php }?>><a href="javascript:goCategory('style');">스타일</a></li>-->
	<li <?php if($TPL_VAR["categoryInfo"]=='frontier'){?>class="first_child focus"<?php }?>><a href="javascript:goCategory('frontier');">프론티어</a></li>
	<li <?php if($TPL_VAR["categoryInfo"]=='blogger'){?>class="first_child focus"<?php }?>><a href="javascript:goCategory('blogger');">블로거</a></li>
	<li <?php if($TPL_VAR["categoryInfo"]=='blog'){?>class="first_child focus"<?php }?>><a href="javascript:goCategory('blog');">블로그</a></li>
</ul>

<form name="historyForm" method="get">
<input type="hidden" name="category" value="<?php echo $TPL_VAR["categoryInfo"]?>"/>
<input type="hidden" name="kwd" value="<?php echo $TPL_VAR["keyword"]?>"/>
<input type="hidden" name="pageNum" value="<?php echo $TPL_VAR["pageNum"]?>"/>
<input type="hidden" name="pageSize" value="<?php echo $TPL_VAR["pageSize"]?>"/>
<input type="hidden" name="reSrchFlag" value="<?php echo $TPL_VAR["reSrchFlag"]?>"/>
<input type="hidden" name="sort" value="<?php echo $TPL_VAR["sort"]?>"/>
<?php echo $TPL_VAR["preKwdValues"]?>

</form>