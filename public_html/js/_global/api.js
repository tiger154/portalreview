var bitly = {
	shorten: function(longurl, callback) {
		var url = "/api/bitly.shorten.url.proc";
		var data = "&longurl=" + longurl + "&callback=" + callback;
		$.ajax({ type: "POST", url: url, data: data, success: this.shortenRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	},	
	shortenRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);
		var bResult = result.result;
		//status_code, status_text, data.long_url, data.url, data.hash, data.global_hash, data.new_hash
		switch(bResult.status_code) {
			case 200 :
				if(result.callback != "") eval(result.callback);
				break; 
			default :  
				$('#dialog').html("처리가 실패하였습니다. 다시 시도하세요.");
				$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "bit.ly-URL 처리 실패" });
				break;
		}
	}
};

var facebook = {
	todo: function(todo, param) {
		if(typeof(param) == "undefined") param = "";
		var url = "/api/facebook/"+todo;
		if(param != "") url += "/" + param;
		common.popup('facebookPopup', url, 1000, 600);
	},	
	wallProc: function(rno) {
		var msg = $('#facebookWall').val();
		if(msg == "") {
			$('#dialog').html("내용이 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "페이스북 담벼락" });
			return false;
		}
		var url = "/api/facebook.wall.proc";
		var data = "&rno=" + rno + "&msg=" + msg;
		$.ajax({ type: "POST", url: url, data: data, success: this.wallProcRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 	
	wallProcRequest: function(data) {
		$('#dialog-modal').dialog("close");
		common.closeLayer("popuplayer");
		var result = $.parseJSON(data);		
		if(result.result == "success") {
			alert("페이스북 담벼락에 글을 남겼습니다.");
			self.close();
		} else {
			alert("페이스북 담벼락에 글을 남기기가 실패하였습니다. 다시 시도하세요.");
			//opener.twitter.todo("tweet", result.rno);
		}		
	}
};

var twitter = {		
	initSession: function() {
		var url = "/api/twitter.session.init.proc";
		var data = "";
		$.ajax({ type: "POST", url: url, data: data, success: this.initSessionRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 	
	initSessionRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);		
		if(result.result == "success") {} else {}
	}, 	
	todo: function(todo, param) {
		if(typeof(param) == "undefined") param = "";
		var url = "/api/twitter/"+todo;
		if(param != "") url += "/" + param;
		common.popup('twitterPopup', url, 700, 500);
	}, 	
	tweet: function(rno) {
		var url = "/api/twitter.tweet.info.proc";
		var data = "&rno=" + rno;
		$.ajax({ type: "POST", url: url, data: data, success: this.tweetRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 	
	tweetRequest: function(data) {
		$('#dialog-modal').dialog("close");
		var result = $.parseJSON(data);		
		if(result.result == "success") {
			$('#popuplayer').html("");
			var msg = result.url + " " + result.title;
			var html = "";
			html += "<div class='review_tweet_box'>";
			html += "<textarea id='reviewTweet' cols='60' row='8' onKeyPress='common.setTextLimit(\"reviewTweet\", \"reviewTweetNum\", 140);' onKeyDown='common.setTextLimit(\"reviewTweet\", \"reviewTweetNum\", 140);' >"+msg+"</textarea><br />";
			html += "<input type='text' id='reviewTweetNum' size='4' value=0 > / 140byte <br />";
			html += "<input type='button' value='트윗' onClick='twitter.tweetProc("+result.rno+");' />";
			html += "<input type='button' value='닫기' onClick='common.closeLayer(\"popuplayer\");' />";
			html += "</div>";
			$('#popuplayer').html(html);
			common.setTextLimit("reviewTweet", "reviewTweetNum", 140);
			$('#popuplayer').show();			
			common.openCenterLayer('popuplayer', 500, 150, 100);
		} else if(result.result == "review") {
			$('#dialog').html("리뷰가 존재 하지 않습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰트윗" });
		} else if(result.result == "shorten") {
			$('#dialog').html("짧은URL 연동이 실패하였습니다. 다시 시도하세요.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰트윗" });
		} else {
			twitter.todo("auth", "");
		}
	}, 	
	tweetProc: function(rno) {
		var msg = $('#reviewTweet').val();
		if(msg == "") {
			$('#dialog').html("내용이 없습니다.");
			$('#dialog').dialog({ autoOpen: true, width: "300", height:"150", title: "리뷰트윗" });
		}
		var url = "/api/twitter.tweet.proc";
		var data = "&rno=" + rno + "&msg=" + msg;
		$.ajax({ type: "POST", url: url, data: data, success: this.tweetProcRequest });
		$('#dialog-modal').dialog({ autoOpen: true });
	}, 	
	tweetProcRequest: function(data) {
		$('#dialog-modal').dialog("close");
		common.closeLayer("popuplayer");
		var result = $.parseJSON(data);		
		if(result.result == "success") {
			alert("리뷰가 트윗되었습니다.");
			self.close();
		} else {
			alert("리뷰 트윗이 실패하였습니다. 다시 시도하세요.");
			//opener.twitter.todo("tweet", result.rno);
		}
	}
};