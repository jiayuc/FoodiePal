var myName;
$(document).ready(function(){
	
	var restaurantList = JSON.parse(localStorage.getItem('restaurantList'));
	console.log("ready-----")
	console.log(restaurantList);
	console.log(restaurantList.length);
	localStorage.removeItem('clicked');
	$("#text").html("");
	$(".result-number").append("<h5>"+"Found "+restaurantList.length+" restaurants:"+"</h5>");
	for(var i =0;i < restaurantList.length;i++)
	{
  		var item = restaurantList[i];
  	
  		setPanel(item, i+1);
	}
	if(localStorage.getItem('myName') != undefined){
		console.log("got here");
		changeButton();
	}else{
		$("#oldUser").css("display", "block");
		$("#logout").css("display", "none");
	}
	signIn();
	
	
	logOut();
	
	
	
    	getCategory();
    
    	getName();
	
	search();
	
	
	
	toRestaurantDetails();
	getRecommandation();
});

var getName = function(){
    	console.log("start2");
    	var mydata = "getName";
    	$.ajax({
            url     : "../backEnd/names.php",
            type    : "GET",
            data    : mydata,
            dataType: "json",
            success : function( data ) {
                        localStorage.setItem('nameList', JSON.stringify(data));
                        console.log(data);  
                      }
        });
 }

var getCategory = function(){
	    	var mydata = "getList";
	    	$.ajax({
	            url     : $('body').attr('action'),
	            type    : $('body').attr('method'),
	            data    : mydata,
	            dataType: "json",
	            success : function( data ) {
	                        //console.log("get list");
	                        //console.log(data[0]);
	                        
	                        localStorage.setItem('categoryList', JSON.stringify(data));
	                        //window.location = "pages/SearchResult.html";   
	                      }
	        });
        
}

var getRecommandation = function(){
	$("#recommendation").on("click", function(){
		console.log("recom clicked");
		var user_info = JSON.parse(localStorage.getItem('userInfo'));
		console.log(user_info);
		if(user_info == undefined || user_info == null){
			alert("please log in first to get your personalized recommandation:)");
		}else{
			user_id = {"id": user_info['email']};
			console.log(user_id);
			 $.ajax({
		            url     : "../backEnd/recommand.php",
		            type    : "GET",
		            data    : user_id,
		            success : function(data){
		            		console.log("success");
		            		console.log(data);
             				var temp = $.parseJSON(data);
             				console.log(temp);
		                       localStorage.setItem('recommandList', JSON.stringify(temp));
		                        window.location = "recommand.html";
		                         
		          	}
	        	});
		}
	});
}

var changeButton = function(){
	console.log("here here");
	myName = localStorage.getItem('myName');
	console.log(myName);
	$("#oldUser").css("display", "none");
	$("#newUser li a").text("Hello There! " + myName);
	$("#logout").css("display", "block");
}
var logOut = function(){
	$("#logout").on('click', function(){
		localStorage.removeItem('myName');
		localStorage.removeItem('userInfo');
		
	        console.log('myName: '+ localStorage.getItem('myName'));
	        $("#newUser li a").text("Hello There!");
	        $("#oldUser").css("display", "block");
		$("#logout").css("display", "none");
		
	});
}
var signIn = function(){
	console.log("before signIn");
	$('#signIn').submit( function() {
	
		//console.log("form submit");
		//console.log($(this).attr('method'));
		//console.log($(this).serialize());
	        $.ajax({
	            url     : $(this).attr('action'),
	            type    : $(this).attr('method'),
	            data    : $(this).serialize(),
	            dataType : "json",
	            success : function(data){
	                        	//console.log("get here1");
	                        	//console.log(data['loggedIn'] === 2);
	                        	//console.log(JSON.stringify(data));
	                       	 	if(data['loggedIn'] === 0){
	                        		//console.log("0");
	                        		$("#text").html("User doesn't exist");
	                      		}
	                      		else if(data['loggedIn'] === 2){
	                      			//console.log("1");
	                      			$("#text").html("Username and password doesn't match");
	                      		}else{
	                      			$("#text").html("Succeed!");
	                      			localStorage.setItem('myName', data['firstName']);
	                      			localStorage.setItem('userInfo', JSON.stringify(data));
	                      			//console.log(localStorage.getItem('userInfo'));
	                         		changeButton();
	                         		//window.location = "SearchResult.html";
	                      		}
	                         
	          	}
        	});

        	return false;
    });

}
var search = function(){

	
   
    $('#search').submit( function() {
	console.log("after click");
	var category = JSON.parse(localStorage.getItem("categoryList"));
	//console.log("category is "+category);
	//for(var i=0; i<category.length; i++){
	//	var temp_obj = category[i];
	//	console.log("temp "+"i:",temp_obj.subcategory);
	//}
    	var names = JSON.parse(localStorage.getItem("nameList"));
    	console.log(names);
    	
	var keyword = $("#searchTerm").val();
	console.log("keyword: "+ keyword);
	//var keyword = "veg";
	
	fuzzy_search(category, names, keyword, function(category_value,name_value){

		console.log("in callback");
		var data = {"category_name": category_value, "rest_name":name_value };
		 //console.log("category_name", category_value);
		 //console.log("rest_name",name_value);
		 //console.log($('form').serialize());
		$.ajax({
			url: "../backEnd/processSearch.php",
			type: "GET",
			data: data,
			success: function(data){
				console.log("success------------------------------");
				console.log($.parseJSON(data));
				var temp = $.parseJSON(data);
				localStorage.setItem("restaurantList", JSON.stringify(temp));
				
				window.location = "SearchResult.html"; 
			}
		});
		
	});
	return false;
		
    });

}



