## Usage[](#usage)

This section will show you how to use the field type via API and in the view layer.


### Setting Values[](#usage/setting-values)

You can set the geocoder field type value with an address:

    $entry->example = "1 Infinite Loop, Cupertino, CA 95014";

You can use partial addresses too:

    $entry->example = "Cupertino CA";


### Basic Output[](#usage/basic-output)

The geocoder field type returns an array of data.

    $entry->example;

    [
        "address"=> "1 Cupertino Loop",
        "formatted" => "Infinite Loop, Cupertino, CA 95014, USA",
        "latitude" => "37.3320403",
        "longitude" => "-122.0285677",
        "formatted_latitude" => "37.3322109",
        "formatted_longitude" => "-122.0307778"
    ]


### Presenter Output[](#usage/presenter-output)

This section will show you how to use the decorated value provided by the `\Anomaly\GeocoderFieldType\GeocoderFieldTypePresenter` class.


#### GeocoderFieldTypePresenter::image()[](#usage/presenter-output/geocoderfieldtypepresenter-image)

The `image` method returns a generated image of the map area.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$options

</td>

<td>

false

</td>

<td>

array

</td>

<td>

none

</td>

<td>

The image options.

</td>

</tr>

<tr>

<td>

$formatted

</td>

<td>

true

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Use the formatted address location instead of the potentially adjusted marker location.

</td>

</tr>

</tbody>

</table>

###### Example

    $decorated->example->image();

###### Twig

    {{ decorated.example.image()|raw }}


##### Available Option[](#usage/presenter-output/geocoderfieldtypepresenter-image/available-option)

Below are a list of available `options` for the image method's `options` argument.

###### Properties

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

scale

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

1

</td>

<td>

The scale of the map.

</td>

</tr>

<tr>

<td>

zoom

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

The configured zoom.

</td>

<td>

The zoom of the map.

</td>

</tr>

<tr>

<td>

format

</td>

<td>

false

</td>

<td>

string

</td>

<td>

png

</td>

<td>

The output format of the image. Valid options are `jpg` and `png`.

</td>

</tr>

<tr>

<td>

maptype

</td>

<td>

false

</td>

<td>

string

</td>

<td>

roadmap

</td>

<td>

The Google maptype. Valid options are `roadmap`, `satellite`, `hybrid`, and `terrain`.

</td>

</tr>

<tr>

<td>

width

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

150

</td>

<td>

The width of the resulting image.

</td>

</tr>

<tr>

<td>

height

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

100

</td>

<td>

The height of the resulting image.

</td>

</tr>

</tbody>

</table>


#### GeocoderFieldTypePresenter::embed()[](#usage/presenter-output/geocoderfieldtypepresenter-embed)

The `embed` method returns an embedded Google map.

<div class="alert alert-warning">**Heads Up:** The embedded map is 0px high by default. Be sure to use CSS to style it or set the height option as described below.</div>

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$options

</td>

<td>

false

</td>

<td>

array

</td>

<td>

none

</td>

<td>

The image options.

</td>

</tr>

<tr>

<td>

$formatted

</td>

<td>

true

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Use the formatted address location instead of the potentially adjusted marker location.

</td>

</tr>

</tbody>

</table>

###### Example

    $decorated->example->embed()->height(500);

###### Twig

    {{ decorated.example.embed().height(500)|raw }}


##### Available Options[](#usage/presenter-output/geocoderfieldtypepresenter-embed/available-options)

Below are a list of available `options` for the embed method's `options` argument.

###### Options

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

scale

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

1

</td>

<td>

The scale of the map.

</td>

</tr>

<tr>

<td>

scrollwheel

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

true

</td>

<td>

Set to `false` to disable scrollwheel interaction.

</td>

</tr>

<tr>

<td>

zoom

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

15

</td>

<td>

The output map zoom.

</td>

</tr>

<tr>

<td>

height

</td>

<td>

false

</td>

<td>

integer

</td>

<td>

none

</td>

<td>

The style height in pixels if any of the map div.

</td>

</tr>

</tbody>

</table>


#### GeocoderFieldTypePresenter::url()[](#usage/presenter-output/geocoderfieldtypepresenter-url)

The `url` method returns the Google Maps URL for the address.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$formatted

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Use the formatted address location instead of the potentially adjusted marker location.

</td>

</tr>

</tbody>

</table>

###### Example

    $decorated->example->url();

###### Twig

    {{ decorated.example.url() }}


