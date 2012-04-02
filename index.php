<?php
/**
 * JAKIM esolat wrapper
 * 
 *
 * @author ibnuyahya <ibnuyahya@gmail.com>
 * @version 1.0
 * @since Apr 2, 2012
 * @link http://www.e-solat.gov.my/prayer_time.php?zon=JHR01&jenis=1
 * 
 * @copyright ibnuyahya.com
 * @license    GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * 
 */

class Esolat{
    const TODAY     = 0;
    const WEEKLY    = 1;
    const MONTHLY   = 2;
    const YEARLY    = 3;
    
    private $_esolatUrl  = 'http://www.e-solat.gov.my/prayer_time.php?zon={!ZONE}&jenis={!PERIOD}';
    private $_zone      = '';
    private $_period    = 0;
    
    
    public function __construct($zone = '',$period=2) {
        $this->_zone    = $zone;
        $this->_period  = $period;
    }
    
    public function fetchEsolatDom(){
        
    }
    
    
    
}

        /**
         * JAKIM esolat wrapper
         *
         * This class created for Educational purpose only. Use on your own risk!
         *
         *
         * @owner      http://ibnuyahya.com
         *
         * @version    1.0
         */
//        if (isset($_GET['kod'])) {
//            $kod = $_GET['kod'];
//            $data = file_get_contents('http://www.e-solat.gov.my/solat.php?kod=' . $kod);
//            $data = strip_tags($data, '<table><tr><td></td></tr></table>');
//            $data = str_replace("&nbsp;", "", $data);
//
//            $dom = new DOMDocument();
//            $dom->prevservWhiteSpace = false;
//            $dom->loadHTML($data);
//            $trs = $dom->getElementsByTagName('tr');
//            foreach ($trs as $tr) {
//                $td = $tr->getElementsByTagName('td');
//                $result = array();
//         @license    GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html        foreach ($td as $row) {
//                    $result[] = trim($row->nodeValue);
//                }
//                $results[] = $result;
//            }
//
//            $data = array();
//            $data['kawasan'] = $results[0][0];
//            $data['tarikh'] = trim($results[1][0], 'JAKIM');
//            $data['kiblat'] = mb_convert_encoding($results[3][1], "HTML-ENTITIES", "UTF-8");;
//            $data['gmt'] = $results[2][1];
//
//            $data['jadual'][$results[5][0]] = $results[5][1];
//            $data['jadual'][($results[6][0])] = $results[6][1];
//            $data['jadual'][($results[7][0])] = $results[7][1];
//            $data['jadual'][($results[8][0])] = $results[8][1];
//            $data['jadual'][($results[9][0])] = $results[9][1];
//            $data['jadual'][($results[10][0])] = $results[10][1];
//            $data['jadual'][($results[11][0])] = $results[11][1];
//
//
//            $json = json_encode($data);
//
//            if (isset($_GET['data']) && $_GET['data'] == 'json') {
//				header('Content-type: application/json');
//                echo $json;
//            } else if (isset($_GET['data']) && $_GET['data'] == 'array') {
//                echo '<pre>';
//                print_r($data);
//                echo '</pre>';
//                
//            }else if(isset($_GET['data']) && $_GET['data'] == 'xml'){
//
//header("Content-type:text/xml");
//
//
//$xml = new XmlWriter();
//$xml->openMemory();
//$xml->startDocument('1.0', 'UTF-8');
//$xml->startElement('esolat');
//
//function write(XMLWriter $xml, $data){
//    foreach($data as $key => $value){
//        if(is_array($value)){
//            $xml->startElement($key);
//            write($xml, $value);
//            $xml->endElement();
//            continue;
//        }
//        $xml->writeElement($key, $value);
//    }
//}
//$data['kiblat'] = mb_convert_encoding($data['kiblat'],"UTF-8", "HTML-ENTITIES");
//write($xml, $data);
//
//$xml->endElement();
//echo $xml->outputMemory(true);
//
//
//            } else {
//                $json = json_decode($json);
//                echo 'Jadual waktu solat bagi kawasan ' . $json->kawasan . ' ( arah kiblat ' . $json->kiblat . ' ) pada ' . $json->tarikh;
//                echo '<hr>';
//                foreach ($json->jadual as $key => $row) {
//                    echo $key . ' : ' . $row . '<br/>';
//                }
//            }
//        } else {
// 
//            echo '<h1>How To Use?</h1><br/>enter <br/>
//            - http://api.ibnuyahya.com/solat.php?kod=SGR03<br/>
//            - http://api.ibnuyahya.com/solat.php?kod=SGR03&data=json<br/>
//            - http://api.ibnuyahya.com/solat.php?kod=SGR03&data=xml<br/>
//            - http://api.ibnuyahya.com/solat.php?kod=SGR03&data=array';
//            echo '<br/>kod format, refer to this url http://www.e-solat.gov.my/e-solat.php';
//
//        }
        
        
        ?>
