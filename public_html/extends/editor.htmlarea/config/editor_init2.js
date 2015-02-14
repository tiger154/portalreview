var editor2 = null;

function initEditor2()
{
	editor2 = new HTMLArea2("editorContent2");	

	editor2.generate();
	return false;
	
	var cfg = editor2.config;
	cfg.registerButton({
		id						: "my-hilite",
		tooltip					: "Highlight text",
		image					: "ed_custom.gif",
		textMode			: false,
		action				: 
		function(editor2)
		{
			editor2.surroundHTML("<span class=\"hilite\">", "</span>");
		},
		context				: 'table'
	});
	
	// add the new button to the toolbar2
	cfg.toolbar2.push(["linebreak", "my-hilite"]);
	
	// BEGIN: code that adds a custom button
	// uncomment it to test
	var cfg = editor2.config;

	function clickHandler(editor2, buttonId)
	{
		switch (buttonId)
		{
			case "my-toc":
				editor2.insertHTML2("<h1>테이블 내용</h1>");
				break;
			
			case "my-date":
				editor2.insertHTML2((new Date()).toString());
				break;
			
			case "my-bold":
				editor2.execCommand("bold");
				editor2.execCommand("italic");
				break;
			
			case "my-hilite":
				editor2.surroundHTML("<span class=\"hilite\">", "</span>");
				break;
		}
	};

	cfg.registerButton("my-toc",  "Insert TOC", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-date", "Insert date/time", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-bold", "Toggle bold/italic", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-hilite", "Hilite selection", "ed_custom.gif", false, clickHandler);
	cfg.registerButton("my-sample", "Class: sample", "ed_custom.gif", false,
		function(editor2)
		{
			if (HTMLArea2.is_ie)
			{
				editor2.insertHTML2("<span class=\"sample\">&nbsp;&nbsp;</span>");
				var r = editor2._doc.selection.createRange();
				r.move("character", -2);
				r.moveEnd("character", 2);
				r.select();
			}
			else
			{
				// Gecko/W3C compliant
				var n = editor2._doc.createElement("span");
				n.className = "sample";
				editor2.insertNodeAtSelection(n);
				var sel = editor2._iframe.contentWindow.getSelection();
				sel.removeAllRanges();
				var r = editor2._doc.createRange();
				r.setStart(n, 0);
				r.setEnd(n, 0);
				sel.addRange(r);
			}
		}
	);

	cfg.pageStyle = "body { background-color: #efd; } .hilite { background-color: yellow; } " +
						".sample { color: green; font-family: monospace; }";

	// add the new button to the toolbar2  // END: code that adds a custom button
	cfg.toolbar2.push(["linebreak", "my-toc", "my-date", "my-bold", "my-hilite", "my-sample"]); 

	editor2.generate();
}

HTMLArea2.onload = initEditor2;