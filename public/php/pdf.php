<?php
    require('fpdf.php');
    require_once('connection_bd.php');

    $local_dates = $_POST['dates'];
    $local_name = $_POST['localite'];
    $maladiesName = array('Tétanos','Coquéluche','Diphtérie','La Diarrhée non sanglante','Helminthiase','I.R.A. inferieur de 3 semaines',
                         'I.R.A superieur a 3 semaines','Asthme','Autres maladies respiratoires chronique','La malnutrition','Anémies femme en grossesse',
                         'Anémies autres','Drépanocytose','Goitre','Diabéte Sucré','Paludisme simple','Paludisme grave','Ictères',
                         'Ophtalmie du nouveau née','Conjonctivite',"Plaie traumatiques de l'oeil",'Trâchome trichiasis','Cataracte',
                         'Autres maladies des yeux','Ecoulement vaginale','Ecoulement Urétral','Douleur abdominale','Ulcération Genitale Femmes',
                         'Ulcération Genitale Hommes','Infection Sexuallement transmissible','Maladie Urinaire non IST','Maladie Gyneco Non IST',
                         'Gale','Autre Mal Dermatologiques','Fracture','Traumatisme Cranien','Brulure','Autre traumatisme','La gastrite',
                         'Appendicites','Abdomen Aigu','Hernies','Occlusions','Autre pathologies digestives',"L’hypertension Artérielle",
                         'Autres mal Cardio vasculaires','RAA','Maladies ORL','Autres mal articulaire','Carie Dentaire','Autre mal Bouche dents',
                         'Maladies mentales','Mal Neurologiques','Morsure de serpent','Autre','Tetanos neo natal','La paralysie Flasque Aigue',
                         'Poliomyélite','Rougeole','La diarrhée sanglante','La Méningite','Cholera','Fièvre Jaune','Dracunculose',
                         'Schistosomiase urinaire','Schistosomiase intestinale','Onchocercose','Tuberculose','Lepre','Trypanosomiase',
                         'Fièvre Typhoide','Hepatite virale','VIH SIDA','Abcés','Accident Vasculaire Cérébral','Blessure','Candidose vaginale',
                         'Chancre','Décharge du pénis','Dermatite','Dermatite de la tete','Douleur corporelle','Douleur destomac','Douleur musculaire',
                         'Fiévre','Infection respiratoire aigue','Mal au dos','Mal de Tete','Oreillons','Pharyngite','La pneumonie','Le rhume','Rubéole',
                         'Saignements Vaginaux','Syphilis','Varicelle','Vomissement');

    $pdf_req_localite = $bdd->prepare("SELECT * FROM localite WHERE localite_name LIKE :locality AND Mois_localite LIKE :local_date");
    $pdf_req_localite->execute(array(
        'locality' => $local_name,
        'local_date' => $local_dates
    ));
    if($pdf_req_localite->rowCount() > 0){
        $rows_localite = $pdf_req_localite->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows_localite as $row){
            $id_localite = $row['Id_localite'];
            $localite_name = $row['localite_name'];
            $Mois_localite = $row['Mois_localite'];
            $nb_consultation = $row['nb_consultation'];
            $NB_ACC = $row['NB_ACC'];
            $nb_tdr_moins = $row['nb_tdr_moins'];
            $nb_tdr_plus = $row['nb_tdr_plus'];
            $nb_tdr_suspect = $row['nb_tdr_suspect'];
            $nb_tdr_confirme = $row['nb_tdr_confirme'];
        }
        //recuperation des donnes de moins_de_11_mois
        $pdf_req_11_mois = $bdd->prepare("SELECT * FROM moins_de_11_mois WHERE id_localite LIKE :localID");
        $pdf_req_11_mois->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_11_mois->rowCount() > 0){
            $rows_11_mois = $pdf_req_11_mois->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_11_mois as $row){
                $nb_consult_11_mois = $row['nb_consultation'];
                $nb_maladie_11_mois = $row['maladies'];
            }
        }

        //recuperation des donnes de moins_de_5_ans
        $pdf_req_5_ans = $bdd->prepare("SELECT * FROM moins_de_5_ans WHERE id_localite LIKE :localID");
        $pdf_req_5_ans->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_5_ans->rowCount() > 0){
            $rows_5_ans = $pdf_req_5_ans->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_5_ans as $row){
                $nb_consult_5_ans = $row['nb_consultation'];
                $nb_maladie_5_ans = $row['maladies'];
            }
        }

        //recuperation des donnes de moins_de_15_ans
        $pdf_req_15_ans = $bdd->prepare("SELECT * FROM moins_de_15_ans WHERE id_localite LIKE :localID");
        $pdf_req_15_ans->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_15_ans->rowCount() > 0){
            $rows_15_ans = $pdf_req_15_ans->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_15_ans as $row){
                $nb_consult_15_ans = $row['nb_consultation'];
                $nb_maladie_15_ans = $row['maladies'];
            }
        }

        //recuperation des donnes de moins_de_20_ans
        $pdf_req_20_ans = $bdd->prepare("SELECT * FROM moins_de_20_ans WHERE id_localite LIKE :localID");
        $pdf_req_20_ans->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_20_ans->rowCount() > 0){
            $rows_20_ans = $pdf_req_20_ans->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_20_ans as $row){
                $nb_consult_20_ans = $row['nb_consultation'];
                $nb_maladie_20_ans = $row['maladies'];
            }
        }

        //recuperation des donnes de moins_de_25_ans
        $pdf_req_25_ans = $bdd->prepare("SELECT * FROM moins_de_25_ans WHERE id_localite LIKE :localID");
        $pdf_req_25_ans->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_25_ans->rowCount() > 0){
            $rows_25_ans = $pdf_req_25_ans->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_25_ans as $row){
                $nb_consult_25_ans = $row['nb_consultation'];
                $nb_maladie_25_ans = $row['maladies'];
            }
        }

        //recuperation des donnes de moins_de_50_ans
        $pdf_req_50_ans = $bdd->prepare("SELECT * FROM moins_de_50_ans WHERE id_localite LIKE :localID");
        $pdf_req_50_ans->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_50_ans->rowCount() > 0){
            $rows_50_ans = $pdf_req_50_ans->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_50_ans as $row){
                $nb_consult_50_ans = $row['nb_consultation'];
                $nb_maladie_50_ans = $row['maladies'];
            }
        }

        //recuperation des donnes de moins_de_60_ans
        $pdf_req_60_ans = $bdd->prepare("SELECT * FROM moins_de_60_ans WHERE id_localite LIKE :localID");
        $pdf_req_60_ans->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_60_ans->rowCount() > 0){
            $rows_60_ans = $pdf_req_60_ans->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_60_ans as $row){
                $nb_consult_60_ans = $row['nb_consultation'];
                $nb_maladie_60_ans = $row['maladies'];
            }
        }

        //recuperation des donnes de plus_de_60_ans
        $pdf_req_plus_60_ans = $bdd->prepare("SELECT * FROM plus_de_60_ans WHERE id_localite LIKE :localID");
        $pdf_req_plus_60_ans->execute(array(
            'localID' => $id_localite
        ));
        if($pdf_req_plus_60_ans->rowCount() > 0){
            $rows_plus_60_ans = $pdf_req_plus_60_ans->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows_plus_60_ans as $row){
                $nb_consult_plus_60_ans = $row['nb_consultation'];
                $nb_maladie_plus_60_ans = $row['maladies'];
            }
        }

        
    }
