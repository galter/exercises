<?php
    require 'simple_html_dom.php';
    $html = file_get_html('http://www.educacao.cc/escolas/particular-iguatu-ce');
?>    

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAv7zKRvNVfqXC0eU44PGnYTPCFe5-LXHg&amp;sensor=false"></script>
	<script src="https://code.jquery.com/jquery-3.1.0.min.js" type="text/javascript"></script>
</head>
<body>

<?php
    $count = 0; 
    // Find all images
    foreach($html->find('p') as $element) {
       $elemento = $element->outertext;
       echo  $elemento . "<br>\n";
       
       $endereco = explode('<br>', $elemento, -1);

       $enderecos[] = $endereco[1];

       $count++;
    }

    echo "Total: " . $count;
    echo json_encode($enderecos, JSON_FORCE_OBJECT);
?>

	<div id="mapa" style="height: 500px; width: 500px;"></div>

	<a href="#" onclick="carregaEnderecos()">TESTE</a>

<script>
	var geocoder;
	var map;
	var marker;
	 
	function initialize() {
	    var latlng = new google.maps.LatLng(-18.8800397, -47.05878999999999);
	    var options = {
	        zoom: 5,
	        center: latlng,
	        mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
	 
	    map = new google.maps.Map(document.getElementById("mapa"), options);
	 
	    geocoder = new google.maps.Geocoder();
	 
	    marker = new google.maps.Marker({
	        map: map,
	        draggable: true,
	    });
	 
	    marker.setPosition(latlng);
	}
	 
	$(document).ready(function () {
	    initialize();
	});	

	function carregaEnderecos() {
		var enderecos = <?php echo $enderecos?>;

	    alert(enderecos[0]);
	}
 
    function carregarNoMapa(endereco) {
        geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
 
             
 					return latitude + "|" + longitude;
                }
            }
        });
	}

</script>
	
</body>
</html>

