<?php 
    session_start();
    if(($_SESSION['isConnected'] == false) || ($_SESSION['login'] == "")){
        header('location:index.php');
    }
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
    
    <div id="wrapper" class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 sidebar-nav">
                <div class="logo">
                    <a class="navbar-brand" href="#">
                        <img src="static/images/guinea.png" alt="Guinea Connect" height="17.92" width="204.79">
                    </a>
                </div>
                <div class="liens">
                    <div class="header-nav">STRUCTURE SANITAIRE</div>
                    <hr/>
                    <div class="structure-nav">
                        <div class="panel panel-default">
                            <div class="panel-heading rapport" data-toggle="collapse" data-target="#collapseElement" aria-expanded="true"><i class="chevron fa" ></i> Timbi touni</div>
                            <div class="collapse in" id="collapseElement" aria-expanded="true">
                            <div class="click colectivity-selected"><span class="fa fa-circle"></span> Rapport Sous-Prefecture</div>
                                <div class="click colectivity"><span class=""></span> CS Timbi Tounni Centre</div>
                                <div class="click colectivity"><span class=""></span> PS Péllel Bantan</div>
                                <div class="click colectivity"><span class=""></span> PS Diaga</div>
                                <div class="click colectivity"><span class=""></span> PS Djongassi</div>
                                <div class="click colectivity"><span class=""></span> PS Hôre Wouri</div>
                                <div class="click colectivity"><span class=""></span> PS Kothyou</div>
                                <div class="click colectivity"><span class=""></span> PS Bendékouré</div>
                                <div class="click colectivity"><span class=""></span> PS Saran</div>
                                <div class="click colectivity"><span class=""></span> PS Wansan</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="deconnexion">
                    Connecté en tant que <br/>
                    <span>
                    <?php
                        echo strtoupper($_SESSION['login']);
                    ?>
                    </span><br/>
                    DÉCONNEXION <a href="/guinea-connect/public/" style="text-decoration:none;"><span class="fa fa-sign-out"></span></a>
                </div>
            </div>
                       
            <div class="col-lg-9 col-sm-6">
                <div id="test">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/App.js"></script>
    <script>
        $(document).ready(function(){
            $("#test").load("php/body_content.php",{ "locality": 'Rapport Sous-Prefecture' });
        });
        $(".click").click(function(){
            $(".click").children("span").removeClass("fa");
            $(".click").children("span").removeClass("fa-circle");
            $(".click").removeClass("colectivity-selected");
            $(".click").addClass("colectivity");
            $(this).removeClass("colectivity");
            $(this).addClass("colectivity-selected");
            $(this).children("span").addClass("fa");
            $(this).children("span").addClass("fa-circle");
            
            $("#test").load("php/body_content.php",{ "locality": $(this).text() });
         
        });
        
    </script>
</body>