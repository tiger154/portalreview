<!--
$(document).ready( function() {	
	common.setLayer("reviewlayer");
	$('#cancelBtn').bind('click', function() { common.closeLayer('reviewlayer'); });
	try { category.set('cate1', 'cate2', 'cate3', 'cate4', ''); } catch(err) {}
	try { zipcode.set('bcode', 'mcode', 'scode', ''); } catch(err) {}
});

var reviewManager = {	
	_url: '',
	_rss: '',
	_item: '',
	_blogno: '',
	_html: '', 	
	initArticle: function() {
		$('#articleList tr:gt(0)').remove();
	},	
	initURL: function() {
		this._url = '';
		this._rss = '';
	},	
	closeModal: function(id) {
		$('#dialog-modal').dialog("close");
	},	
	loadRSSURL: function() {
		this._url = $('#blogList option:selected').val(); 
		if(this._url != "") {
			var url = "/myrevu/review.rssurl.load.proc";
			var data = "&blog_url=" + this._url;
			$.ajax({ type: "POST", url: url, data: data, success: this.loadRSSURLRequest });
			$('#dialog-modal').dialog({ autoOpen: true });
		} else {
			this.initURL();
		}
	},	
	loadRSSURLRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		if(result.result == "success") {
			reviewManager._rss = result.url;
		} else {
			$('#dialog').html("RSS정보를 찾을 수 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "RSS정보 오류" });
		}
	},	
	loadArticle: function() {		
		if(this._url != "" && this._rss != "") {
			var url = "/myrevu/review.article.load.proc";
			var data = "&rss_url=" + this._rss + "&blog_url=" + this._url ;
			$.ajax({ type: "POST", url: url, data: data, success: this.loadArticleRequest });
			$('#dialog-modal').dialog({ autoOpen: true });
		} else {
			$('#dialog').html("블로그 주소 또는 RSS XML주소가 잘못되었습니다.<br />블로그를 다시 선택해 주십시오. ");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "주소 오류" });
		}
	},	
	loadArticleRequest: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			reviewManager.initArticle();
			reviewManager.bindArticle(result.item);
		} else {
			$('#dialog-modal').dialog("close");
			$('#dialog').html("게시물이 없거나 불러올 수 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "게시물 오류" });
		}
	},	
	viewArticle: function(url) {
		common.redirectOpen(url, 'viewArticleWindow');
	},	
	bindArticle: function(item) {
		var table = $('#articleList');
		this.initArticle();
		var content = "";
		var amp = new RegExp("&amp;", "g");
		for(var i=0; i<item.length; i++) item[i].blogimage = item[i].blogimage.replace(amp, "&");
		this._item = item;
		for(var i=0; i<item.length; i++)
		{
			content += "<tr>";
			content += "	<td colspan='2' class='table12_line' align='center'>";
			content += "		<div class='common_text text_overlay17'>";
			content += item[i].date;
			content += "		</div>";
			content += "	</td>";
			content += "	<td colspan='2' class='table12_line' align='center'>";
			if(item[i].blogimage != "") {
			content += "		<img src='"+item[i].blogimage+"' width='50' height='50' />";
			} else {
			content += "		<img src='"+IMAGES+"/common/thum/thum_profile_dummy4.gif' width='50' height='50' />";	
			}
			content += "	</td>";
			content += "	<td colspan='2' class='table12_line'>";
			content += "		<div class='common_text text_overlay17'>";
			content += "			<a href='javascript:reviewManager.viewArticle(\""+item[i].guid+"\")'>"+item[i].title+"</a>";
			content += "		</div>";
			content += "	</td>";			
			content += "	<td colspan='2' class='table12_line' align='center'>";
			if(item[i].flag_review == "0") 
			content += "		<img src='/images/common/but/but_g_in.gif' id='reviewRegisterBtn"+i+"' alt='등록' title='등록' onClick='reviewManager.setForm1("+i+");' class='btn' />";
			content += "	</td>";
			content += "</tr>";
			//content += item[i].description;
		}
		table.append(content);
		$('#dialog-modal').dialog("close");
	},	
	setForm1: function(num) {
		var author = this._item[num].author;
		var category = this._item[num].category;
		var title = this._item[num].title;
		var link = this._item[num].link;
		var guid = this._item[num].guid;		
		var comments = this._item[num].comments;
		var description = this._item[num].description;
		var pubdate = this._item[num].pubdate;
		var blogimage = this._item[num].blogimage;
		var frno = "";
		var btnnum = num;
		this.initFormValue();
		this.initImage();	
		$('#reviewTitle').val(title);
		if(blogimage != null && blogimage != "") {
			$('#thumb_image').attr('src', blogimage);
			$('#thumb_image').attr('width', '80');
			$('#thumb_image').attr('height', '80');
		}
		this.setFormValue("B", "1", author, category, title, link, guid, comments, description, pubdate, blogimage, frno, btnnum);		
		$('#registBtn').bind('click', function() { reviewManager.registReview1(); });		
		//$('#dialog-modal').dialog({ autoOpen: true });
		common.openCenterLayer('reviewlayer', -1, -1, 100);
	},	
	registReview1: function() {
		$('#title').val($('#reviewTitle').val());
		if($('#reviewTitle').val() == "") {
			$('#dialog').html("제목을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "제목 확인"});
			return false;
		}
		if($('#cate1').val() == "") {
			$('#dialog').html("카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "카테고리 선택 체크"});
			return false;
		}
		/*
		if($('#cate2').val() == "" && $('#cate2 option').length > 1) {
			$('#dialog').html("2차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "2차 카테고리 선택 체크"});
			return false;
		}
		
		if($('#cate3').val() == "" && $('#cate3 option').length > 1) {
			$('#dialog').html("3차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "3차 카테고리 선택 체크"});
			return false;
		}
		*/		
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#reviewForm').attr('target', 'frm');
		$('#reviewForm').attr('method', 'post');
		$('#reviewForm').attr('action', '/myrevu/review.register.proc');					
		$('#reviewForm').submit();
	},	
	setForm2: function() {
		var author = "";
		var category = "";
		var title = "";
		var link = $('#feedURL').val();
		var guid = $('#feedURL').val();
		var comments = "";
		var description = "";
		var pubdate = "";
		var blogimage = "";
		var frno = "";
		var btnnum = "";
		this.initFormValue();
		this.initImage();
		$('#reviewTitle').val("");		
		this.setFormValue("U", "1", author, category, title, link, guid, comments, description, pubdate, blogimage, frno, btnnum);		
		$('#registBtn').bind('click', function() { reviewManager.registReview2(); });
		common.openCenterLayer('reviewlayer', -1, -1, 100);
	},	
	registReview2: function() {
		$('#title').val($('#reviewTitle').val());
		$('#link').val($('#feedURL').val());
		$('#guid').val($('#feedURL').val());
		if($('#title').val() == "") {
			$('#dialog').html("제목을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "제목 체크"});
			return false;
		}
		if($('#cate1').val() == "") {
			$('#dialog').html("카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "카테고리 선택 체크"});
			return false;
		}
		/*
		if($('#cate2').val() == "" && $('#cate2 option').length > 1) {
			$('#dialog').html("2차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "2차 카테고리 선택 체크"});
			return false;
		}
		
		if($('#cate3').val() == "" && $('#cate3 option').length > 1) {
			$('#dialog').html("3차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "3차 카테고리 선택 체크"});
			return false;
		}
		*/
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#reviewForm').attr('target', 'frm');
		$('#reviewForm').attr('method', 'post');
		$('#reviewForm').attr('action', '/myrevu/review.register.proc');					
		$('#reviewForm').submit();
	},	
	setForm3: function() {
		var author = "";
		var category = "";
		var title = "";
		var link = "";
		var guid = "";		
		var comments = "";
		var description = "";
		var pubdate = "";
		var blogimage = "";
		var frno = "";
		var btnnum = "";
		this.initFormValue();
		this.initImage();
		this.setFormValue("R", "1", author, category, title, link, guid, comments, description, pubdate, frno, btnnum);
	},	
	registReview3: function() {
		$('#title').val($('#reviewTitle').val());
		if($('#title').val() == "") {
			$('#dialog').html("제목을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰등록"});
			return false;
		}		
		if($('#cate1').val() == "") {
			$('#dialog').html("카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "카테고리 선택 체크"});
			return false;
		}
		/*
		if($('#cate2').val() == "" && $('#cate2 option').length > 1) {
			$('#dialog').html("2차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "2차 카테고리 선택 체크"});
			return false;
		}
		
		if($('#cate3').val() == "" && $('#cate3 option').length > 1) {
			$('#dialog').html("3차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "3차 카테고리 선택 체크"});
			return false;
		}
		*/
		/* 본문 내용이 입력되었는지 검사하는 부분 */
		var _validator = new Trex.Validator();
		var _content = Editor.getContent();
		if(!_validator.exists(_content)) {
			$('#dialog').html("내용을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰등록"});
			return false;
		}
		$('#description').val(_content);
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#reviewForm').attr('target', 'frm');
		$('#reviewForm').attr('method', 'post');
		$('#reviewForm').attr('action', '/myrevu/review.register.proc');
		//$('#reviewForm').submit();
		saveContent();
	}, 
	loadArticle2: function() {		
		if(this._url != "" && this._rss != "") {
			var url = "/myrevu/review.article.load.proc";
			var data = "&rss_url=" + this._rss;
			$.ajax({ type: "POST", url: url, data: data, success: this.loadArticleRequest2 });
			$('#dialog-modal').dialog({ autoOpen: true });
		} else {
			$('#dialog').html("블로그 주소 또는 RSS XML주소가 잘못되었습니다.<br />블로그를 다시 선택해 주십시오. ");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "주소 오류" });
		}
	},	
	loadArticleRequest2: function(data) {
		var result = $.parseJSON(data);
		if(result.result == "success") {
			reviewManager.initArticle();
			reviewManager.bindArticle2(result.item);
		} else {
			$('#dialog-modal').dialog("close");
			$('#dialog').html("게시물이 없거나 불러올 수 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "게시물 오류" });
		}
	},	
	bindArticle2: function(item) {
		this.initArticle();
		var table = $('#articleList');
		var content = "";
		var amp = new RegExp("&amp;", "g");
		for(var i=0; i<item.length; i++) item[i].blogimage = item[i].blogimage.replace(amp, "&");
		this._item = item;
		for(var i=0; i<item.length; i++)
		{
			content += "<tr>";
			content += "	<td colspan='2' class='table12_line' align='center' width='70'>";
			content += "		<div class='common_text'>";
			content += item[i].date;
			content += "		</div>";
			content += "	</td>";
			content += "	<td colspan='2' class='table12_line' align='center'>";
			if(item[i].blogimage != "") {
			content += "		<img src='"+item[i].blogimage+"' width='50' height='50' />";
			} else {
			content += "		<img src='"+IMAGES+"/common/thum/thum_profile_dummy4.gif' width='50' height='50' />";	
			}
			content += "	</td>";
			content += "	<td colspan='2' class='table12_line'>";
			content += "		<div class='common_text'>";
			content += "			<a href='javascript:reviewManager.viewArticle(\""+item[i].guid+"\")'>"+item[i].title+"</a>";
			content += "		</div>";
			content += "	</td>";			
			content += "	<td colspan='2' class='table12_line' align='center'>";
			if(item[i].flag_review == "0") 
			content += "		<img src='/images/common/but/but_g_in.gif' id='reviewRegisterBtn"+i+"' alt='등록' title='등록' onClick='reviewManager.setFormfrontier("+i+");' class='btn' />";
			content += "	</td>";
			content += "</tr>";
			//content += item[i].description;
		}
		table.append(content);
		$('#dialog-modal').dialog("close");
	},
	setFrontier: function(frno, subject) {
		$('#frno').val(frno);
		$('#subject').html(subject);

	},
	setFormfrontier: function(num) {
		var author = this._item[num].author;
		var category = this._item[num].category;
		var title = this._item[num].title;
		var link = this._item[num].link;
		var guid = this._item[num].guid;		
		var comments = this._item[num].comments;
		var description = this._item[num].description;
		var pubdate = this._item[num].pubdate;
		var blogimage = this._item[num].blogimage;
		var frno = $('#frno').val();
		var btnnum = num;
		this.initFormValue();
		this.initImage();
		$('#reviewTitle').val(title);
		if(blogimage != null && blogimage != "") {
			$('#thumb_image').attr('src', blogimage);
			$('#thumb_image').attr('width', '80');
			$('#thumb_image').attr('height', '80');
		}
		this.setFormValue("B", "1", author, category, title, link, guid, comments, description, pubdate, blogimage, frno, btnnum);
		$('#registBtn').bind('click', function() { reviewManager.registReviewfrontier(frno); });		
		//$('#dialog-modal').dialog({ autoOpen: true });
		common.closeLayer('entrylayer2');	
		common.openCenterLayer('reviewlayer', -1, -1, 90);
	},
	registReviewfrontier: function(frno) {
		$('#title').val($('#reviewTitle').val());
		if($('#cate1').val() == "") {
			$('#dialog').html("카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "카테고리 선택 체크"});
			return false;
		}
		/*
		if($('#cate2').val() == "" && $('#cate2 option').length > 1) {
			$('#dialog').html("2차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "2차 카테고리 선택 체크"});
			return false;
		}
		
		if($('#cate3').val() == "" && $('#cate3 option').length > 1) {
			$('#dialog').html("3차 카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "3차 카테고리 선택 체크"});
			return false;
		}
		*/
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#reviewForm').attr('target', 'frm');
		$('#reviewForm').attr('method', 'post');
		$('#reviewForm').attr('action', '/myrevu/review.register.proc/'+frno);					
		$('#reviewForm').submit();
	},	
	infoReview: function(rno) {
		var url = "/myrevu/review.info.proc";
		var data = "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: reviewManager.infoReviewRequest });
		$('#dialog-modal').dialog({ autoOpen: true });	
	}, 	
	infoReviewRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var review = result.review;
		var msg = "";
		if(result.result == "success") {
			reviewManager.initFormValue();
			$('#rno').val(review.rno);
			$('#reviewTitle').val(review.title);
			$('#registBtn').bind('click', function() { reviewManager.modifyReview(); });
			if(result.blogimage != null && result.blogimage != "") {
				$('#thumb_image').attr('src', result.blogimage);
				$('#thumb_image').attr('width', '80');
				$('#thumb_image').attr('height', '80');
			}
			try { category.set('cate1', 'cate2', 'cate3', 'cate4', result.cate); } catch(err) {}
			try { zipcode.set('bcode', 'mcode', 'scode', result.area); } catch(err) {}
			$('#addr').val(review.addr);
			common.openCenterLayer('reviewlayer', -1, -1, 100);
		} else if(result.result == "perm") {
			$('#dialog').html("본인의 리뷰만 읽어 올 수 있습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰수정" });
		}else {
			$('#dialog').html("리뷰정보를 읽어오는데 실패하였습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰수정" });
		}		
	}, 	
	modifyReview: function() {
		$('#title').val($('#reviewTitle').val());
		$('#link').val($('#feedURL').val());
		$('#guid').val($('#feedURL').val());
		if($('#title').val() == "") {
			$('#dialog').html("제목을 입력하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "제목 체크"});
			return false;
		}
		if($('#cate1').val() == "") {
			$('#dialog').html("카테고리를 선택하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "카테고리 선택 체크"});
			return false;
		}
		$('#dialog-modal').dialog({ autoOpen: true });
		$('#reviewForm').attr('target', 'frm');
		$('#reviewForm').attr('method', 'post');
		$('#reviewForm').attr('action', '/myrevu/review.modify.proc');					
		$('#reviewForm').submit();
	},	
	deleteReview: function(rno) {
		$('#dialog2').html("리뷰를 삭제하시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "리뷰삭제",		
			buttons: { 
				"리뷰삭제": function(e) { 
					$(this).dialog("close");
					var url = "/myrevu/review.delete.proc";
					var data = "&rno=" + rno;
					$.ajax({ type: "POST", url: url, data: data, success: reviewManager.deleteReviewRequest });
					$('#dialog-modal').dialog({ autoOpen: true });
				},
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	},	
	deleteReviewRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			common.reload();
		} else if(result.result == "info") {
			msg = "정보가 부족합니다.";
		} else if(result.result == "perm") {
			msg = "삭제할 권한이 없습니다.";
		} else if(result.result == "cash") {
			msg = "캐시를 지급받은 리뷰는 삭제 할 수 없습니다.";
		} else {
			msg = "리뷰삭제가 실패하였습니다.";
		}
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰삭제" });
	},	
	chooseDeleteReview: function(checkno) {
		$('#dialog2').html("선택한 리뷰를 삭제하시겠습니까?");
		$('#dialog2').dialog({ 
			autoOpen: true, width: "300", height:"150", title: "리뷰삭제",		
			buttons: { 
				"리뷰삭제": function(e) { 
					$(this).dialog("close");
					var url = "/myrevu/review.choose.delete.proc";
					var data = "&checkno=" + checkno;
					$.ajax({ type: "POST", url: url, data: data, success: reviewManager.chooseDeleteReviewRequest });
					$('#dialog-modal').dialog({ autoOpen: true });
				},
				"닫기": function() { $(this).dialog("close");} 
			}
		});
	},	
	chooseDeleteReviewRequest: function(data) {		
		var result = $.parseJSON(data);
		var msg = "";
		if(result.result == "success") {
			common.reload();
		} else {
			$('#dialog-modal').dialog("close");
			if(result.result == "info") {
				msg = "정보가 부족합니다.";
			} else if(result.result == "perm") {
				msg = "삭제할 권한이 없습니다.";
			} else {
				msg = "리뷰삭제가 실패하였습니다.";
			}
			$('#dialog').html(msg);
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"160", title: "리뷰삭제" });	
		} 		
	},	
	resultForm: function(type) {
		var msg = "";
		this.closeModal();
		switch(type) {
			case "success" :
				$('#dialog2').dialog("close");
				msg = "리뷰가 등록되었습니다.";
				$('#reviewRegisterBtn'+$('#btnnum').val()).hide();
				break;
			case "wrongblog" :
				msg = "블로그 정보가 정확하지 않습니다."; 
				break;
			case "repeat" :
				$('#dialog2').dialog("close");
				msg = "이미등록된 리뷰입니다."; 
				break;
			case "info" :
				$('#dialog2').dialog("close");
				msg = "리뷰수정에 필요한 정보가 없습니다."; 
				break;
			case "perm" :
				$('#dialog2').dialog("close");
				msg = "리뷰수정에 필요한 권한이 없습니다."; 
				break;
			case "update" :
				$('#dialog2').dialog("close");
				msg = "리뷰가 업데이트 되었습니다."; 
				break;
			case "updatefail" :
				$('#dialog2').dialog("close");
				msg = "리뷰업데이트가 실패하였습니다."; 
				break;
			default :
				msg = "리뷰등록이 실패하였습니다.";
				break;
		}
		common.closeLayer("reviewlayer");
		$('#dialog').html(msg);
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰등록 결과"});
		if(type == "update") common.reload();
		return false;
	},		
	initFormValue: function() {
		$('#blogURL').val("");
		$('#feedURL').val("");
		$('#type').val("");
		$('#status').val("");
		$('#author').val("");
		$('#category').val("");
		$('#title').val("");
		$('#link').val("");
		$('#guid').val("");
		$('#comments').val("");
		$('#description').val("");
		$('#pubdate').val("");
		$('#blogimage').val("");
		$('#frno').val("");
		$('#rno').val("");
		$('#btnnum').val("");
		category.init('cate1', "1차분류선택");
		category.init('cate2', "2차분류선택");
		category.init('cate3', "3차분류선택");
		zipcode.init('bcode', "지역선택");
		zipcode.init('mcode', "지역선택");
		zipcode.init('scode', "지역선택");
		try { category.set('cate1', 'cate2', 'cate3', 'cate4', ''); } catch(err) {}
		try { zipcode.set('bcode', 'mcode', 'scode', ''); } catch(err) {}
		$('#addr').val("");
		$("#file1").remove();
		$("#fileform").append("<input type='file' name='file1' id='file1' onChange='reviewManager.changeImage();' />");		
		$("#thumbmime").val("");
		$("#thumbname").val("");
		$("#thumbsize").val("");
	},	
	setFormValue: function(type, status, author, category, title, link, guid, comments, description, pubdate, blogimage, frno, btnnum) {
		$('#blogURL').val($('#blogList').val());
		$('#feedURL').val($('#feedFormURL').val());
		$('#type').val(type);
		$('#status').val(status);
		$('#author').val(author);
		$('#category').val(category);
		$('#title').val(title);
		$('#link').val(link);
		$('#guid').val(guid);
		$('#comments').val(comments);
		$('#description').val(description);
		$('#pubdate').val(pubdate);
		$('#blogimage').val(blogimage);
		$('#frno').val(frno);
		$('#btnnum').val(btnnum);
	},	
	changeImage: function() {				
		if($('#file1').val() != "") {
			if(validation.isImageFile($('#file1').val()) == false) {
				$('#file1').val(""); 
				$('#dialog').html("이미지 파일(gif,jpg,png)만 가능합니다.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"1y67t50", title: "프로필 이미지 확인"});
			} else {
				$('#dialog-modal').dialog({ autoOpen: true });
				$('#reviewForm').attr('target', 'frm');
				$('#reviewForm').attr('method', 'post');
				$('#reviewForm').attr('action', '/myrevu/review.image.upload.proc');
				//$("#reviewForm > form[name='reviewForm']").submit();
				document.reviewForm.submit();
			}
		}
	},	
	previewImage: function(filemime, filename, filesize) {
		$('#dialog-modal').dialog("close");
		$('#thumbmime').val(filemime);
		$('#thumbname').val(filename);
		$('#thumbsize').val(filesize);
		$('#thumb_image').attr('width', '80');
		$('#thumb_image').attr('height', '80');
		$('#thumb_image').attr('src', DOMAIN_FILE+'/tmp/' + filename);
	},	
	initImage: function() {
		$('#dialog-modal').dialog("close");
		$('#thumbmime').val("");
		$('#thumbname').val("");
		$('#thumbsize').val("");
		$('#thumb_image').attr('width', '80');
		$('#thumb_image').attr('height', '80');
		$('#thumb_image').attr('src', IMAGES+'/common/profile_blank.gif');
	},	
	checkImage: function() {
		reviewManager.initImage();
		$('#dialog').html("썸네일 이미지업로드가 실패하였습니다.");
		$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "썸네일 이미지 확인"});
	},	
	changeCate1: function(cate1, cate2, cate3, cate4) {
		var _cate1 = $("#"+cate1+" option:selected").val();
		category.search2(_cate1, cate2, cate3, cate4);
	},
	changeCate2: function(cate1, cate2, cate3, cate4) {
		var _cate1 = $("#"+cate1+" option:selected").val();
		var _cate2 = $("#"+cate2+" option:selected").val();
		category.search3(_cate1, _cate2, cate3, cate4);		
	},
	changeCate3: function(cate1, cate2, cate3, cate4) {
		var _cate1 = $("#"+cate1+" option:selected").val();
		var _cate2 = $("#"+cate2+" option:selected").val();
		var _cate3 = $("#"+cate3+" option:selected").val();
		category.search4(_cate1, _cate2, _cate3, cate4);		
	},
	changeArea1: function(bcode, mcode, scode) {
		var _bcode = $("#"+bcode+" option:selected").val();
		zipcode.searchMcode(_bcode, mcode, scode);
	},
	changeArea2: function(bcode, mcode, scode) {
		var _bcode = $("#"+bcode+" option:selected").val();
		var _mcode = $("#"+mcode+" option:selected").val();
		zipcode.searchScode(_bcode, _mcode, scode);
	}
};
-->