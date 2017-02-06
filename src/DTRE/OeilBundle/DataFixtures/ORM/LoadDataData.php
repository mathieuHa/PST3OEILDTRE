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
        $interval = new DateInterval('P0Y0M0DT0H10M0S'); //1min
        $max = 10000;
        $nbrsensors = 4;

        $s1 = new Sensor();
        $s2 = new Sensor();
        $s3 = new Sensor();
        $s4 = new Sensor();
        $s1->setName("température");
        $s2->setName("humidité");
        $s3->setName("capteur 3");
        $s4->setName("capteur 4");
        $sensors = [$max*$nbrsensors];
        $d = null;
        for ($i=0; $i<$max; $i++){
            $d = clone $date;
            $sensors[$i] = new Data();
            $sensors[$i]->setSensor($s1);
            $sensors[$i]->setDate($d);
            $sensors[$i]->setValue(rand(-5,25));
            $date->add($interval);
            $d = clone $date;
            $sensors[$i] = new Data();
            $sensors[$i]->setSensor($s2);
            $sensors[$i]->setDate($d);
            $sensors[$i]->setValue(rand(-5,25));
            $date->add($interval);
            $d = clone $date;
            $sensors[$i] = new Data();
            $sensors[$i]->setSensor($s3);
            $sensors[$i]->setDate($d);
            $sensors[$i]->setValue(rand(-5,25));
            $date->add($interval);
            $d = clone $date;
            $sensors[$i] = new Data();
            $sensors[$i]->setSensor($s4);
            $sensors[$i]->setDate($d);
            $sensors[$i]->setValue(rand(-5,25));
            $date->add($interval);
        }

        foreach ($sensors as $sensor) {
            foreach ($sensor as $data){
                $manager->persist($data);
            }
        }

        $manager->flush();
    }
}