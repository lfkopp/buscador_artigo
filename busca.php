<!DOCTYPE html>
<html>
<head>
</head>
<body>


<? 

include_once('pdf-to-txt.php');
$conecta=mysqli_connect('localhost','ambio802_kopp','fgvfgv','ambio802_transparencia') or die('Erro ao conectar BD');
set_time_limit(0);

//ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
$ok=0;
$no=0;

$pesquisas = array();
$get = 'SELECT keyword FROM BUSCA_PESQUISA WHERE 1 order by keyword asc';
$result=mysqli_query($conecta,$get) or die ('Erro ao pegar keyword');
while($row=mysqli_fetch_array($result)){
	$pesquisas[] = $row[keyword]; 
}
shuffle($pesquisas);

$agents[] = "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.7) Gecko/20091221 Firefox/3.5.7";
$agents[] = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)";
$agents[] = "Opera/9.80 (Windows NT 5.1; U; en) Presto/2.2.15 Version/10.10";
$agents[] = "Mozilla/4.0 (compatible; MSIE 6.0)";
$agents[] = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; WOW64; Trident/4.0; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; 360SE)";

$random = rand(0,5);
ini_set('user_agent', $agents[$random]);

	for($i=1;$i<20;$i+=10){
		print("<p>".$i);
foreach($pesquisas as $pesquisa){

	echo "<br>".$pesquisa."<br>";
	$texto=$pesquisa." filetype:pdf";
	// $texto = "transparencia auditoria lei de acesso informação";
		$site="google";
		// $ch = curl_init();
		//usleep(rand(1000000,2000000));
		// curl_setopt($ch, CURLOPT_URL, "http://www.google.com.br/search?q=".urlencode($texto)."&start=".$i);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_HEADER, 0);
		// $google=curl_exec($ch);
		// print($google);
		// curl_close($ch);
		$google=file_get_contents("http://www.google.com.br/search?q=".urlencode($texto)."&start=".$i);
		echo $google;
		if($google<>NULL){
			$google=explode('<ol>',$google,2);
			$google="<ol>".$google[1];
			$google=explode('</ol>',$google,2);
			$google=$google[0].'</ol>';
			$google=str_replace('/url?q=','',$google);
			$google=str_replace('&amp;sa=','"><"',$google);
			if(preg_match_all('/<a\s+href=["\']([^"\']+)["\']/i', $google, $links, PREG_PATTERN_ORDER)){
				$all_hrefs = array_unique($links[1]);
				foreach($all_hrefs as $href){
					$parse = parse_url($href);
					$host=$parse['host'];
					$hash = hash('sha256', $href);
					$add_dados = "INSERT INTO BUSCA_RESULTADO(link,website,hash)"."VALUES('".$href."','".$host."','".$hash."')";
					if(mysqli_query($conecta,$add_dados)){
						print($site.": ok ".$href."<br>");
						$ok++;
						$texto2=str_replace('"', "",str_replace("'", "", pdf2text($href)));
						$up = "UPDATE BUSCA_RESULTADO SET content_pdf='".htmlentities(utf8_encode($texto2))."' WHERE link='".$href."'";
						mysqli_query($conecta,$up);
					}else{
						print($site.": no ".$href."<br>");
						$no++;
					}
				}
			}		
		}


		$bing=file_get_contents("http://www.bing.com/search?q=".urlencode($texto)."&qs=n&form=QBRE&sp=-1&pq=".urlencode($texto)."&sc=0-21&sk=&cvid=DEC7B1C34D4644E98AEB305ACA216014&first=".$i."&FORM=PERE2");
		if($bing<>NULL){
			$site = "bing";
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
			if(preg_match_all('/<a\s+href=["\']([^"\']+)["\']/i', $bing, $links, PREG_PATTERN_ORDER)){
				$all_hrefs = array_unique($links[1]);
				foreach($all_hrefs as $href){
					$parse = parse_url($href);
					$host=$parse['host'];
					$hash = hash('sha256', $href);
					$add_dados = "INSERT INTO BUSCA_RESULTADO(link,website,hash)"."VALUES('".$href."','".$host."','".$hash."')";
					if(mysqli_query($conecta,$add_dados)){
						$ok++;
						print($site.": ok ".$href."<br>");
						$texto2=str_replace('"', "",str_replace("'", "", pdf2text($href)));
						$up = "UPDATE BUSCA_RESULTADO SET content_pdf='".htmlentities(utf8_encode($texto2))."' WHERE link='".$href."'";
						mysqli_query($conecta,$up);
					}else{
						print($site.": no ".$href."<br>");
						$no++;
					}
				}
			}
		}
		
		$scholar=file_get_contents("https://scholar.google.com.br/scholar?q=".urlencode($texto)."&start=".$i."&hl=pt-BR&as_sdt=1,5&as_vis=1");
		$site="Scholar";
		if($scholar<>NULL){
			if(preg_match_all('/<a\s+href=["\']([^"\']+)["\']/i', $scholar, $links, PREG_PATTERN_ORDER)){
				$all_hrefs = array_unique($links[1]);
				foreach($all_hrefs as $href){
					if((substr($href, -3)=="pdf")&&(substr($href,0,4)=="http")){
						$parse = parse_url($href);
						$host=$parse['host'];
						$hash = hash('sha256', $href);
						$add_dados = "INSERT INTO BUSCA_RESULTADO(link,website,hash)"."VALUES('".$href."','".$host."','".$hash."')";
						if(mysqli_query($conecta,$add_dados)){
							print($site.": ok ".$href."<br>");
							$ok++;
							$texto2=str_replace('"', "",str_replace("'", "", pdf2text($href)));
							$up = "UPDATE BUSCA_RESULTADO SET content_pdf='".htmlentities(utf8_encode($texto2))."' WHERE link='".$href."'";
							mysqli_query($conecta,$up);
						}else{
							print($site.": no ".$href."<br>");
							$no++;
						}
					}
				}
			}		
		}
		
	}
}

	
print("ok: ".$ok." no: ".$no);