var fuzzy_search = function(category, names, key, callback){
	var keyword=key.toLowerCase();
	var list_length=category.length;
	var names_length = names.length;
	console.log(category);
	console.log(keyword);
	console.log("category list length: "+ list_length);
	console.log("key_word length: "+ keyword.length);
	var ret;
	var ret1;
	var min=Number.MAX_VALUE;
	var min1=Number.MAX_VALUE;
	var cur =0;
	var cur1 =0;
	for(var q=0; q<list_length; q++){
		//console.log("category "+q +" "+category[q].subcategory);
		var temp_word = category[q].subcategory.toLowerCase();
		//console.log("tempword: "+temp_word);
		var word_length =temp_word.length;
		
		//console.log("temp_word length: "+temp_word.length);
		//console.log(temp_word);
		var key_length = keyword.length;
		
		if(key_length<=word_length){
			var substring=temp_word.substring(0,key_length);
			if(substring==keyword){
				console.log("here");
				min=0;
				ret=category[q].subcategory;
				break;
			}
		}
		
		
		
		var opt = new Array(word_length);
		for(var i=0; i<word_length; i++){
			opt[i]=new Array(key_length);
		}
		for(var j=0;j<key_length;j++){
			opt[0][j]=j;
		}
		for(var n=1;n<word_length;n++){
			opt[n][0]=n;
			for(var m=1;m<key_length;m++){
				var penalty = 1.0;
				if(keyword[m] == temp_word[n]){
					penalty = 0;
				}
				opt[n][m]=Math.min(penalty+opt[n-1][m-1],
					1+opt[n-1][m],
					1+opt[n][m-1]
				);
			}	
		}
		cur=opt[word_length-1][key_length-1];
		//console.log(cur);
		if(temp_word == "mexican"){
			console.log("mexican: "+ cur);
		}
		if(min>cur){
			console.log("-------");
			console.log("curr: "+cur);
			console.log("temp_word:" +temp_word);
			min=cur;
			ret=category[q].subcategory;
			opt = null;
		}
	}
	for(var q=0; q<names_length; q++){
		
		var temp_word = names[q].name.toLowerCase();
		var word_length =temp_word.length;
		//console.log("temp_name length: "+temp_word.length);
		//console.log(temp_word);
		var key_length = keyword.length;
		
		if(key_length<=word_length){
			var substring=temp_word.substring(0,key_length);
			if(substring==keyword){
				console.log("here");
				min1=0;
				ret1=names[q].name;
				break;
			}
		}
		
		
		
		
		
		
		var opt1 = new Array(word_length);
		for(var i=0; i<word_length; i++){
			opt1[i]=new Array(key_length);
		}
		for(var j=0;j<key_length;j++){
			opt1[0][j]=j;
		}
		for(var n=1;n<word_length;n++){
			opt1[n][0]=n;
			for(var m=1;m<key_length;m++){
				var penalty = 1.0;
				if(keyword[m] == temp_word[n]){
					penalty = 0;
				}
				opt1[n][m]=Math.min(penalty+opt1[n-1][m-1],
					1+opt1[n-1][m],
					1+opt1[n][m-1]
				);
			}	
		}
		cur1=opt1[word_length-1][key_length-1];
		console.log(cur1);
		if(min1>cur1){
			min1=cur1;
			ret1=names[q].name;
			console.log("-------");
			console.log("curr1: "+cur);
			console.log("temp_word1:" +temp_word);
			opt1 = null;
		}
	}
	console.log(min);
	console.log(ret);
	console.log(min1);
	console.log(ret1);
	var result = null;
	//if(min > min1)
	//	result = ret1;
	//else if(min < min1)
	//	result = ret;
	//else
	//	result = ret;
	if(Math.abs(min-min1)<2){
		callback(ret,ret1);
	}else{
		if(min<min1){
			callback(ret,null);
		}else{
			callback(null,ret1);
		}
	}
			
}
































