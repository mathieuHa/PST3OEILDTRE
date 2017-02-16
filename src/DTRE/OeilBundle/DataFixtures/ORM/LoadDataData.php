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

        $d = null;
        for ($i=0; $i<$max; $i++){
            $d = clone $date;
            $data1[$i] = new Data();
            $data1[$i]->setDate($d);
            $data1[$i]->setValue(rand(-5,25));
            $s1->addDatum($data1[$i]);
            $d = clone $date;
            $data2[$i] = new Data();
            $data2[$i]->setDate($d);
            $data2[$i]->setValue(rand(-5,25));
            $s2->addDatum($data2[$i]);
            $d = clone $date;
            $data4[$i] = new Data();
            $data4[$i]->setDate($d);
            $data4[$i]->setValue(rand(-5,25));
            $s4->addDatum($data4[$i]);
            $d = clone $date;
            $data3[$i] = new Data();
            $data3[$i]->setDate($d);
            $data3[$i]->setValue(rand(-5,25));
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