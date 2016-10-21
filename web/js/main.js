var gm = google.maps;
var map, oms, iw;

var businesses;
var filters = [];


function getInfoWindowContent(business) {
    // TODO
    return '<div>' +
            '<h1>' + business.business.name + '</h1>' +
        '</div>'
    ;
}

function getMarkerIcon(color) {
    color = color || '#000';

    var circle = 'M-8,0a8,8 0 1,0 16,0a8,8 0 1,0 -16,0';

    return {
        path       : circle,
        strokeColor: color,
        fillColor  : color,
        fillOpacity: 1,
        size       : gm.Size(16, 16),
        origin     : new gm.Point(0, 0),
        anchor     : new gm.Point(0, 0)
    };
}


function filterDataForCategorySelect(data) {
    return _(data)
        .uniqBy(function(business) {
            return business.usage.id;
        })
        .map(function(business) {
            return {
                id  : business.usage.id,
                text: business.usage.name
            };
        })
        .sortBy('text')
        .value()
    ;
}

function removeFilter(filter) {
    if (_.includes(filters, filter)) {
        filters = _.without(filters, filter);
        updateBusinessPartition();
    }
}

function addFilter(filter) {
    if (!_.includes(filters, filter)) {
        filters.push(filter);
        updateBusinessPartition();
    }
}

function clearFilters() {
    filters = [];
    updateBusinessPartition();
}

function getActiveFilters() {
    var active = filters;
    var hasUsageFilter = _.some(filters, function(filter) {
        return filter.constructor === UsageFilter;
    });

    if (hasUsageFilter) {
        active = _.reject(active, function(filter) {
            return filter.constructor === InverseCategoryFilter;
        });
    }

    return active;
}

function separateSomeAndEveryFilters(filters) {
    var partition = _.partition(filters, { type: 'some' });

    return {
        'some' : partition[0],
        'every': partition[1]
    };

    return filters;
}

function applyFilters(businesses, filters) {
    var type = filters[0].type;

    return _.partition(businesses, function(business) {
        return _[type](filters, function(filter) {
            return filter.match(business);
        });
    });
}

function showMarker(business) {
    business.marker.setMap(map);
    oms.addMarker(business.marker);
}

function hideMarker(business) {
    business.marker.setMap(null);
    oms.removeMarker(business.marker);
}

function updateInfo(businesses) {
    var
        $visible  = $('.js-info-visible'),
        $outdoor  = $('.js-info-visible-with-outdoor'),
        $seats    = $('.js-info-outdoor-seats'),
        $bartable = $('.js-info-outdoor-bartable'),
        $togo     = $('.js-info-visible-togo')
    ;

    var
        businessesWithOutdoor = _.filter(businesses, function(business) {
            return !!business.business.outdoor_area;
        }),
        businessesWithToGo = _.filter(businesses, function(business) {
            return business.business.to_go;
        })
    ;

    var
        seats = _.reduce(businessesWithOutdoor, function(result, business) {
            return result + business.business.outdoor_area.seats;
        }, 0),
        bartablePlaces = _.reduce(businessesWithOutdoor, function(result, business) {
            return result + business.business.outdoor_area.bartable_places;
        }, 0)
    ;

    $visible.text(businesses.length);
    $outdoor.text(businessesWithOutdoor.length);
    $seats.text(seats);
    $bartable.text(bartablePlaces);
    $togo.text(businessesWithToGo.length);
}

function updateBusinessPartition() {
    var partition;
    var visible = [], hidden = [];

    var filters = separateSomeAndEveryFilters(getActiveFilters());


    if (filters.some.length) {
        partition = applyFilters(businesses, filters.some);

        visible = partition[0];
        hidden  = partition[1];
    } else {
        visible = businesses;
    }


    if (filters.every.length) {
        partition = applyFilters(visible, filters.every);

        visible = partition[0];
        hidden  = hidden.concat(partition[1]);
    }


    _.forEach(visible, showMarker);
    _.forEach(hidden, hideMarker);

    updateInfo(visible);
}

