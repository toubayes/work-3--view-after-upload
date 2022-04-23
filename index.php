<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&family=Work+Sans:ital,wght@0,100;0,200;0,500;1,100&display=swap" rel="stylesheet">
</head>
<body>
    <h1 class="title">upload image</h1>
   <?php
   include "connectDatabase.php";
   
if(isset($_POST['send'])){
    $fileType = $_FILES["file"]["type"];
    $fileName = $_FILES["file"]["name"];
    $file = $_FILES["file"]["tmp_name"];
    
    move_uploaded_file($file,"files/".$fileName);
    $position = "files/".$fileName;
    $uploadFile = $database->prepare("INSERT INTO image(name,type,position,date_add) VALUES(:name,:type,:position,now())");
    $uploadFile->bindParam("name",$fileName);
    $uploadFile->bindParam("type",$fileType);
    $uploadFile->bindParam("position",$position);
 
    if($uploadFile->execute()){
        ?>
        <div class="message_succes">
            <p>Great sucess ,your file is completled uploaded </p>
        </div>
        <?php
    }else{
        ?>
         <div class="message_warning">
            <p>warning, something wrong, cant uploaded your file</p>
        </div>
        <?php
    }
    }
    
   ?>
        <div class="upload_image">
            <img src="default.jpg" alt="" id="image" class="image"  >
        </div>
        <form action="<?php $_SERVER["PHP_SELF"]?>" enctype="multipart/form-data" method="post">
               <input type="file" name="file" oninput="change_picture()" accept="image/*,video/*,audio/*" id="file_chossen">
                <label for="file_chossen">select image</label>
                <button type="submit" name="send" class="btn_send">upload</button>
        </form>
    <?php
    $showfile=$database->prepare("SELECT * FROM image");
    $showfile->execute();

    ?>
    <h1 class="sub-title">show file stored in databade :</h1>
        <table id="table-content">
        <thead> 
            <tr> 
                <td>#</td>
                <td>name file</td>
                <td>typr file</td>
                <td>position file</td>
                <td>date_add</td>
                <td>delete</td>

                
            </tr>
        </thead>
        <?php
        foreach ($showfile as $data) {
      
        ?>
        <tbody>
          <tr> 
            <td><?php echo $data["id"];?></td>
            <td><?php echo $data["name"];?></td>
            <td><?php echo $data["type"];?> </td>
            <td> <?php echo $data["position"];?></td>
            <td> <?php echo $data["date_add"];?></td>
            <td><form action="<?php $_SERVER["PHP_SELF"]?>" method="get">
             <a href="delete_id=<?php echo $data["id"]?>" class="remove"name="delete">delete</a>
            </form></td>
          </tr>

    <?php 
}
        ?>
           </tbody>
    </table>
    <?php
      if( isset($_GET["delete"])){  
        $id = $data["id"];
            $delete= $database->prepare("DELETE FROM image WHERE id = :id");
            $delete->bindParam("id",$id);
            $delete->execute();

   }
    ?>     
    <script src="script.js">
    </script>
</body>
</html>