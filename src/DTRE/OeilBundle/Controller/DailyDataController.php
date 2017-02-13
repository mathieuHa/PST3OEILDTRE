<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\DailyData;
use DTRE\OeilBundle\Entity\Data;
use DTRE\OeilBundle\Entity\Sensor;
use DTRE\OeilBundle\Form\DailyDataType;
use DTRE\OeilBundle\Form\DataType;
use DTRE\OeilBundle\Form\SensorType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;


class DailyDataController extends Controller
{

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"dailydata"})
     * @Rest\Get("/sensors/{id}/dailydata")
     */
    public function getDailyDataAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        if (NULL ===$sensor) {
            return View::create(['message' => 'Sensor not found'], Response::HTTP_NOT_FOUND);
        }

        return $sensor->getDailyData();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED,  serializerGroups={"dailydata"})
     * @Rest\Post("/sensors/{id}/dailydata")
     */
    public function postDailyDataAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        $dailyData = new DailyData();
        $form = $this->createForm(DailyDataType::class, $dailyData);

        $form->submit($request->request->all());

        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $sensor->addDailydatum($dailyData);
            $em->persist($sensor);
            $em->flush();
            return $dailyData;
        }
        else {
            return $form;
        }
    }

}
