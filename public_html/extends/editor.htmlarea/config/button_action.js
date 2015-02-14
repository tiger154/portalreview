function insertHTML()
{
	var html = prompt("이곳에 HTML 코드를 입력하세요.");
	if (html)
	{
		editor.insertHTML(html);
	}
}
function highlight()
{
	editor.surroundHTML('<span style="background-color: yellow">', '</span>');
}

function mySubmit()
{
	// document.edit.save.value = "yes";
	//document.edit.onsubmit(); // workaround browser bugs.
	document.edit.submit();
};