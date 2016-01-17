google.maps.event.addDomListener(window, 'load', function () {

    var geocoder = new google.maps.Geocoder();

    // Initialize the geocoders.
    $('.geocoder-map').each(function () {

        // Define the inputs.
        var match = $(this).closest('.form-group').find('.match');
        var address = $(this).closest('.form-group').find('input.address');
        var formatted = $(this).closest('.form-group').find('input.formatted');
        var latitude = $(this).closest('.form-group').find('input.latitude');
        var longitude = $(this).closest('.form-group').find('input.longitude');
        var formattedLatitude = $(this).closest('.form-group').find('input.formatted_latitude');
        var formattedLongitude = $(this).closest('.form-group').find('input.formatted_longitude');
        var refresh = $(this).closest('.form-group').find('[data-toggle="refresh"]');

        // Create the initial location from value or New York.
        var location = new google.maps.LatLng(latitude.val() || 40.7128, longitude.val() || -74.0059);
        var formattedLocation = new google.maps.LatLng(formattedLatitude.val() || 40.7128, formattedLongitude.val() || -74.0059);

        // Initialize the Google Map.
        var map = new google.maps.Map(
            $(this)[0],
            {
                clickable: true,
                zoomControl: true,
                scrollwheel: false,
                mapTypeControl: true,
                disableDefaultUI: true,
                zoom: $(this).data('zoom'),
                maxZoom: $(this).data('max-zoom'),
                center: formattedLocation
            }
        );

        // Initialize the initial marker.
        var marker = new google.maps.Marker({
            zIndex: 2,
            draggable: true,
            position: location
        });

        // Initialize the initial marker.
        var position = new google.maps.Marker({
            zIndex: 1,
            opacity: 0.5,
            draggable: false,
            position: formattedLocation
        });

        if (address.val().length > 1) {
            marker.setMap(map);
            position.setMap(map);
        }

        // When the marker moves, update.
        google.maps.event.addListener(marker, 'drag', function () {

            var result = marker.getPosition();

            // Update the inputs.
            latitude.val(result.lat().toFixed(7));
            longitude.val(result.lng().toFixed(7));
        });

        // When the address changes, update.
        address.on('keyup', function () {
            geocoder.geocode(
                {
                    'address': address.val()
                },
                function (results, status) {

                    // If nothing was found - don't do anything.
                    if (status != google.maps.GeocoderStatus.OK) {
                        return;
                    }

                    var result = results[0];
                    var geometry = result.geometry;

                    // Set the match string.
                    match.text(result.formatted_address);

                    // Center the map to the new location.
                    map.setCenter(geometry.location);

                    // Create a new marker.
                    marker.setMap(map);
                    position.setMap(map);
                    marker.setPosition(geometry.location);
                    position.setPosition(geometry.location);

                    // Update the inputs.
                    formatted.val(result.formatted_address);
                    latitude.val(geometry.location.lat().toFixed(7));
                    longitude.val(geometry.location.lng().toFixed(7));
                    formattedLatitude.val(geometry.location.lat().toFixed(7));
                    formattedLongitude.val(geometry.location.lng().toFixed(7));
                });
        });

        // When refresh is required, trigger keyup.
        refresh.on('click', function (e) {

            e.preventDefault();

            address.trigger('keyup');
        });

        $('[data-toggle="tab"]').on('shown.bs.tab', function () {
            google.maps.event.trigger(map, 'resize');
            map.setCenter(position.getPosition());
        });
    });
});
