const message = document.querySelector('#msg');
//creation of LEAFLET map api
//DEFAULT view is on melbourne (aka: main FlexFit store)
const geoMap = L.map('map').setView([-37.8142454, 144.9631732], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(geoMap);

// Array of 3 different FlexFit (made-up MARKED) Locations
    var marked_location = [
        { latitude: -37.8142454, longitude: 144.9631732, name: 'Melbourne', description: 'Capital City of Victoria, home to millions.', store: 'Main FlexFit store location!' },
        { latitude: -37.7987978, longitude: 144.776051, name: 'Derrimut', description: 'Melbourne Suburb, West of Melbourne.', store: 'FlexFit store location - West!' },
        { latitude: -37.9716749, longitude: 145.0891155, name: 'Oakleigh', description: 'Melbourne Suburb, East of Melbourne.', store: 'FlexFit store location - East!' }
    ];

//Loop through made FlexFit Locations
marked_location.forEach(function (location) {
    //used to ADD marked-location onto geoMap
    const marker = L.marker([location.latitude, location.longitude]).addTo(geoMap);

    marker.bindPopup(`<b>${location.name}</b><br>${location.description}<br><br>${location.store}`);

    //User hover -> show popup
    marker.on('mouseover', function (e) {
        this.openPopup();
    });

    //User not hover -> close popup
    marker.on('mouseout', function (e) {
        this.closePopup();
    });
});

//Notification popup
navigator.geolocation.getCurrentPosition(showSuccess,showError);

function showSuccess(position) {
    const {latitude, longitude} = position.coords;

    message.classList.add('success');
    message.textContent = `Your Location: ${latitude}, ${longitude}`;
    //When a user allows location, instead of panning to main stores, set view of map to their current location
    geoMap.setView([latitude, longitude], 13);

    L.marker([latitude, longitude]).addTo(geoMap).bindPopup('Your Location:').openPopup();
}

function showError() {
    message.classList.add('error');
    message.textContent = 'Location not Found';
}