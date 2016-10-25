
var fs = require('fs');
var path = require('path');
var express = require('express');
var bodyParser = require('body-parser');

function csvJSON(csv){

  var lines=csv.split("\n");

  var result = [];

  var headers=lines[0].split(",");

  for(var i=1;i<lines.length;i++){

	  var obj = {};
	  var currentline=lines[i].split(",");

	  for(var j=0;j<headers.length;j++){
		  obj[headers[j]] = currentline[j];
	  }

	  result.push(obj);

  }
  
  //return result; //JavaScript object
  return JSON.stringify(result); //JSON
}

fs.readFile("./form_csv.csv",function(err,data){
        if(err){
            console.log(err);
            process.exit(1);
        }
        
   donnee = csvJSON(data);
   console.log(donnee);

 });


