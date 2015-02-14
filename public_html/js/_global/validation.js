var validation = {
	isLength: function(str, num1, num2) {
		if(str.length < num1 || str.length > num2) {
			return false;
		} else {
			return true;
		}
	},
	isEng: function(str) {
		for(var i=0; i < str.length; i++)
		{
			var chr = str.substr(i,1);
			if((chr < 'a' || chr > 'z') && ( chr < 'A' || chr > 'Z')) {
				return false;
			}
		}
		return true;
	},
	isKor: function(str) {
		for(var i=0; i < str.length; i++)
		{
			if(!((str.charCodeAt(i) > 0x3130 && str.charCodeAt(i) < 0x318F) || (str.charCodeAt(i) >= 0xAC00 && str.charCodeAt(i) <= 0xD7A3))) {
				return false;
			}
		}
		return true;
	},
	isNumber: function(str) {
		for(var i=0; i < str.length; i++) {
			var chr = str.substr(i,1);
			if((chr < '0' || chr > '9')) {
				return false;
			}
		}
		return true;
	},
	isSpecail: function(str) {
		for(var i=0; i < str.length; i++)
		{
			ch_char = str.charAt(i);
			ch = ch_char.charCodeAt();
			if( (ch >= 33 && ch <= 47) || (ch >= 58 && ch <= 64) || (ch >= 91 && ch <= 96) || (ch >= 123 && ch <= 126) ) {
				return false;
			}
		}
		return true;
	},
	isAscii: function(str) {
		for(var i=0; i < str.length; i++)
		{	
			ch_char = str.charAt(i);
			ch = ch_char.charCodeAt();
			if( ch == Ascii ) {
				return false;
			}
		}
		return true;
	},
	isSpace: function(str) {
		if(str.search(/\s/) != -1) {
			return true;
		} else {
			return false;
		}
	},
	isEngNum: function(str) {
		for(var i=0; i < str.length; i++)
		{
			var chr = str.substr(i,1);
			if((chr < 'a' || chr > 'z') && ( chr < 'A' || chr > 'Z') && (chr < '0' || chr > '9')) {			
				if(chr.search(/\s/) == -1) return false;
			}
		}
		return true;
	},
	isEngNum2: function(str) {
		for(var i=0; i < str.length; i++)
		{
			var chr = str.substr(i,1);
			if((chr < 'a' || chr > 'z') && ( chr < 'A' || chr > 'Z') && (chr < '0' || chr > '9') && (chr != '-') && (chr != '_')) {			
				if(chr.search(/\s/) == -1) return false;
			}
		}
		return true;
	},
	isEngKor: function(str) {
		for(var i=0; i < str.length; i++)
		{
			var chr = str.substr(i,1);
			var chr2 = str;
			if((chr < 'a' || chr > 'z') && ( chr < 'A' || chr > 'Z') && !((chr2.charCodeAt(i) > 0x3130 && chr2.charCodeAt(i) < 0x318F) || (chr2.charCodeAt(i) >= 0xAC00 && chr2.charCodeAt(i) <= 0xD7A3))) {
				if(chr.search(/\s/) == -1) {
					return false;
				}
			}
		}
		return true;
	}, 
	isChar: function(str) {
		for(var i=0; i < str.length; i++)
		{
			var chr = str.substr(i,1);
			var chr2 = str;
			if((chr < 'a' || chr > 'z') && ( chr < 'A' || chr > 'Z') && (chr < '0' || chr > '9') && !((chr2.charCodeAt(i) > 0x3130 && chr2.charCodeAt(i) < 0x318F) || (chr2.charCodeAt(i) >= 0xAC00 && chr2.charCodeAt(i) <= 0xD7A3))) {
				if(chr.search(/\s/) == -1) {
					return false;
				}
			}
		}
		return true;
	}, 
	isConf: function(str) {
		for(var i=0; i < str.length; i++) {
			ch_char = str.charAt(i);
			ch = ch_char.charCodeAt();
			if( ch == 33 || ch == 34 || ch == 38 || ch == 40 || ch == 41 || ch == 59 || ch == 61 || ch == 126 ) {
				return false;
			}
		}
		return true;
	},
	isJumin: function(jumin1, jumin2) {
		var jumin = jumin1 + jumin2;
	    if(jumin1.length != 6 || jumin2.length != 7 || isNaN(jumin) || jumin.charAt(6)<1 || jumin.charAt(6)>4) 	{
	        return false; 
	    }
	    var check = 0 ;
	    for (var i=0;i<12;i++)
		{
	        check += (i%8+2) * jumin.charAt(i); 
	    }
	    check = (11-check%11) % 10;
	    if(check != jumin.charAt(12)) {
	        return false; 
	    }
		return true;
	},
	isImageFile: function(filename) {
		if(!/(\.gif|\.jpg|\.jpeg|\.png)$/i.test(filename)) {
			return false;
		}
		return true;
	},
	isRunFile: function(filename) {
		if(!/(\.asp|\.aspx|\.jsp|\.php|\.php3|\.php4|\.php5|\.inc|\.lib|\.revu|\.htm|\.html)$/i.test(filename)) {
			return true;
		}
		return false;
	},
	isEmail: function(email) {
		var checkTLD=1;
		var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
		var emailPat=/^(.+)@(.+)$/;
		var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
		var validChars="\[^\\s" + specialChars + "\]";
		var quotedUser="(\"[^\"]*\")";
		var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
		var atom=validChars + '+';
		var word="(" + atom + "|" + quotedUser + ")";
		var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
		var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
		var matchArray=email.match(emailPat);
		if (matchArray==null) {
			//alert("email 주소에 '@', '.'이 빠졌습니다.");
			return false;
		}
		var user=matchArray[1];
		var domain=matchArray[2];
		// Start by checking that only basic ASCII characters are in the strings (0-127).	
		for (i=0; i<user.length; i++) 
		{
			if (user.charCodeAt(i)>127) {
				//alert("ID의 길이가 초과하였습니다.");
				return false;
	   		}
		}
		for (i=0; i<domain.length; i++) 
		{
			if (domain.charCodeAt(i)>127) {
				//alert("도메인 길이가 초과하였습니다.");
				return false;
	   		}
		}
		// See if "user" is valid 
		if (user.match(userPat)==null) {
			// user is not valid
			//alert("username이 유효하지 않습니다.");
			return false;
		}
		/* if the e-mail address is at an IP address (as opposed to a symbolic
		host name) make sure the IP address is valid. */
		var IPArray=domain.match(ipDomainPat);
		if (IPArray!=null) {
			// this is an IP address
			for (var i=1;i<=4;i++) 
			{
				if (IPArray[i]>255) {
					//alert("IP address길이가 초과하였습니다.");
					return false;
	   			}
			}
			return true;
		}
		// Domain is symbolic name.  Check if it's valid.
		var atomPat=new RegExp("^" + atom + "$");
		var domArr=domain.split(".");
		var len=domArr.length;
		for (i=0;i<len;i++) 
		{
			if (domArr[i].search(atomPat)==-1) {
				//alert("도메인 이름이 유효하지 않습니다.");
				return false;
	   		}
		}
		if (checkTLD && domArr[domArr.length-1].length!=2 && domArr[domArr.length-1].search(knownDomsPat)==-1) {
			//alert("도메인 이름이 유효하지 않습니다.");
			return false;
		}
		// Make sure there's a host name preceding the domain.
		if (len<2) {
			//alert("hostname이 없습니다.");
			return false;
		}
		return true;
	},
	isDomain: function(domainName) {
		var arr = new Array(
		'.com','.net','.org','.biz','.coop','.info','.museum','.name',
		'.pro','.edu','.gov','.int','.mil','.ac','.ad','.ae','.af','.ag',
		'.ai','.al','.am','.an','.ao','.aq','.ar','.as','.at','.au','.aw',
		'.az','.ba','.bb','.bd','.be','.bf','.bg','.bh','.bi','.bj','.bm',
		'.bn','.bo','.br','.bs','.bt','.bv','.bw','.by','.bz','.cf','.cc',
		'.cd','.cf','.cg','.ch','.ci','.ck','.cl','.cm','.cn','.co','.cr',
		'.cu','.cv','.cx','.cy','.cz','.de','.dj','.dk','.dm','.do','.dz',
		'.ec','.ee','.eg','.eh','.er','.es','.et','.fi','.fj','.fk','.fm',
		'.fo','.fr','.ga','.gd','.ge','.gf','.gg','.gh','.gi','.gl','.gm',
		'.gn','.gp','.gq','.gr','.gs','.gt','.gu','.gv','.gy','.hk','.hm',
		'.hn','.hr','.ht','.hu','.id','.ie','.il','.im','.in','.io','.iq',
		'.ir','.is','.it','.je','.jm','.jo','.jp','.ke','.kg','.kh','.ki',
		'.km','.kn','.kp','.kr','.kw','.ky','.kz','.la','.lb','.lc','.li',
		'.lk','.lr','.ls','.lt','.lu','.lv','.ly','.ma','.mc','.md','.mg',
		'.mh','.mk','.ml','.mm','.mn','.mo','.mp','.mq','.mr','.ms','.mt',
		'.mu','.mv','.mw','.mx','.my','.mz','.na','.nc','.ne','.nf','.ng',
		'.ni','.nl','.no','.np','.nr','.nu','.nz','.om','.pa','.pe','.pf',
		'.pg','.ph','.pk','.pl','.pm','.pn','.pr','.ps','.pt','.pw','.py',
		'.qa','.re','.ro','.rw','.ru','.sa','.sb','.sc','.sd','.se','.sg',
		'.sh','.si','.sj','.sk','.sl','.sm','.sn','.so','.sr','.st','.sv',
		'.sy','.sz','.tc','.td','.tf','.tg','.th','.tj','.tk','.tm','.tn',
		'.to','.tp','.tr','.tt','.tv','.tw','.tz','.ua','.ug','.uk','.um',
		'.us','.uy','.uz','.va','.vc','.ve','.vg','.vi','.vn','.vu','.ws',
		'.wf','.ye','.yt','.yu','.za','.zm','.zw');	
		var mai = domainName;
		var val = true;	
		var dot = mai.lastIndexOf(".");
		var dname = mai.substring(0,dot);
		var ext = mai.substring(dot,mai.length);
		//alert(ext);		
		if(dot>2 && dot<57) {
			for(var i=0; i<arr.length; i++) 
			{
				if(ext == arr[i]) {
					val = true;
					break;
				} else {
					val = false;
				}
			}
			if(val == false) {
				//alert("도메인 확장자("+ext+")가 옳바르지 않습니다.");
				return false;
			} else {
				for(var j=0; j<dname.length; j++)
				{
					var dh = dname.charAt(j);
					var hh = dh.charCodeAt(0);
					if((hh > 47 && hh<59) || (hh > 64 && hh<91) || (hh > 96 && hh<123) || hh==45 || hh==46) {
						if((j==0 || j==dname.length-1) && hh == 45)	{
							//alert("도메인 끝은 '-' 으로 끝날 수 없습니다.");
							return false;
						}
					} else {
						//alert("특수문자는 사용할 수 없습니다.");
						return false;
					}
				}
			}
		} else {
			//alert("도메인이 너무 길거나 짧습니다.");
			return false;
		}
		return true;
	}
};