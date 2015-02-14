var imgWidth=0;
var imgCount=0;
var thisImage=1;
var $slide;
//var autoSlide;

$(function(){
	$slide = $(".slideContainer .slideShow");
	imgWidth = $(".slideContainer").width();
	imgCount = $slide.children("ul").length;

	//autoSlide = setTimeout("rightMove(1)",3000);
});

function moveImage(num) {
	var move = thisImage - num;

	// 현재 이미지 번호보다 작은 번호를 클릭했을 때 왼쪽으로
	if(thisImage>num) {
		leftMove(thisImage - num);
	
	// 현재 이미지보다 큰 번호를 클릭했을 때 오른쪽으로
	} else if(thisImage<num) {
		rightMove(num - thisImage);
	}
}

// 왼쪽으로
function leftMove(num) {
	//clearInterval(autoSlide);
	
	// 현재 보이는 이미지번호가 1보다 클때만 움직임
	if(thisImage>1) {
		thisImage-=num;
		//$slide.animate({"left":"+="+imgWidth*num},500);
		$slide.animate({"left":"+="+125*num},500);
	}

	//autoSlide = setTimeout("rightMove(1)",3000);
}

// 오른쪽으로
function rightMove(num) {
	//clearTimeout(autoSlide);
	//alert(num);
	//alert(imgWidth);
	//wid = 160;
	// 현재 이미지번호가 이미지 개수보다 작을 때 움직임
	if(thisImage<imgCount) {
		thisImage+=num;
		//$slide.animate({"left":"-="+imgWidth*num},500);
		$slide.animate({"left":"-="+125*num},500);
	// 현재 이미지 번호가 이미지 개수를 넘겼을 땐 처음으로(1번 이미지)..
	} else {
		showImage(1);
		moveImage(1);
		return;
	}
	//autoSlide = setTimeout("rightMove(1)",3000);
}


function showImage(num) {
	$slide.children().eq(num-1).animate({"opacity":"1"},600);
}

function hideImage(num) {
	$slide.children().eq(num-1).animate({"opacity":"0"},300);
}