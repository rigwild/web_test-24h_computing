const dPlaceId = "ChIJT_x1AIOB0IkRhcd1YOHXJXk"

const imgSize = {
	maxWidth: 500,
	maxHeight: 325
}

const map = new google.maps.Map(document.getElementById('map-canvas'), {
	zoom: 13,
	/*center: {
		lat: -33.867,
		lng: 151.206
	},*/
	mapTypeId: google.maps.MapTypeId.HYBRID
});


const log = (...el) => el.forEach(x => console.log(x))

/*Parse*/
const getPhotos = obj => obj.photos.map(x => x.getUrl(imgSize))

/*GMAP API*/

/*Get place by place id*/
const getPlace = placeIdd => {
	return new Promise((resolve, reject) => {
		var request = {
			placeId: placeIdd
		};

		var infowindow = new google.maps.InfoWindow();
		var service = new google.maps.places.PlacesService(map);

		service.getDetails(request, function(place, status) {
			if (status == google.maps.places.PlacesServiceStatus.OK) {
				var marker = new google.maps.Marker({
					map: map,
					position: place.geometry.location
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.setContent(place.name);
					infowindow.open(map, this);
				});
				resolve(place);
			} else {
				reject(status);
			}
		});

	})
}

const getLocation = (callbackSuccess, callbackFail) => {
	if (navigator.geolocation)
		return navigator.geolocation.getCurrentPosition(callbackSuccess, callbackFail)
}

/*Get nearby places by lat long*/
const getNearbyPosition = (lat, long) => {
	return new Promise((resolve, reject) => {
		var infowindow = new google.maps.InfoWindow();
		var service = new google.maps.places.PlacesService(map);
		const location = {
			lat: lat,
			lng: long
		}
		service.nearbySearch({
			location: location,
			radius: 5500
		}, callback);

		map.setCenter(location)


		function callback(results, status) {
			if (status === google.maps.places.PlacesServiceStatus.OK)
				resolve(results.map(x => createMarker(x)))
			else
				reject(status)
		}

		function createMarker(place) {
			var placeLoc = place.geometry.location;
			var marker = new google.maps.Marker({
				map: map,
				position: place.geometry.location
			});

			google.maps.event.addListener(marker, 'click', function() {
				log(place.place_id)
				document.getElementById('lieu').value = place.place_id
				document.getElementById('lieu_name').value = place.name
			});
			return place
		}

	})
}

google.maps.event.addDomListener(window, 'load', () => {
	/*
	getPlace(dPlaceId)
		.then(res => {
			log(getPhotos(res))
		})
		.catch(err => log(err))


	const dLat = -33.867
	const dLong = 151.206

	getNearbyPosition(dLat, dLong)
		.then(res => {
			log(res)
		})
		.catch(err => log(err))*/
});