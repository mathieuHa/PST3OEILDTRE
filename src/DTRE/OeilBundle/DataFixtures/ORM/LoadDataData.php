<?php
/**
 * Created by PhpStorm.
 * User: mat
 * Date: 24/01/2017
 * Time: 09:35
 */

namespace DTRE\OeilBundle\DataFixtures\ORM;

use DateInterval;
use DateTimeZone;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DTRE\OeilBundle\Entity\DailyData;
use DTRE\OeilBundle\Entity\Data;
use DTRE\OeilBundle\Entity\Sensor;

class LoadDataData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime('2017-01-01 00:00:00', new DateTimeZone('Europe/Paris'));
        $interval = new DateInterval('P0Y0M0DT0H30M0S'); //1min
        $max = 20000;

        $s1 = new Sensor();
        $s2 = new Sensor();
        $s3 = new Sensor();
        $s4 = new Sensor();
        $s1->setName("température");
        $s2->setName("humidité");
        $s3->setName("luminosité");
        $s4->setName("son");
        $s1->setTitle("Température dans la DTRE");
        $s2->setTitle("Humidité dans la DTRE");
        $s3->setTitle("Luminosité dans la DTRE");
        $s4->setTitle("Bruit dans la DTRE");
        $s1->setSubtitle("En degré Celsius");
        $s2->setSubtitle("En %");
        $s3->setSubtitle("En %");
        $s4->setSubtitle("En décibels");
        $data1 = [$max];
        $data2 = [$max];
        $data3 = [$max];
        $data4 = [$max];
        $dailydata1 = [$max/48];
        $dailydata2 = [$max/48];
        $dailydata3 = [$max/48];
        $dailydata4 = [$max/48];

        $number1 = rand(-5,25);
        $oldnumber1 = $number1;
        $number2 = rand(-5,25);
        $oldnumber2 = $number2;
        $number3 = rand(-5,25);
        $oldnumber3 = $number3;
        $number4 = rand(-5,25);
        $oldnumber4 = $number4;

        $d = null;
        for ($i=0; $i<$max; $i++){
            $d = clone $date;
            $data1[$i] = new Data();
            $data1[$i]->setDate($d);
            $number1 = rand($oldnumber1-1,$oldnumber1+1);
            if ($number1<-5) $number1 = -4; if ($number1>25) $number1 = 24;
            $oldnumber1 = $number1;
            $data1[$i]->setValue($number1);
            $s1->addDatum($data1[$i]);
            $d = clone $date;
            $data2[$i] = new Data();
            $data2[$i]->setDate($d);
            $number2 = rand($oldnumber2-1,$oldnumber2+1);
            if ($number2<-5) $number2 = -4; if ($number2>25) $number2 = 24;
            $oldnumber2 = $number2;
            $data2[$i]->setValue($number2);
            $s2->addDatum($data2[$i]);
            $d = clone $date;
            $data4[$i] = new Data();
            $data4[$i]->setDate($d);
            $number3 = rand($oldnumber3-1,$oldnumber3+1);
            if ($number3<-5) $number3 = -4; if ($number3>25) $number3 = 24;
            $oldnumber3 = $number3;
            $data4[$i]->setValue($number3);
            $s4->addDatum($data4[$i]);
            $d = clone $date;
            $data3[$i] = new Data();
            $data3[$i]->setDate($d);
            $number4 = rand($oldnumber4-1,$oldnumber4+1);
            if ($number4<-5) $number4 = -4; if ($number4>25) $number4 = 24;
            $oldnumber4 = $number4;
            $data3[$i]->setValue($number4);
            $date->add($interval);
            $s3->addDatum($data3[$i]);
        }
        $date = new \DateTime('2017-01-01 00:00:00', new DateTimeZone('Europe/Paris'));
        $interval = new DateInterval('P0Y0M1DT0H0M0S'); //1min
        $d = null;
        for ($i=0; $i<$max/48; $i++){
            $d = clone $date;
            $dailydata1[$i] = new DailyData();
            $dailydata1[$i]->setDate($d);
            $dailydata1[$i]->setValue(rand(-5,25));
            $dailydata1[$i]->setMin(rand(-5,15));
            $dailydata1[$i]->setMax(rand(5,25));
            $dailydata1[$i]->setNumber(48);
            $s1->addDailydatum($dailydata1[$i]);
            $d = clone $date;
            $dailydata2[$i] = new DailyData();
            $dailydata2[$i]->setDate($d);
            $dailydata2[$i]->setValue(rand(-5,25));
            $dailydata2[$i]->setMin(rand(-5,15));
            $dailydata2[$i]->setMax(rand(5,25));
            $dailydata2[$i]->setNumber(48);
            $s2->addDailydatum($dailydata2[$i]);
            $d = clone $date;
            $dailydata3[$i] = new DailyData();
            $dailydata3[$i]->setDate($d);
            $dailydata3[$i]->setValue(rand(-5,25));
            $dailydata3[$i]->setMin(rand(-5,15));
            $dailydata3[$i]->setMax(rand(5,25));
            $dailydata3[$i]->setNumber(48);
            $s3->addDailydatum($dailydata3[$i]);
            $d = clone $date;
            $dailydata4[$i] = new DailyData();
            $dailydata4[$i]->setDate($d);
            $dailydata4[$i]->setValue(rand(-5,25));
            $dailydata4[$i]->setMin(rand(-5,15));
            $dailydata4[$i]->setMax(rand(5,25));
            $dailydata4[$i]->setNumber(48);
            $s4->addDailydatum($dailydata4[$i]);
            $date->add($interval);
        }

        $manager->persist($s1);
        $manager->persist($s2);
        $manager->persist($s3);
        $manager->persist($s4);
        $manager->flush();
    }
}