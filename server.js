var fs = require('fs');
var path = require('path');
var express = require('express');
var bodyParser = require('body-parser');
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


app.get('/api/submitFiles',function(req,res){
    fs.readFile(COMMENTS_FILE,function(err,data){
        if(err){
            console.log(err);
            process.exit(1);
        }
        console.log(res.json(JSON.parse(data)));
        res.json(JSON.parse(data));
    });
});

app.listen(app.get('port'),function(){
    console.log('server started : http://localhost:'+app.get('port')+'/');
});
