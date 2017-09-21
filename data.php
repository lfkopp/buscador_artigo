<?
$conecta=mysqli_connect('localhost','ambio802_kopp','fgvfgv','ambio802_transparencia') or die('Erro ao conectar BD');
set_time_limit(0);
header('Content-Type: application/json');
$data=array();
$row2 = ['nota','host','texto','nota2'];
$data[]= $row2;


$get = 'SELECT * FROM BUSCA_RESULTADO WHERE 1 order by horario desc LIMIT 0,10  ';
$result=mysqli_query($conecta,$get) or die ('Erro ao pegar resultado');
while($row=mysqli_fetch_array($result)){
$temp = '<div style="height:80px; overflow-y: auto;  word-wrap:break-word;">';
$hash=$row["hash"];
$row2=array();
$row2[]= nota($row[nota],$hash);
$row2[]= $row[website];
$row2[]= '<a href="'.$row[link].'" target=_blank>"'.clean($row[link]).'"</a><br>"'.$temp.clean($row[content_pdf]).'"</div>';
$row2[]= $row[nota];
$data[]=$row2;
}

print_r(json_encode($data));

$file=fopen('data.json','w');
fwrite($file, json_encode($data));
fclose($file);

function nota($nota,$hash) {
$seta_up = "<a href=seta.php?dir=up&hash=".$hash." target=_blank>up</a>";
$seta_down = "<a href=seta.php?dir=down&hash=".$hash." target=_blank>down</a>";
$texto="";
if($nota<1) $texto.=" ".$seta_up;
if($nota>-1) $texto.=$seta_down;

   return $texto; 
}
		

function clean($string) {
	$string = html_entity_decode($string, ENT_QUOTES, "UTF-8");
	$string = str_replace("'","", $string); 
	$string = preg_replace('/[^A-Za-z0-9\sàáéíóúãõçèÁÉÍÓÚÃÕ\/\.\,\:\&\%\?\=\+\-\;]/', '', $string);
	$string = preg_replace('/\s\s+/', ' ', $string);
	$string = preg_replace('/\r|\n/', ' ', $string);
   return $string; // Removes special chars.
}		