#### GeocoderFieldTypePresenter::link()[](#usage/presenter-output/geocoderfieldtypepresenter-link)

The `link` method returns an HTML link to the Google Maps URL.

###### Returns: `string`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$title

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The link title.

</td>

</tr>

<tr>

<td>

$attributes

</td>

<td>

false

</td>

<td>

array

</td>

<td>

none

</td>

<td>

The array of HTML attributes of the link.

</td>

</tr>

<tr>

<td>

$secure

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

True if request is secure.

</td>

<td>

Force a secure URL.

</td>

</tr>

<tr>

<td>

$formatted

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Use the formatted address location instead of the potentially adjusted marker location.

</td>

</tr>

</tbody>

</table>


#### GeocoderFieldTypePresenter::position()[](#usage/presenter-output/geocoderfieldtypepresenter-position)

The `position` method returns an array containing the `longitude` and `latitude` values.

###### Returns: `array`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$formatted

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Use the formatted address location instead of the potentially adjusted marker location.

</td>

</tr>

</tbody>

</table>

###### Example

    $decorated->example->position()['longitude'];

###### Twig

    {{ decorated.example.position().longitude }}


#### GeocoderFieldTypePresenter::latitude()[](#usage/presenter-output/geocoderfieldtypepresenter-latitude)

The `latitude` method is a shortcut to return the value's latitude position.

###### Returns: `float`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$formatted

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Use the formatted address location instead of the potentially adjusted marker location.

</td>

</tr>

</tbody>

</table>

###### Example

    $deocrated->example->latitude();

###### Twig

    {{ decorated.example.latitude() }}


#### GeocoderFieldTypePresenter::longitude()[](#usage/presenter-output/geocoderfieldtypepresenter-longitude)

The `longitude` method is a shortcut to return the value's longitude position.

###### Returns: `float`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$formatted

</td>

<td>

false

</td>

<td>

boolean

</td>

<td>

false

</td>

<td>

Use the formatted address location instead of the potentially adjusted marker location.

</td>

</tr>

</tbody>

</table>

###### Example

    $decorated->example->longitude();

###### Twig

    {{ decorated.example.longitude() }}


#### GeocoderFieldTypePresenter::point()[](#usage/presenter-output/geocoderfieldtypepresenter-point)

The `point` method returns a `Point` instance for use within spatial utilities.

###### Returns: `\Anomaly\GeocoderFieldType\Spatial\Point`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$formatted

</td>

<td>

false

</td>

<td>

bool

</td>

<td>

none

</td>

<td>

Whether to use the formatted latitude and longitude instead of the adjustable marker.

</td>

</tr>

</tbody>

</table>

###### Example

    $decorated->point();

###### Twig

    {{ decorated.point() }}


#### GeocoderFieldTypePresenter::geocode()[](#usage/geocoder/geocoderfieldtypepresenter-geocode)

The `geocode` method returns a _geocoder_ point (as opposed to the above _spatial_ point).

###### Returns: `\Anomaly\GeocoderFieldType\GeocoderFieldTypePoint`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$formatted

</td>

<td>

false

</td>

<td>

bool

</td>

<td>

none

</td>

<td>

Whether to use the formatted address instead of the input address.

</td>

</tr>

</tbody>

</table>

###### Example

    echo $decorated->geocode->city() . ', ' . $decorated->geocode->state();

###### Twig

    {{ entry.location.geocode.city() }}, {{ entry.location.geocode.state() }}


### Geocoder[](#usage/geocoder)

This section will go over how to use the geocoder utility included with the geocoder field type.

To get started use the geocoder field type to create a new geocoder instance:

    $geocoder = $fieldType->newGeocoder();


#### GeocoderFieldTypeGeocoder::convert()[](#usage/geocoder/geocoderfieldtypegeocoder-convert)

The `convert` method will convert the provided address into a `geocoded point` object.

###### Returns: `\Anomaly\GeocoderFieldType\GeocoderFieldTypePoint`

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$address

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The address to geocode. Partial addresses are supported as well.

</td>

</tr>

</tbody>

</table>

###### Example

    $point = $geocoder->convert('Davenport, IA');


#### GeocoderFieldTypeGeocoder::reverse()[](#usage/geocoder/geocoderfieldtypegeocoder-reverse)

The `reverse` method performs a reverse geocode lookup.

###### Arguments

<table class="table table-bordered table-striped">

<thead>

<tr>

<th>Key</th>

<th>Required</th>

