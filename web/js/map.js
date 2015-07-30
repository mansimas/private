var geocoder = new google.maps.Geocoder();
function geocodePosition(pos) 	
{
        geocoder.geocode({
        latLng: pos
        }, function(responses)
        {
                if (responses && responses.length > 0) {
                        var snPosition = pos;
                        var snPosition = snPosition.toString();
                        snCoordinatePosition = snPosition.substring(1,snPosition.length - 1);
						var address='';						
						for (var i = 0; i < responses[0].address_components.length; i++) 
						{
							var addr = responses[0].address_components[i];							
							// check if this entry in address_components has a type of country							
							if (addr.types[0] == ['street_number'])
								address = address + addr.long_name;
							else if (addr.types[0] == 'street_address')
								address = address + addr.long_name;
							else if (addr.types[0] == 'establishment')
								address = address +", "+addr.long_name;
							else if (addr.types[0] == 'route')
								address = address +", "+addr.long_name;
							else if (addr.types[0] == 'postal_code')
								address = address +", "+addr.short_name;
							else if (addr.types[0] == ['administrative_area_level_1'])
								address = address +", "+addr.short_name;
							else if (addr.types[0] == ['locality'])
								address = address +", "+addr.long_name;							
                      }					  
                      $('#admin_medicalbundle_company_address').val(address);
                } 
        });
}

function getAddressMapInitialize()
{
    
	var geocoder = new google.maps.Geocoder();
    if($('#admin_medicalbundle_company_address').val() == '')
            var address = 'Lithunia';		
    else
            var address = $('#admin_medicalbundle_company_address').val();
	
    geocoder.geocode( { 'address': address}, function(results, status) 
    {

            if (status == google.maps.GeocoderStatus.OK) 
            {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();

                    var mapOptions = {
                                      center: new google.maps.LatLng(latitude, longitude),
                                      zoom: 11,                                                  
                                      mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };
                    var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
                            var marker = new google.maps.Marker({
                              map: map,
                              position: new google.maps.LatLng(latitude, longitude),
                              draggable: true,
                            });
                            google.maps.event.addListener(marker, 'dragend', function() 
                            { 
                                    geocodePosition(marker.getPosition());	
                            } );
                            marker.bindTo('center', marker, 'position');
            }				
    });
    google.maps.event.addDomListener(window, 'load', getAddressMapInitialize);		
}

function getGivenAddressMapInitialize(address, company_name)
{
	$("#show_address_map").width("900px");
	$("#show_address_map").height("400px");	
	var geocoder = new google.maps.Geocoder();		
	geocoder.geocode( { 'address': address}, function(results, status) 
	{
		if (status == google.maps.GeocoderStatus.OK) 
		{
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();					
				var mapOptions = {
								  center: new google.maps.LatLng(latitude, longitude),
								  zoom: 15,                                                  
								  mapTypeId: google.maps.MapTypeId.ROADMAP
								};
				var map = new google.maps.Map(document.getElementById("show_address_map"), mapOptions);
						var marker = new google.maps.Marker({
						  map: map,
						  position: new google.maps.LatLng(latitude, longitude),							 
						});															
				var poupcontent = company_name+address;
				var contentString = '<h4 id="firstHeading">'+company_name+'</h4><p>'+address+'</p>';

					marker.bindTo('center', marker, 'position');
					var infoWindow = new google.maps.InfoWindow({
						content: contentString
						});
					//google.maps.event.addListener(marker, 'click', function () {
						infoWindow.open(map, marker);
					//});
		}				
	});		
}