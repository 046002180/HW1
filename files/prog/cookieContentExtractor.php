<?php

function ExtractContent($cookie)
{  $string=str_replace('Prodotti : ','',$cookie);
   $a=explode(',',$string);
   $a=array_filter($a);
   return $a;
}

?>