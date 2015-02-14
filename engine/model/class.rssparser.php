<?php

class RSSParser {
	
	var $parser;

    var $insideTag	= '';
    var $activeTag	= ''; // 값이 있으면 현재 태그 파싱중, 없으면 파싱 종료
    var $channel	= array();

    var $items		= array();
    var $item		= array();

	var $images		= array();
    var $image		= array();

    var $textinput	= array();
    var $textinputs	= array();

    var $parentTags		= array('CHANNEL', 'ITEM', 'IMAGE', 'TEXTINPUT');
	var $channelTags	= array('TITLE', 'LINK', 'DESCRIPTION', 'LANGUAGE','COPYRIGHT','MANAGINGEDITOR',
								'WEBMASTER','PUBDATE','LASTBUILDDATE','CATEGORY','GENERATOR','DOCS','CLOUD',
								'TTL','RATING','SKIPHOURS','SKIPDAYS','IMAGE','ITEMS', 'TEXTINPUT');
    var $itemTags		= array('TITLE', 'LINK', 'DESCRIPTION', 'AUTHOR','CATEGORY','COMMENTS','ENCLOSURE','GUID','PUBDATE','SOURCE');
    var $imageTags		= array('TITLE', 'URL', 'LINK','WIDTH','HEIGHT','DESCRIPTION');
    var $textinputTags	= array('TITLE', 'DESCRIPTION', 'NAME', 'LINK');
    var $moduleTags		= array('DC:TITLE', 'DC:CREATOR', 'DC:SUBJECT', 'DC:DESCRIPTION',
							    'DC:PUBLISHER', 'DC:CONTRIBUTOR', 'DC:DATE', 'DC:TYPE',
								'DC:FORMAT', 'DC:IDENTIFIER', 'DC:SOURCE', 'DC:LANGUAGE',
								'DC:RELATION', 'DC:COVERAGE', 'DC:RIGHTS',
								'BLOGCHANNEL:BLOGROLL', 'BLOGCHANNEL:MYSUBSCRIPTIONS',
								'BLOGCHANNEL:MYSUBSCRIPTIONS', 'BLOGCHANNEL:CHANGES');

	public function RSSParser(){
		$this->_create();
	}

	private function _create() {
		$this->parser = @xml_parser_create();
		if (is_resource($this->parser)) {
			xml_set_object($this->parser, &$this);
			xml_set_element_handler($this->parser, "startHandler", "endHandler");
			xml_set_character_data_handler($this->parser, "cdataHandler");
			return true;
		}
		return false;
    }

	public function free(){
		if(is_resource($this->parser)) {
			xml_parser_free($this->parser);
			unset( $this->parser );
		}
		return null;
    }
    /**

	 Tip 1. xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/ = RSS 1.0 표준 모듈
     Tip 2. xmlns:activity="http://activitystrea.ms/spec/1.0/ = Atom 표준 모듈
   
	   <!ELEMENT item (title | link | description | author | category | comments | enclosure | guid | pubDate | source)+>
	   <!ELEMENT image (url | title | link | width? | height? | description)*>
	   <!ELEMENT channel (title | link | description | item* | language? | copyright? | managingEditor? | webMaster? | pubDate? | lastBuildDate? | category? | generator? | docs? | cloud? | ttl? | image? | rating? | textInput? | skipHours? | skipDays?)*>
   <!ELEMENT textInput (title | description | name | link)*> 
     * Start element handler for XML parser
     *
     * @access private
     * @param  object XML parser object
     * @param  string XML element
     * @param  array  Attributes of XML tag
     * @return void
	   -- 브레이크 문을 만나기 전까지는 조건문을 계속해서 실행한다. 
     */
	private function startHandler($parser, $element, $attr){
		switch ($element) {
			case 'CHANNEL':
			case 'ITEM':
			case 'IMAGE':
			case 'TEXTINPUT':
				$this->insideTag = $element;	// 현재 처리 시작한 부모태그 이름 저장		
				break;
			default:
			$this->activeTag = $element; // 현재 처리 시작한 자식(기본)태그 이름 저장
		}
	}
    /**
     * End element handler for XML parser
     *
     * @access private
     * @param  object XML parser object
     * @param  string
     * @return void
     */
	private function endHandler($parser, $element){
		if ($element == $this->insideTag) { //TEXTINPUT 태그 처리시
			$this->insideTag = '';
			$this->struct[] = array_merge(array('type' => strtolower($element)), $this->last); // 존재하는 태그명 및 값 세팅 예) 'type' = item, item['title'] = '테스트 제목'
		}
		if ($element == 'ITEM') {
			$this->items[] = $this->item;
			$this->item = '';
		}
        if ($element == 'IMAGE') {
        	$this->images[] = $this->image;
			$this->image = '';
		}
        if ($element == 'TEXTINPUT') {
        	$this->textinputs = $this->textinput;
			$this->textinput = '';
        }
        $this->activeTag = ''; // 태그 작업 종료 표시
    }

    /**
     * Handler for character data
     * 실제 데이터를 만났을때 처리 하는 구문 
     * @access private
     * @param  object XML parser object
     * @param  string CDATA
     * @return void
	 	@@중요!! : 데이터 파싱 후, 해당 태그이름으로 배열변수생성 및 값 입력 
		예) item 태그경우, item['title'] = '임의의 태그값';
     */
	private function cdataHandler($parser, $cdata) {
		if (in_array($this->insideTag, $this->parentTags)) { //// 부모 태그 라면..> insideTag값이 parentTags배열 내의 값에 존재할 경우, 데이터 버퍼 처리 
			$tagName = strtolower($this->insideTag); // 소문자 치환 
			$var = $this->{$tagName . 'Tags'}; // 해당 태그의 (상단에 정의된) 하위 태그 배열 정보를 가져온다.
			if (in_array($this->activeTag, $var)){ //  // (상단에 정의된)부모태그배열 값 내부에, (파싱된) 자식 태그 값이 일치 한다면....
				$this->_add($tagName, strtolower($this->activeTag),$cdata); // 배열 값 추가 예) item['title'] = '제목테스트값';
			} elseif(in_array($this->activeTag, $this->moduleTags)) { 
				$this->_add($tagName, strtolower($this->activeTag),$cdata);
			}
		}
		
	}
    /**
     * Add element to internal result sets
     *
     * @access private
     * @param  string Name of the result set
     * @param  string Fieldname
     * @param  string Value
     * @return void
     * @see    cdataHandler
     */
	private function _add($type, $field, $value) // 태그 값 추가 방식
	{
		if (empty($this->{$type}) || empty($this->{$type}[$field])) {
			$this->{$type}[$field] = $value;
		} else {
			$this->{$type}[$field] .= $value;
		}
		$this->last = $this->{$type};
	}

	public function parse($data){
		xml_parse($this->parser,$data);
		return true;
	}

	public function getStructure()
	{
		return (array)$this->struct;
    }

	public function getChannel()
	{
		return (array)$this->channel;
	}

	public function getItems()
	{
		return (array)$this->items;
	}

	public function getImages()
	{
		return (array)$this->images;
	}

	public function getTextinputs()
	{
		return (array)$this->textinputs;
	}
}
?>