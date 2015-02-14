
var url = "http://c2down.cyworld.co.kr/download?fid=64223364296e318521c3336440fc59b2&name=L.jpg";

//function initImage(blogimage)
function initImage()
{
	var blogimage = url;
	if(blogimage != null && blogimage != "") {
			$('#thumb_image').attr('src', blogimage);
			$('#thumb_image').attr('width', '80');
			$('#thumb_image').attr('height', '80');
		}
}
