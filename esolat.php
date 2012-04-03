<?php

/**-----------------------------------------------------------------------------
 * JAKIM's esolat wrapper
 * Wrap and convert jakim's esolat html data into array, text delimiter, json and xml 
 *
 * @author      ibnuyahya <ibnuyahya@gmail.com>
 * @version     1.0 require php 5.2 and above
 * @since       Apr 2, 2012
 * @link        http://www.e-solat.gov.my/prayer_time.php?zon=JHR01&jenis=1
 * 
 * @copyright   ibnuyahya.com
 * @license     GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * 
 * You are premit to do whatever you want with this code. Spread it or fork it  
 * from my github, 
 * 
 *      https://github.com/hanafiah/esolat
 * 
 * live sample : http://api.ibnuyahya.com/esolat/
 * 
 * blog post   : http://ibnuyahya.com/esolat-jakim/
 * 
 * -----------------------------------------------------------------------------
 * Sample Usage
 * -----------------------------------------------------------------------------
 
  <?php

  //instantiate esolat class
  $esolat = new Esolat();

  //get solat schedule for the whole year
  $year   = $esolat->getYear();
  print_r($year);

  //get solat schedule for the selected month
  $month  = $esolat->getMonth(1); //1 = january, 2 = february ...
  print_r($month);

  //get solat schedule for the selected day
  $day = $esolat->getDay(20,1); //first argument is day and second argument is month
  print_r($day);
 
  ?>
 
 */

set_time_limit(120);

class Esolat {

    private $_esolatUrl = 'http://www.e-solat.gov.my/prayer_time.php?zon={!ZONE}&jenis=3&bulan={!MONTH}&LG=BM&year=';
    private $_zone;
    private $_timeout;
    private $_tables = array(); // table dom
    private $_month = 0;
    public $cache = true;
    public $cacheDays = 30;

    /**
     * constructor
     * 
     * @param type $zone
     * @param type $timeout 
     */
    public function __construct($zone = 'jhr02', $timeout = 120) {
        $this->_zone = $zone;
        $this->_timeout = $timeout;
    }

    /**
     * fetchEsolatDom()
     * 
     * get html dom from target url
     * 
     * @return array dom data 
     */
    public function fetchEsolatDom() {
        $this->_esolatUrl = str_replace('{!ZONE}', $this->_zone, $this->_esolatUrl);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, ''); //handle all encodings

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
        $output = array();
        try {
            foreach (range(1, 12) as $month) {
                $url = str_replace('{!MONTH}', $month, $this->_esolatUrl);
                curl_setopt($ch, CURLOPT_URL, $url);
                $output[] = curl_exec($ch);
            }
            curl_close($ch);
        } catch (Exception $e) {
            exit("Error with cURL request");
        }
        return $output;
    }

    /**
     * getTablesDom()
     * 
     * extract html table from dom document.
     * 
     * @return Esolat 
     */
    public function getTablesDom() {
        $htmlDoms = $this->fetchEsolatDom();
        if (count($htmlDoms) > 0) {
            foreach ($htmlDoms as $htmlDom) {
                $dom = new DOMDocument();
                $dom->preservWhiteSpace = false;
                @$dom->loadHTML($htmlDom);
                $this->_tables[] = $dom->getElementsByTagname('table');
            }
        } else {
            exit("Error with Table DOM");
        }
        return $this;
    }

    /**
     * getTableData()
     * 
     * read html table row and convert it to array data
     * 
     * @param integer $tableNumber
     * @return array of data 
     */
    public function getTableData($tableNumber = 1) {
        if (count($this->_tables) == 0) {
            $this->getTablesDom();
        }
        $rowData = array();
        foreach ($this->_tables as $key => $value) {
            $table = $value->item($tableNumber - 1);
            $rows = $table->getElementsByTagName('tr');

            $rowData[$key] = array();
            for ($i = 0; $i < $rows->length; $i++) {
                $row = $rows->item($i);
                $cols = $row->getElementsByTagName('td');
                $colData = array();
                foreach ($cols as $col) {
                    $colData[] = trim($col->nodeValue);
                }
                $rowData[$key][] = $colData;
            }
        }
        return $rowData;
    }

    /**
     * getEsolatInfo()
     * 
     * get solat info
     * 
     * @return array 
     */
    public function getEsolatInfo() {
        $cache_file = 'cache/' . md5('info' . $this->_zone);
        if ($this->cache === true) {

            if (is_readable($cache_file)) {
                $result = json_decode(fread(fopen($cache_file, 'r'), filesize($cache_file)), true);
                return $result;
            }
        }
        $datas = $this->getTableData(1);
        $result = array();
        foreach ($datas as $key => $data) {
            $info = array();
            $info['title'] = $data[0][0];
            $info['location'] = $data[1][1];
            $info['date'] = $data[2][1];
            $info['gmt'] = $data[3][1];
            $info['qibla'] = $data[4][1];
            $result[$key] = $info;
        }

        if (is_writable('cache/')) {
            $fh = fopen($cache_file, 'w');
            fwrite($fh, json_encode($result));
            fclose($fh);
        }

        return $result;
    }

    /**
     * getEsolatData()
     * 
     * get solat time data
     * 
     * @return array 
     */
    public function getEsolatData() {
        $cache_file = 'cache/' . md5('data' . $this->_zone);
        if ($this->cache === true) {
            if (is_readable($cache_file)) {
                $result = json_decode(fread(fopen($cache_file, 'r'), filesize($cache_file)), true);
                return $result;
            }
        }

        $months = $this->getTableData(2);


        $result = array();
        foreach ($months as $key => $month) {
            if ($key == 0) {
                $result[$key]['meta'][] = $month[0];
            }
            $month = array_slice($month, 1);
            $result[$key]['data'] = $month;
        }



        if (is_writable('cache/')) {

            $fh = fopen($cache_file, 'w');
            fwrite($fh, json_encode($result));
            fclose($fh);
        }

        return $result;
    }

    /**
     * getMonth()
     * 
     * get solat time schedule by month
     * 
     * @param integer $month
     * @return array 
     */
    public function getMonth($month = 1) {
        $data = $this->getEsolatData();
        $info = $this->getEsolatInfo();

        return array(
            'info' => $info[$month - 1],
            'meta' => $data[0]['meta'][0],
            'data' => $data[$month - 1]['data'],
        );
    }

    /**
     * getDay()
     * 
     * get solat time schedule by day
     * 
     * @param integer $day
     * @param integer $month
     * @return array 
     */
    public function getDay($day = 1, $month = 1) {
        $data = $this->getEsolatData();
        $info = $this->getEsolatInfo();
        return array(
            'info' => $info[$month - 1],
            'meta' => $data[0]['meta'][0],
            'data' => $data[$month - 1]['data'][$day - 1],
        );
    }

    /**
     * getYear()
     * 
     * get solat time schedule for the whole year
     * 
     * @return array 
     */
    public function getYear() {
        $data = $this->getEsolatData();
        $info = $this->getEsolatInfo();


        $monthData = array();
        foreach ($data as $month) {
            $monthData[] = $month['data'];
        }
        return array(
            'info' => $info[0],
            'meta' => $data[0]['meta'][0],
            'data' => $monthData,
        );
    }

}