class PDF extends FPDF{
    var $local;
    var $dates;
    // En-tête
    function Header()
    {
        $this->SetFont('Arial','B',13);
        $this->Cell(80);
        $this->Cell(30,10,'rapport_'.$this->dates.'_de_la_localite_de_'.$this->local,0,0,'C');
        $this->Ln(20);
    }
    // Pied de page
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
    //mes fonction d'affichage personaliser'
    function fcell($c_width,$c_height,$x_axis,$text){
        $w_w=$c_height/3;
        $w_w_1=$w_w+2;
        $w_w1=$w_w+$w_w+$w_w+3;
        $len=strlen($text); 
        if($len>10){
        $w_text=str_split($text,10);
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w_1,$w_text[0],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w1,$w_text[1],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,'','LTRB',0,'C',0);
        }
        else{
            $this->SetX($x_axis);
            $this->Cell($c_width,$c_height,$text,'LTRB',0,'C',0);
        }
    }

    function hcell($c_width,$c_height,$x_axis,$text){
        $w_w=$c_height/3;
        $w_w_1=$w_w+2;
        $w_w1=$w_w+$w_w+$w_w+3;
        $len=strlen($text); 
        if($len>6){
        $w_text=str_split($text,6);
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w_1,$w_text[0],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w1,$w_text[1],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,'','LTRB',0,'C',0);
        }
        else{
            $this->SetX($x_axis);
            $this->Cell($c_width,$c_height,$text,'LTRB',0,'C',0);
        }
    }
    function ecell($c_width,$c_height,$x_axis,$text){
        $w_w=$c_height/3;
        $w_w_1=$w_w+2;
        $w_w1=$w_w+$w_w+$w_w+3;
        $len=strlen($text); 
        if($len>58){
        $w_text=str_split($text,58);
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w_1,$w_text[0],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$w_w1,$w_text[1],'','','');
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
        }
        else{
            $this->SetX($x_axis);
            $this->Cell($c_width,$c_height,$text,'LTRB',0,'L',0);
        }
    }
    function scell($c_width,$c_height,$x_axis,$text){
        $w_w=$c_height/3;
        $w_w_1=$w_w+2;
        $w_w1=$w_w+$w_w+$w_w+3;
        $this->SetX($x_axis);
        $this->Cell($c_width,$c_height,$text,'LTRB',0,'C',0);
    }

    //envoi les donnee de l'entete'
    function setLocalDate($loca,$dat){
        $this->local = $loca;
        $this->dates = $dat;
    }

    // Nombre de naissance
    function nbNaissance($nb)
    {   
        $this->SetFont('Arial','',15);
        $this->Cell(0,6,"Tableau naissance ");
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(120,5,"Nombre de naissance ",1);
        $this->Cell(30,5,$nb,1,0,'R');
        $this->Ln();
        $this->Ln();
    }
    //creer le tableau de consultation
    function consultation($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8){
        $this->SetFont('Arial','',15);
        $this->Cell(0,6,"Tableau de Consultation");
        $this->Ln();
        $this->SetFont('Times','',14);
        $this->Cell(50,5,"Tranches ",1);
        $this->Cell(30,5,'Nombre',1,0,'R');
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(50,5,"0-11 mois ",1);
        $this->Cell(30,5,$p1,1,0,'R');
        $this->Ln();
        $this->Cell(50,5,"1-4 ans ",1);
        $this->Cell(30,5,$p2,1,0,'R');
        $this->Ln();
        $this->Cell(50,5,"5-14 ans ",1);
        $this->Cell(30,5,$p3,1,0,'R');
        $this->Ln();
        $this->Cell(50,5,"15-19 ans ",1);
        $this->Cell(30,5,$p4,1,0,'R');
        $this->Ln();
        $this->Cell(50,5,"20-24 ans ",1);
        $this->Cell(30,5,$p5,1,0,'R');
        $this->Ln();
        $this->Cell(50,5,"25-49 ans ",1);
        $this->Cell(30,5,$p6,1,0,'R');
        $this->Ln();
        $this->Cell(50,5,"50-59 ans ",1);
        $this->Cell(30,5,$p7,1,0,'R');
        $this->Ln();
        $this->Cell(50,5,"60 ans et plus ",1);
        $this->Cell(30,5,$p8,1,0,'R');
        $this->Ln();
        $this->SetFont('Times','',14);
        $this->Cell(50,5,"Totals ",1);
        $this->Cell(30,5,$p1+$p2+$p3+$p4+$p5+$p6+$p7+$p8,1,0,'R');
        $this->Ln();
        $this->Ln();
    }
    //creer le tableau de paludisme
    function paludisme($nb_susp,$nb_tdr_moins,$nb_tdr_plus,$nb_traite){
        $this->SetFont('Arial','',15);
        $this->Cell(0,6,"Tableau de Paludisme");
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(120,5,"Nombre de supect de paludisme ",1);
        $this->Cell(30,5,$nb_susp,1,0,'R');
        $this->Ln();
        $this->Cell(120,5,utf8_decode("Nombre de cas de paludisme testés"),1);
        $this->Cell(30,5,$nb_tdr_moins + $nb_tdr_plus,1,0,'R');
        $this->Ln();
        $this->Cell(120,5,"Nombre de cas de TDR+",1);
        $this->Cell(30,5,$nb_tdr_plus,1,0,'R');
        $this->Ln();
        $this->Cell(120,5,utf8_decode("Nombre de cas de paludisme traités (confirmé)"),1);
        $this->Cell(30,5,$nb_traite,1,0,'R');
        $this->Ln();
        $this->Ln();
    }
    //creer le tableau de frequence des maladies
    function maladies($p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$mal){
        $lop1 = json_decode($p1,true);
        $lop2 = json_decode($p2,true);
        $lop3 = json_decode($p3,true);
        $lop4 = json_decode($p4,true);
        $lop5 = json_decode($p5,true);
        $lop6 = json_decode($p6,true);
        $lop7 = json_decode($p7,true);
        $lop8 = json_decode($p8,true);

        $this->SetFont('Arial','',15);
        $this->Cell(0,6,"Tableau de frequence des maladies ");
        $this->Ln();

        $this->SetFont('Times','B',12);
        $x_axis=$this->getx();
        $this->fcell(64,10,$x_axis,"Tranches / Maladies");
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'0-11 mois');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'1-4 ans');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'5-14 ans');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'15-19 ans');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'20-24 ans');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'25-49 ans');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'50-59 ans');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'60 ans et plus');
        $x_axis=$this->getx();
        $this->hCell(14,10,$x_axis,'Totals');

        $this->Ln();
        $itera = 0;
        foreach($lop1 as $k=>$v){
            $this->SetFont('Times','',10);
            $x_axis=$this->getx();
            $this->ecell(64,10,$x_axis,utf8_decode($mal[$itera]));
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop1[$k]);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop2[$k]);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop3[$k]);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop4[$k]);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop5[$k]);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop6[$k]);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop7[$k]);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop8[$k]);
             $this->SetFont('Times','B',13);
            $x_axis=$this->getx();
            $this->hcell(14,10,$x_axis,$lop1[$k]+$lop2[$k]+$lop3[$k]+$lop4[$k]+$lop5[$k]+$lop6[$k]+$lop7[$k]+$lop8[$k]);
            $this->Ln();
            $itera +=1; 
        }
           
    }


}
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->setLocalDate(utf8_decode($local_name),utf8_decode($local_dates));
    $pdf->AddPage();
    $pdf->nbNaissance($NB_ACC);
    $pdf->consultation($nb_consult_11_mois,
                       $nb_consult_5_ans,
                       $nb_consult_15_ans,
                       $nb_consult_20_ans,
                       $nb_consult_25_ans,
                       $nb_consult_50_ans,
                       $nb_consult_60_ans,
                       $nb_consult_plus_60_ans
                        );
    $pdf->paludisme($nb_tdr_suspect,
                    $nb_tdr_moins,
                    $nb_tdr_plus,
                    $nb_tdr_confirme
                    );
    $pdf->maladies($nb_maladie_11_mois,
                   $nb_maladie_5_ans,
                   $nb_maladie_15_ans,
                   $nb_maladie_20_ans,
                   $nb_maladie_25_ans,
                   $nb_maladie_50_ans,
                   $nb_maladie_60_ans,
                   $nb_maladie_plus_60_ans,
                   $maladiesName
                   );
    $file_name = "rapport_".$local_dates."_de_la_localite_de_".$local_name.".pdf";
    $pdf->Output($file_name, "I");
?>
