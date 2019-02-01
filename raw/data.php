<?php 

function writedata($path, $data, $mode="w"){
   $fh = fopen($path, $mode) or die($path);
   fwrite($fh,$data . "\n");
   fclose($fh);
   chmod($path, 0777);
}

$pozos = file('capitulo-iv-pozos.csv');
$str = '';
foreach($pozos as $i => $line){
	if($i){
		$parts = explode(',',$line);
		$features[]= '{
	  "type": "Feature",
	  "geometry": {
	    "type": "Point",
	    "coordinates": [
	      ' . $parts[3] . ',
	      ' . $parts[4] . '
	    ]
	  },
	  "properties": {
	    "name": "' . str_replace(['"','-',"\t"],'',$parts[2]) . '",
	    "description": "' . str_replace(['"','-',"\t"],'',$parts[1]) . '"
	  }
	}';
	}
}

$data = '{
  "type": "FeatureCollection",
  "features": [
  	' . implode(',',$features) . '
  ]
}
';

\writedata( __DIR__ . "/../static/pozos.geojson",$data); 