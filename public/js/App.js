 "use strict";
//common functions
var common = {
    totals : function(data,value){
        var inf_5_a = 0,
            inf_12_m = 0, 
            inf_15_a = 0,
            inf_20_a = 0,
            inf_25_a = 0,
            inf_50_a = 0,
            inf_60_a = 0,
            sup_60_a = 0,
            premier_contact = 0, 
            tdr_plus = 0, 
            sumTotal = 0, 
            acc = 0;

        data.map(function(key){
        if(key['group_main/Type_de_Fiche']==value){
            acc++;
          if((key['group_cj5tm91/en'] == 'mois') && (key['group_cj5tm91/Age'] < 12)){
              inf_12_m ++;
          }
          if(key['group_cj5tm91/en'] == 'ans'){
              if(key['group_cj5tm91/Age'] < 5)
               {  inf_5_a++;}
               else if(key['group_cj5tm91/Age'] < 15){
                   inf_15_a++;
               }else if(key['group_cj5tm91/Age'] < 20){
                   inf_20_a++;
               }else if(key['group_cj5tm91/Age'] < 25){
                   inf_25_a++;
               }else if(key['group_cj5tm91/Age'] < 50){
                   inf_50_a++;
               }else if(key['group_cj5tm91/Age'] < 60){
                   inf_60_a++;
               }else{
                   sup_60_a++;
               }
          }
          if(key['group_cj5tm91/type_contact'] == 'premier'){
              premier_contact++;
          }
          if(key['group_cj5tm91/labo'] == 'TDR_+'){
              tdr_plus++;
          }
        }
      });
      sumTotal = inf_12_m + inf_5_a + inf_15_a + inf_20_a + inf_25_a + inf_50_a + inf_60_a + sup_60_a;
      return [ sumTotal,
               acc,
               premier_contact,
               tdr_plus,
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
    dateFilter : function(data){
        var newData =[];
        var dateNew = new Date();
        dateNew = (dateNew.getFullYear()+'-'+(dateNew.getMonth()-1)).split("-");
        
        data.map(function(key){
        
        var dateObj = key['end'];
        dateObj = dateObj.split("-");
        var months = [ "Janv.", "Fev.", "Mars", "Avril", "Mai", "Juin",
        "Juil.", "Aout", "Sept.", "Octo.", "Nov.", "Dec." ];
        
        if((dateObj[0] == dateNew[0]) && (months[parseInt(dateObj[1],10)] == months[parseInt(dateNew[1],10)])){
          newData.push(key);
        }
        });

        return newData;
    },
    locationFilter : function(data,group,value){
        var newData = [];
        data.map(function(key){
          if(key[group] == value){
              newData.push(key);
          }
        });
        return newData;
    },

}

// Acouchement functions
var acouchement = {
    calculSomme : function (data,group){
        var total = 0; 
        data.map(function(key){
          if(key['group_main/Type_de_Fiche'] == 'accouchement')
              if(key[group] != 'n/a')
                  total+=parseInt(key[group]);
        });

        return total;
    }
}

//Registre de Consultation

var regist_consultation = {

}



function loadDataFromServer(date) {
      var auth = "Basic " + btoa("staging_guineaconnect"+":"+"jjhV6kciZb2pgw");
      var settings = {
        "url": "https://forms.eocng.org/staging_guineaconnect/forms/hospital_form/api",
        "method": "GET",
        headers: {
            "Authorization": auth,
        },
      };
      $.ajax(settings).done(function(data){
        var donne = [];
        var dateNew = '2016-09'.split('-');
        data.map(function(key){
            var dateObj = key['end'];
                dateObj = dateObj.split("-");
            if((dateObj[0] == dateNew[0]) && (dateObj[1] == dateNew[1])){
                donne.push(key);
            }
        });
        //var newdonne = common.dateFilter(donne);
        var newdonne = common.locationFilter(donne,'group_main/Poste','Péllel_Bantan');
        

        var donnee = {};
        donnee.LOCALITE = 'Péllel_Bantan'
        donnee.NB_ACC = common.totals(newdonne,'accouchement')[1];
        donnee.NB_REG_CONSULT = common.totals(newdonne,'registre_de_consultation')[0];




        // donnee.NB_NAISS_V = acouchement.calculSomme(newdonne,'group_ar3bw24/N_Vivant');
        // donnee.NB_NAISS_MORT_N = acouchement.calculSomme(newdonne,'group_ar3bw24/Mort_n');      
        // donnee.PREMIER_CONTACT = common.totals(newdonne,'registre_de_consultation')[2];
        // donnee.TDR_PLUS = common.totals(newdonne,'registre_de_consultation')[3];



        console.log("nombre d'accouchement "+donnee.NB_ACC);
        console.log("nombre de consultation "+donnee.NB_REG_CONSULT);




        // console.log("premier contact "+donnee.PREMIER_CONTACT);
        // console.log("nombre de TDR plus "+donnee.TDR_PLUS);
        // console.log("nombre de naissance vivante "+donnee.NB_NAISS_V);
        // console.log("nombre de naissance mort ne "+donnee.NB_NAISS_MORT_N);
      });
  }

  loadDataFromServer('2016-09');
