// -------------------------------------------------------------------
// Image Thumbnail Viewer Script- By Dynamic Drive, available at: http://www.dynamicdrive.com
// Last updated: Jan 22nd, 2007
// -------------------------------------------------------------------

var thumbnailviewer={
enableTitle: true, //Should "title" attribute of link be used as description?
enableAnimation: true, //Enable fading animation?
definefooter: '<div class="footerbar">닫기 X</div>', //Define HTML for footer interface
defineLoading: '<img src="/plugin/js.thumbnailviewer/images/loading.gif" /> 이미지로딩중...', //Define HTML for "loading" div

/////////////No need to edit beyond here/////////////////////////
scrollbarwidth: 16,
opacitystring: '',
targetlinks:[], //Array to hold links with rel="thumbnail"

createthumbBox:function() {
	//write out HTML for Image Thumbnail Viewer plus loading div
	document.write('<div id="thumbBox" onClick="thumbnailviewer.closeit()"><div id="thumbImage"></div>'+this.definefooter+'</div>');
	document.write('<div id="thumbLoading">'+this.defineLoading+'</div>');
	this.thumbBox=document.getElementById("thumbBox");
	//Reference div that holds the shown image
	this.thumbImage=document.getElementById("thumbImage");
	//Reference "loading" div that will be shown while image is fetched
	this.thumbLoading=document.getElementById("thumbLoading");
	//create reference to common "body" across doctypes
	this.standardbody=(document.compatMode=="CSS1Compat")? document.documentElement : document.body;
},

//Centers a div element on the page
centerDiv:function(divobj) { 
	var ie=document.all && !window.opera;
	var dom=document.getElementById;
	var scroll_top=(ie)? this.standardbody.scrollTop : window.pageYOffset;
	var scroll_left=(ie)? this.standardbody.scrollLeft : window.pageXOffset;
	var docwidth=(ie)? this.standardbody.clientWidth : window.innerWidth-this.scrollbarwidth;
	var docheight=(ie)? this.standardbody.clientHeight: window.innerHeight;
	//Full scroll height of document
	var docheightcomplete=(this.standardbody.offsetHeight>this.standardbody.scrollHeight)? this.standardbody.offsetHeight : this.standardbody.scrollHeight;
	//width of div element
	var objwidth=divobj.offsetWidth;
	//height of div element
	var objheight=divobj.offsetHeight;
	//Vertical position of div element: Either centered, or if element height larger than viewpoint height, 10px from top of viewpoint
	var topposition=(docheight>objheight)? scroll_top+docheight/2-objheight/2+"px" : scroll_top+10+"px"; 
	divobj.style.left=docwidth/2-objwidth/2+"px" //Center div element horizontally
	divobj.style.top=Math.floor(parseInt(topposition))+"px";
	divobj.style.visibility="visible";
},

//Show ThumbBox div
showthumbBox:function() { 
	this.centerDiv(this.thumbBox);
	//If fading animation enabled
	if (this.enableAnimation) {
		//Starting opacity value
		this.currentopacity = 0.1;
		this.opacitytimer = setInterval("thumbnailviewer.opacityanimation()", 20);
	}
},

//Load image function that gets attached to each link on the page with rel="thumbnail"
loadimage:function(link) {
	//if thumbox is visible on the page already
	if (this.thumbBox.style.visibility=="visible")
		this.closeit() //Hide it first (not doing so causes triggers some positioning bug in Firefox

	//Construct HTML for shown image
	var imageHTML='<img src="'+link.getAttribute("href")+'" style="'+this.opacitystring+'" />';
	
	//Use title attr of the link as description?
	if (this.enableTitle && link.getAttribute("title")) 
		imageHTML+='<br />'+link.getAttribute("title");
	
	//Center and display "loading" div while we set up the image to be shown
	this.centerDiv(this.thumbLoading);
	//Populate thumbImage div with shown image's HTML (while still hidden)
	this.thumbImage.innerHTML=imageHTML;
	//Reference shown image itself
	this.featureImage=this.thumbImage.getElementsByTagName("img")[0];
	//When target image has completely loaded
	this.featureImage.onload=function(){
		//Hide "loading" div
		thumbnailviewer.thumbLoading.style.visibility="hidden";
		//Display "thumbbox" div to the world!
		thumbnailviewer.showthumbBox();
	}
	//Target IE5.0 browsers only. Address IE image cache not firing onload bug: panoramio.com/blog/onload-event/
	if (document.all && !window.createPopup)
		this.featureImage.src=link.getAttribute("href");
	//If an error has occurred while loading the image to show
	this.featureImage.onerror=function() { 
		thumbnailviewer.thumbLoading.style.visibility="hidden"; //Hide "loading" div, game over
	}
},

//Sets the opacity of "thumbimage" div per the passed in value setting (0 to 1 and in between)
setimgopacity:function(value) {
	var targetobject=this.featureImage;
	//IE syntax
	//if (targetobject.filters && targetobject.filters[0]) {
	if (typeof targetobject.style.filter!="undefined") {
		targetobject.style.filter="alpha(opacity="+value*100+")";
		/*
		//IE6
		if (typeof targetobject.filters[0].opacity=="number") {
			targetobject.filters[0].opacity=value*100;
		//IE 5.5
		} else {
			targetobject.style.filter="alpha(opacity="+value*100+")";
		}
		*/
	//Old Mozilla syntax
	} else if (typeof targetobject.style.MozOpacity!="undefined") {
		targetobject.style.MozOpacity=value;
	//Standard opacity syntax
	} else if (typeof targetobject.style.KhtmlOpacity!="undefined") {
		targetobject.style.opacity=value;
	//Non of the above, stop opacity animation
	} else if (typeof targetobject.style.opacity!="undefined") {
		targetobject.style.opacity=value;
	//Non of the above, stop opacity animation
	} else {
		//alert("cc");
		this.stopanimation();
	}
},

//Gradually increase opacity function
opacityanimation:function() {
	this.setimgopacity(this.currentopacity);
	this.currentopacity+=0.1;
	if (this.currentopacity>1)
		this.stopanimation();
},

stopanimation:function() {
	if (typeof this.opacitytimer!="undefined")
		clearInterval(this.opacitytimer);
},

//Close "thumbbox" div function
closeit:function() { 
	this.stopanimation();
	this.thumbBox.style.visibility="hidden";
	this.thumbImage.innerHTML="";
	this.thumbBox.style.left="-2000px";
	this.thumbBox.style.top="-2000px";
},

//Clean up routine on page unload
cleanup:function() {
	this.thumbLoading=null
	if (this.featureImage) this.featureImage.onload=null
	this.featureImage=null
	this.thumbImage=null
	for (var i=0; i<this.targetlinks.length; i++)
		this.targetlinks[i].onclick=null
	this.thumbBox=null
},

//assign a function to execute to an event handler (ie: onunload)
dotask:function(target, functionref, tasktype) {
	var tasktype=(window.addEventListener)? tasktype : "on"+tasktype
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false)
	else if (target.attachEvent)
		target.attachEvent(tasktype, functionref)
},

