<?php
session_start();
    $con = mysqli_connect('127.0.0.1','root','');
    if(!$con)
    {
        $error='Not Connected to server';
    }
    if(!mysqli_select_db($con,'tp-vote'))
    {
        $error='Database not selected';
    }
    
        
    
    if(isset($_POST['submit'])){
    $prenom =$_POST['prenom'];
    $nom =$_POST['nom'];
    $cid =$_POST['cid'];
    $email =$_POST['email'];
    $section = $_POST['section'];
    $mdp=$_POST['mdp'];
    $hash=password_hash($mdp,PASSWORD_BCRYPT,array('cost'=>11));
    $isAdmin =false;
    $isCandidate =false;
    $SQL="SELECT email FROM etudiants WHERE email='$email'";
    $rec = mysqli_query($con,$SQL);
    
    if($rec->num_rows > 0){
        $error = "Email Existant";
    }else{
    
    $req="INSERT INTO etudiants (prenom,nom,cid,section,email,mdp,isAdmin,isCandidate,vote) VALUES('$prenom','$nom','$cid','$section','$email','$hash','$isAdmin','$isCandidate')";
    if(!mysqli_query($con,$req))
    {
        $error='Id inscrit vérifiez votre ID';
    }
    else
    {
        $select='Inserted';
    }
    }    
    
    
}
if(isset($_POST['submitLogin'])){
    $email=$_POST['email'];
    $password=$_POST['mdp'];
    
    $SQL="SELECT prenom,nom,cid,section,email,mdp,isAdmin,vote FROM etudiants WHERE email='$email'";
    $rec = mysqli_query($con,$SQL);
    
    if($rec->num_rows > 0){
        $data=mysqli_fetch_array($rec);
        
       if(password_verify($password ,$data['mdp'])){
        if($data['isAdmin']==true){
            
            $_SESSION['prenom']=$data['prenom'];
            $_SESSION['nom']=$data['nom'];
            $_SESSION['admin']= "Administrateur";
            $_SESSION['vote']="";
            $_SESSION['email']=$data['email'];
            
            
            header('Location: http://localhost/TP/vote-selection/vote-selection.php');
            
          
        }else{
            $_SESSION['prenom']=$data['prenom'];
            $_SESSION['nom']=$data['nom'];
            $_SESSION['admin']= "";
            $_SESSION['section']=$data['section'];
            $_SESSION['cid']=$data['cid'];
            $_SESSION['email']=$data['email'];
            if($data['vote']==0){
                header('Location: http://localhost/TP/vote-selection/vote-selection.php');
            }else{
                header('Location: http://localhost/TP/resultat/resultat.php');
            }
            
            
            
        }
        
       }else{
           
           $errror="Mot de passe Incorrect";
       }
    }else {
        $errror="Email inexistanst";
        
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="connexion.css">
    <link href="https://fonts.googleapis.com/css2?family=Crete+Round&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <?php include '../layout/header.php' ?>
    
        <div class="connexion-inscription">
            
                <div  class="connexion">
                    <h2>Connexion</h2>
                    
                    <form method="POST" action="" class="connexion-form">
                        
                        <div class="connexion-input">
                            
                            <input type="email" name="email" placeholder="E-mail"> 
                            
                            <input type="password" name="mdp" placeholder="Mot de passe"> 
                            
                        </div>
                        <?php if(isset($errror)){?>
                                <p class="mdp-alert error"><?php echo $errror ?></p>
                        <?php } ?>
                        <input name="submitLogin" class="connexion-submit" type="submit" value="Connexion" >
                    </form>
                </div>
                <div id="img">
                    <img class="mySlides" src="../img/img_la.jpg" >
                    <img class="mySlides" src="../img/img_ny.jpg" >
                    <img class="mySlides" src="../img/img_chicago.jpg" >
                </div>
                <div class="inscription">
                    <h2>Inscription</h2>
                    <form method="POST" action="connexion.php" class="inscription-form">
                    
                        <div class="inscription-input">
                            <label class="label" for="prenom">Prenom :</label>
                            <input type="text" name="prenom" id="prenom" placeholder="Prénom" required>
                            <label for="nom" class="label">Nom :</label>
                            <input type="text" name="nom" id="nom" placeholder="Nom" required>
                            <label for="cid" class="label">Numéro de carte d'étudiant :</label>
                            <input type="text" name="cid" id="cid" placeholder="Carte d'étudiant" required>
                            <label for="section" class="label">Section :</label>
                            <input type="number" name="section" id="section" placeholder="Section" required>
                            <label for="email" class="label">Adress mail :</label>
                            <input type="email" name="email" id="email" placeholder="E-mail" required>
                            <label for="mdp" class="label">Mot De Passe :</label>
                            <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>
                            <label for="confirmPwd" class="label">Confirmer Mot de Passe :</label>
                            <input type="password" name="confirmMdp" id="confirmMdp" placeholder="Confirmer Mot de passe" required>
                            <p class="mdp-alert">Le mot de passe ne Correspond pas</p>
                            <p class="mdp-alert mdp-confirm">mot de passe correcte</p>
                            <?php if(isset($error)||isset($select)){?>
                            <p id="server-error" class="mdp-alert error <?php if(isset($select)){echo "mdp-confirm";} ?>"><?php if(isset($error)){echo $error;}  if(isset($select)){echo $select;} ?></p>
                            <?php } ?>
                        </div>
                        <input class="inscription-submit" type="submit" name="submit" value="Inscription">
                    </form>

        </div>
      
    </div>
    <h2 id="news-title">Tech News : </h2>
    <div class="ticker-wrap">
        <div class="ticker" id="ticker">
        <div class="ticker__item"></div>

        </div>
    </div>


   <?php include('../layout/footer.php')?>
    <script src="./connexion.js"></script>
    
</body>
</html>