<?

$conecta=mysqli_connect('localhost','ambio802_kopp','fgvfgv','ambio802_transparencia') or die('Erro ao conectar BD');
set_time_limit(0);


$csv = array();
$lines = file('classifica.csv', FILE_IGNORE_NEW_LINES);

foreach ($lines as $key => $value)
{
    $csv[$key] = str_getcsv($value,";");
}

$array=array();

foreach ($csv as $linha){
$array[$linha[0]]=$linha[3];
}


// echo '<pre>';
// print_r($array);
// echo '</pre>';

$get = 'SELECT link,hash,content_pdf,nota,grau FROM BUSCA_RESULTADO WHERE nota=0 LIMIT 0,900';
$result=mysqli_query($conecta,$get) or die ('Erro ao pegar keyword');
while($row=mysqli_fetch_array($result)){

	$texto = $row[content_pdf]; 
	$texto = html_entity_decode($texto, ENT_QUOTES, "UTF-8");
	$texto = str_replace("'","", $texto); 
	$texto = preg_replace('/[^A-Za-z\sàáéíóúãõçèÁÉÍÓÚÃÕ]/', ' ', $texto);
	$texto = preg_replace('/\s\s+/', ' ', $texto);
	$texto = preg_replace('/\r|\n/', ' ', $texto);
	$texto = strtolower($texto);

	$content = explode(" ",$texto);
	
	$grau=0;
	$total=1;
	foreach($content as $word){
		if(strlen($word)>3){
			if($array[$word]<>NULL){
				$total+=abs($array[$word]);
				$grau+=$array[$word];
			}
		}
	}





$up = "UPDATE BUSCA_RESULTADO SET grau=".$grau/$total." WHERE hash='".$row[hash]."'";
echo $grau/$total.";".$row[link]."<br>";
mysqli_query($conecta,$up);
}

