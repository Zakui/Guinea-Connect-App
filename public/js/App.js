
function loadDataFromServer() {
      var auth = "Basic " + btoa("staging_guineaconnect"+":"+"jjhV6kciZb2pgw");
      var settings = {
        "url": "https://forms.eocng.org/staging_guineaconnect/forms/hospital_form/api",
        "method": "GET",
        headers: {
            "Authorization": auth,
        },
      };
      $.ajax(settings).done(function(data){
        var newdonn = [];
        var dateNew = '2016-10'.split('-');
        data.map(function(key){
            var dateObj = key['end'];
                dateObj = dateObj.split("-");
            if((dateObj[0] == dateNew[0]) && (dateObj[1] == dateNew[1])){
                newdonn.push(key);
            }
        });

        dateNew = new Date();
        dateNew = dateNew.getFullYear()+'-'+(dateNew.getMonth()-1);
        var db_date;

        var nom_des_localites = ['Timbi Tounni Centre','Hôrè Wouri','Bendékouré','Diaga','Saran','Wansan','Djongassi','Péllel_Bantan','Kothyou','total'];
        dateNew = dateNew.split('-');
        var months = [ "Janv.", "Fev.", "Mars", "Avril", "Mai", "Juin",
        "Juil.", "Aout", "Sept.", "Octo.", "Nov.", "Dec." ];

        db_date = months[parseInt(dateNew[1],10)] +' '+dateNew[0];
        nom_des_localites.map(function(localit){
            var newdonne = newdonn;
            var donnee = {};
            if(localit != 'total'){
                newdonne = common.locationFilter(newdonne,localit);
            }
            //Recuperation des donnes globales
            donnee.NB_REG_CONSULT = common.totals(newdonne,'registre_de_consultation')[0];
            donnee.NB_ACC = common.totals(newdonne,'accouchement')[1];
            donnee.MEDICAMENTS = common.totals(newdonne,'registre_de_consultation')[2];
            donnee.moins_de_12_mois = common.totals(newdonne,'registre_de_consultation')[3];
            donnee.moins_de_5_ans = common.totals(newdonne,'registre_de_consultation')[4];
            donnee.moins_de_15_ans = common.totals(newdonne,'registre_de_consultation')[5];
            donnee.moins_de_20_ans = common.totals(newdonne,'registre_de_consultation')[6];
            donnee.moins_de_25_ans = common.totals(newdonne,'registre_de_consultation')[7];
            donnee.moins_de_50_ans = common.totals(newdonne,'registre_de_consultation')[8];
            donnee.moins_de_60_ans = common.totals(newdonne,'registre_de_consultation')[9];
            donnee.plus_de_60_ans = common.totals(newdonne,'registre_de_consultation')[10];
        
            if(newdonne.length > 0){
                $.ajax({
                    type: "POST",
                    url: "./php/process.php",
                    data:{ 
                        //donnees de pour la table localite
                        localite_name: localit || '',
                        Mois_localite: db_date,
                        NB_ACC: donnee.NB_ACC,
                        nb_consultation: donnee.NB_REG_CONSULT || 0,
                        nb_tdr_moins:donnee.moins_de_12_mois.tdr_moins + donnee.moins_de_5_ans.tdr_moins + donnee.moins_de_15_ans.tdr_moins +
                                    donnee.moins_de_20_ans.tdr_moins + donnee.moins_de_25_ans.tdr_moins + donnee.moins_de_50_ans.tdr_moins +
                                    donnee.moins_de_60_ans.tdr_moins + donnee.plus_de_60_ans.tdr_moins || 0,
                        nb_tdr_plus: donnee.moins_de_12_mois.tdr_plus + donnee.moins_de_5_ans.tdr_plus + donnee.moins_de_15_ans.tdr_plus +
                                    donnee.moins_de_20_ans.tdr_plus + donnee.moins_de_25_ans.tdr_plus + donnee.moins_de_50_ans.tdr_plus +
                                    donnee.moins_de_60_ans.tdr_plus + donnee.plus_de_60_ans.tdr_plus || 0,
                        nb_tdr_suspect: donnee.moins_de_12_mois.tdr_suspect + donnee.moins_de_5_ans.tdr_suspect + donnee.moins_de_15_ans.tdr_suspect +
                                    donnee.moins_de_20_ans.tdr_suspect + donnee.moins_de_25_ans.tdr_suspect + donnee.moins_de_50_ans.tdr_suspect +
                                    donnee.moins_de_60_ans.tdr_suspect + donnee.plus_de_60_ans.tdr_suspect || 0,
                        nb_tdr_confirme : donnee.moins_de_12_mois.tdr_confirme + donnee.moins_de_5_ans.tdr_confirme + donnee.moins_de_15_ans.tdr_confirme +
                                    donnee.moins_de_20_ans.tdr_confirme + donnee.moins_de_25_ans.tdr_confirme + donnee.moins_de_50_ans.tdr_confirme +
                                    donnee.moins_de_60_ans.tdr_confirme + donnee.plus_de_60_ans.tdr_confirme || 0,
                        medicaments : JSON.stringify(donnee.MEDICAMENTS),

                        //donnees pour la tables moins_de_11_mois
                        nb_maladies_12_m: common.maladiesList(donnee.moins_de_12_mois.diagnostic),
                        nb_consult_12_m: donnee.moins_de_12_mois.count || 0,
                        
                        //donnees pour la tables moins_de_5_ans
                        nb_maladies_5_a: common.maladiesList(donnee.moins_de_5_ans.diagnostic),
                        nb_consult_5_a: donnee.moins_de_5_ans.count || 0,

                        //donnees pour la tables moins_de_15_ans
                        nb_maladies_15_a: common.maladiesList(donnee.moins_de_15_ans.diagnostic),
                        nb_consult_15_a: donnee.moins_de_15_ans.count || 0,

                        //donnees pour la tables moins_de_20_ans
                        nb_maladies_20_a: common.maladiesList(donnee.moins_de_20_ans.diagnostic),
                        nb_consult_20_a: donnee.moins_de_20_ans.count || 0,

                        //donnees pour la tables moins_de_25_ans
                        nb_maladies_25_a: common.maladiesList(donnee.moins_de_25_ans.diagnostic),
                        nb_consult_25_a: donnee.moins_de_25_ans.count || 0,

                        //donnees pour la tables moins_de_50_ans
                        nb_maladies_50_a: common.maladiesList(donnee.moins_de_50_ans.diagnostic),
                        nb_consult_50_a: donnee.moins_de_50_ans.count || 0,

                        //donnees pour la tables moins_de_60_ans
                        nb_maladies_60_a: common.maladiesList(donnee.moins_de_60_ans.diagnostic),
                        nb_consult_60_a: donnee.moins_de_60_ans.count || 0,

                        //donnees pour la tables plus_de_60_ans
                        nb_maladies_plus_60_a: common.maladiesList(donnee.plus_de_60_ans.diagnostic),
                        nb_consult_plus_60_a: donnee.plus_de_60_ans.count || 0,
                    },
                    success:function(d){
                        //console.log(d);
                    }
                });
            }

       });
        console.log("----------------------------------------");
        console.log('Ajouter dans la base de donne');

      });
  }

  //loadDataFromServer();
