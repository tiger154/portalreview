<!--
$(document).ready( function() {	
	$('#blogList').bind('change', function() { reviewManager.loadRSSURL(); });
	$('#blogLoadBtn').bind('click', function() { reviewManager.loadArticle2(); });
	$('#frontierEntryMoreBtn').bind({ 'click' : function() { common.redirect("/myrevu/frontier"); } });
	$('#frontierWinMoreBtn').bind({ 'click' : function() { common.redirect("/myrevu/frontier"); } });	
	$('#frontierWin').css("display", "none");		
	$('#frontierTab1').bind('click', function() {
		$('#frontierTab1').attr("src", IMAGES+"/myrevu/tab_frontier_on1.gif");
		$('#frontierTab2').attr("src", IMAGES+"/myrevu/tab_frontier_off2.gif");
		$('#frontierEntry').show();
		$('#frontierWin').hide(); 
	});	
	$('#frontierTab2').bind('click', function() {
		$('#frontierTab1').attr("src", IMAGES+"/myrevu/tab_frontier_off1.gif");
		$('#frontierTab2').attr("src", IMAGES+"/myrevu/tab_frontier_on2.gif");
		$('#frontierEntry').hide();
		$('#frontierWin').show(); 
	});
	$('#reviewMoreBtn').bind({ 'click' : function() { common.redirect("/myrevu/review"); } });
	$('#friendMoreBtn').bind({ 'click' : function() { common.redirect("/myrevu/friend"); } });
	$('#friendTab1').bind('click', function() { myrevu.showFriend(1); });	
	$('#friendTab2').bind('click', function() { myrevu.showFriend(2); });
	$('#friendTab3').bind('click', function() {	myrevu.showFriend(3); });
	for(var i=2; i<=myrevu._friendSize; i++) $('#friendList'+i).hide();
	$('#socialTalk2').css("display", "none");		
	$('#socialTab1').bind('click', function() {
		$('#socialTab1').attr("src", IMAGES+"/myrevu/tab_socialtalk_on1.gif");
		$('#socialTab2').attr("src", IMAGES+"/myrevu/tab_socialtalk_off2.gif");
		$('#socialTalk1').show();
		$('#socialTalk2').hide(); 
	});	
	$('#socialTab2').bind('click', function() {
		$('#socialTab1').attr("src", IMAGES+"/myrevu/tab_socialtalk_off1.gif");
		$('#socialTab2').attr("src", IMAGES+"/myrevu/tab_socialtalk_on2.gif");
		$('#socialTalk1').hide();
		$('#socialTalk2').show(); 
	});
});

var myrevu = {
	_friendSize : 3,	
	showFriend: function(num) {
		for(var i=1; i<=this._friendSize; i++) {
			if(num == i) {
				$('#friendList'+i).show();
				$('#friendTab'+i).attr('src', IMAGES+'/myrevu/tab_friend_on'+i+'.gif');
			} else {
				$('#friendList'+i).hide();
				$('#friendTab'+i).attr('src', IMAGES+'/myrevu/tab_friend_off'+i+'.gif');
			} 
		}
	}
};
-->