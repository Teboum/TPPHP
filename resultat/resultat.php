
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
    if(isset($_POST['submitVote'])){
        $cid=$_POST['vote'];
        $vote=1;
        $email=$_SESSION['email'];
        $connect = "UPDATE etudiants SET cpt=cpt+1 WHERE cid='$cid'";
        $resulT= mysqli_query($con,$connect);
        $connect2 = "UPDATE etudiants SET vote=1 WHERE email='$email'";
        $resulT2= mysqli_query($con,$connect2);
        
        
        
    }
    
        
        
    
    
    
    
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resultat.css">
    <title><?php if($_SESSION['admin']=="Administrateur"){echo "Administration";}else{echo "Vote";}?></title>
</head>
<body>
   <?php include('../layout/header.php'); ?>
    
            
        
   <?php if($_SESSION['admin']=="Administrateur"){?>
    <?php $requeteSQL="SELECT DISTINCT section FROM etudiants";
            $result = mysqli_query($con,$requeteSQL);
             ?>
       <form action="" method="post" id="select">
           
       <select name="selection1" id="select-section">
        
       <option disabled selected>Selectionner Une Section</option>
       <?php
       while($Data=mysqli_fetch_array($result)){?>
        <option value="<?php echo $Data['section'] ?>"><?php echo $Data['section']; ?></option>
      <?php } ?>

       
       
    </select>
    
    </form>
    <?php 
    if(isset($_POST['selection1'])){ $sectionPost = $_POST['selection1'];?>
    
       <?php $SQL1="SELECT prenom,nom,cid,isCandidate,section FROM etudiants WHERE section='$sectionPost'"; 
        $rec1 = mysqli_query($con,$SQL1); ?>
      

        <table>
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>N° Carte d'étudiant</th>
                    <th>Candidat</th>
                </tr>
            </thead>
            <tbody>
            <?php while($Data1=mysqli_fetch_array($rec1)){ ?>
                <tr>
                    <td><?php echo $Data1['prenom'] ?></td>
                    <td><?php echo $Data1['nom'] ?></td>
                    <td><?php echo $Data1['cid'] ?></td>
                    <td><?php if($Data1['isCandidate']=true){echo "Candidat";}else{echo "Non Candidat";} ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php }?>
    
    <?php }else if($_SESSION['admin']==""){ 
        $checkVote =0;
        $Section=$_SESSION['section'];
        $requetesql="SELECT vote FROM etudiants WHERE section='$Section' AND vote=$checkVote ";
        $RESULTT = mysqli_query($con,$requetesql);
        if($RESULTT->num_rows >= 1){
            echo "VOTE EN COURS";
        }else{
             $isCandidate=1; $requetesQL="SELECT prenom,nom,cid,section FROM etudiants WHERE section='$Section' AND isCandidate=$isCandidate ";
            $rEsult = mysqli_query($con,$requetesQL);
             
       ?>
       <table>
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>N° Carte d'étudiant</th>
                    <th>Candidat</th>
                </tr>
            </thead>
            <tbody>
            <?php while($Data1=mysqli_fetch_array($rEsult)){ ?>
                <tr>
                    <td><?php echo $Data1['prenom'] ?></td>
                    <td><?php echo $Data1['nom'] ?></td>
                    <td><?php echo $Data1['cid'] ?></td>
                    <td><?php if($Data1['isCandidate']=true){echo "Candidat";}else{echo "Non Candidat";} ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
      <?php } ?>
        
      <?php }
        

         
        ?>
       
        
    

   <?php include('../layout/footer.php'); ?>
   <script src="vote-selection.js"></script>
</body>
</html>