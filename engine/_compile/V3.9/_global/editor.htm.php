<?php /* Template_ 2.2.4 2011/10/21 17:02:44 /www/revu39/engine/view/V3.9/_global/editor.htm 000015064 */ ?>
<style type="text/css">	
/* width, position  */
.wrapper { width: 100%; }
</style>
<!-- 에디터 시작 -->
<!--
	@decsription 
	등록하기 위한 Form으로 상황에 맞게 수정하여 사용한다. Form 이름은 에디터를 생성할 때 설정값으로 설정한다. 
-->
<div class="wrapper">
	<!-- 에디터 컨테이너 시작 -->
	<div id="tx_trex_container" class="tx-editor-container">
		<!-- 사이드바 -->
		<div id="tx_sidebar" class="tx-sidebar">
			<div class="tx-sidebar-boundary">
				<!-- 사이드바 / 첨부 -->
				<ul class="tx-bar tx-bar-left tx-nav-attach">
					<!-- 이미지 첨부 버튼 시작 -->
					<!--
						@decsription 
						<li></li> 단위로 위치를 이동할 수 있다. 
					-->
					<li class="tx-list">
						<div unselectable="on" id="tx_image" class="tx-image tx-btn-trans">
							<a href="javascript:;" title="사진" class="tx-text">사진</a>
						</div>
					</li>
					<!-- 이미지 첨부 버튼 끝 -->
					<li class="tx-list">
						<div unselectable="on" id="tx_file" class="tx-file tx-btn-trans">
							<a href="javascript:;" title="파일" class="tx-text">파일</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" id="tx_media" class="tx-media tx-btn-trans">
							<a href="javascript:;" title="외부컨텐츠" class="tx-text">외부컨텐츠</a>
						</div>
					</li>
					<li class="tx-list tx-list-extra">
						<div unselectable="on" class="tx-btn-nlrbg tx-extra">
							<a href="javascript:;" class="tx-icon" title="버튼 더보기">버튼 더보기</a>
						</div>
						<ul class="tx-extra-menu tx-menu" style="left:-48px;" unselectable="on">
							<!-- 
								@decsription
								일부 버튼들을 빼서 레이어로 숨기는 기능을 원할 경우 이 곳으로 이동시킬 수 있다. 
							-->
						</ul>
					</li>
				</ul>
				<!-- 사이드바 / 우측영역 -->
				<ul class="tx-bar tx-bar-left tx-group-etc">
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-lbg tx-emoticon" id="tx_emoticon">
							<a href="javascript:;" class="tx-icon" title="이모티콘">이모티콘</a>
						</div>
						<div id="tx_emoticon_menu" class="tx-emoticon-menu tx-menu" unselectable="on"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-link" id="tx_link">
							<a href="javascript:;" class="tx-icon" title="링크 (Ctrl+K)">링크</a>
						</div>
						<div id="tx_link_menu" class="tx-link-menu tx-menu"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-specialchar" id="tx_specialchar">
							<a href="javascript:;" class="tx-icon" title="특수문자">특수문자</a>
						</div>
						<div id="tx_specialchar_menu" class="tx-specialchar-menu tx-menu"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-table" id="tx_table">
							<a href="javascript:;" class="tx-icon" title="표만들기">표만들기</a>
						</div>
						<div id="tx_table_menu" class="tx-table-menu tx-menu" unselectable="on">
							<div class="tx-menu-inner">
								<div class="tx-menu-preview"></div>
								<div class="tx-menu-rowcol"></div>
								<div class="tx-menu-deco"></div>
								<div class="tx-menu-enter"></div>
							</div>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-rbg tx-horizontalrule" id="tx_horizontalrule">
							<a href="javascript:;" class="tx-icon" title="구분선">구분선</a>
						</div>
						<div id="tx_horizontalrule_menu" class="tx-horizontalrule-menu tx-menu" unselectable="on"></div>
					</li>
				</ul>
				<ul class="tx-bar tx-bar-left"> 
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-lbg tx-textbox" id="tx_textbox">
							<a href="javascript:;" class="tx-icon" title="글상자">글상자</a>
						</div>		
						<div id="tx_textbox_menu" class="tx-textbox-menu tx-menu"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-quote" id="tx_quote">
							<a href="javascript:;" class="tx-icon" title="인용구 (Ctrl+Q)">인용구</a>
						</div>
						<div id="tx_quote_menu" class="tx-quote-menu tx-menu" unselectable="on"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-background" id="tx_background">
							<a href="javascript:;" class="tx-icon" title="배경색">배경색</a>
						</div>
						<div id="tx_background_menu" class="tx-menu tx-background-menu tx-colorpallete" unselectable="on"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-rbg tx-dictionary" id="tx_dictionary">
							<a href="javascript:;" class="tx-icon" title="사전">사전</a>
						</div>
					</li>
				</ul> 
				<ul class="tx-bar tx-bar-left tx-group-undo"> 
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-lbg tx-undo" id="tx_undo">
							<a href="javascript:;" class="tx-icon" title="실행취소 (Ctrl+Z)">실행취소</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-rbg tx-redo" id="tx_redo">
							<a href="javascript:;" class="tx-icon" title="다시실행 (Ctrl+Y)">다시실행</a>
						</div>
					</li>
				</ul> 
				<ul class="tx-bar tx-bar-right tx-nav-opt">
					<li class="tx-list">
						<div unselectable="on" class="tx-switchtoggle" id="tx_switchertoggle">
							<a href="javascript:;" title="에디터 타입">에디터</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- 툴바 - 기본 시작 -->
		
		<!-- 
			@decsription
			툴바 버튼의 그룹핑의 변경이 필요할 때는 위치(왼쪽, 가운데, 오른쪽) 에 따라 <li> 아래의 <div>의 클래스명을 변경하면 된다.
			tx-btn-lbg: 왼쪽, tx-btn-bg: 가운데, tx-btn-rbg: 오른쪽, tx-btn-lrbg: 독립적인 그룹
		
			드롭다운 버튼의 크기를 변경하고자 할 경우에는 넓이에 따라 <li> 아래의 <div>의 클래스명을 변경하면 된다.
			tx-slt-70bg, tx-slt-59bg, tx-slt-42bg, tx-btn-43lrbg, tx-btn-52lrbg, tx-btn-57lrbg, tx-btn-71lrbg
			tx-btn-48lbg, tx-btn-48rbg, tx-btn-30lrbg, tx-btn-46lrbg, tx-btn-67lrbg, tx-btn-49lbg, tx-btn-58bg, tx-btn-46bg, tx-btn-49rbg
		-->  
		<div id="tx_toolbar_basic" class="tx-toolbar tx-toolbar-basic">
			<div class="tx-toolbar-boundary">
				<ul class="tx-bar tx-bar-left">
					<li class="tx-list">
						<div id="tx_fontfamily" unselectable="on" class="tx-slt-70bg tx-fontfamily">
							<a href="javascript:;" title="글꼴">굴림</a>
						</div>
						<div id="tx_fontfamily_menu" class="tx-fontfamily-menu tx-menu" unselectable="on"></div>
					</li>
				</ul>
				<ul class="tx-bar tx-bar-left">
					<li class="tx-list">
						<div unselectable="on" class="tx-slt-42bg tx-fontsize" id="tx_fontsize">
							<a href="javascript:;" title="글자크기">9pt</a>
						</div>
						<div id="tx_fontsize_menu" class="tx-fontsize-menu tx-menu" unselectable="on"></div>
					</li>
				</ul>
				<ul class="tx-bar tx-bar-left tx-group-font">
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-lbg tx-bold" id="tx_bold">
							<a href="javascript:;" class="tx-icon" title="굵게 (Ctrl+B)">굵게</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-underline" id="tx_underline">
							<a href="javascript:;" class="tx-icon" title="밑줄 (Ctrl+U)">밑줄</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-italic" id="tx_italic">
							<a href="javascript:;" class="tx-icon" title="기울임 (Ctrl+I)">기울임</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-strike" id="tx_strike">
							<a href="javascript:;" class="tx-icon" title="취소선 (Ctrl+D)">취소선</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-slt-tbg tx-forecolor" style="background-color:#5c7fb0;" id="tx_forecolor">
							<a href="javascript:;" class="tx-icon" title="글자색">글자색</a>
							<a href="javascript:;" class="tx-arrow" title="글자색 선택">글자색 선택</a>
						</div>
						<div id="tx_forecolor_menu" class="tx-menu tx-forecolor-menu tx-colorpallete" unselectable="on"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-slt-brbg tx-backcolor" style="background-color:#5c7fb0;" id="tx_backcolor">
							<a href="javascript:;" class="tx-icon" title="글자 배경색">글자 배경색</a>
							<a href="javascript:;" class="tx-arrow" title="글자 배경색 선택">글자 배경색 선택</a>
						</div>
						<div id="tx_backcolor_menu" class="tx-menu tx-backcolor-menu tx-colorpallete" unselectable="on"></div>
					</li>
				</ul>
				<ul class="tx-bar tx-bar-left tx-group-align"> 
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-lbg tx-alignleft" id="tx_alignleft">
							<a href="javascript:;" class="tx-icon" title="왼쪽정렬 (Ctrl+,)">왼쪽정렬</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-aligncenter" id="tx_aligncenter">
							<a href="javascript:;" class="tx-icon" title="가운데정렬 (Ctrl+.)">가운데정렬</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-bg tx-alignright" id="tx_alignright">
							<a href="javascript:;" class="tx-icon" title="오른쪽정렬 (Ctrl+/)">오른쪽정렬</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-rbg tx-alignfull" id="tx_alignfull">
							<a href="javascript:;" class="tx-icon" title="양쪽정렬">양쪽정렬</a>
						</div>
					</li>
				</ul>
				<ul class="tx-bar tx-bar-left tx-group-tab"> 
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-lbg tx-indent" id="tx_indent">
							<a href="javascript:;" title="들여쓰기 (Tab)" class="tx-icon">들여쓰기</a>
						</div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-rbg tx-outdent" id="tx_outdent">
							<a href="javascript:;" title="내어쓰기 (Shift+Tab)" class="tx-icon">내어쓰기</a>
						</div>
					</li>
				</ul>
				<ul class="tx-bar tx-bar-left tx-group-list">
					<li class="tx-list">
						<div unselectable="on" class="tx-slt-31lbg tx-lineheight" id="tx_lineheight">
							<a href="javascript:;" class="tx-icon" title="줄간격">줄간격</a>
							<a href="javascript:;" class="tx-arrow" title="줄간격">줄간격 선택</a>
						</div>
						<div id="tx_lineheight_menu" class="tx-lineheight-menu tx-menu" unselectable="on"></div>
					</li>
					<li class="tx-list">
						<div unselectable="on" class="tx-slt-31rbg tx-styledlist" id="tx_styledlist">
							<a href="javascript:;" class="tx-icon" title="리스트">리스트</a>
							<a href="javascript:;" class="tx-arrow" title="리스트">리스트 선택</a>
						</div>
						<div id="tx_styledlist_menu" class="tx-styledlist-menu tx-menu" unselectable="on"></div>
					</li>
				</ul>
				<ul class="tx-bar tx-bar-right">
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-nlrbg tx-advanced" id="tx_advanced">
							<a href="javascript:;" class="tx-icon" title="툴바 더보기">툴바 더보기</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- 툴바 - 기본 끝 -->
		
		<!-- 툴바 - 더보기 시작 -->
		<div id="tx_toolbar_advanced" class="tx-toolbar tx-toolbar-advanced">
			<div class="tx-toolbar-boundary">
				<ul class="tx-bar tx-bar-left tx-group-order">
					
				</ul>
				<ul class="tx-bar tx-bar-right">
					<li class="tx-list">
						<div unselectable="on" class="tx-btn-lrbg tx-fullscreen" id="tx_fullscreen">
							<a href="javascript:;" class="tx-icon" title="넓게쓰기 (Ctrl+M)">넓게쓰기</a>
						</div>
					</li>
				</ul>
			</div>				
		</div>
		<!-- 툴바 - 더보기 끝 -->
			
		<!-- 편집영역 시작 -->
		<!-- 에디터 Start -->
		<div id="tx_canvas" class="tx-canvas">
			<div id="tx_loading" class="tx-loading"><div><img src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/images/icon/loading2.png?rv=1.0.1" width="113" height="21" align="absmiddle"/></div></div>
			<div id="tx_canvas_wysiwyg_holder" class="tx-holder" style="display:block;">
				<iframe id="tx_canvas_wysiwyg" name="tx_canvas_wysiwyg" allowtransparency="true" frameborder="0"></iframe>
			</div>
			<div class="tx-source-deco">
				<div id="tx_canvas_source_holder" class="tx-holder">
					<textarea id="tx_canvas_source" rows="30" cols="30"></textarea>
				</div>
			</div>
			<div id="tx_canvas_text_holder" class="tx-holder">
				<textarea id="tx_canvas_text" rows="30" cols="30"></textarea>
			</div>	
		</div>
		<!-- 높이조절 Start -->
		<div id="tx_resizer" class="tx-resize-bar">
			<div class="tx-resize-bar-bg"></div>
			<img id="tx_resize_holder" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/images/icon/btn_drag01.gif" width="58" height="12" unselectable="on" alt="" />
		</div>
		<div class="tx-side-bi" id="tx_side_bi">
			<div style="text-align: right;">
				<img hspace="4" height="14" width="78" align="absmiddle" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/images/icon/editor_bi.png?rv=1.0.1" />
			</div>
		</div>
		
		<!-- 편집영역 끝 -->
		<!-- 첨부박스 시작 -->
		<!-- 파일첨부박스 Start -->
		<div id="tx_attach_div" class="tx-attach-div">
			<div id="tx_attach_txt" class="tx-attach-txt">파일 첨부</div>
			<div id="tx_attach_box" class="tx-attach-box">
				<div class="tx-attach-box-inner">
					<div id="tx_attach_preview" class="tx-attach-preview"><p></p><img src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.daum/images/icon/pn_preview.gif" width="147" height="108" unselectable="on"/></div>
					<div class="tx-attach-main">
						<div id="tx_upload_progress" class="tx-upload-progress"><div>0%</div><p>파일을 업로드하는 중입니다.</p></div>
						<ul class="tx-attach-top">
							<li id="tx_attach_delete" class="tx-attach-delete"><a>전체삭제</a></li>
							<li id="tx_attach_size" class="tx-attach-size">
								파일: <span id="tx_attach_up_size" class="tx-attach-size-up"></span>/<span id="tx_attach_max_size"></span>
							</li>
							<li id="tx_attach_tools" class="tx-attach-tools">
							</li>
						</ul>
						<ul id="tx_attach_list" class="tx-attach-list"></ul>
					</div>
				</div>
			</div>
		</div>
		<!-- 첨부박스 끝 -->
	</div>
<!-- 에디터 컨테이너 끝 -->
</div>
<!-- 에디터 끝 -->