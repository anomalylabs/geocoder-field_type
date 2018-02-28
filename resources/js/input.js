(function (window, document) {

    if (typeof(google) == 'undefined') {

        (function (document, tag) {
            let scriptTag = document.createElement(tag), // create a script tag
                firstScriptTag = document.getElementsByTagName(tag)[0]; // find the first script tag in the document
            scriptTag.src = this.dataset.include; // set the source of the script to your script
            firstScriptTag.parentNode.insertBefore(scriptTag, firstScriptTag); // append the script to the DOM
        }(document, 'script'));
    }

    let fields = Array.from(
        document.querySelectorAll('[data-provides="anomaly.field_type.geocoder"]')
    );

    let geocoder = new google.maps.Geocoder();

    fields.forEach(function (field) {

        let wrapper = field.closest('.input-wrapper');

        // Define the inputs.
        let match = wrapper.querySelector('.match');
        let map = wrapper.querySelector('.geocoder-map');
        let address = wrapper.querySelector('input.address');
        let latitude = wrapper.querySelector('input.latitude');
        let formatted = wrapper.querySelector('input.formatted');
        let longitude = wrapper.querySelector('input.longitude');
        let formattedLatitude = wrapper.querySelector('input.formatted_latitude');
        let formattedLongitude = wrapper.querySelector('input.formatted_longitude');

        // Create the initial location from value or New York.
        let location = new google.maps.LatLng(latitude.value || 40.7128, longitude.value || -74.0059);
        let formattedLocation = new google.maps.LatLng(formattedLatitude.value || 40.7128, formattedLongitude.value || -74.0059);

        // Initialize the Google Map.
        let gmap = new google.maps.Map(
            map,
            {
                clickable: true,
                zoomControl: true,
                scrollwheel: false,
                mapTypeControl: true,
                disableDefaultUI: true,
                zoom: Number(map.dataset.zoom),
                center: formattedLocation
            }
        );

        // Initialize the initial marker.
        let marker = new google.maps.Marker({
            zIndex: 2,
            draggable: true,
            position: location
        });

        // Initialize the initial marker.
        let position = new google.maps.Marker({
            zIndex: 1,
            opacity: 0.5,
            draggable: false,
            position: formattedLocation
        });

        // Do we have a value?
        marker.setMap(gmap);
        position.setMap(gmap);

        // When the marker moves, update.
        google.maps.event.addListener(marker, 'drag', function () {

            let result = marker.getPosition();

            // Update the inputs.
            latitude.value = result.lat().toFixed(7);
            longitude.value = result.lng().toFixed(7);
        });


        // When the address changes, update.
        address.addEventListener('keyup', function () {
            geocoder.geocode(
                {
                    'address': address.value
                },
                function (results, status) {

                    // If nothing was found - don't do anything.
                    if (status != google.maps.GeocoderStatus.OK) {
                        return;
                    }

                    let result = results[0];
                    let geometry = result.geometry;

                    // Set the match string.
                    match.innerText = result.formatted_address;

                    // Center the map to the new location.
                    if (map) {
                        gmap.setCenter(geometry.location);

                        // Create a new marker.
                        marker.setMap(gmap);
                        position.setMap(gmap);
                        marker.setPosition(geometry.location);
                        position.setPosition(geometry.location);
                    }

                    // Update the inputs.
                    formatted.value = result.formatted_address;
                    latitude.value = geometry.location.lat().toFixed(7);
                    longitude.value = geometry.location.lng().toFixed(7);
                    formattedLatitude.value = geometry.location.lat().toFixed(7);
                    formattedLongitude.value = geometry.location.lng().toFixed(7);
                });
        });

        // Resize on tab displays.
        $('[data-toggle="tab"]').on('shown.bs.tab', function () {
            google.maps.event.trigger(gmap, 'resize');
            gmap.setCenter(position.getPosition());
        });
    });
})(window, document);
