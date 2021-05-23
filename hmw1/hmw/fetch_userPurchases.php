<?php
require_once 'query.php';
session_start();
if (!isset($_SESSION['lambda_user'])) {
    header('Location:login.php');
    exit;
}
header('Content-Type: application/json');
$conn = mysqli_connect("localhost", "root", "", "hmw") or die("Errore:" . mysqli_error($conn));
$query = create_retrieveTransactionsQuery($conn,$_POST['user']);
$res = mysqli_query($conn, $query) or die("Errore:" . mysqli_error($conn));
if(mysqli_num_rows($res)>0){
$length = $res->num_rows;
$out = array();
while ($row = mysqli_fetch_assoc($res)) {
    $out[] = $row;
}
if ($length > 1) {
    $transactions = array();
    $index = 0;
    for ($i = 0; $i < $length; $i++) {
        $a = $i + 1;
        if ($a < $length && $out[$i]['Id'] === $out[$a]['Id']) {
            $transactions[$index] = array('Id' => $out[$i]['Id'], 'Data' => $out[$i]['DATA'], 'Metodo' => $out[$i]['Metodo'], 'Num.Metodo' => $out[$i]['Numero_metodo'], 'Importo' => $out[$i]['Importo']);
            $transactions[$index]['Prodotti'][] = $out[$i]['Software'] . ',' . $out[$i]['N_copie'];
            while ($a < $length && $out[$i]['Id'] === $out[$a]['Id']) {
                $transactions[$index]['Prodotti'][] = $out[$a]['Software'] . ',' . $out[$a]['N_copie'];
                $a++;
            }
            if ($a === $length){ //Array completamente iterato
                break;
            }
            elseif ($a > $i) {
                //salta tutti i prodotti già aggiunti che hanno lo stesso id
                $i = $a - 1; //bilancia l'incremento del ciclo for
                $a = 0;
                $index++;
            }
        } else {
            $transactions[$index] = array('Id' => $out[$i]['Id'], 'Data' => $out[$i]['DATA'], 'Metodo' => $out[$i]['Metodo'], 'Num.Metodo' => $out[$i]['Numero_metodo'], 'Importo' => $out[$i]['Importo'], 'Prodotti' => $out[$i]['Software'] . ',' . $out[$i]['N_copie']);
            $index++;
        }
    }
} else {
    //transazione di un solo prodotto
    $transactions = array('Id' => $out['Id'], 'Data' => $out['DATA'], 'Metodo' => $out['Metodo'], 'Num.Metodo' => $out['Numero_metodo'], 'Importo' => $out['Importo'], 'Prodotti' => $out['Software'] . ',' . $out['N_copie']);
}
$transactions = json_encode($transactions);
mysqli_close($conn);
mysqli_free_result($res);
echo $transactions;
exit;
}
$response=array('error'=>"No transaction found");
mysqli_close($conn);
echo json_encode($response);
?>
