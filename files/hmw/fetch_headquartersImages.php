<?php
require_once 'images_path.php';

$response=array('Houston'=>array(
                     'City'=>$path2['Houston'],
                     'HQ'=>$path2['HoustonHQ']
                    ),'Rome'=>array(
                     'City'=>$path2['Rome'],
                     'HQ'=>$path2['RomeHQ']
                    ),
    'Moscow'=>array(
                    'City'=>$path2['Moscow'],
                    'HQ'=>$path2['MoscowHQ']
                     ),
    'Prague'=>array(
                  'City'=>$path2['Prague'],
                   'HQ'=>$path2['PragueHQ']
                     ),
);
$json=json_encode($response);
echo $json;

?>