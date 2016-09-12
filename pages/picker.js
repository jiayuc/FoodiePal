var count=0;
var restList;
var indexList = [];
var result = [];

if(localStorage.getItem('initList') == undefined || localStorage.getItem('initList') == null){
		$.ajax({
	            url     : "../backEnd/init_restaurant.php",
	            type    : "GET",
	            data    : "getRestaurant",
	            success : function( data ) {
	            		var temp = $.parseJSON(data);
	                        localStorage.setItem('initList', JSON.stringify(temp));
	                        console.log(temp);
	                        console.log("success");
	                        
	            }
	 	});
}

$(document).ready(function(){
	showRestaurant();
	
    	
    	var user = JSON.parse(localStorage.getItem("user"));
    	console.log("user is: " + user);
    	if(user == null || user['id']== undefined || user['id']== null)
    		window.location = "../index.html"; 
    
    	$(".page").css("display", "none");
    	$(".page1").css("display", "block");
    	pagination();
    	console.log("user: "+ user['id']);
    	categorizeUser();
    	submit(user['id']);
});


var showRestaurant = function(){
	console.log("showRestaurant");
	restList = JSON.parse(localStorage.getItem('initList'));
	console.log(restList);
	for(var i=0; i<30; i++){
		var curr_rest = restList[i];
		var num = i+1;
		var div_id = "#rest" + num;
		var img_id = div_id + " >a img";
		var rest_name = div_id + " h3 a";
		$(img_id).attr('src', curr_rest['imageUrl']);
		$(rest_name).html(curr_rest['name']);
		var review = div_id+ " p";
		$(review).html(curr_rest['snippet_text']);
	}
}

var pagination = function(){
    $(".btn").on('click', function(){
       var num =$(this).attr('num');
        var tempClass = ".page"+num;
        $(".page").css("display", "none");
        $(tempClass).css("display", "block");
    });
}
//asian, casual, unhealthy, healthy, upscale, dietary, cafe, meat, bar, special
var categorizeUser = function(){
    console.log("before count is :"+count);
    $(".restItem").on('click', function(){
    	
        if($(this).css('border') !== '1px solid rgb(255, 0, 0)'){
           if(count==10){
    	        console.log("more than 10 picks");
    		alert("more than 10 picks");
    		return;
    	    }else{
            	$(this).css('background-color', 'rgba(0,0,0,0.2)');
            	count = count +1;
            	var curr_id = $(this).attr("id");
            	console.log(curr_id); 
            	var index = curr_id.substring(4, curr_id.length);
            	console.log("index: " + index);
	    	indexList.push(index);
            	console.log(indexList);
            }
            console.log("after add count is :"+count);
        }else{
            $(this).css('border', 'none');
            count = count-1;
            var curr_cate = $(this).attr("cate");
            console.log($(this).attr("cate"));
            var curr_id = $(this).attr("id");
            var index = curr_id.substring(4, curr_id.length);
            console.log("index: " + index);
	    indexList = jQuery.grep(indexList, function(a){
	    	return a !== index;
	    });
            console.log(indexList);
           console.log("after delete count is :"+count);
        }
    });
}



//asian, casual, unhealthy, healthy, upscale, dietary, cafe, meat, bar, special
var submit = function(id){
    $("#submit").on('click', function(){
    	if(count<10){
    	        console.log("need 10 picks");
    		alert("need 10 picks");
    		window.location = "picker.html";

    		
    	}else{
    	
    		for(var i=0; i<indexList.length; i++){
    			curr_index = parseInt(indexList[i]);
    			var bus_id = restList[curr_index]['id'];
	    		var rating = parseInt(restList[curr_index]['stars'])+0.5;
	    		if(rating == 5)
	    			rating = 5;
	    		//console.log("bus_id: "+bus_id);
	    		//console.log("user_id: "+id);
	    		//console.log("rating: "+ rating);
	    		var curr_obj = {"bus_id": bus_id, "user_id": id, "rating": rating};
	    		result.push(curr_obj);
    		}
    	    	console.log(result);
    	    	var myData = {"result": result};
		$.ajax({
		      	url     : "../backEnd/picker.php",
		        type    : "POST",
		        data    : myData,
		        //contentType: "application/json; charset=utf-8",
		        //dataType: "json",
		        success : function( data ) {
		           	 console.log(data);
		                 //console.log($.parseJSON(data));
		                 localStorage.removeItem('user');
		                 alert("Successively registered!")
		                 window.location = "../index.html";
		                        
		        }
		});
        }
        
    });
}