<th>Type</th>

<th>Default</th>

<th>Description</th>

</tr>

</thead>

<tbody>

<tr>

<td>

$collection

</td>

<td>

true

</td>

<td>

string

</td>

<td>

none

</td>

<td>

The collection to add the asset to.

</td>

</tr>

</tbody>

</table>


### Point[](#usage/point)

This section will go over how to use the geocoded point class included with the geocoder field type.

This particular class is returned by the presenter's `geocode` method:

    $point = $decorated->geocode();

And an example of using the below methods in Twig:

    {{ entry.location.geocode.state() }}


#### GeocoderFieldTypePoint::getResult()[](#usage/point/geocoderfieldtypepoint-getresult)

The `getResult` returns the entire result array from Google's geocoding service.

###### Returns: `array`

###### Example

    $result = $point->getResult();


#### GeocoderFieldTypePoint::address()[](#usage/point/geocoderfieldtypepoint-address)

The `address` method returns the original input address used in the geocoder.

###### Returns: `string`

###### Example

    $address = $point->address();


#### GeocoderFieldTypePoint::formatted()[](#usage/point/geocoderfieldtypepoint-formatted)

The `formatted` method returns the formatted address string matched by the geocoder service.

###### Returns: `string`

###### Example

    $match = $point->formatted();


#### GeocoderFieldTypePoint::route()[](#usage/point/geocoderfieldtypepoint-route)

The `route` method returns the route component of the formatted address.

###### Returns: `string`

###### Example

    $street = $point->route();


#### GeocoderFieldTypePoint::streetAddress()[](#usage/point/geocoderfieldtypepoint-streetaddress)

The `streetAddress` method returns the street address (street number and route).

###### Returns: `string`

###### Example

    $address1 = $point->streetAddress();


#### GeocoderFieldTypePoint::streetNumber()[](#usage/point/geocoderfieldtypepoint-streetnumber)

The `streetNumber` method returns the street number of the formatted address.

###### Returns: `string`

###### Example

    $house = $point->streetNumber();


#### GeocoderFieldTypePoint::city()[](#usage/point/geocoderfieldtypepoint-city)

The `city` method returns the city component of the formatted address.

###### Returns: `string`

###### Example

    $city = $point->city();


#### GeocoderFieldTypePoint::postalCode()[](#usage/point/geocoderfieldtypepoint-postalcode)

The `postalCode` method returns the postal code component of the formatted address.

###### Returns: `string`

###### Example

    $zip = $point->postalCode();


#### GeocoderFieldTypePoint::state()[](#usage/point/geocoderfieldtypepoint-state)

The `state` method returns the state component of the formatted address.

###### Returns: `string`

###### Example

    $state = $point->state();


#### GeocoderFieldTypePoint::county()[](#usage/point/geocoderfieldtypepoint-county)

The `county` method returns the county component of the formatted address.

###### Returns: `string`

###### Example

    $county = $point->county();


#### GeocoderFieldTypePoint::country()[](#usage/point/geocoderfieldtypepoint-country)

The `country` method returns the country name component of the formatted address.

###### Returns: `string`

###### Example

    $country = $point->country();


#### GeocoderFieldTypePoint::countryCode()[](#usage/point/geocoderfieldtypepoint-countrycode)

The `countryCode` method returns the country code component of the formatted address.

###### Returns: `string`

###### Example

    $country = $point->countryCode();


#### GeocoderFieldTypePoint::location()[](#usage/point/geocoderfieldtypepoint-location)

The `location` method returns the location array component of the formatted address.

###### Returns: `array`

###### Example

    $latitude = $point->location()['lat'];


#### GeocoderFieldTypePoint::latitude()[](#usage/point/geocoderfieldtypepoint-latitude)

The `latitude` method returns the latitude component of the formatted address.

###### Returns: `float`

###### Example

    $latitude = $point->latitude();


#### GeocoderFieldTypePoint::longitude()[](#usage/point/geocoderfieldtypepoint-longitude)

The `longitude` method returns the longitude component of the formatted address.

###### Returns: `float`

###### Example

    $longitude = $point->longitude();


#### GeocoderFieldTypePoint::point()[](#usage/point/geocoderfieldtypepoint-point)

The `point` method returns a geometric `Point` instance to be used with the query builder if needed.

###### Returns: `\Anomaly\GeocoderFieldType\Spatial\Point`

###### Example

    $location = $model->whereDistance('address', $geocoder->point(), '25 mi')->get();
