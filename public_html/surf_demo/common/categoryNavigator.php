<?	// menu ?>
<div class="line"></div>
		    <ul id="lnb">
		  		<li <?=makeReturnValue($srchParam->getCategory(),"TOTAL", "class='select'", "")?>><a href="javascript:goCategory('TOTAL');">통합검색</a></li>
		  		<li <?=makeReturnValue($srchParam->getCategory(),"CATEGORY1", "class='select'", "")?>><a href="javascript:goCategory('CATEGORY1');">바로가기</a></li>
		  		<li <?=makeReturnValue($srchParam->getCategory(),"CATEGORY2", "class='select'", "")?>><a href="javascript:goCategory('CATEGORY2');">인물</a></li>
		  		<li <?=makeReturnValue($srchParam->getCategory(),"CATEGORY3", "class='select'", "")?>><a href="javascript:goCategory('CATEGORY3');">사이트</a></li>
		  		<li <?=makeReturnValue($srchParam->getCategory(),"CATEGORY4", "class='select'", "")?>><a href="javascript:goCategory('CATEGORY4');">뉴스</a></li>
		  		<li <?=makeReturnValue($srchParam->getCategory(),"CATEGORY5", "class='select'", "")?>><a href="javascript:goCategory('CATEGORY5');">전문자료</a></li>
		  		<li <?=makeReturnValue($srchParam->getCategory(),"CATEGORY6", "class='select'", "")?>><a href="javascript:goCategory('CATEGORY6');">쇼핑</a></li>
		  	</ul>
		  	<? //menu ?>
