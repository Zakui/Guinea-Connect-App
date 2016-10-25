function loadCommentsFromServer() {
    return $.ajax({
      url: '/api/submitFiles',
      dataType: 'json',
      cache: false,
      error: function(xhr, status, err) {
        console.error("Erreur URL", status, err.toString());
      }.bind(this)
    });
  }


var promise = loadCommentsFromServer();

promise.success(function(data){
    console.log(JSON.stringify(data));
});

