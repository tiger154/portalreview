var editor = null;
function initEditor()
{
	editor = new HTMLArea("editorContent");	

	editor.generate();
	return false;
	
	var cfg = editor.config;
	cfg.registerButton({
		id						: "my-hilite",
		tooltip					: "Highlight text",
		image					: "ed_custom.gif",
		textMode			: false,
		action				: 
		function(editor)
		{
			editor.surroundHTML("<span class=\"hilite\">", "</span>");
		},
		context				: 'table'
	});
	
	// add the new button to the toolbar
	cfg.toolbar.push(["linebreak", "my-hilite"]);
	
	// BEGIN: code that adds a custom button
	// uncomment it to test
	var cfg = editor.config;

	function clickHandler(editor, buttonId)
	{
		switch (buttonId)
		{
			case "my-toc":
				editor.insertHTML("<h1>테이블 내용</h1>");
				break;
			
			case "my-date":
				editor.insertHTML((new Date()).toString());
				break;
			
			case "my-bold":
				editor.execCommand("bold");
				editor.execCommand("italic");
				break;
			
			case "my-hilite":
				editor.surroundHTML("<span class=\"hilite\">", "</span>");
				break;
		}
	};

	cfg.registerButton("my-toc",  "Insert TOC", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-date", "Insert date/time", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-bold", "Toggle bold/italic", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-hilite", "Hilite selection", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-sample", "Class: sample", "ed_custom.gif", false,
		function(editor)
		{
			if (HTMLArea.is_ie)
			{
				editor.insertHTML("<span class=\"sample\">&nbsp;&nbsp;</span>");
				var r = editor._doc.selection.createRange();
				r.move("character", -2);
				r.moveEnd("character", 2);
				r.select();
			}
			else
			{
				// Gecko/W3C compliant
				var n = editor._doc.createElement("span");
				n.className = "sample";
				editor.insertNodeAtSelection(n);
				var sel = editor._iframe.contentWindow.getSelection();
				sel.removeAllRanges();
				var r = editor._doc.createRange();
				r.setStart(n, 0);
				r.setEnd(n, 0);
				sel.addRange(r);
			}
		}
	);

	cfg.pageStyle = "body { background-color: #efd; } .hilite { background-color: yellow; } " +
						".sample { color: green; font-family: monospace; }";

	// add the new button to the toolbar  // END: code that adds a custom button
	cfg.toolbar.push(["linebreak", "my-toc", "my-date", "my-bold", "my-hilite", "my-sample"]); 

	editor.generate();
}

HTMLArea.onload = initEditor;