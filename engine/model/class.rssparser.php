<?php

class RSSParser {
	
	var $parser;

    var $insideTag	= '';
    var $activeTag	= ''; // ���� ������ ���� �±� �Ľ���, ������ �Ľ� ����
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

	 Tip 1. xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/ = RSS 1.0 ǥ�� ���
     Tip 2. xmlns:activity="http://activitystrea.ms/spec/1.0/ = Atom ǥ�� ���
   
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
	   -- �극��ũ ���� ������ �������� ���ǹ��� ����ؼ� �����Ѵ�. 
     */
	private function startHandler($parser, $element, $attr){
		switch ($element) {
			case 'CHANNEL':
			case 'ITEM':
			case 'IMAGE':
			case 'TEXTINPUT':
				$this->insideTag = $element;	// ���� ó�� ������ �θ��±� �̸� ����		
				break;
			default:
			$this->activeTag = $element; // ���� ó�� ������ �ڽ�(�⺻)�±� �̸� ����
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
		if ($element == $this->insideTag) { //TEXTINPUT �±� ó����
			$this->insideTag = '';
			$this->struct[] = array_merge(array('type' => strtolower($element)), $this->last); // �����ϴ� �±׸� �� �� ���� ��) 'type' = item, item['title'] = '�׽�Ʈ ����'
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
        $this->activeTag = ''; // �±� �۾� ���� ǥ��
    }

    /**
     * Handler for character data
     * ���� �����͸� �������� ó�� �ϴ� ���� 
     * @access private
     * @param  object XML parser object
     * @param  string CDATA
     * @return void
	 	@@�߿�!! : ������ �Ľ� ��, �ش� �±��̸����� �迭�������� �� �� �Է� 
		��) item �±װ��, item['title'] = '������ �±װ�';
     */
	private function cdataHandler($parser, $cdata) {
		if (in_array($this->insideTag, $this->parentTags)) { //// �θ� �±� ���..> insideTag���� parentTags�迭 ���� ���� ������ ���, ������ ���� ó�� 
			$tagName = strtolower($this->insideTag); // �ҹ��� ġȯ 
			$var = $this->{$tagName . 'Tags'}; // �ش� �±��� (��ܿ� ���ǵ�) ���� �±� �迭 ������ �����´�.
			if (in_array($this->activeTag, $var)){ //  // (��ܿ� ���ǵ�)�θ��±׹迭 �� ���ο�, (�Ľ̵�) �ڽ� �±� ���� ��ġ �Ѵٸ�....
				$this->_add($tagName, strtolower($this->activeTag),$cdata); // �迭 �� �߰� ��) item['title'] = '�����׽�Ʈ��';
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
	private function _add($type, $field, $value) // �±� �� �߰� ���
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