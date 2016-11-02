var fs = require('fs');
var path = require('path');
var express = require('express');
var bodyParser = require('body-parser');
var request = require('request');
var app = express();

var COMMENTS_FILE = path.join(__dirname,'data.json');

app.set('port',(process.env.PORT || 4000));

app.use('/',express.static(path.join(__dirname,'public')));
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended:true}));

app.use(function(req,res,next){
    res.setHeader('Access-Control-Allow-Origin','*');
    res.setHeader('Cache-Control','no-cache');
    next();
});


app.get('/api/submitFiles/:date',function(req,resultat){
    var username = "staging_guineaconnect";
    var password = "jjhV6kciZb2pgw";
    var auth = "Basic " + new Buffer(username + ":" + password).toString("base64");
    request({
            url: 'https://forms.eocng.org/staging_guineaconnect/forms/hospital_form/api',
            method: 'GET',
            qs: {
                q: req.params.date,
            },
            headers: {
                "Authorization": auth,
            }
            }, function(err, res, body) {
            var donnee = [];
            dateNew = req.params.date.split('-');
            JSON.parse(body).map(function(key){
                var dateObj = key['end'];
                 dateObj = dateObj.split("-");
                if((dateObj[0] == dateNew[0]) && (dateObj[1] == dateNew[1])){
                    donnee.push(key);
                }
            });
            
            resultat.json(donnee);
            
        });
});

app.listen(app.get('port'),function(){
    console.log('server started : http://localhost:'+app.get('port')+'/');
});
