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
use DTRE\OeilBundle\Entity\Data;
use DTRE\OeilBundle\Entity\Sensor;

class LoadDataData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime('2017-01-01 00:00:00', new DateTimeZone('Europe/Paris'));
        $interval = new DateInterval('P0Y0M0DT0H30M0S'); //1min
        $max = 10000;

        $s1 = new Sensor();
        $s2 = new Sensor();
        $s3 = new Sensor();
        $s4 = new Sensor();
        $s1->setName("temperature");
        $s2->setName("humidité");
        $s3->setName("capteur 3");
        $s4->setName("capteur 4");
        $data1 = [$max];
        $data2 = [$max];
        $data3 = [$max];
        $data4 = [$max];
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

        $manager->persist($s1);
        $manager->persist($s2);
        $manager->persist($s3);
        $manager->persist($s4);
        $manager->flush();
    }
}