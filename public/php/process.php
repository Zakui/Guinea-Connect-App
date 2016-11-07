<?php

    require_once('connection_bd.php');



    //donnees de pour la table localite
    $localite_name = $_POST['localite_name'];
    $Mois_localite = $_POST['Mois_localite'];
    $NB_ACC = $_POST['NB_ACC'];
    $nb_consultation = $_POST['nb_consultation'];
    $nb_tdr_moins = $_POST['nb_tdr_moins'];
    $nb_tdr_plus = $_POST['nb_tdr_plus'];
    $nb_tdr_suspect = $_POST['nb_tdr_suspect'];
    $nb_tdr_confirme = $_POST['nb_tdr_confirme'];

    //donnees pour la tables moins_de_11_mois
    $nb_maladies_12_m = $_POST['nb_maladies_12_m'];
    $nb_consult_12_m = $_POST['nb_consult_12_m'];

    //donnees pour la tables moins_de_5_ans
    $nb_maladies_5_a = $_POST['nb_maladies_5_a'];
    $nb_consult_5_a = $_POST['nb_consult_5_a'];

    //donnees pour la tables moins_de_15_ans
    $nb_maladies_15_a = $_POST['nb_maladies_15_a'];
    $nb_consult_15_a = $_POST['nb_consult_15_a'];

    //donnees pour la tables moins_de_20_ans
    $nb_maladies_20_a = $_POST['nb_maladies_20_a'];
    $nb_consult_20_a = $_POST['nb_consult_20_a'];

    //donnees pour la tables moins_de_25_ans
    $nb_maladies_25_a = $_POST['nb_maladies_25_a'];
    $nb_consult_25_a = $_POST['nb_consult_25_a'];

    //donnees pour la tables moins_de_50_ans
    $nb_maladies_50_a = $_POST['nb_maladies_50_a'];
    $nb_consult_50_a = $_POST['nb_consult_50_a'];

    //donnees pour la tables moins_de_60_ans
    $nb_maladies_60_a = $_POST['nb_maladies_60_a'];
    $nb_consult_60_a = $_POST['nb_consult_60_a'];

    //donnees pour la tables plus_de_60_ans
    $nb_maladies_plus_60_a = $_POST['nb_maladies_plus_60_a'];
    $nb_consult_plus_60_a = $_POST['nb_consult_plus_60_a'];
     

    try{
    
        if(!(($localite_name == '') || ($Mois_localite == ''))){

        if($localite_name != 'total'){
            // insertion donnees de pour la table localite
            $insert_localite = $bdd->prepare('INSERT INTO localite(localite_name,Mois_localite,nb_consultation,NB_ACC,nb_tdr_moins,nb_tdr_plus,nb_tdr_suspect,nb_tdr_confirme) 
                            VALUES(:localite_name,:Mois_localite,:nb_consultation,:NB_ACC,:nb_tdr_moins,:nb_tdr_plus,:nb_tdr_suspect,:nb_tdr_confirme)
                        ');
            $insert_localite->execute(array('localite_name' => $localite_name,
                        'Mois_localite' => $Mois_localite,
                        'nb_consultation' => $nb_consultation,
                        'NB_ACC' => $NB_ACC,
                        'nb_tdr_moins' => $nb_tdr_moins,
                        'nb_tdr_plus' => $nb_tdr_plus,
                        'nb_tdr_suspect' => $nb_tdr_suspect,
                        'nb_tdr_confirme' => $nb_tdr_confirme
                ));

            $local_id = $bdd->lastInsertId();
        }else{
            // insertion donnees de pour la table synthese_mois
            $id = rand();
            $t = true;
            while($t){
                $test = $bdd->query("SELECT * FROM synthese_mois WHERE id_synthese_mois = $id");
                if($test->num_rows > 0){
                    $id = rand();
                }else{
                    $t = false;
                }
            }

            $insert_synthese_mois = $bdd->prepare('INSERT INTO synthese_mois(localite_name,Mois_localite,nb_consultation,NB_ACC,nb_tdr_plus,nb_tdr_suspect,nb_tdr_confirme,id_synthese_mois) 
                            VALUES(:localite_name,:Mois_localite,:nb_consultation,:NB_ACC,:nb_tdr_plus,:nb_tdr_suspect,:nb_tdr_confirme,:id_synthese_mois)
                        ');
            $insert_synthese_mois->execute(array('localite_name' => $localite_name,
                        'Mois_localite' => $Mois_localite,
                        'nb_consultation' => $nb_consultation,
                        'NB_ACC' => $NB_ACC,
                        'nb_tdr_plus' => $nb_tdr_plus,
                        'nb_tdr_suspect' => $nb_tdr_suspect,
                        'nb_tdr_confirme' => $nb_tdr_confirme,
                        'id_synthese_mois' => $id
                ));

            $local_id = $id;
        }
        

        //insertion donnees pour la tables moins_de_11_mois
        $insert_11_mois = $bdd->prepare('INSERT INTO moins_de_11_mois(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_11_mois->execute(array('nb_consultation' => $nb_consult_12_m,
                    'maladies' => $nb_maladies_12_m,
                    'id_localite' => $local_id   
            ));

        
        //insertion donnees pour la tables moins_de_5_ans
        $insert_de_5_ans = $bdd->prepare('INSERT INTO moins_de_5_ans(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_de_5_ans->execute(array('nb_consultation' => $nb_consult_5_a,
                'maladies' => $nb_maladies_5_a,
                'id_localite' => $local_id   
         ));
         

         //insertion donnees pour la tables moins_de_15_ans
        $insert_de_15_ans = $bdd->prepare('INSERT INTO moins_de_15_ans(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_de_15_ans->execute(array('nb_consultation' => $nb_consult_15_a,
                'maladies' => $nb_maladies_15_a,
                'id_localite' => $local_id   
         ));


         //insertion donnees pour la tables moins_de_20_ans
        $insert_de_20_ans = $bdd->prepare('INSERT INTO moins_de_20_ans(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_de_20_ans->execute(array('nb_consultation' => $nb_consult_20_a,
                'maladies' => $nb_maladies_20_a,
                'id_localite' => $local_id   
         ));


         //insertion donnees pour la tables moins_de_25_ans
        $insert_de_25_ans = $bdd->prepare('INSERT INTO moins_de_25_ans(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_de_25_ans->execute(array('nb_consultation' => $nb_consult_25_a,
                'maladies' => $nb_maladies_25_a,
                'id_localite' => $local_id   
         ));


         //insertion donnees pour la tables moins_de_50_ans
        $insert_de_50_ans = $bdd->prepare('INSERT INTO moins_de_50_ans(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_de_50_ans->execute(array('nb_consultation' => $nb_consult_50_a,
                'maladies' => $nb_maladies_50_a,
                'id_localite' => $local_id   
         ));


         //insertion donnees pour la tables moins_de_60_ans
        $insert_de_60_ans = $bdd->prepare('INSERT INTO moins_de_60_ans(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_de_60_ans->execute(array('nb_consultation' => $nb_consult_60_a,
                'maladies' => $nb_maladies_60_a,
                'id_localite' => $local_id   
         ));


        //insertion donnees pour la tables plus_de_60_ans
        $insert_de_plus_60_ans = $bdd->prepare('INSERT INTO plus_de_60_ans(nb_consultation,maladies,id_localite) 
                        VALUES(:nb_consultation,:maladies,:id_localite)
                    ');
        $insert_de_plus_60_ans->execute(array('nb_consultation' => $nb_consult_plus_60_a,
                'maladies' => $nb_maladies_plus_60_a,
                'id_localite' => $local_id   
         ));

    }
    }
    catch(Exception $e){ 
        die('Erreur : '.$e->getMessage());
    }
    
?>