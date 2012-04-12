# Esolat Jakim wrapper

A simple php wrapper to crawl dom data from Jakim's esolat web page. http://www.e-solat.gov.my/prayer_time.php?zon=JHR01&jenis=1

## Pre


## Sample Usage
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