<?php
// Include PHP before any content is generated to we can set cookies
// Sets the $content variable with the dynamic page content
//include "./action_db.php";
//phpinfo();
//echo 
//session_save_path("/www/revu39/engine/_session");
//echo session_save_path();
//echo session_save_path();
//tcp://121.189.18.71:11211?persistent=1



Class StatusOpt {
	function isResource(){
		if($_SERVER['REMOTE_ADDR'] != "61.107.166.119"){
			return false;
		}else{
			return true;
		}
	}
}

$insStautus = new StatusOpt;
if(!$insStautus->isResource()){
	exit;
}

DEFINE ('MEM_HOST1','121.189.18.71'); 
DEFINE ('MEM_PORT', 11211); 

$memcache = new Memcache; 
$memcache->addServer(MEM_HOST1,MEM_PORT); 

//$data = $memcache->get(session_id()); 
//print_r(unserialize($data)); 
$list = array(); 
$i = 0; 
$Slabs= $memcache->getExtendedStats('slabs'); 
$items = $memcache->getExtendedStats('items'); 

foreach ($Slabs as $server => $slabs) { 
  foreach ($slabs as $slab_id => $slabMeta) { 
    if(is_numeric($slab_id)){ 
      $cache_dump = $memcache->getExtendedStats('cachedump', (int)$slab_id); 
	  
	  foreach ($cache_dump as $server => $entries) { 
        if ($entries) { 
          foreach ($entries as $entry => $detail) { 
			  
            $list[$entry] = array( 
                'key' => $entry, 
                'server' => $server, 
                'slab_id' => $slab_id, 
                'detail' => $detail, 
                'age' => $items[$server]['items'][$slab_id]['age'], 
                ); 
            if($memcache->get($entry)){ 
              $value[] = array($entry=>$memcache->get($entry)); 
              $key_list[] = $entry; 
              $i++; 
            } 
          } 
        } 
      } 
    } 
  } 
} 
?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php
//print_r($_SESSION);

echo "use memcache key count : ". $i."<br/>"; 
//echo "Key List "; 
//print_r($key_list); 

// $data = $memcache->get("f2rpqj4qngnc421edgthl9qll3"); 
//  print_r($data); 

// key value 
//foreach($key_list as $key){ 
//  $data = $memcache->get($key);
//  echo $key.":::::::";
//  print_r($data);
//  echo "<br/><br/>";
//
//} 
//632690460-zwJc9jcXC9OKAiT78D4X42tRA8YYKvfAqTo3DnGx
?>