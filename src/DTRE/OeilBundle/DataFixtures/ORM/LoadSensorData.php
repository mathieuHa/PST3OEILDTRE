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
use DTRE\OeilBundle\Entity\Sensor;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $date = new \DateTime('2017-01-01 00:00:00', new DateTimeZone('Europe/Paris'));
        $interval = new DateInterval('P0Y0M0DT0H10M0S'); //1min
        $max = 10000;
        $sensors = [$max];
        $d = null;
        for ($i=0; $i<$max; $i++){
            $d = clone $date;
            $sensors[$i] = new Sensor();
            $sensors[$i]->setDate($d);
            $sensors[$i]->setValue(rand(-5,25));
            $date->add($interval);
        }

        foreach ($sensors as $sensor) {
            $manager->persist($sensor);
        }


        $manager->flush();
    }
}