<?php 




function create_retriveSoftwaresInfoQuery(){
    $query="SELECT nome AS Nome,costo_licenza AS Prezzo FROM software WHERE nome<>'Hydra' AND nome<>'RCAS' AND nome<>'MACK' AND nome<>'SCC' ;";
    return $query;
}


function create_signupQuery($conn,$email,$password,$name,$surname,$state,$city,$address,$n_address){
    $email=mysqli_real_escape_string($conn,$email); 
    $password=mysqli_real_escape_string($conn,$password);
    /*ALGORITMO HASHING PASSWORD*/
    $password = hash("sha256",$password,false);
    $password = base64_encode($password);
    /********/ 
    $name=mysqli_real_escape_string($conn,$name); 
    $surname=mysqli_real_escape_string($conn,$surname); 
    $state=mysqli_real_escape_string($conn,$state); 
    $city=mysqli_real_escape_string($conn,$city); 
    $n_address=mysqli_real_escape_string($conn,$n_address); 
    $address=mysqli_real_escape_string($conn,$address); 
    $complete_address=$city.','.$address.','.$n_address; 
    $query = "INSERT INTO cliente_privato(email,password,nome,cognome,stato,indirizzo) VALUES ('$email','$password','$name','$surname','$state','$complete_address')";
    return $query;
};

function create_retrieveTransactionsQuery($conn,$email){
    $email=mysqli_real_escape_string($conn,$email);
    $query="CALL retrieve_transactions ('$email')";
    return $query;
};
function create_getPasswordQuery($email){
    $query="SELECT password FROM cliente_privato c WHERE c.Email='$email' ;";
    return $query;
}
function create_productsQuery($conn,$email){
    $email=mysqli_real_escape_string($conn,$email);
    $query="SELECT DISTINCT cp.software FROM (cliente_privato c JOIN transazione t ON c.email=t.email_cliente) JOIN copia_pvt cp ON cp.id_transazione=t.id WHERE c.Email='$email' ;";
    return $query;
}
function create_reportQuery(){};
function create_changeCredentialsQuery($conn,$email,$password){
    $email=mysqli_real_escape_string($conn,$email);
    $password=mysqli_real_escape_string($conn,$password);
    $query="UPDATE cliente_privato SET password='$password' WHERE email='$email' ;";
    return $query;
};
function create_changePasswordQuery($email,$new_password){
    $query="UPDATE cliente_privato SET password='$new_password' WHERE Email='$email';";
    return $query;
}
