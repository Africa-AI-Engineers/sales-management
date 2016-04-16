<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta charset="utf-8">
		<title>Simple Polylines</title>
		<style>
			html, body, #map-canvas {
				height: 100%;
				margin: 0px;
				padding: 0px
			}
		</style>
	</head>
	<body>
		<div id="map-canvas"></div>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
		<script>
			var unit = " Kilometers";
			var total_distance = 0.0;
			function initialize() {
				var mapOptions = {
					zoom: 12,
					center: new google.maps.LatLng({{$c_lat}}, {{$c_lon}}),
					mapTypeId: google.maps.MapTypeId.STREET
				};

				var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

				/*var paths = [
					new google.maps.LatLng(23.8194165, 90.4082087),
					new google.maps.LatLng(23.7790463, 90.3811369),
					new google.maps.LatLng(23.8044763, 90.4156033),
					new google.maps.LatLng(23.7817464, 90.4039672),
					new google.maps.LatLng(23.7685408, 90.4255465),
					new google.maps.LatLng(23.8134897, 90.4242889),
					new google.maps.LatLng(23.8140582, 90.3976575),
					new google.maps.LatLng(23.8465762, 90.4025772)
				];*/
				{{$locations}}
				/*
				 * 	Changes start
				 */

				var latLngBounds = new google.maps.LatLngBounds();
				for(var i = 0; i < paths.length; i++) {
					var title = "";
					var icon = "";
					if(i == 0){
						message = "Distance between " + (i+1) + " and " + (i+2) + " is: ";
						distance = calculateDistance(paths[0], paths[1]);
						title = message + distance + unit;
						icon = "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=S|009933|ffffff";
						total_distance += distance;
					} else if( i == (paths.length - 1)){
						message = "Distance between " + (i) + " and " + (i+1) + " is: ";
						distance = calculateDistance(paths[i], paths[i-1]);
						title = message + distance + unit;
						icon = "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=E|FF3300|ffffff";
					} else{
						distance1 = calculateDistance(paths[i], paths[i-1]);
						distance2 = calculateDistance(paths[i], paths[i+1]);
						message1 = "Distance between " + (i) + " and " + (i+1) + " is: " + distance1 + unit;
						message2 = "Distance between " + (i+1) + " and " + (i+2) + " is: " + distance2 + unit;
						title = message1 + "\n" + message2;
						icon = "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=P|33CCFF|000000";
						total_distance += distance2;
					}

					latLngBounds.extend(paths[i]);
					var marker = new google.maps.Marker({
						map: map,
						position: paths[i],
						title: title,
						//animation: google.maps.Animation.BOUNCE,
						animation: google.maps.Animation.DROP,
						icon: icon
					});
				}


				/*
				 *  Changes end
				 */
				var polyline = new google.maps.Polyline({
					path: paths,
					geodesic: true,
					strokeColor: '#00AAC4',
					strokeOpacity: 1.0,
					strokeWeight: 5
				});
				polyline.setMap(map);
				console.log(round(total_distance) + unit);
			}
			google.maps.event.addDomListener(window, 'load', initialize);
			function calculateDistance(locationObject1, locationObject2){
				var Rm = 3961; // mean radius of the earth (miles) at 39 degrees from the equator
				var Rk = 6373; // mean radius of the earth (km) at 39 degrees from the equator
				var origin_latitude, 
					origin_longitude, 
					destination_latitude, 
					destination_longitude, 
					origin_latitude_radian, 
					origin_longitude_radian, 
					destination_latitude_radian, 
					destination_longitude_radian, 
					latitude_difference, 
					longitude_difference, 
					a, 
					c, 
					distance_in_miles, 
					distance_in_kilometers, 
					mi, 
					rounded_distance_in_kilometers;
				// get values for lat1, lon1, lat2, and lon2
				origin_latitude = locationObject1.lat();
				origin_longitude = locationObject1.lng();
				destination_latitude = locationObject2.lat();
				destination_longitude = locationObject2.lng();
				
				// convert coordinates to radians
				origin_latitude_radian = deg2rad(origin_latitude);
				origin_longitude_radian = deg2rad(origin_longitude);
				destination_latitude_radian = deg2rad(destination_latitude);
				destination_longitude_radian = deg2rad(destination_longitude);
				
				// find the differences between the coordinates
				latitude_difference = destination_latitude_radian - origin_latitude_radian;
				longitude_difference = destination_longitude_radian - origin_longitude_radian;
				
				// here's the heavy lifting
				a  = Math.pow(Math.sin(latitude_difference/2),2) + Math.cos(origin_latitude_radian) * Math.cos(destination_latitude_radian) * Math.pow(Math.sin(longitude_difference/2),2);
				c  = 2 * Math.atan2(Math.sqrt(a),Math.sqrt(1-a)); // great circle distance in radians
				distance_in_miles = c * Rm; // great circle distance in miles
				distance_in_kilometers = c * Rk; // great circle distance in km
				
				// round the results down to the nearest 1/1000
				rounded_distance_in_kilometers = round(distance_in_kilometers);
				
				// display the result
				return rounded_distance_in_kilometers;
			}
			
			// convert degrees to radians
			function deg2rad(deg) {
				rad = deg * Math.PI/180; // radians = degrees * pi/180
				return rad;
			}
			
			// round to the nearest 1/1000
			function round(x) { return Math.round( x * 1000) / 1000; }
		</script>
	</body>
</html>