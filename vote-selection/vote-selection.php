<?php
    session_start();
    
        
        $con = mysqli_connect('127.0.0.1','root','');
        if(!$con)
        {
            $select='Not Connected to server';
        }
        if(!mysqli_select_db($con,'tp-vote'))
        {
            $error='Database not selected';
        }
    
    
    
        $Section=$_SESSION['section'];
    
    if(isset($_POST['submitCandidate'])){
        
        $section =$_POST['section'];
        
        
        $candidat=$_POST['candidat'];
        
        $cid = $_POST['cid'];
        
        $reQueteSQL="SELECT isCandidate FROM etudiants WHERE isCandidate=1 AND section='$section'";
        $reSult = mysqli_query($con,$reQueteSQL);
        if($reSult->num_rows < 5){
            $connect = "UPDATE etudiants SET isCandidate=$candidat WHERE cid='$cid'";
            $resulT= mysqli_query($con,$connect);
        }else{
            $error="Vous avez déja selectionnez 5 Candidat";
        }

        
    }
    if(isset($_POST['submitAdmin'])){
        
        $cid = $_POST['cid'];
            $connect = "UPDATE etudiants SET isAdmin=!isAdmin WHERE cid='$cid'";
            $resulT= mysqli_query($con,$connect);
        

        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vote.css">
    <title><?php if($_SESSION['admin']=="Administrateur"){echo "Administration";}else{echo "Vote";}?></title>
</head>
<body>
   <?php include('../layout/header.php'); ?>
    
            
        
   <?php if($_SESSION['admin']=="Administrateur"){?>
    
    <?php if(isset($error)){ ?>
        <p><?php echo $error ?></p>
        <?php } ?>
    
    <?php $requeteSQL="SELECT DISTINCT section FROM etudiants";
            $result = mysqli_query($con,$requeteSQL);
             ?>
       <form action="" method="GET" id="select">
           
       <select name="selection1" id="select-section">
        
       <option disabled selected>Selectionner Une Section</option>
       <?php
       while($Data=mysqli_fetch_array($result)){?>
        <option value="<?php echo $Data['section'] ?>"><?php echo $Data['section']; ?></option>
      <?php } ?>

       
       
    </select>
    
    </form>
    <?php 
    if(isset($_GET['selection1'])){  $sectionPost = $_GET['selection1'];?>
       <?php $SQL1="SELECT prenom,nom,cid,isCandidate,section FROM etudiants WHERE section='$sectionPost'"; 
        $rec1 = mysqli_query($con,$SQL1); ?>
      

        <table>
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>N° Carte d'étudiant</th>
                    <th>Candidat</th>
                    
                    <th></th>
                    <th>Admin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php while($Data1=mysqli_fetch_array($rec1)){ ?>
                <tr>
                    <td><?php echo $Data1['prenom'] ?></td>
                    <td><?php echo $Data1['nom'] ?></td>
                    <td><?php echo $Data1['cid'] ?></td>
                    <form action="" method="post">
                    <td><select name="candidat" id="candidat">
                        <option disabled selected>Selectionnez Candidat</option>
                        <option value="1">Candidat</option>
                        <option value="0">Non Candidat</option>
                    </select></td>
                    
                    <td><input type="submit" name="submitCandidate" id="submitCandidate" value="Confirmer"><input name="section" type="hidden" value="<?php echo $Data1['section'] ?>"><input name="cid" type="hidden" value="<?php echo $Data1['cid'] ?>"></td>
                    <td><select name="admin" id="admin">
                        <option disabled selected>Selectionnez admin</option>
                        <option value="1">admin</option>
                        <option value="0">Non admin</option>
                    </select></td>
                    <td><input type="submit" name="submitAdmin" id="submitAdmin" value="ConfirmerAdmin"></td>
                    </form>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php }?>
    <?php }else if($_SESSION['admin']==""){ 
         
        ?>
       
        <?php $isCandidate=true; $requetesQL="SELECT prenom,nom,cid,section FROM etudiants WHERE section='$Section' AND isCandidate=$isCandidate";
            $rEsult = mysqli_query($con,$requetesQL);
             ?>
   <form action="../resultat/resultat.php" method="post">
        <select name="vote" id="vote">
            <option disabled selected>Selectionner Un Candidat</option>
            <?php
       while($Data2=mysqli_fetch_array($rEsult)){?>
        <option value="<?php echo $Data2['cid'] ?>"> -Section N° : <?php echo $Data2['section']; ?>  Etudiant : <?php echo $Data2['prenom'] ?></option>
      <?php } ?>
        </select>
        <input type="hidden" name="cid" value="<?php echo $_SESSION['email'] ?>">
        <input type="submit" name="submitVote" value="Voté">
</form>
        
    <?php }?>

   <?php include('../layout/footer.php'); ?>
   <script src="vote-selection.js"></script>
</body>
</html>