var myName;
$(document).ready(function(){
	
	$("#myRating").rating({'size':'sm'});

	if(localStorage.getItem('myName') != undefined){
		changeButton();
	}else{
		$("#oldUser").css("display", "block");
		$("#logout").css("display", "none");
	}
	signIn();
	logOut();
	setValue();
	initialize();
	ratingChange();
	

});



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

var map;
var marker;

function ratingChange(){
	$('#myRating').on('rating.change', function(event, value, caption){
		if(localStorage.getItem('myName') != undefined){
	   		console.log(value);
	   		//console.log(localStorage.getItem('userInfo'));
	   		var user = JSON.parse(localStorage.getItem('userInfo'));
	    		var user_id = user['email'];
	    		//console.log(JSON.parse(localStorage.getItem("currRestaurant")));
	    		var bus = JSON.parse(localStorage.getItem("currRestaurant"));
	    		var bus_id = bus['id'];
	    		my_rating = {"rating": value, "user_id": user_id, "bus_id": bus_id};
	    		console.log(my_rating);
	    		$.ajax({
		            url     : "../backEnd/personalRating.php",
		            type    : "POST",
		            data    : my_rating,
		            success : function( data ) {
		                        console.log(data);
		            }
		       });
	       }else{
	       		alert("Please log in first to rate restaurant");
	       }
	});
}

function initialize() {
  console.log("initialize");
  var mapOptions = {
    center: new google.maps.LatLng(40.680898,-8.684059),
    zoom: 11,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
  console.log("map");
  console.log(map);
  return searchAddress();
}


function searchAddress() {
  console.log("searchAddress");
  var obj = JSON.parse(localStorage.getItem("currRestaurant"));
  var addressInput = obj['address'] + " " + obj['city'] + " " + obj['state'] + " " + obj['postal_code'];
  console.log(addressInput);

  var geocoder = new google.maps.Geocoder();

  geocoder.geocode({address: addressInput}, function(results, status) {
	console.log("geocode");
	console.log(addressInput);
	console.log(results);
    if (status == google.maps.GeocoderStatus.OK) {

	    var myResult = results[0].geometry.location; // reference LatLng value
	    console.log(myResult);
	    createMarker(myResult); // call the function that adds the marker
	
	    map.setCenter(myResult);
	
	    map.setZoom(17);
	
	  } else { // if status value is not equal to "google.maps.GeocoderStatus.OK"
	
	    // warning message
	    alert("The Geocode was not successful for the following reason: " + status);

     }
  });
}

function createMarker(latlng) {

   // If the user makes another search you must clear the marker variable
   if(marker != undefined && marker != ''){
    marker.setMap(null);
    marker = '';
   }

   marker = new google.maps.Marker({
      map: map,
      position: latlng
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

var setValue = function(){

	
	var obj = JSON.parse(localStorage.getItem("currRestaurant"));
	console.log(obj);
	console.log("got here");
	console.log(obj['address']);
	$("#name").text(obj['name']);
	$("#street").text(obj['address']);
	$("#city").text(obj['city']);
	$("#state").text(obj['state']);
	$("#postal").text(obj['postal_code']);
	$("#phone").text(obj['phone']);
	$("#rating").attr("src", obj["rating_img_url"]);
	$("#ratingNum").text(obj['stars']);
	$("#website").text(obj['url']);
	$("#website").attr("href",obj["url"]);
	$("#testimonial").text(obj['snippet_text']);
	$("#image").attr("src", obj["imageUrl"]);
	
}
	