//Initialize thumbnail viewer script by scanning page and attaching appropriate function to links with rel="thumbnail"
init:function() {
	if (!this.enableAnimation)
		this.opacitystring=""
	var pagelinks=document.getElementsByTagName("a")
	//BEGIN FOR LOOP
	for (var i=0; i<pagelinks.length; i++) { 
		//Begin if statement
		if (pagelinks[i].getAttribute("rel") && pagelinks[i].getAttribute("rel")=="thumbnail") {
			pagelinks[i].onclick=function() {
				thumbnailviewer.stopanimation() //Stop any currently running fade animation on "thumbbox" div before proceeding
				thumbnailviewer.loadimage(this) //Load image
				return false
			}
			//store reference to target link
			this.targetlinks[this.targetlinks.length]=pagelinks[i]
		} //end if statement
	} //END FOR LOOP
	//Reposition "thumbbox" div when page is resized
	this.dotask(window, function() {
		if (thumbnailviewer.thumbBox.style.visibility=="visible") thumbnailviewer.centerDiv(thumbnailviewer.thumbBox)}, "resize")
	} //END init() function
}

thumbnailviewer.createthumbBox() //Output HTML for the image thumbnail viewer
thumbnailviewer.dotask(window, function(){thumbnailviewer.init()}, "load") //Initialize script on page load
thumbnailviewer.dotask(window, function(){thumbnailviewer.cleanup()}, "unload")