//go to restaurantDetails page when click
var toRestaurantDetails = function(){
	$(".panel-heading").on("click", function(){
		console.log("clicked title");
		var index = $(this).attr("index");
		console.log(index);
		var restaurantList = JSON.parse(localStorage.getItem('restaurantList'));
		localStorage.setItem('currRestaurant', JSON.stringify(restaurantList[index]));
		console.log(localStorage.getItem("currRestaurant"));
		 window.location = "RestaurantDetail.html"; 
		
	});
}

//name, link, image, phone, address
var setPanel = function(obj, index){
	var perPanel = "<div></div>";
	$(".panel-group").append(perPanel);
	var temp1 = index+1;
	var temp = ".panel-group > div:last-child";
	$(temp).addClass("panel");
	var curr = $(".panel-group > .panel:last-child ");
	curr.addClass("panel-default");
	
	curr.append("<div><a>" + index + " " + obj["name"]+"</a></div>");
	$(".panel-group .panel:last-child > div").addClass("panel-heading");
	$(".panel-group .panel:last-child > div").attr("index", index-1);
	//$(".panel-group div div a").attr("href",obj["url"]);
	
	curr.append("<div></div>");
	$(".panel-group .panel:last-child > div:last-child").addClass("panel-body");
	
	$(".panel-group > .panel:last-child .panel-body").append("<div></div>");
	$(".panel-group .panel:last-child  .panel-body  > div").addClass("col-md-1");
	$(".panel-group .panel:last-child  .panel-body > div:last-child").append("<div><img /></div>");
	$(".panel-group .panel:last-child .panel-body .col-md-1 > div").addClass("pull-left");
	$(".panel-group .panel:last-child .panel-body .col-md-1 div >img").attr("src", obj["imageUrl"]);
	$(".panel-group .panel:last-child .panel-body .col-md-1 div > img").css("height", "70px");
	
	$(".panel-group > .panel:last-child .panel-body").append("<div>rating<img /></div>");
	$(".panel-group .panel:last-child  .panel-body >div:nth-child(2)").addClass("col-md-2");
	$(".panel-group .panel:last-child  .panel-body >.col-md-2").addClass("text-left");
	$(".panel-group .panel:last-child  .panel-body .col-md-2 >img").attr("src", obj["rating_img_url_small"]);
	$(".panel-group .panel:last-child .panel-body .col-md-2 >img").css("width", "80px");
	$(".panel-group .panel:last-child  .panel-body >.col-md-2").append("<div>"+"review"+" "+obj["reviewCount"]+"</div>");
	$(".panel-group .panel:last-child .panel-body .col-md-2 >div").addClass("text-left");
	
	$(".panel-group > .panel:last-child .panel-body").append("<div></div>");
	$(".panel-group .panel:last-child  .panel-body > div:nth-child(3)").addClass("col-md-6");
	$(".panel-group > .panel:last-child .panel-body .col-md-6:last-child").append("<div>"+obj["snippet_text"]+"</div>");
	$(".panel-group > .panel:last-child .panel-body .col-md-6:last-child > div").addClass("text-left");
	
	
	$(".panel-group > .panel:last-child .panel-body").append("<div></div>");
	$(".panel-group .panel:last-child  .panel-body > div:nth-child(4)").addClass("col-md-3");
	$(".panel-group > .panel:last-child .panel-body .col-md-3:last-child").append("<div>"+obj["address"]+" "+obj["city"]+","+obj["state"]+"</div>"+"<div>"+obj["postal_code"]+"</div>"+"<div>"+"phone: "+obj["phone"]+"</div>");
	$(".panel-group > .panel:last-child .panel-body .col-md-3:last-child > div").addClass("text-center");
	
	
	
	
	
}