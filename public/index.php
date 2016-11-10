<?php 
    session_start();
    $_SESSION['isConnected'] = false;
    $_SESSION['login'] ="";
 ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Guinea Connect</title>

    <!--favicon-->
    <link rel=icon href=static/images/favicon.png sizes="16x16" type="image/png">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <?php
     
        require_once('php/connection_bd.php');
    
        if((isset($_POST['login']) && !empty($_POST['login'])) && 
            (isset($_POST['passwd']) && !empty($_POST['passwd']))){
        
            $response = "";
        
    
            $login = htmlspecialchars($_POST['login']);
            $pass = htmlspecialchars($_POST['passwd']);
        
    try{ 
    
        $requete = $bdd->prepare('SELECT * FROM login 
                                    WHERE login LIKE :login AND passwd LIKE :pass
                                    LIMIT 1');
        $requete->execute(array('login'=>$login,
                                'pass'=>$pass,
                        ));
            
        if($requete->rowCount() > 0){
            //c'est bon 
            $_SESSION['isConnected'] = true;
            $_SESSION['login'] =$login;
            $msg = false;
            header('location:main.php');
            
            }else {
            //login ou mot de passe errone
            $msg = true;
            $_SESSION['isConnected'] = false;
            }
        
        
        }catch(Exception $e){ 
            die('Erreur : '.$e->getMessage());
            echo json_encode ($response);
        }
        
    }
    ?>
   <div class="login-contenu">
        <div class="conteneur">
            <?php	
                // on teste s'il n'est pas connect avant d'afficher le formulaire
                if(!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] ==false){
            ?>
            <div class="login-logo">
                <a href="/guinea-connect/public/">
                    <img src="static/images/guinea.png" alt="Guinea Connect" height="27.89" width="250.28">
                </a>
            </div>
            <div class="contenu">
                <form action="index.php" method="post">
                    <div class="groupe-btn">
                        <div class="text-label">Nom d'utilisateur</div>
                        <input class="text-box" name="login" type="text">
                    </div>
                    <div class="groupe-btn">
                        <div class="text-label">Mot de passe</div>
                        <input class="text-box" name="passwd" type="password">
                    </div>
                    <div class="groupe-btn">
                        <button class="connexion">CONNEXION</button>
                    </div>
                </form>
            </div>
            <div class="partener">
                <p class="partenaire">EN PARTENARIAT AVEC</p>
                <div>
                    <a href="http://www.ehealthafrica.org/">
                        <img src="static/images/ehealth.png" alt="eHealth Africa" height="35.45" width="125.13">
                    </a>
                </div>
            </div>
            <?php }
                else {
                    echo "vous etes deja connecter mon amie !";
                    header('location:main.php');
                }
            ?>
        </div>
   </div>
</body>
</html>