<?php
  require_once "../database/Conn.php";
  require_once "../models/Pet.php";
  require_once "../services/PetService.php";
  require_once "../services/ImageUpload.php";

  $db = new Conn('localhost','pets','root', '');

  $folderPets = '../../tmp/pets/';
  $entity = 'pets';
  $imagePath = upload($folderPets, $entity);
  
  if ($imagePath !== '') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $userId = $_POST['userId'];
    var_dump(empty($name));

    if (empty($name) || empty($description) || empty($type) || empty($userId)) {
      // echo 'Preencha todos os dados.';
      header ("location: http://localhost/pets/src/presentation/failure");
    } else {
      $pet = new Pet;
      $pet->setPhoto($imagePath);
      $pet->setName($name);
      $pet->setDescription($description);
      $pet->setType($type);
      $pet->setUserId($userId);
  
      $service = new PetService($db, $pet);
      $service->save();
      header ("location: http://localhost/pets/src/presentation/success");
    }
  } else {
    // echo 'Falha ao salvar imagem.';
    header ("location: http://localhost/pets/src/presentation/failure");
  }
?>