
module.exports.totals = function(data,group,value){
    var count = 0;
    data.map(function(key){
     if(key[group]==value){
       count++;
     }
   });
   return count;
}

var regexes = {
  integer: /^(?:[-+]?(?:0|[1-9]\d*))$/,
  float: /^(?:[-+]?(?:\d+))?(?:\.\d*)?(?:[eE][\+\-]?(?:\d+))?$/
}

var convert = module.exports.convert = function (val) {
  // Try to convert string from FormHub
  // to numbers, so we can add up integrated data
  // later on
  if (regexes.integer.test(val)) {
    return parseInt(val, 10)
  } else if (regexes.float.test(val)) {
    return parseFloat(val, 10)
  }

  return val
}