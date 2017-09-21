<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="site.css">
</head>
<body>


<? 


if(isset($_GET['q'])) {
$placeholder=$_GET['q'];}else{
$placeholder="Faça sua busca";

echo '<center><img width="20%" src="http://isbe.com.br/wp-content/uploads/2015/09/Logo-FGV-sozinho.png">';




} 
	
	
echo '<form action="index2.php"  method="get"><label>Buscador FGV: </label><input type="text" id="q" name="q" placeholder="'.$placeholder.'" required> <input type="submit" value="Pesquisa" /> </form></center>';

if(isset($_GET['q'])) {
	$texto=$_GET['q'];
	//echo "Procurando para: ".htmlspecialchars($_GET['q']);
	 
	
	$google=file_get_contents("http://www.google.com.br/search?q=".urlencode($texto));
	$google=explode('<ol>',$google,2);
	$google="<ol>".$google[1];
	$google=explode('</ol>',$google,2);
	$google=$google[0].'</ol>';
    $google= preg_replace('/<table[\s\S]+?table>/i', ' ', $google); 
    $google= preg_replace('/<a class="_Zkb"[\s\S]+?a>/i', ' ', $google); 
   	$google=str_replace('/url?q=','',$google);
	$google=str_replace('&amp;sa=','"><"',$google);
	$google=strip_tags($google,"<a><h3><cite>");
	$google=str_replace('</cite>','</cite><br>',$google);
	
	 
	$bing=file_get_contents("http://www.bing.com/search?q=".urlencode($texto)."&pq=".urlencode($texto)."&go=Enviar&qs=n&form=QBLH&cc=br&cvid=23A92EB34E6648ABA08ABA125F03399D");
	
//	$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, "http://www.bing.com/search?q=".$texto."&go=Enviar&qs=n&form=QBLH&cc=br");
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//$bing=curl_exec($ch);
//curl_close($ch);
	$bing= preg_replace('/<ul[\s\S]+?ul>/i', ' ', $bing);  
	$bing=explode('<ol id="b_results"',$bing,2);
		$bing=explode('>',$bing[1],2);
	$bing=$bing[1];
	$bing=explode('<li class="b_pag">',$bing,2);
	$bing=$bing[0];

	$bing= preg_replace('/\<li class="b_ad"\>+?\<li class="b_algo"\>/i', '<li class="b_algo">', $bing); 
   $bing=str_replace('<li','<h3 ',$bing);
	$bing=str_replace('<cite>','</h3><cite>',$bing);
$bing=strip_tags($bing,"<a><h3><img><cite>");
$bing=str_replace('</cite>','</cite><br>',$bing);
	$bing=str_replace('</a>','</a><br>',$bing);
		
	//print_r($bing);
	
	
echo '<table align="top"><tr><td width="50%">'.$google.'</td><td width="50%">'.$bing.'</td></tr></table>';
	
	
}