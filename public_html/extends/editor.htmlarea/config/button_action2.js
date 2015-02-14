function insertHTML2()
{
	var html = prompt("이곳에 HTML 코드를 입력하세요.");
	if (html)
	{
		editor2.insertHTML2(html);
	}
}
function highlight()
{
	editor2.surroundHTML('<span style="background-color: yellow">', '</span>');
}

function mySubmit()
{
	// document.edit.save.value = "yes";
	//document.edit.onsubmit(); // workaround browser bugs.
	document.edit.submit();
};