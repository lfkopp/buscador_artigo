<!DOCTYPE html>
		
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

	<title> Crawler</title>

<?
//$json_data=file_get_contents('data.json');
//$json_data=json_encode($json_data,TRUE);
//echo "<pre>";
//print_r($json_data);

?>

  <script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.1', {packages: ['controls']});
    </script>
    <script type="text/javascript">
	
    function drawVisualization() {
      // Create and populate the data table.
      var data = google.visualization.arrayToDataTable([['nota','grau','host','texto','nota2'],

	    
		
		

<? 


$conecta=mysqli_connect('localhost','ambio802_kopp','fgvfgv','ambio802_transparencia') or die('Erro ao conectar BD');
set_time_limit(0);

if(isset($_GET[num])){
$num=$_GET[num];}else{
	$num=25000;
}



function nota($nota,$hash) {
$seta_up = "<a href=seta.php?dir=up&hash=".$hash." target=_blank><img src=up.png height=20></a>";
$seta_down = "<a href=seta.php?dir=down&hash=".$hash." target=_blank><img src=down.png height=20></a>";
$texto="";
if($nota<1) $texto.=" ".$seta_up;
if($nota>-1) $texto.=$seta_down;

   return $texto; 
}
		

function clean($string) {
	$string = html_entity_decode($string, ENT_QUOTES, "UTF-8");
	$string = str_replace("'","", $string); 
	$string = preg_replace('/[^A-Za-z0-9\säáàëéèíìöóòúùñç\/\.\,\:\&\%\?\=\+\-\;]/', '', $string);
	$string = preg_replace('/\s\s+/', ' ', $string);
	$string = preg_replace('/\r|\n/', ' ', $string);
	$string = preg_replace('/\.+/','.', $string);
   return $string; // Removes special chars.
}		





$cont=1;
$get = 'SELECT * FROM BUSCA_RESULTADO WHERE 1 order by abs(nota) asc, grau desc limit 0,'.$num;
$result=mysqli_query($conecta,$get) or die ('Erro ao pegar resultado');
while($row=mysqli_fetch_array($result)){
//echo "[".$cont++.",".$row[nota].",".$row[website]."<div style='height:60px; overflow-y: auto; max-width: 250px; word-wrap:break-word;'>".$row[link]."</div>,<div style='height:60px; overflow-y: auto;'>".$row[content_pdf]."],";
$temp = '<div style="max-height:80px; overflow-y: auto;  word-wrap:break-word;">';
$hash=$row["hash"];
echo "['".nota($row[nota],$hash)."',".$row[grau].",'".$row[website]."','<a href=".$row[link]." target=_blank>".$row[link]."</a><br>".$temp.clean($row[content_pdf])."</div>',".$row[nota]."],";


}

?>

 ]);
	  
	  
	  
    // Define a StringFilter control for the 'Name' column
        var stringFilter = new google.visualization.ControlWrapper({
          'controlType': 'StringFilter',
          'containerId': 'control1',
          'options': {
            'filterColumnLabel': 'texto',
			'matchType':'any'
			          }
	  
        });
	
		var categoryPicker = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'control2',
		  	'state': {'selectedValues': ['0']},
          'options': {
            'filterColumnLabel': 'nota2',
            'ui': {
            'labelStacking': 'vertical',
              'allowTyping': false,
              'allowMultiple': false,
			  'caption' : 'nota',
			    'label' : ''
            }
          }
        });
				var categorystatus = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'control3',

          'options': {
            'filterColumnLabel': 'host',
            'ui': {
            'labelStacking': 'vertical',
              'allowTyping': false,
              'allowMultiple': true,
			  'caption' : 'host',

			    'label' : ''
            }
          }
        });
       // Define a table
	   
	 
	 
        var table = new google.visualization.ChartWrapper({
          'chartType': 'Table',
          'containerId': 'chart1',
          'options': {
				'width': '85%',
				'pageSize':	'28',
				'allowHtml': 'true'},
		'view':{'columns':[0,1,2,3]}
        });
      
        // Create a dashboard
        new google.visualization.Dashboard(document.getElementById('dashboard')).
            // Establish bindings, declaring the both the slider and the category
            // picker will drive both charts.
            bind([stringFilter, categoryPicker,categorystatus], [table]).
            // Draw the entire dashboard.
            draw(data);
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  
<body>
grau - grau de semelhança com uma auditoria.<br>
-1 = mais parecido com o que não é auditoria.<br>
+1 = mais parecido com auditoria.<br>
<center>


<div id="dashboard">
<div  id="control1" style="display: inline-block"></div>
<div  id="control2" style="display: inline-block"></div>
<div  id="control3" style="display: inline-block"></div>
 <p>
<div  id="chart1"></div>
      
    </div>
</center>
<?


echo "<p><b>Palavras pesquisadas:</b><br>";
$get = 'SELECT keyword FROM BUSCA_PESQUISA WHERE 1 order by keyword asc';
$result=mysqli_query($conecta,$get) or die ('Erro ao pegar keyword');
while($row=mysqli_fetch_array($result)){
	echo "<b>".$row[keyword]."</b> // ";
}


echo $num;
?> 

<br>
<a href="busca.php" target=_blank>busca.php</a><br>
<a href="classifica.php" target=_blank>classifica.php</a><br>
<a href="grau.php" target=_blank>grau.php</a><br>
<a href="data.json" target=_blank>data.json</a><br>
<a href="classifica.csv" target=_blank>classifica.csv</a><br>
</body>
</html>













	