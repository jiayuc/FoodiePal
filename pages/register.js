$(document).ready(function(){
	console.log("in js right now");
	register();
});

var register = function(){

	$('form').submit( function() {
		console.log("form submit");
	        $.ajax({
	            url     : $(this).attr('action'),
	            type    : $(this).attr('method'),
	            data    : $(this).serialize(),
		    //dataType: "json",
	            success : function( data ) {
	            		if(data == "used"){
	            			alert("sorry, the email is used already... Please give another email")
	            		}else if(data == "Oops... Something goes wrong..."){
	            			alert(data);
	            		}else{
	            			console.log("get here");
		                        console.log(data);
		                        data1 = $.parseJSON(data);
		                        console.log(data1['id']);
		                        redirect_func(data1, function(){
		                        	window.location = "picker.html";
		                        });
	            		}
	                        
	                        
                        	  
	                      }
        });

        return false;
    });

}

var redirect_func= function(data, callback){
	localStorage.setItem('user', JSON.stringify(data));
	callback();
};