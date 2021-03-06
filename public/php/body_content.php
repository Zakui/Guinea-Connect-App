<?php
    require_once('connection_bd.php');

    $local_name = $_POST['locality'];
    $local_name = trim($local_name);

    
    $nom_des_localites =array(
        'CS Timbi Tounni Centre' => 'Timbi Tounni Centre',
        'PS Hôre Wouri' => 'Hôrè Wouri',
        'PS Bendékouré' => 'Bendékouré',
        'PS Diaga' => 'Diaga',
        'PS Saran' => 'Saran',
        'PS Wansan' => 'Wansan',
        'PS Djongassi' => 'Djongassi',
        'PS Péllel Bantan' => 'Péllel_Bantan',
        'PS Kothyou' => 'Kothyou',
        'Rapport Sous-Prefecture' => 'Globals'
        );
        $db_local = '';
        foreach ($nom_des_localites as $key=>$value) {
            if(strcmp($local_name,$key) == 0){
                $db_local = $value;
            }
        }

        
?>
<div class="body-nav">
    <div class="navigation">
        <p class="local-name">
            <?php
                if($db_local == 'Globals'){
                    echo 'Récapitulatif et Synthèse de Toutes les Données de Timbi Tounni';
                }else{
                    echo $local_name;
                }
            ?>
        </p>
    </div>
    <div class="container">
        <div class="scroll-div">
                <div class="element-active">
                    <div class="dates" style="font-size:18px;">
                        <?php
                            $months = array("Janv.", "Fev.", "Mars", "Avril", "Mai", "Juin",
                                    "Juil.", "Aout", "Sept.", "Octo.", "Nov.", "Dec.");
                            echo $months[(intval(Date('m'))-1)%12].' '.date("Y");
                        ?> 
                    </div>
                    <div class="document">
                        <div class="document-active">
                            <span class="fa fa-circle"></span>
                            <div>0 DE 1 RAPPORTS TÉLÉCHARGÉS</div>
                        </div>
                        <div>
                            <!--<button >
                                <span class="fa fa-file-pdf-o"></span>
                                Télécharger en PDF
                            </button>-->
                        </div>
                    </div>
                </div>

                <?php
                    if($db_local == 'Globals'){
                        $body_req = $bdd->prepare("SELECT * FROM synthese_mois");
                        $body_req->execute();
                    }else{
                        $body_req = $bdd->prepare("SELECT * FROM localite WHERE localite_name LIKE :locality");
                        $body_req->execute(array(
                            'locality' => $db_local
                        ));
                    }
                    if($body_req->rowCount() > 0){
                        $rows = $body_req->fetchAll(PDO::FETCH_ASSOC);
                        foreach (array_reverse($rows) as $row){
                            ?>
                            <div class="element-save">
                                <div class="dates" style="font-size:18px;">
                                <?php
                                    echo $row['Mois_localite'];
                                ?>
                                </div>
                                <div class="document">
                                    <div class="document-save">
                                        <span class="fa fa-check"></span>
                                        <div>1 DE 1 RAPPORTS TÉLÉCHARGÉS</div>
                                    </div>
                                    <div>
                                        <form action="php/pdf.php" method="post" target="_blank">
                                            <input type="text" name="dates" value="<?php echo htmlspecialchars($row['Mois_localite']); ?>" style="display:none;">
                                            <input type="text" name="localite" value="<?php echo htmlspecialchars($row['localite_name']); ?>" style="display:none;">
                                            <button>
                                                <span class="fa fa-file-pdf-o"></span>
                                                Télécharger en PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
               <?php
                        }
                        
                    }

                ?>
        </div>
    </div>
</div>
<script>
    
</script>