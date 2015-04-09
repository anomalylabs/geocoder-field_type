google.maps.event.addDomListener(window, 'load', function () {

    var geocoder = new google.maps.Geocoder();

    // Initialize the geocoders.
    $('.geocoder-map').each(function () {

        // Define the inputs.
        var search = $(this).closest('.form-group').find('input.search');
        var address = $(this).closest('.form-group').find('input.address');
        var longitude = $(this).closest('.form-group').find('input.longitude');
        var latitude = $(this).closest('.form-group').find('input.latitude');
        var refresh = $(this).closest('.form-group').find('[data-toggle="refresh"]');

        // Create the initial location from value or New York.
        var location = new google.maps.LatLng(latitude.val() || 40.7033127, longitude.val() || -73.979681);

        // Initialize the Google Map.
        var map = new google.maps.Map(
            $(this)[0],
            {
                center: location,
                clickable: true,
                zoomControl: true,
                scrollwheel: false,
                mapTypeControl: true,
                disableDefaultUI: true,
                zoom: $(this).data('zoom'),
                maxZoom: $(this).data('max-zoom')
            }
        );

        // Initialize the initial marker.
        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: location
        });

        // When the marker moves, update.
        google.maps.event.addListener(marker, 'dragend', function () {

            var result = marker.getPosition();

            // Update the inputs.
            latitude.val(result.lat().toFixed(4));
            longitude.val(result.lng().toFixed(4));
        });

        // When the address changes, update.
        search.on('keyup', function () {
            geocoder.geocode(
                {
                    'address': search.val()
                },
                function (results, status) {

                    // If nothing was found - don't do anything.
                    if (status != google.maps.GeocoderStatus.OK) {
                        return;
                    }

                    var result = results[0];
                    var geometry = result.geometry;

                    // Create a new marker.
                    marker.setPosition(geometry.location);

                    // Update the inputs.
                    address.val(result.formatted_address);
                    latitude.val(geometry.location.lat().toFixed(4));
                    longitude.val(geometry.location.lng().toFixed(4));

                    // Center the map to the new location.
                    map.setCenter(geometry.location);
                });
        });

        // When refresh is required, trigger keyup.
        refresh.on('click', function (e) {

            e.preventDefault();

            search.trigger('keyup');
        });

        // Initialize spinners.
        latitude.spinner({
            min: '-180',
            max: '180',
            page: 10,
            step: '0.0001',
            spin: function (e) {

                e.stopPropagation();

                // Create a new location.
                var location = new google.maps.LatLng(latitude.val(), longitude.val());

                // Create a new marker.
                marker.setPosition(location);
            },
            change: function (e) {

                e.stopPropagation();

                // Create a new location.
                var location = new google.maps.LatLng(latitude.val(), longitude.val());

                // Create a new marker.
                marker.setPosition(location);
            }
        });

        longitude.spinner({
            min: '-180',
            max: '180',
            page: 10,
            step: '0.0001',
            spin: function (e) {

                e.stopPropagation();

                // Create a new location.
                var location = new google.maps.LatLng(latitude.val(), longitude.val());

                // Create a new marker.
                marker.setPosition(location);
            },
            change: function (e) {

                e.stopPropagation();

                // Create a new location.
                var location = new google.maps.LatLng(latitude.val(), longitude.val());

                // Create a new marker.
                marker.setPosition(location);
            }
        });
    });
});
