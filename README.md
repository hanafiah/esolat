# Perhatian!!
Kod ini tidak lagi berfungsi disebabkan jakim telah menukar paparan laman web esolat mereka. Saya masih belum sempat untuk update kod disini... walaubagaimanapun, saya dah update kod di scraperwiki https://scraperwiki.com/scrapers/esolat/ 

# Esolat Jakim wrapper

A simple php wrapper to crawl dom data from Jakim's esolat web page. http://www.e-solat.gov.my/prayer_time.php?zon=JHR01&jenis=1

## Pre

* This wrapper require php 5.2 and curl support.
* Allow write permission to "cache" directory.

## Sample Usage

Please refer to this page for the location code.
http://www.e-solat.gov.my/e-solat.php

     <?php
          //include esolat class
          include 'esolat.php';

          //get data for the following location
          $code = 'JHR01';

          //instantiate esolat class
          $esolat = new Esolat($code);

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