function handleLegendItemClicked(e) {
    var $el = $(e.currentTarget);
    var filter;

    if ($el.hasClass('icon--inactive')) {
        filter = $el.data('filter');

        removeFilter(filter);

        $el.removeData('filter');
        $el.removeClass('icon--inactive');
    } else {
        filter = new InverseCategoryFilter($el.data('id'));

        addFilter(filter);

        $el.addClass('icon--inactive');
        $el.data('filter', filter);
    }
}

function handleCategorySelected(event) {
    var filter = new UsageFilter(event.params.data.id);

    addFilter(filter);
}

function handleCategoryUnselected(event) {
    var filter = _.find(filters, function(filter) {
        if (filter instanceof UsageFilter) {
            return filter.id === parseInt(event.params.data.id, 10);
        }

        return false;
    });

    removeFilter(filter);
}

function handleAttributeSelected(event) {
    var filter = new AttributeFilter(event.params.data.id);

    addFilter(filter);
}

function handleAttributeUnselected(event) {
    var filter = _.find(filters, function(filter) {
        if (filter instanceof AttributeFilter) {
            return filter.name === event.params.data.id;
        }

        return false;
    });

    removeFilter(filter);
}


function initialize() {
    map = new gm.Map(
        document.getElementById('map-canvas'),
        {
            center          : { lat: 53.549535, lng: 9.962462},
            zoom            : 17,
            disableDefaultUI: true,
            styles          : [ {"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#0c0b0b"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#090909"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#d4e4eb"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#fef7f7"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9b7f7f"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#fef7f7"}]} ]
        }
    );


    // add bid boundaries
    map.data.loadGeoJson(GEOJSON);


    // oms initialization with listener
    iw  = new gm.InfoWindow();
    oms = new OverlappingMarkerSpiderfier(map, {
        markersWontMove: true,
        markersWontHide: true
    });

    oms.addListener('click', function(marker) {
        iw.setContent(getInfoWindowContent(marker.business));
        iw.open(map, marker);
    })

    oms.addListener('spiderfy', function(markers) {
        iw.close();
    });


    // add legend listener
    $('.legend__item .icon').on('click', handleLegendItemClicked);


    // initial load of all businesses
    $.get(CONFIG.map.markerUrl, function(data) {
        var categorySelect = $('.js-category-select').select2({
            data: filterDataForCategorySelect(data)
        });
        var attributeSelect = $('.js-attribute-select').select2();

        categorySelect.on('select2:select', handleCategorySelected);
        categorySelect.on('select2:unselect', handleCategoryUnselected);
        attributeSelect.on('select2:select', handleAttributeSelected);
        attributeSelect.on('select2:unselect', handleAttributeUnselected);


        businesses = data.map(function(business) {
            var marker = new gm.Marker({
                position: new gm.LatLng(business.lat, business.lng),
                map     : map,
                title   : business.business.name,
                icon    : getMarkerIcon(business.usage.color)
            });

            oms.addMarker(marker);

            // bidirectional one-to-one reference
            marker.business = business;
            business.marker = marker;

            return business;
        });

        updateInfo(businesses);
    });


}


// filter
function InverseCategoryFilter(id) {
    var that = this;

    this.id   = parseInt(id, 10);
    this.type = 'every';

    this.match = function(business) {
        if (that.id === business.usage.id) {
            return false;
        }

        if (
            business.usage.parent
            && that.id === business.usage.parent.id
        ) {
            return false;
        }

        return true;
    }
}

function UsageFilter(id) {
    var that = this;

    this.id   = parseInt(id, 10);
    this.type = 'some';

    this.match = function(business) {
        if (that.id === business.usage.id) {
            return true;
        }

        return false;
    }
}

function AttributeFilter(name) {
    var that = this;

    this.name = name;
    this.type = 'every';

    this.match = function(business) {
        if (_.has(business.business, that.name)) {
            return !!business.business[that.name];
        }

        return false;
    }
}


gm.event.addDomListener(window, 'load', initialize);
