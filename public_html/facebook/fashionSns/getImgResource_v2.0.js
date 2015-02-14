/*
javascript: void((function () {
    var e = document.createElement('script');
    e.setAttribute('type', 'text/javascript');
    e.setAttribute('charset', 'UTF-8');
    e.setAttribute('src', 'http://www.revu.co.kr/facebook/fashionSns/getImgResource_v2.0.js?r=' + Math.random() * 99999999);

	var f = document.createElement('script');
    f.setAttribute('src','http://www.revu.co.kr/extends/js.jquery/jquery.js');
	var g = document.createElement('script');
    g.setAttribute('src','http://www.revu.co.kr/extends/js.jquery.ui/jquery-ui-1.8.13.custom.min.js');
	var h = document.createElement('script');
    h.setAttribute('src','http://www.revu.co.kr/js/jquery.nailthumb.1.1.js');
	var j = document.createElement('script');
    j.setAttribute('src','http://www.revu.co.kr/js/jquery.imgpreload.js');
	var k = document.createElement('script');
    k.setAttribute('src','http://www.revu.co.kr/js/jquery.waitforimages.js');





	var i = document.createElement('link');
	i.setAttribute('type', 'text/css');
	i.setAttribute('rel', 'stylesheet');
    i.setAttribute('href','http://www.revu.co.kr/css/passion/jquery.nailthumb.1.1.css');
	

    document.body.appendChild(e);
	document.body.appendChild(f);
	document.body.appendChild(g);
	document.body.appendChild(h);
	document.body.appendChild(i);
	document.body.appendChild(j);
	document.body.appendChild(k);
})());

*/

$(document).ready(function() {

		var jimg_cnt = $('img').length; // 이미지 총 갯수 
		var tmp_cnt=0;
		var img_load_cnt =0;
		var divimgTxt=''; // 반복 이미지 html문 저장용 변수
		var onloadCount=0; 
		var image = new Image(); // 실제 이미지 정보를 구하기 위한 객체 생성 
		var swidth = 0; // 이미지 임시 넓이
        var sheight = 0; // 이미지 임시 높이
		var thumbsize = 200; // 썸네일 제한 사이즈 
		var crallingsize = 89; // (크롤링)검색 제한 사이즈

		// 이미지 
		for(var i=0; i < jimg_cnt; i++){
				image.src = $('img')[i].src;		
				swidth = image.width;
				sheight = image.height;
			   //&&  image.src.indexOf("img/common") < 0 &&  image.src.indexOf("images/common") < 0
				
				if(swidth > crallingsize && sheight > crallingsize  ){
							//alert($('img')[i].src+"/////"+$('img')[i].width+"/////"+$('img')[i].height);
							//divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"'width='100' height='100' class='thumb' alt='"+$('img')[i].width+"'/>";
							 if(swidth >= sheight) {
									if(swidth > thumbsize) {
										sratio = Math.round((thumbsize / swidth) * 100);
										nwidth = Math.round(swidth * sratio / 100);
										nheight = Math.round(sheight * sratio / 100);										
//										nheight = thumbsize;
//										nwidth = thumbsize * (swidth / sheight);
										//this.style.marginLeft = 0 - (this.width - a.a.thumbsize) / 2 + "px"
										divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"' width='"+nwidth+"' height='"+nheight+"'/>";
								   } else {
										divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"' />";
								   }
							 } else {
								 if(sheight > thumbsize) {
									sratio = Math.round((thumbsize / sheight) * 100);
									nwidth = Math.round(swidth * sratio / 100);
									nheight = Math.round(sheight * sratio / 100); 									
//									nwidth = thumbsize;
//									nheight = thumbsize * (sheight / swidth);
//									this.style.marginTop = 0 - (this.height - a.a.thumbsize) / 2 + "px"
									divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"' width='"+nwidth+"' height='"+nheight+"'/>";
								   } else {
									divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"' />";	
								   }
							}

							image.onload = function() {
		//						divimgTxt = divimgTxt+"<div class='nailthumb-container' ><img src='"+$('img')[i].src+"' title='resize'/></div>";
								onloadCount++;
							};	
							//divimgTxt = divimgTxt+"<img src='"+$('img')[i].src+"' class='thumb' alt='PassionSNS' width='"+$('img')[i].width+"' height='"+$('img')[i].height+"' />";
							tmp_cnt++;					
				}
		}
		
//		http://dev.fassion.co.kr/?media=http%3A%2F%2Fdev.revu.co.kr%2Fimages%2Fcommon%2Fbanner%2Fbanner_powerblog_224090.gif&url=http%3A%2F%2Fdev.revu.co.kr%2Freview&title=%EB%A0%88%EB%B7%B0%3A%3A%3A&is_video=false&description=%ED%8C%8C%EC%9B%8C%EB%B8%94%EB%A1%9C%EA%B1%B0%EC%A7%80%EC%9B%90
//		//overflow-y:auto;		
		ResultTxt = "<div id='bacpin' style='position:absolute; height: 100%; overflow:scroll;overflow-y:auto; z-index:2147483641; top:0; right:0; bottom:0; left:0; background-color:#e2e2e2; opacity:.95;'>";
		ResultTxt = ResultTxt+divimgTxt;
		ResultTxt = ResultTxt+"</div>";
		iframeTxt = "<iframe height='100%' width='1903' id='PIN_1354604896402_shim' nopin='nopin' style='background:transparent;  height: 4210px; width: 1903px; z-index:2147483640;position:absolute;'></iframe>"
		$(iframeTxt).appendTo("body");
		$(ResultTxt).appendTo("body");
		


			
		d = document;
		domD = document.documentElement;
		domB = d.getElementsByTagName("BODY")[0];
		domH = d.getElementsByTagName("HEAD")[0];

//		function getHeight() {
//			//1. 문서 자체 길이
//			//2. 문서 바디 길이
//			//3. 문서 바디 클라이언트 길이
//			return Math.max(Math.max(domB.scrollHeight, domD.scrollHeight), Math.max(domB.offsetHeight, domD.offsetHeight), Math.max(domB.clientHeight, domD.clientHeight));
//		}
//		
//
//		var s =   document.getElementById("bacpin");
//		var b = getHeight();
//		//alert(s.style.height);		
//		s.style.height = b + "px";			
//		alert(s.style.height);
		

//		Body scroll 제거용 Script
		var html_dom = document.getElementsByTagName('html')[0]; 
		var overflow = ''; 		 
		if(html_dom.style.overflow==''){
			overflow='hidden';
		}else{
			overflow='';
		} 		 
		html_dom.style.overflow = overflow; 
		domB.style.overflow = "hidden";

		
});