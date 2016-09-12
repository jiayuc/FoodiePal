var myName;
$(document).ready(function(){
    console.log("start");
    
    
    	if(localStorage.getItem('myName') != undefined){
    		
		console.log("got here");
		changeButton();
	}else{
		console.log("in here");
		//console.log("myname is :"+myname);
		$("#oldUser").css("display", "block");
		$("#oldUser1").css("display", "block");
		$("#newUser").css("display", "none");
	}
    
    signIn();
    logOut();
    toAccount();
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
    getCategory();
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
                        //console.log(data);  
                      }
        });
    }
    getName();
   //$('#search').on('click', function(){
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
			url: "./backEnd/processSearch.php",
			type: "GET",
			data: data,
			success: function(data){
				console.log("success------------------------------");
				console.log($.parseJSON(data));
				var temp = $.parseJSON(data);
				localStorage.setItem("restaurantList", JSON.stringify(temp));
				
				window.location = "pages/SearchResult.html"; 
			}
		});
		
	});
	return false;
		
    });
    
    
    

});

var toAccount = function(){
	$("#account").on('click', function(){
		//var user = JSON.parse(localStorage.getItem('userInfo'));
		//console.log(user);
		window.location = "pages/account.html"; 
	});
}


var changeButton = function(){
	console.log("here here");
	myName = localStorage.getItem('myName');
	console.log(myName);
	$("#oldUser").css("display", "none");
	$("#oldUser1").css("display", "none");
	$("#newUser").css("display", "block");
}



var logOut = function(){
	$("#logout").on('click', function(){
		localStorage.removeItem('myName');
		localStorage.removeItem('userInfo');
		
	        console.log('myName: '+ localStorage.getItem('myName'));
	        $("#newUser li a").text("Hello There!");
	        $("#oldUser").css("display", "block");
	        $("#oldUser1").css("display", "block");
		$("#newUser").css("display", "none");
		
	});
}

var signIn = function(){
	console.log("before signIn");
	$('#signIn').submit( function() {
	
		console.log("form submit");
		console.log($(this).attr('method'));
		console.log($(this).serialize());
	        $.ajax({
	            url     : $(this).attr('action'),
	            type    : $(this).attr('method'),
	            data    : $(this).serialize(),
	            dataType : "json",
	            success : function(data){
	                        	console.log("get here1");
	                        	console.log(data['loggedIn'] === 2);
	                        	console.log(JSON.stringify(data));
	                       	 	if(data['loggedIn'] === 0){
	                        		console.log("0");
	                        		$("#text").html("User doesn't exist");
	                      		}
	                      		else if(data['loggedIn'] === 2){
	                      			console.log("1");
	                      			$("#text").html("Username and password doesn't match");
	                      		}else{
	                      			$("#text").html("Succeed!");
	                      			localStorage.setItem('myName', data['firstName']);
	                      			localStorage.setItem('userInfo', JSON.stringify(data));
	                      			console.log(JSON.parse(localStorage.getItem('userInfo')));
	                         		changeButton();
	                         		//window.location = "SearchResult.html";
	                         }
	          	}
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