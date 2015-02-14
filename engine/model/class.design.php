<?php
class Design
{
	var $setConf;
	var $TPL;
	var $FILE;
	var $XMLParser;

	public function Design()
	{
		$this->setConf = parse_ini_file(_CONF_SITE_INI);
		$this->TPL = &Module::singleton("Template");
		$this->FILE = &Module::singleton("File");
		$this->XMLParser = &Module::singletonExtends("XMLParser");
	}

	public function designLogo()
	{
		$_logoSrc = _DIR_FTP."/images/logo";
		$_logoSrc_ = _DIR_FTP_."/images/logo";
		$_logo = $this->setConf["logoFile"];
		if($this->setConf["logo"] == "Y") {
			if($this->FILE->checkIsFile($_logoSrc."/".$_logo)) {
				$logo = $_logoSrc_."/".$_logo;
			} else {
				$logo = _DIR_IMAGES_."/common/logo.gif";
			}
			$logo = "<img src=\"".$logo."\" alt=\"로고\" />";
			$this->TPL->setValue(array("LOGO"=>$logo,));
		}
	}

	public function designLogocopy()
	{
		$_logoSrc = _DIR_FTP."/images/logo";
		$_logoSrc_ = _DIR_FTP_."/images/logo";
		$_logoCopy = $this->setConf["logoCopyFile"];
		if($this->setConf["logoCopy"] == "Y") {
			if($this->FILE->checkIsFile($_logoSrc."/".$_logoCopy)) {
				$logoCopy = $_logoSrc_."/".$_logoCopy;
			} else {
				$logoCopy = _DIR_IMAGES_."/common/logocopy.gif";
			}
			$logoCopy = "<img src=\"".$logoCopy."\" />";
			$this->TPL->setValue(array("LOGOCOPY"=>$logoCopy));
		}
	}

	public function designMenu($type)
	{
		$_menuSrc = _CONF_MENU_XML;
		if($this->FILE->checkIsFile($_menuSrc)) {
			$_menuXML = file_get_contents($_menuSrc);
			$this->XMLParser = new XMLParser($_menuXML);
			$this->XMLParser->Parse();
			switch($type)
			{
				case "side" :
					$sideMenu = "<ul>\n";
					if(sizeof($this->XMLParser->document->menu[0]->item) > 0) {
						foreach($this->XMLParser->document->menu[0]->item as $d1)
						{
							$sideMenu .= "<li class='depth1'><a href=".$d1->tagAttrs['href']." target=".$d1->tagAttrs['target'].">".$d1->tagAttrs['name']."</a></li>\n";
							for($i=0;$i<sizeof($d1->item);$i++)
							{
								$d2 = $d1->item[$i];
								$sideMenu .= "<li class='depth2'><a href=".$d2->tagAttrs['href']." target=".$d2->tagAttrs['target'].">".$d2->tagAttrs['name']."</a></li>\n";

								for($j=0;$j<sizeof($d2->item);$j++)
								{
									$d3 = $d2->item[$j];
									$sideMenu .= "<li class='depth3'><a href=".$d3->tagAttrs['href']." target=".$d3->tagAttrs['target'].">".$d3->tagAttrs['name']."</a></li>\n";
								}
							}
						}
						$sideMenu .= "</ul>";
					}
					$this->TPL->setValue(array("sideMenu"=>$sideMenu, ));
					break;

				case "top" :
					if(sizeof($this->XMLParser->document->menu[0]->item) > 0) {
						$_type = $this->XMLParser->document->menu[0]->tagAttrs['type'];
						switch($_type)
						{
							case "basic" :
								break;
							case "text" :
								// 메뉴DIV 스타일
								$_style = "style=\"";
								$_style .= "position:relative; over-flow: hidden;";
								$_style .= "width:".$this->XMLParser->document->menu[0]->tagAttrs['stagew']."px;";
								$_style .= "height:".$this->XMLParser->document->menu[0]->tagAttrs['stageh']."px;";
								$_style .= "left:".$this->XMLParser->document->menu[0]->tagAttrs['startx']."px;";
								$_style .= "top:".$this->XMLParser->document->menu[0]->tagAttrs['starty']."px;";
								$_style .= "\"";
								$topMenu = "<div ".$_style.">";
								// 메뉴 스타일
								$_style_ = "style=\"";
								$_style_ .= "float:".$this->XMLParser->document->menu[0]->tagAttrs['align'].";";
								$_style_ .= "margin-right:".$this->XMLParser->document->menu[0]->tagAttrs['mmspace']."px;";
								$_style_ .= "font-weight:bold; font-size:14pt; ";
								$_style_ .= "color:#".$this->XMLParser->document->menu[0]->tagAttrs['mmout'].";";
								$_style_ .= "\"";
								foreach($this->XMLParser->document->menu[0]->item as $d1)
								{
									$topMenu .= "<a href=".$d1->tagAttrs['href']." target=".$d1->tagAttrs['target']."><span ".$_style_."".$topMenuStyle.">".$d1->tagAttrs['name']."</span></a>";
								}
								$topMenu .= "</div>";
								break;
							case "flash" :
								//<script>swfvar("/images/menu/menu.swf",740,70,"HOST_ROOT","/hosts/ver2.webshop.kr/conf");</script>
								$topMenu = "<script>";
								$topMenu .= "swfvar(";
								$topMenu .= "\"/_images/menu/menu.swf\",";
								$topMenu .= $this->XMLParser->document->menu[0]->tagAttrs['stagew'].",";
								$topMenu .= $this->XMLParser->document->menu[0]->tagAttrs['stageh'].",";
								$topMenu .= "\"HOST_ROOT\",";
								$topMenu .= "\""._DIR_FTP_."/conf\"";
								$topMenu .= ")";
								$topMenu .= "</script>";
								break;
							case "custom" :
								break;
						}
					}
					$this->TPL->setValue(array("topMenu"=>$topMenu, ));
					break;
			}

		}
	}

}
?>