var textlimit = {
	textLimit: function(obj1, obj2, length) {
		var textArea = document.getElementById(obj1);
		var textBox = document.getElementById(obj2);		
		var str				= textArea.value;
		var strLen			= str.length;	
		var max				= length;		
		var i					= 0;		
		var textByte		= 0;			
		var subLen			= 0;			
		var oneChar		= "";				
		var str2				= "";		   
	
		for(i=0; i< strLen; i++)
		{		
			oneChar = str.charAt(i);	
			if (escape(oneChar).length > 4) {
				textByte = textByte + 2;
			} else {
				textByte++;
			}		
			if(textByte <= max) {
				subLen = i + 1;
			}
		}
		textBox.value = textByte;
		if(textByte > max) {
			alert( max + "자 이상 입력할 수 없습니다.\n추가로 입력된 내용은 자동으로 삭제됩니다.");
			str2 = str.substr(0, subLen);
			textArea.value = str2;
			textBox.value = max;
		}
		textArea.focus();
	}, 
	textByte: function(obj) {
		var textArea = document.getElementById(obj);	
		var str				= textArea.value;
		var strLen			= str.length;	
		var i					= 0;		
		var textByte		= 0;			
		var oneChar		= "";				
	
		for(i=0; i< strLen; i++)
		{
			oneChar = str.charAt(i);		
			if (escape(oneChar).length > 4) {
				textByte = textByte + 2;
			} else {
				textByte++;
			}
		}
		return textByte;
	},
	noEnter: function() {
		if(event.keyCode == 13) event.returnValue=false;
	}	
};