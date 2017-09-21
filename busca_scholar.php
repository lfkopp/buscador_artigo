<?
include_once('pdf-to-txt.php');
$conecta=mysqli_connect('localhost','ambio802_kopp','fgvfgv','ambio802_transparencia') or die('Erro ao conectar BD');
set_time_limit(0);
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');


//$scholar=@file_get_contents("http://www.google.com.br/search?q=".urlencode($texto)."&start=".$i);
$scholar=@file_get_contents("https://scholar.google.com.br/scholar?start=10&q=transparency+evaluation+response+rate+filetype:pdf&hl=pt-BR&as_sdt=1,5&as_vis=1");

if(preg_match_all('/<a\s+href=["\']([^"\']+)["\']/i', $scholar, $links, PREG_PATTERN_ORDER)){
				$all_hrefs = array_unique($links[1]);
				foreach($all_hrefs as $href){
				$parse = parse_url($href);
				$host=$parse['host'];
				if((substr($href, -3)=="pdf")&&(substr($href,0,4)=="http")){
				//$scholar2=pdf2text($href);
				echo "<br>";
				print_r($href);
				
				}
				}
}
