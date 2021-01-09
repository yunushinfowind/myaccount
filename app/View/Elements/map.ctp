<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3WW3zngbcYrk6MYBQxmCcvtFAPM6qD1I&v=3.exp&sensor=false&libraries=places"></script>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<script>
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initialize() {
        autocomplete = new google.maps.places.Autocomplete((document.getElementById('StudentAddress')),
                {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {

            fillInAddress1();
        });
    }


    function fillInAddress1() {
        var activityLocation = $("#StudentAddress").val();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': activityLocation}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                $.each(results[0].address_components, function (ckey, value) {
                    $.each(results[0].address_components[ckey].types, function (inkey, value1) {
                        if (results[0].address_components[ckey].types[inkey] == "locality") {
                            city = results[0].address_components[ckey].long_name;
                            console.log(city);
//                            $("#locality").val(city);

                        }
                        if (results[0].address_components[ckey].types[inkey] == "administrative_area_level_1") {
                            state = results[0].address_components[ckey].short_name;
                            console.log(state);
//                            $("#administrative_area_level_1").val(state);

                        }

                        if (results[0].address_components[ckey].types[inkey] == "postal_code") {
                            zip = results[0].address_components[ckey].short_name;
                            console.log(zip);
//                            $("#postal_code").val(zip);

                        }
                    });

                });

                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
                stockholm = new google.maps.LatLng(lat, lng);

//                $("#maperror").delay(2000);
//                $("#maperror").html('');
//                $("#map-canvas").addClass('map-canvas');

                $("#latitude").val(lat);
                $("#longitude").val(lng);
            }
            else
            {
                lat = '';
                lng = '';
                $("#map-canvas").removeClass('map-canvas');
                $('#maperror').show();
                $("#maperror").html('<font color="red" >Please enter a valid address.</font>');
                return false;
            }
        });
    }




</script>