$(function() {
    $('#add_contact').on('keyup change', function(ev) {
        var $this = $(this);

        if ($this.val() !== '') {
            $('#add_contactUse').closest('.form-group').stop().fadeIn('fast');
        } else {
            $('#add_contactUse').closest('.form-group').stop().fadeOut('fast');
        }
    });

    $('#add_own').on('change', function(ev) {
        var $this = $(this);

        if ($this.val() === '5') {
            $('#add_source').closest('.form-group').stop().fadeIn('fast');
        } else {
            $('#add_source').closest('.form-group').stop().fadeOut('fast');
        }
    });

    $('#legend').draggable({ containment: 'parent' });
});

function getMarkerIcon(color) {
    return {
        path       : 'M-8,0a8,8 0 1,0 16,0a8,8 0 1,0 -16,0',
        strokeColor: color,
        fillColor  : color,
        fillOpacity: 1,
        size       : google.maps.Size(16, 16),
        origin     : new google.maps.Point(0, 0),
        anchor     : new google.maps.Point(8, 8)
    };
}


function initialize() {
    var mapOptions = {
        center          : { lat: 53.549535, lng: 9.962462},
        zoom            : 17,
        disableDefaultUI: true,
        styles          : [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#0c0b0b"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#090909"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d4e4eb"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#fef7f7"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9b7f7f"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#fef7f7"}]}]
    };

    var map = new google.maps.Map(
        document.getElementById('map-canvas'),
        mapOptions
    );

    map.data.loadGeoJson('js/bid.geojson');

    $.get(CONFIG.map.markerUrl, function(data) {
      // console.log(data);
        var markerss = data.map(function(business) {
                var icon = getMarkerIcon(business.usage.color);

                var contentString = '<div id="content">'+
                  '<h1 id="firstHeading" class="firstHeading">'+business.business.name+'</h1>'+
                  '<div id="bodyContent">'+
                  //'<p>'business.usage.parent' : 'business.usage.name '</p>'+
                  '<p> Adresse: '+business.business.address+' im '+business.business.addressInfo+'</p>'+

                  '</div>'+
                  '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });


                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(business.lat, business.lng),
                    map     : map,
                    title   : business.business.name,
                    icon    : icon
                });

                // var oms = new OverlappingMarkerSpiderfier(map);
                //
                // var iw = new google.maps.InfoWindow();
                //
                // oms.addListener('click', function(marker) {
                //   iw.setContent(marker.desc);
                //   iw.open(map, marker);
                // });
                // oms.addListener('spiderfy', function(markers) {
                //   for(var i = 0; i < markers.length; i ++) {
                //     markers[i].setIcon(iconWithColor(spiderfiedColor));
                //     markers[i].setShadow(null);
                //   }
                //   iw.close();
                // });
                // oms.addListener('unspiderfy', function(markers) {
                //   for(var i = 0; i < markers.length; i ++) {
                //     markers[i].setIcon(iconWithColor(usualColor));
                //     markers[i].setShadow(shadow);
                //   }
                // });
                //
                // var bounds = new google.maps.LatLngBounds();
                // for (var i = 0; i < window.mapData.length; i ++) {
                //
                //   bounds.extend(loc);
                //   var marker = new google.maps.Marker({
                //         position: new google.maps.LatLng(business.lat, business.lng),
                //         map     : map,
                //         title   : business.business.name,
                //         icon    : icon
                //   });
                //   marker.desc = datum.d;
                //   oms.addMarker(marker);
                // }
                // map.fitBounds(bounds);


                marker.addListener('click', function() {
                  infowindow.open(map, marker);
                });

                return marker;

            });

        //     markerCluster = new MarkerClusterer(map, markers, {
        //         gridSize: 50,
        //         maxZoom: 13,
        //         styles: [
        //             {
        //                 height: 53,
        //                 url: CONFIG.map.clusterImages[0],
        //                 width: 53
        //             },
        //             {
        //                 height: 56,
        //                 url: CONFIG.map.clusterImages[1],
        //                 width: 56
        //             },
        //             {
        //                 height: 66,
        //                 url: CONFIG.map.clusterImages[2],
        //                 width: 66
        //             },
        //             {
        //                 height: 78,
        //                 url: CONFIG.map.clusterImages[3],
        //                 width: 78
        //             },
        //             {
        //                 height: 90,
        //                 url: CONFIG.map.clusterImages[4],
        //                 width: 90
        //         }]
        //     })
        // ;
    });


}

google.maps.event.addDomListener(window, 'load', initialize);
