<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\DTREOeilBundle;
use DTRE\OeilBundle\Entity\DailyData;
use DTRE\OeilBundle\Entity\Data;
use DTRE\OeilBundle\Entity\Image;
use DTRE\OeilBundle\Entity\Sensor;
use DTRE\OeilBundle\Form\DailyDataType;
use DTRE\OeilBundle\Form\DataType;
use DTRE\OeilBundle\Form\ImageType;
use DTRE\OeilBundle\Form\SensorType;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class CommandController extends Controller
{

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/control/servo")
     * @Rest\QueryParam(name="dir", requirements="[a-z]", default="c", description="direction")
     */
    public function getTurnAction(ParamFetcher $paramFetcher)
    {
        $dir = $paramFetcher->get('dir');
        $result = $this->turnServoMotor($dir);

        return $result;

    }

    public function turnServoMotor ($direction){
        $process = new Process('/home/pi/oeildtre/pst3oeildtrearduino/run '.$direction);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }


}
