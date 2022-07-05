<?php

  session_start();

  include_once("connection.php");
  include_once("url.php");

  $data = $_POST;

  // modificações no bd
  if(!empty($data)) {

    // Criar contato
    if($data["type"] === "create") {

      $name = $data["name"];
      $phone = $data["phone"];
      $observations = $data["observations"];

      $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";

      $stmt = $conn->prepare($query);

      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":observations", $observations);

      try {

        $stmt->execute();
        $_SESSION['msg'] = "Contato criado com sucesso!";
    
      }catch(PDOException $e) {
    
        // erro na conexão
        $error = $e->getMessage();    
        echo "Error: $error";
    
      }
    } else if($data["type"] === "edit") {

      $id = $data["id"];
      $name = $data["name"];
      $phone = $data["phone"];
      $observations = $data["observations"];

      $query = "UPDATE contacts 
                SET name = :name, phone = :phone, observations = :observations 
                WHERE id = :id";
      
      $stmt = $conn->prepare($query);

      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":phone", $phone);
      $stmt->bindParam(":observations", $observations);
      $stmt->bindParam(":id", $id);

      try {

        $stmt->execute();
        $_SESSION['msg'] = "Contato atualizado com sucesso!";
    
      }catch(PDOException $e) {
    
        // erro na conexão
        $error = $e->getMessage();    
        echo "Error: $error";
    
      }
      
    } else if($data["type"] === "delete") {

      $id = $data["id"];

      $query = "DELETE FROM contacts WHERE id = :id";
      $stmt = $conn->prepare($query);
      $stmt->bindParam(":id", $id);

      try {

        $stmt->execute();
        $_SESSION['msg'] = "Contato removido com sucesso!";
    
      }catch(PDOException $e) {
    
        // erro na conexão
        $error = $e->getMessage();    
        echo "Error: $error";
    
      }

    }

    // redirect home
    header("Location:" . $BASE_URL . "/../index.php");

  } else {
    $id;

    if(!empty($_GET)) {
      $id = $_GET["id"];
    }
  
    // retorna 1 contato
    if(!empty($id)) {
      $query = "SELECT * FROM contacts WHERE id = :id";
  
      $stmt = $conn->prepare($query);    
      $stmt->bindParam(":id" , $id);
      $stmt->execute();
      
      $contact = $stmt->fetch();
  
    } else {
      // retorna todos os contatos
      $contacts = [];
    
      $query = "SELECT * FROM contacts";
    
      $stmt = $conn->prepare($query);
    
      $stmt->execute();
    
      $contacts = $stmt->fetchAll();
    }

  }

  // fechar conexão
  $conn = null;
