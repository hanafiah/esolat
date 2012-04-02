<?php

/**
 * JAKIM's esolat wrapper
 * Wrap and convert jakim's esolat html data into text delimiter, json and xml 
 *
 * @author      ibnuyahya <ibnuyahya@gmail.com>
 * @version     1.0
 * @since       Apr 2, 2012
 * @link        http://www.e-solat.gov.my/prayer_time.php?zon=JHR01&jenis=1
 * 
 * @copyright   ibnuyahya.com
 * @license     GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * 
 * You are premit to do whatever you want with this code. Spread it or fork it  
 * from my github, 
 *      https://github.com/hanafiah/esolat
 * 
 */
class Esolat {
    const TODAY = 0;
    const WEEKLY = 1;
    const MONTHLY = 2;
    const YEARLY = 3;

    private $_esolatUrl = 'http://www.e-solat.gov.my/prayer_time.php?zon={!ZONE}&jenis={!PERIOD}&bulan={!MONTH}&LG=BM&year=';
    private $_zone;
    private $_period;
    private $_timeout;
    private $_tables; // table dom
    private $_month = 0;

    public function __construct($zone = 'jhr02', $period=2, $timeout = 120) {
        $this->_zone = $zone;
        $this->_period = $period;
        $this->_timeout = $timeout;
    }

    public function fetchEsolatDom() {
        $this->_esolatUrl = str_replace('{!ZONE}', $this->_zone, $this->_esolatUrl);
        $this->_esolatUrl = str_replace('{!PERIOD}', $this->_period, $this->_esolatUrl);
        $this->_esolatUrl = str_replace('{!MONTH}', $this->_month, $this->_esolatUrl);
        $ch = curl_init($this->_esolatUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, ''); //handle all encodings

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        $output = false;
        try {
            $output = curl_exec($ch);
            preg_match("~<body[^>]*>(.*?)</body>~si", $output, $output);
            $output = $output[1];
            curl_close($ch);
        } catch (Exception $e) {
            exit("Error with cURL request");
        }

        return $output;
    }

    public function getTablesDom() {
        $htmlDom = $this->fetchEsolatDom();
        if ($htmlDom !== false) {
            $dom = new DOMDocument();
            $dom->preservWhiteSpace = false;

            @$dom->loadHTML($htmlDom);
            $this->_tables = $dom->getElementsByTagname('table');
        } else {
            exit("Error with Table DOM");
        }
        return $this;
    }

    public function getTableData($tableNumber = 1) {
        if (empty($this->_tables)) {
            $this->getTablesDom();
        }

        $table = $this->_tables->item($tableNumber - 1);
        $rows = $table->getElementsByTagName('tr');

        $rowData = array();
        for ($i = 0; $i < $rows->length; $i++) {
            $row = $rows->item($i);
            $cols = $row->getElementsByTagName('td');
            $colData = array();
            foreach ($cols as $col) {
                $colData[] = trim($col->nodeValue);
            }
            $rowData[] = $colData;
        }
        return $rowData;
    }

    public function getEsolatInfo() {
        $data = $this->getTableData(1);

        $result = array();
        $result['title'] = $data[0][0];
        $result['Location'] = $data[1][1];
        $result['date'] = $data[2][1];
        $result['gmt'] = $data[3][1];
        $result['qibla'] = $data[4][1];
        return $result;
    }

    public function getEsolatData() {
        $data = $this->getTableData(2);
        $result = array();
        foreach ($data[0] as $row) {
            $result['meta'][] = $row;
        }

        $data = array_slice($data, 1);
        $result['data'] = $data;

        return $result;
    }

}

$test = new Esolat('jhr02', 3, 0);

$myFile = "domoutput.txt";
$fh = fopen($myFile, 'w');
fwrite($fh, $test->fetchEsolatDom());

$data = $test->getEsolatInfo();
echo '<pre>';
print_r($data);
echo '</pre>';
//
$data = $test->getEsolatData();
echo '<pre>';
print_r($data);
echo '</pre>';


