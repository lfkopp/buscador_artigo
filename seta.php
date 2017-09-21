<?
$conecta=mysqli_connect('localhost','ambio802_kopp','fgvfgv','ambio802_transparencia') or die('Erro ao conectar BD');
set_time_limit(0);

$dir = $_GET[dir];
$hash = $_GET[hash];


if($dir=="up") {
	$valor=1;
}else{
	$valor=-1;
}


$update = 'UPDATE `BUSCA_RESULTADO` SET `nota`="'.$valor.'" WHERE hash="'.$hash.'" ';
$result=mysqli_query($conecta,$update) or die ('Erro ao pegar keyword');

echo $result;
echo "<script>window.close();</script>";