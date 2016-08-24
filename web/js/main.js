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
        center          : { lat: 53.554084, lng: 9.955185},
        zoom            : 15,
        disableDefaultUI: true,
        styles          : [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#0c0b0b"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#090909"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d4e4eb"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#fef7f7"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9b7f7f"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#fef7f7"}]}]
    };

    var map = new google.maps.Map(
        document.getElementById('map-canvas'),
        mapOptions
    );

    // var districtArea = [{lat: 9.956129517115954, lng: 53.550109332291285 }, {lat: 9.956262617497353, lng: 53.550412461759429 }, {lat: 9.956517726561701, lng: 53.55035974374703 }, {lat: 9.956617551847753, lng: 53.550570615402577 }, {lat: 9.956817202419851, lng: 53.550531077047211 }, {lat: 9.956961394499704, lng: 53.550867151890429 }, {lat: 9.956806110721402, lng: 53.550880331241665 }, {lat: 9.956972486198152, lng: 53.551176865559242 }, {lat: 9.95781545528035, lng: 53.551117558861968 }, {lat: 9.957848730375698, lng: 53.551236172173411 }, {lat: 9.958547507378047, lng: 53.551216403311251 }, {lat: 9.958503140584249, lng: 53.550965996924624 }, {lat: 9.958414406996647, lng: 53.550985765903761 }, {lat: 9.958370040202848, lng: 53.550867151890429 }, {lat: 9.958492048885796, lng: 53.550847382855892 }, {lat: 9.958492048885796, lng: 53.550498128389506 }, {lat: 9.959468118349395, lng: 53.550517897587198 }, {lat: 9.959501393444746, lng: 53.550129101670606 }, {lat: 9.959689952318394, lng: 53.550129101670606 }, {lat: 9.959689952318394, lng: 53.549964356560714 }, {lat: 9.960011611573444, lng: 53.549964356560714 }, {lat: 9.960222353843992, lng: 53.54992481763891 }, {lat: 9.960455279511443, lng: 53.54992481763891 }, {lat: 9.96046082536067, lng: 53.550326794955936 }, {lat: 9.960832397258741, lng: 53.550320205194637 }, {lat: 9.960876764052543, lng: 53.549977536193119 }, {lat: 9.960876764052543, lng: 53.549911637990107 }, {lat: 9.961209515006043, lng: 53.549911637990107 }, {lat: 9.961464624070391, lng: 53.549845739684478 }, {lat: 9.964015714713884, lng: 53.550056613901269 }, {lat: 9.964026806412333, lng: 53.550142281251702 }, {lat: 9.96434291981816, lng: 53.550148871040712 }, {lat: 9.964387286611961, lng: 53.550063203703615 }, {lat: 9.965252439091058, lng: 53.550102742496129 }, {lat: 9.965307897583308, lng: 53.550412461759429 }, {lat: 9.966017766284105, lng: 53.550438820741 }, {lat: 9.966062133077907, lng: 53.55016205061564 }, {lat: 9.966173050062405, lng: 53.550194999535009 }, {lat: 9.966184141760856, lng: 53.550155460828684 }, {lat: 9.966583442905055, lng: 53.550188409753183 }, {lat: 9.966561259508156, lng: 53.550419051506367 }, {lat: 9.967692612750053, lng: 53.550425641252268 }, {lat: 9.967659337654704, lng: 53.550886920915751 }, {lat: 9.967770254639204, lng: 53.550946227936265 }, {lat: 9.969045799960952, lng: 53.55095281760007 }, {lat: 9.969079075056301, lng: 53.550900100260812 }, {lat: 9.969489467898951, lng: 53.55072217875599 }, {lat: 9.96957820148655, lng: 53.550616743437175 }, {lat: 9.96955601808965, lng: 53.550557435954907 }, {lat: 9.969445101105149, lng: 53.550524487317716 }, {lat: 9.96935636751755, lng: 53.550504718123108 }, {lat: 9.969378550914451, lng: 53.549937997283614 }, {lat: 9.968812874293503, lng: 53.549937997283614 }, {lat: 9.968491215038451, lng: 53.549384448671887 }, {lat: 9.968025363703553, lng: 53.548949512540375 }, {lat: 9.967570604067104, lng: 53.548923152631168 }, {lat: 9.966583442905057, lng: 53.548844072805046 }, {lat: 9.966439250825209, lng: 53.549456937592559 }, {lat: 9.96545208966316, lng: 53.549364678944698 }, {lat: 9.965596281743009, lng: 53.548771582834611 }, {lat: 9.964570299636385, lng: 53.548764992831138 }, {lat: 9.964492657747238, lng: 53.548995642341986 }, {lat: 9.964093356603035, lng: 53.548956102515113 }, {lat: 9.964137723396837, lng: 53.548870432763493 }, {lat: 9.963771697347989, lng: 53.548863842775418 }, {lat: 9.963838247538687, lng: 53.548732042798399 }, {lat: 9.96327257091774, lng: 53.548738632807009 }, {lat: 9.963239295822389, lng: 53.54881771283015 }, {lat: 9.962895453170439, lng: 53.548791352838862 }, {lat: 9.962895453170439, lng: 53.548718862778124 }, {lat: 9.962684710899889, lng: 53.548712272766451 }, {lat: 9.962740169392141, lng: 53.548527752022849 }, {lat: 9.962995278456489, lng: 53.54854093210264 }, {lat: 9.963050736948739, lng: 53.548105987302172 }, {lat: 9.96252942712159, lng: 53.548086216977765 }, {lat: 9.962562702216939, lng: 53.547858857583229 }, {lat: 9.961209515006043, lng: 53.547812726542546 }, {lat: 9.961142964815341, lng: 53.548201543739964 }, {lat: 9.960688205178894, lng: 53.548194953647723 }, {lat: 9.960754755369592, lng: 53.547964299773156 }, {lat: 9.960377637622294, lng: 53.547872037871336 }, {lat: 9.959945061382744, lng: 53.548419016207923 }, {lat: 9.960211262145544, lng: 53.548682617701203 }, {lat: 9.959789777604446, lng: 53.548801237837523 }, {lat: 9.959379384761796, lng: 53.548860547781004 }, {lat: 9.95949584759552, lng: 53.549104376675395 }, {lat: 9.958841437386974, lng: 53.549236175492865 }, {lat: 9.958641786814873, lng: 53.548913267660993 }, {lat: 9.958486503036573, lng: 53.548933037599049 }, {lat: 9.958353402655174, lng: 53.549071426906899 }, {lat: 9.958353402655174, lng: 53.549367973899869 }, {lat: 9.958031743400126, lng: 53.549308664667507 }, {lat: 9.957843184526475, lng: 53.549400923437481 }, {lat: 9.957643533954377, lng: 53.549295484826807 }, {lat: 9.957277507905527, lng: 53.549526131446477 }, {lat: 9.956129517115954, lng: 53.550109332291285 }];
    // var district = new google.maps.Polyline({
    //   paths: districtArea,
    //   strokeColor: '#000000',
    //   strokeOpacity: 0.8,
    //   strokeWeight: 2,
    //   fillColor: '#000000',
    //   fillOpacity: 0.35
    // });
    // district.setMap(map);

    map.data.loadGeoJson('js/bid.geojson');

    $.get(CONFIG.map.markerUrl, function(data) {
      // console.log(data);
        var markers = data.map(function(business) {
                icon = getMarkerIcon(business.usage.color);

                return new google.maps.Marker({
                    position: new google.maps.LatLng(business.lat, business.lng),
                    map     : map,
                    title   : business.usage.name,
                    icon    : icon
                });
            }),

            markerCluster = new MarkerClusterer(map, markers, {
                gridSize: 50,
                maxZoom: 13,
                styles: [
                    {
                        height: 53,
                        url: CONFIG.map.clusterImages[0],
                        width: 53
                    },
                    {
                        height: 56,
                        url: CONFIG.map.clusterImages[1],
                        width: 56
                    },
                    {
                        height: 66,
                        url: CONFIG.map.clusterImages[2],
                        width: 66
                    },
                    {
                        height: 78,
                        url: CONFIG.map.clusterImages[3],
                        width: 78
                    },
                    {
                        height: 90,
                        url: CONFIG.map.clusterImages[4],
                        width: 90
                }]
            })
        ;
    });


}

google.maps.event.addDomListener(window, 'load', initialize);
