 "use strict";
//common functions
var common = {
    maladiesList : function(tranche){
        var dia = {};
        tranche.forEach(function(x) { dia[x] = dia[x] + 1 || 1; });
        
         var maladies = ['Tétanos_1','Coquéluche_2','Diphtérie_3','La_Diarrhée_non_sanglante_4','Helminthiase_5','I.R.A._3_semaines_6',
                         'I.R._3_semaines_7','asthme_8','Autres_maladies_respiratoires_chronique_9','La_malnutrition_10','Anémies_femme_en_grossesse_11',
                         'Anémies_autres_11','Drépanocytose_12','Goitre_13','Diabéte_Sucré_14','Paludisme_simple_15','Paludisme_grave_16','Ictères_17',
                         'Ophtalmie_du_nouveau_née_18','Conjonctivite_19','Plaie_traumatiques_de_l_oeil_20','Trâchome_trichiasis_21','Cataracte_22',
                         'Autres_maladies_des_yeux_23','Ecoulement_vaginale_24','Ecoulement_Urétral_25','Douleur_abdominale_26','Ulcération_Genitale_Femmes_27',
                         'Ulcération_Genitale_Hommes_27','Infection_Sexuallement_transmissible_28','Maladie_Urinaire_non_IST_29','Maladie_Gyneco_Non_IST_30',
                         'Gale_31','Autre_Mal_Dermatologiques_32','Fracture_33','Traumatisme_Cranien_34','Brulure_35','Autre_traumatisme_36','La_gastrite_37',
                         'Appendicites_38','Abdomen_Aigu_39','Hernies_40','Occlusions_41','Autre_pathologies_digestives_42','L’hypertension_Artérielle_43',
                         'Autres_mal_Cardio_vasculaires_44','RAA_45','Maladies_ORL_46','Autres_mal_articulaire_47','Carie_Dentaire_48','Autre_mal_Bouche_dents_49',
                         'Maladies_mentales_50','Mal_Neurologiques_51','Morsure_de_serpent_52','Autre_53','Tetanos_neo_natal_54','La_paralysie_Flasque_Aigue_55',
                         'Poliomyélite_56','Rougeole_57','La_diarrhée_sanglante_58','La_Méningite_59','Cholera_60','Fièvre_Jaune_61','Dracunculose_62',
                         'Schistosomiase_urinaire_63','Schistosomiase_intestinale_64','Onchocercose_65','Tuberculose_66','Lepre_67','Trypanosomiase_68',
                         'Fièvre_Typhoide_69','Hepatite_virale_70','VIH_SIDA_71','Abcés','Accident_Vasculaire_Cérébral','Blessure','Candidose_vaginale',
                         'Chancre','Décharge_du_pénis','Dermatite','Dermatite_de_la_tete','Douleur_corporelle','Douleur_destomac','Douleur_musculaire',
                         'Fiévre','Infection_respiratoire_aigue_','Mal_au_dos','Mal_de_Tete','Oreillons','Pharyngite','La_pneumonie','Le_rhume','Rubéole',
                         'Saignements_Vaginaux','Syphilis','Varicelle','Vomissement'];
       
         var nb_maladies = {};
        for (var element in dia) {
            maladies.map(function(v){
                if(v == element){                    
                    nb_maladies[v] = dia[element];
                }else{
                    if(!(nb_maladies[v])){
                        nb_maladies[v] = 0;
                    }
                }
            });
        }
        nb_maladies = JSON.stringify(nb_maladies);

        return nb_maladies;
    },
    checkMedicament : function(data,name,qt){
        if(name){
            var found;
            data.map(function(val){
                    if(val['nom'] == name){
                        val['quantite'] += parseInt(qt);
                        found = true;
                    }
            });
            if(found){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    },
    diagnostic : function(key,value){
        if(key['group_cj5tm91/Diagnostic']){
              var valeurs = key['group_cj5tm91/Diagnostic'].split(' ');
              var palus_count = 0;
              valeurs.map(function(val){
                  value.push(val);
                  if(val.indexOf('Paludisme') !== -1){
                      palus_count++;
                  }
              });
          }
          return palus_count;
    },
    totals : function(data,value){
        var inf_5_a = {},
            inf_12_m = {},
            inf_15_a = {},
            inf_20_a = {},
            inf_25_a = {},
            inf_50_a = {},
            inf_60_a = {},
            sup_60_a = {}, 
            sumTotal = 0, 
            acc = 0,
            medicaments = [],
            p;
        inf_12_m.diagnostic = [];
        inf_5_a.diagnostic = [];
        inf_15_a.diagnostic = [];
        inf_20_a.diagnostic = [];
        inf_25_a.diagnostic = [];
        inf_50_a.diagnostic = [];
        inf_60_a.diagnostic = [];
        sup_60_a.diagnostic = [];

        // -------------------------------------------------
        inf_12_m.tdr_suspect = 0;
        inf_12_m.tdr_confirme = 0;
        inf_5_a.tdr_suspect = 0;
        inf_5_a.tdr_confirme = 0;
        inf_15_a.tdr_suspect = 0;
        inf_15_a.tdr_confirme = 0;
        inf_25_a.tdr_suspect = 0;
        inf_25_a.tdr_confirme = 0;
        inf_50_a.tdr_suspect = 0;
        inf_50_a.tdr_confirme = 0;
        inf_60_a.tdr_suspect = 0;
        inf_60_a.tdr_confirme = 0;
        sup_60_a.tdr_suspect = 0;
        sup_60_a.tdr_confirme = 0;

        data.map(function(key){
        if(key['group_main/Type_de_Fiche']==value){
            acc++;
            //console.log(medicaments.length);
           if(medicaments.length >= 0){
               if(common.checkMedicament(medicaments,key['group_cj5tm91/group_nk9tv48/Medicaments_1'],key['group_cj5tm91/group_nk9tv48/Quantite_1'])){
                   medicaments.push({
                                 'nom' : key['group_cj5tm91/group_nk9tv48/Medicaments_1'],
                                 'quantite' : parseInt(key['group_cj5tm91/group_nk9tv48/Quantite_1']),
                                 'types' : key['group_cj5tm91/group_nk9tv48/Type_medicament_1']
                              });
               }
               if(common.checkMedicament(medicaments,key['group_cj5tm91/group_nk9tv48/group_xu33g78/Medicaments_2'],key['group_cj5tm91/group_nk9tv48/group_xu33g78/Quantite_2'])){
                   medicaments.push({
                                 'nom' : key['group_cj5tm91/group_nk9tv48/group_xu33g78/Medicaments_2'],
                                 'quantite' : parseInt(key['group_cj5tm91/group_nk9tv48/group_xu33g78/Quantite_2']),
                                 'types' : key['group_cj5tm91/group_nk9tv48/group_xu33g78/Type_medicament_2']
                              });
               }
               if(common.checkMedicament(medicaments,key['group_cj5tm91/group_nk9tv48/group_fp0fa49/Medicaments_3'],key['group_cj5tm91/group_nk9tv48/group_fp0fa49/Quantite_3'])){
                   medicaments.push({
                                 'nom' : key['group_cj5tm91/group_nk9tv48/group_fp0fa49/Medicaments_3'],
                                 'quantite' : parseInt(key['group_cj5tm91/group_nk9tv48/group_fp0fa49/Quantite_3']),
                                 'types' : key['group_cj5tm91/group_nk9tv48/group_fp0fa49/Type_medicament_3']
                              });
               }
               if(common.checkMedicament(medicaments,key['group_cj5tm91/group_nk9tv48/group_lb3mc19/Medicaments_4'],key['group_cj5tm91/group_nk9tv48/group_lb3mc19/Quantite_4'])){
                   medicaments.push({
                                 'nom' : key['group_cj5tm91/group_nk9tv48/group_lb3mc19/Medicaments_4'],
                                 'quantite' : parseInt(key['group_cj5tm91/group_nk9tv48/group_lb3mc19/Quantite_4']),
                                 'types' : key['group_cj5tm91/group_nk9tv48/group_lb3mc19/Type_medicament_4']
                              });
               }
               if(common.checkMedicament(medicaments,key['group_cj5tm91/group_nk9tv48/group_kt09j36/Medicaments_5'],key['group_cj5tm91/group_nk9tv48/group_kt09j36/Quantite_5'])){
                   medicaments.push({
                                 'nom' : key['group_cj5tm91/group_nk9tv48/group_kt09j36/Medicaments_5'],
                                 'quantite' : parseInt(key['group_cj5tm91/group_nk9tv48/group_kt09j36/Quantite_5']),
                                 'types' : key['group_cj5tm91/group_nk9tv48/group_kt09j36/Type_medicament_5']
                              });
               }
           }else{
               if(key['group_cj5tm91/group_nk9tv48/Medicaments_1']){
                   medicaments.push({
                                 'nom' : key['group_cj5tm91/group_nk9tv48/Medicaments_1'],
                                 'quantite' : parseInt(key['group_cj5tm91/group_nk9tv48/Quantite_1']),
                                 'types' : key['group_cj5tm91/group_nk9tv48/Type_medicament_1']
                              });

               }
           }

          if((key['group_cj5tm91/en'] == 'mois') && (key['group_cj5tm91/Age'] < 12)){

              inf_12_m.count = inf_12_m.count+1 || 1;
              if(key['group_cj5tm91/type_contact'] == 'premier'){
                inf_12_m.premier_contact = inf_12_m.premier_contact+1 || 1;
              }
                            
              p = common.diagnostic(key,inf_12_m.diagnostic);

              inf_12_m.palus_count = inf_12_m.palus_count + p | 0;

              if(key['group_cj5tm91/labo'] == 'TDR_+'){
                 inf_12_m.tdr_plus = inf_12_m.tdr_plus+1 || 1;
                 if((p != 0)){
                    inf_12_m.tdr_confirme = inf_12_m.tdr_confirme+1 || 1;
                 }
              }
              if(key['group_cj5tm91/labo'] == 'TDR_-'){
                 inf_12_m.tdr_moins = inf_12_m.tdr_moins+1 || 1;
                 if((p != 0)){
                    inf_12_m.tdr_suspect = inf_12_m.tdr_suspect+1 || 1;
                }
              }
              
              
          }
          if(key['group_cj5tm91/en'] == 'ans'){
              if(key['group_cj5tm91/Age'] < 5){  

                  inf_5_a.count = inf_5_a.count+1 || 1;
                  if(key['group_cj5tm91/type_contact'] == 'premier'){
                    inf_5_a.premier_contact = inf_5_a.premier_contact+1 || 1;
                  }
                    
                    p = common.diagnostic(key,inf_5_a.diagnostic);

                    inf_5_a.palus_count = inf_5_a.palus_count + p | 0;

                  if(key['group_cj5tm91/labo'] == 'TDR_+'){
                    inf_5_a.tdr_plus = inf_5_a.tdr_plus+1 || 1;
                    if((p != 0)){
                        inf_5_a.tdr_confirme = inf_5_a.tdr_confirme+1 || 1;
                    }
                  }
                  if(key['group_cj5tm91/labo'] == 'TDR_-'){
                        inf_5_a.tdr_moins = inf_5_a.tdr_moins+1 || 1;
                        if((p != 0)){
                            inf_5_a.tdr_suspect = inf_5_a.tdr_suspect+1 || 1;
                        }
                    }


               }
               else if(key['group_cj5tm91/Age'] < 15){

                   inf_15_a.count = inf_15_a.count+1 || 1;
                   if(key['group_cj5tm91/type_contact'] == 'premier'){
                     inf_15_a.premier_contact = inf_15_a.premier_contact+1 || 1;
                   }
                    
                    p = common.diagnostic(key,inf_15_a.diagnostic);

                    inf_15_a.palus_count = inf_15_a.palus_count + p | 0;

                  if(key['group_cj5tm91/labo'] == 'TDR_+'){
                    inf_15_a.tdr_plus = inf_15_a.tdr_plus+1 || 1;
                    if((p != 0)){
                        inf_15_a.tdr_confirme = inf_15_a.tdr_confirme+1 || 1;
                    }
                  }
                  if(key['group_cj5tm91/labo'] == 'TDR_-'){
                        inf_15_a.tdr_moins = inf_15_a.tdr_moins+1 || 1;
                        if((p != 0)){
                            inf_15_a.tdr_suspect = inf_15_a.tdr_suspect+1 || 1;
                        }
                    }


               }else if(key['group_cj5tm91/Age'] < 20){

                   inf_20_a.count = inf_20_a.count+1 || 1;
                   if(key['group_cj5tm91/type_contact'] == 'premier'){
                        inf_20_a.premier_contact = inf_20_a.premier_contact+1 || 1;
                    }
                    
                    p = common.diagnostic(key,inf_20_a.diagnostic);

                    inf_20_a.palus_count = inf_20_a.palus_count + p | 0;

                    inf_20_a.tdr_suspect = 0;
                    inf_20_a.tdr_confirme = 0;

                  if(key['group_cj5tm91/labo'] == 'TDR_+'){
                    inf_20_a.tdr_plus = inf_20_a.tdr_plus+1 || 1;
                    if((p != 0)){
                        inf_20_a.tdr_confirme = inf_20_a.tdr_confirme+1 || 1;
                    }
                  }
                  if(key['group_cj5tm91/labo'] == 'TDR_-'){
                        inf_20_a.tdr_moins = inf_20_a.tdr_moins+1 || 1;
                        if((p != 0)){
                            inf_20_a.tdr_suspect = inf_20_a.tdr_suspect+1 || 1;
                        }
                    }
                    

               }else if(key['group_cj5tm91/Age'] < 25){

                   inf_25_a.count = inf_25_a.count+1 || 1;
                   if(key['group_cj5tm91/type_contact'] == 'premier'){
                        inf_25_a.premier_contact = inf_25_a.premier_contact+1 || 1;
                    }
                    
                    p = common.diagnostic(key,inf_25_a.diagnostic);

                    inf_25_a.palus_count = inf_25_a.palus_count + p | 0;

                  if(key['group_cj5tm91/labo'] == 'TDR_+'){
                    inf_25_a.tdr_plus = inf_25_a.tdr_plus+1 || 1;
                    if((p != 0)){
                        inf_25_a.tdr_confirme = inf_25_a.tdr_confirme+1 || 1;
                    }
                  }
                  if(key['group_cj5tm91/labo'] == 'TDR_-'){
                        inf_25_a.tdr_moins = inf_25_a.tdr_moins+1 || 1;
                        if((p != 0)){
                            inf_25_a.tdr_suspect = inf_25_a.tdr_suspect+1 || 1;
                        }
                    }


               }else if(key['group_cj5tm91/Age'] < 50){

                   inf_50_a.count = inf_50_a.count+1 || 1;
                   if(key['group_cj5tm91/type_contact'] == 'premier'){
                        inf_50_a.premier_contact = inf_50_a.premier_contact+1 || 1;
                    }
                    
                    p = common.diagnostic(key,inf_50_a.diagnostic);

                    inf_50_a.palus_count = inf_50_a.palus_count + p | 0;

                  if(key['group_cj5tm91/labo'] == 'TDR_+'){
                    inf_50_a.tdr_plus = inf_50_a.tdr_plus+1 || 1;
                    if((p != 0)){
                        inf_50_a.tdr_confirme = inf_50_a.tdr_confirme+1 || 1;
                    }
                  }
                  if(key['group_cj5tm91/labo'] == 'TDR_-'){
                        inf_50_a.tdr_moins = inf_50_a.tdr_moins+1 || 1;
                        if((p != 0)){
                            inf_50_a.tdr_suspect = inf_50_a.tdr_suspect+1 || 1;
                        }
                    }


               }else if(key['group_cj5tm91/Age'] < 60){

                   inf_60_a.count = inf_60_a.count+1 || 1;
                   if(key['group_cj5tm91/type_contact'] == 'premier'){
                        inf_60_a.premier_contact = inf_60_a.premier_contact+1 || 1;
                    }
                    
                    p = common.diagnostic(key,inf_60_a.diagnostic);

                    inf_60_a.palus_count = inf_60_a.palus_count + p | 0;

                  if(key['group_cj5tm91/labo'] == 'TDR_+'){
                    inf_60_a.tdr_plus = inf_60_a.tdr_plus+1 || 1;
                    if((p != 0)){
                        inf_60_a.tdr_confirme = inf_60_a.tdr_confirme+1 || 1;
                    }
                  }
                  if(key['group_cj5tm91/labo'] == 'TDR_-'){
                        inf_60_a.tdr_moins = inf_60_a.tdr_moins+1 || 1;
                        if((p != 0)){
                            inf_60_a.tdr_suspect = inf_60_a.tdr_suspect+1 || 1;
                        }
                    }


               }else{

                   sup_60_a.count = sup_60_a.count+1 || 1;
                   if(key['group_cj5tm91/type_contact'] == 'premier'){
                        sup_60_a.premier_contact = sup_60_a.premier_contact+1 || 1;
                    }
                    
                    p = common.diagnostic(key,sup_60_a.diagnostic);

                    sup_60_a.palus_count = sup_60_a.palus_count + p | 0;

                  if(key['group_cj5tm91/labo'] == 'TDR_+'){
                    sup_60_a.tdr_plus = sup_60_a.tdr_plus+1 || 1;
                    if((p != 0)){
                        sup_60_a.tdr_confirme = sup_60_a.tdr_confirme+1 || 1;
                    }
                  }
                  if(key['group_cj5tm91/labo'] == 'TDR_-'){
                        sup_60_a.tdr_moins = sup_60_a.tdr_moins+1 || 1;
                        if((p != 0)){
                            sup_60_a.tdr_suspect = sup_60_a.tdr_suspect+1 || 1;
                        }
                    }

               }
          }
          
        }
      });

      sumTotal = inf_12_m.count + 
                 inf_5_a.count + 
                 inf_15_a.count + 
                 inf_20_a.count + 
                 inf_25_a.count + 
                 inf_50_a.count + 
                 inf_60_a.count + 
                 sup_60_a.count || 0;
    if(sumTotal == null){
        sumTotal = 0;
    }
      return [ sumTotal,
               acc,
               medicaments,
               inf_12_m,
               inf_5_a,
               inf_15_a,
               inf_20_a,
               inf_25_a,
               inf_50_a,
               inf_60_a,
               sup_60_a
            ];
    },
    locationFilter : function(data,value){
        var newData = [];
        value = value.toString();
        data.map(function(key){
          if(key['group_main/Poste'] == value){
              newData.push(key);
          }
        });
        return newData;
    },

}