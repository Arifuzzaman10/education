function showResult(str) {
    alert(str);
    var url = $('#url').val();    
    if (str.length == 0) {
        document.getElementById("livesearch").innerHTML="";
    return;
    }
   // console.log(str);
    
    $.ajax({
            method:'POST',
            url: url + '/' + 'search',
            data:{search:str},
            success:function(data){
                console.log(data);
                if (data.length != 0) {
                 document.getElementById("livesearch").innerHTML="";
                 data.forEach(value => {
                    $("#livesearch").append("<a href='"+value.route+"'>"+value.name+"</a>");
                 }); 
                }
                else{
                    document.getElementById("livesearch").innerHTML="";
                    $("#livesearch").append("<a id='lol'> Not Found </a>");
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }

        });
    
}