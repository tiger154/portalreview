<?php

class MethodTest
{
    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
		if($name=="display"){
			echo "call display function ". implode(', ', $arguments). "<br/>";
		}else{
			echo "call default function ". implode(', ', $arguments). "<br/>";
		}

    }

    /**  As of PHP 5.3.0  */
    public static function __callStatic($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        echo "Calling static method '$name' "
             . implode(', ', $arguments). "<br/>";
    }
}

$obj = new MethodTest;
$obj->runTest('in object context',"tset");

MethodTest::runTest('in static context');  // As of PHP 5.3.0

?>