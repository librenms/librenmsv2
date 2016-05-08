@extends('layouts.widget')

@section('content')
<div id="leaflet-map"></div>
@endsection

@section('scripts')
<script src="{{ url('js/plugins/leaflet/leaflet.js') }}"></script>
<script src="{{ url('js/plugins/leaflet/leaflet.markercluster-src.js') }}"></script>
<script src="{{ url('js/plugins/leaflet/leaflet.awesome-markers.min.js') }}"></script>
<script>

        var map = L.map('leaflet-map').setView([51.4800, 0], 2);
L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var markers = L.markerClusterGroup({
    maxClusterRadius: 80,
    iconCreateFunction: function (cluster) {
        var markers = cluster.getAllChildMarkers();
        var n = 0;
        newClass = "greenCluster marker-cluster marker-cluster-small leaflet-zoom-animated leaflet-clickable";
        for (var i = 0; i < markers.length; i++) {
            if (markers[i].options.icon.options.markerColor == "red") {
                newClass = "redCluster marker-cluster marker-cluster-small leaflet-zoom-animated leaflet-clickable";
            }
        }
        return L.divIcon({ html: cluster.getChildCount(), className: newClass, iconSize: L.point(40, 40) });
    },
  });
var redMarker = L.AwesomeMarkers.icon({
    icon: 'server',
    markerColor: 'red', prefix: 'fa', iconColor: 'white'
  });
var greenMarker = L.AwesomeMarkers.icon({
    icon: 'server',
    markerColor: 'green', prefix: 'fa', iconColor: 'white'
  });
        var title = '<a href="device/device=10/"><img src="images/os/linux.png" width="32" height="32" alt=""> 1.1.1.1</a>';
var tooltip = '1.1.1.1';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: redMarker, zIndexOffset: 10000});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=9/"><img src="images/os/linux.png" width="32" height="32" alt=""> 1.1.1.1</a>';
var tooltip = '1.1.1.1';
var marker = L.marker(new L.LatLng(50.085411, 14.454350), {title: tooltip, icon: redMarker, zIndexOffset: 10000});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=15/"><img src="images/os/linux.png" width="32" height="32" alt=""> 192.168.10.1</a>';
var tooltip = '192.168.10.1';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=7/"><img src="images/os/linux.png" width="32" height="32" alt=""> host3</a>';
var tooltip = 'host3';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=18/"><img src="images/os/linux.png" width="32" height="32" alt=""> hv02</a>';
var tooltip = 'hv02';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=6/"><img src="images/os/linux.png" width="32" height="32" alt=""> influx01</a>';
var tooltip = 'influx01';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=1/"><img src="images/os/linux.png" width="32" height="32" alt=""> localhost</a>';
var tooltip = 'localhost';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=3/"><img src="images/os/linux.png" width="32" height="32" alt=""> mysql01</a>';
var tooltip = 'mysql01';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=2/"><img src="images/os/linux.png" width="32" height="32" alt=""> proxy01</a>';
var tooltip = 'proxy01';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=5/"><img src="images/os/linux.png" width="32" height="32" alt=""> tools01</a>';
var tooltip = 'tools01';
var marker = L.marker(new L.LatLng(51.514397, -0.110893), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
var title = '<a href="device/device=17/"><img src="images/os/linux.png" width="32" height="32" alt=""> utm120.gardar.net</a>';
var tooltip = 'utm120.gardar.net';
var marker = L.marker(new L.LatLng(64.134674, -21.913813), {title: tooltip, icon: greenMarker, zIndexOffset: 0});
marker.bindPopup(title);
    markers.addLayer(marker);
map.addLayer(markers);
map.scrollWheelZoom.disable();
$(document).ready(function(){
    $("#leaflet-map").on("click", function(event) {
        map.scrollWheelZoom.enable();
    });
    $("#leaflet-map").mouseleave(function(event) {
        map.scrollWheelZoom.disable();
    });
});
</script>
@endsection
