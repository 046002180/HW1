<?php
/*API CHE RESTITUISCE LA LISTA DI SOFTWARE,I RELATIVI PREZZI E IL PATH DELLE IMMAGINI*/ 
require_once 'query.php' ;
require_once 'images_path.php';

$conn=mysqli_connect("localhost","root","","hmw") or die("Error : ".mysqli_error($conn));
$query=create_retriveSoftwaresInfoQuery();
$res=mysqli_query($conn,$query) or die("Error : ".mysqli_error($conn));
$arr=array();
while($row=mysqli_fetch_assoc($res)){
    $arr[strtolower($row['Nome'])]=array('Prezzo'=>$row['Prezzo'],'Img'=>$path[$row['Nome']]);

}
mysqli_close($conn);
mysqli_free_result($res);
echo json_encode($arr);
exit;

?>