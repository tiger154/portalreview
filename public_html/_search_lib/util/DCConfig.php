<?php 
class DCConfig { 

    ## private 
    var $_xml_parser; 
    var $_xml_encoding; 
    var $_xml_chk        = 'n'; 
    var $_xml_item        = array(); 
    var $_xml_result    = array(); 

    function xmlOpen($url, $tag) { 
        $this->_tag = $tag; 
        if($fp = fopen($url, 'r')) { 
            while(!feof ($fp)) { 
                $xml_data .= fgets($fp, 4096); 
            } 
            fclose ($fp); 
            $this->_xmlDefine($xml_data); 
            return $this->_xmlInte(); 
        } else { 
            $this->_error('xml open error : fail xml file open => '.$url); 
        } 
    } 

    ## xml ���� 
    function _xmlDefine($xml_data) { 
        preg_match('/encoding="[^"]+"/', $xml_data, $pattern); 
        $this->_xml_encoding = strtolower(preg_replace('/(encoding=)|(")/', '', $pattern[0])); 

        $this->_xml_parser = xml_parser_create(); 
        xml_parser_set_option($this->_xml_parser, XML_OPTION_CASE_FOLDING, 0); //�±� �̸��� �ҹ��ڷ� �ѷ��� 
        xml_parse_into_struct($this->_xml_parser, $xml_data, $this->_xml_item, $index); 
        xml_parser_free($this->_xml_parser); 
    } 

    ## xml ���� 
    function _xmlInte() { 
        foreach($this->_xml_item as $v) { 
            if($v['tag'] == $this->_tag && $v['type'] == 'open') { 
                $this->_xml_result[$v['tag']][] = ''; 
                $this->_xml_chk = 'y'; 
            } 
            if($v['type'] == 'complete' && $this->_xml_chk == 'y') { 
                if($this->_xml_encoding == 'utf-8') { 
                    $this->_xml_result[$v['tag']][] = array('value'=>iconv('utf-8', 'euc-kr', $v['value']),'att'=>iconv('utf-8', 'euc-kr', $v['attributes'])); 
                } else { 
                    $this->_xml_result[$v['tag']][] = array('value'=>$v['value'],'att'=>$v['attributes']); 
                } 
            } 
        } 
        return $this->_xml_result; 
    } 

    ## ����ǥ�� 
    function _error($msg='') { 
        echo $msg; 
        exit; 
    } 
}

    
    /* 
    ## [���� 1] xml ���� 
    ------------------------------------------------------------------------------------------- 
    $xml = new yskXmlClass; 
    $searchInfo = $xml->xmlOpen('xml ���','element��'); 

    $count = count($searchInfo['element��']); 
    for($x=0; $x<$count; $x++) { 
        echo $searchInfo['title'][$x]['value'].'<br>'; 
        echo $searchInfo['link'][$x]['value'].'<br>'; 
        echo $searchInfo['description'][$x]['value'].'<br><br><hr>'; 
    } 
    ------------------------------------------------------------------------------------------- 
    */ 
    
?> 
