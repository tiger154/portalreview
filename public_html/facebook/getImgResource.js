var img_cnt = document.getElementsByTagName('img').length;

//alert(img_cnt);
//alert(document.getElementsByTagName('img')[0].width);
//alert(document.getElementsByTagName('img')[0].height);
//alert(document.getElementsByTagName('img')[0].src);
//



$(document).ready(function() {
		var jimg_cnt = $('img').length;
		var tmp_cnt=0;
		var divimgTxt='';

		for(var i=0; i < jimg_cnt; i++){
			if($('img')[i].width > 89){
				//alert($('img')[i].src+"/////"+$('img')[i].width+"/////"+$('img')[i].height);
				//divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"'width='100' height='100' class='thumb' alt='"+$('img')[i].width+"'/>";
				
				divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"' class='thumb' alt='PassionSNS' width='"+$('img')[i].width+"' height='"+$('img')[i].height+"' />";
				//tmp_cnt++;
			}
			
		}

		ResultTxt = "<div style='position:fixed;	 z-index:8675309; top:0; right:0; bottom:0; left:0; background-color:#e2e2e2; opacity:.95;'>";
		ResultTxt = ResultTxt+divimgTxt;
		ResultTxt = ResultTxt+"</div>";
		//alert(ResultTxt);
		$(ResultTxt).appendTo("body");
			

		$(".thumb").thumbs();
		
});


