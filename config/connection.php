<?php

  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "agenda";

  try {

    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

    // ativa o modo de erros
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  }catch(PDOException $e) {

    // erro na conexão
    $error = $e->getMessage();    
    echo "Error: $error";

  }