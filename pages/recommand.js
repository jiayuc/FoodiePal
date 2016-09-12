var myName;
$(document).ready(function(){
	changeButton();
	
	if(localStorage.getItem('myName') == null || localStorage.getItem('myName') == undefined){
		window.location = "../index.html";
	}
	var restaurantList =  JSON.parse(localStorage.getItem('recommandList'));
	console.log(restaurantList);
	$("#text").html("");
	
	//console.log(restaurantList.length);
	//localStorage.removeItem('clicked');
	for(var i =0;i < restaurantList.length;i++)
	{
  		var item = restaurantList[i];
  	
  		setPanel(item, i+1);
	}
	console.log("got here");
	
	
	//signIn();
	//search();
	logOut();
	toRestaurantDetails();
});

var changeButton = function(){
	console.log("here here");
	myName = localStorage.getItem('myName');
	$("#message").html("Hello There! " + myName);
}
var logOut = function(){
	$("#logout").on('click', function(){
		window.location = "../index.html";
		
	});
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