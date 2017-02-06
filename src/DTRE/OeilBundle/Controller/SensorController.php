<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\Sensor;
use DTRE\OeilBundle\Form\SensorType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;


class SensorController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/{id}")
     */
    public function getSensorsAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $sensors = $em
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        //$data = $sensors->getData();

        return $sensors->getData();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"data"})
     * @Rest\Get("/sensors/{id}/day")
     * @Rest\QueryParam(name="day", requirements="\d+", default="1", description="jour")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getSensorsDayAction(Request $request, ParamFetcher $paramFetcher)
    {
        $day = $paramFetcher->get('day');
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $em = $this
            ->getDoctrine()
            ->getManager();
        $id =$request->get('id');
        $sensors = $em
            ->getRepository('DTREOeilBundle:Data')
            ->getByDay($id, new \DateTime($year.'-'.$month.'-'.$day));

        return $sensors;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/month")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getSensorsMonthAction(Request $request, ParamFetcher $paramFetcher)
    {
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $sensors = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->getByMonth(new \DateTime($year.'-'.$month));

        return $sensors;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/week")
     * @Rest\QueryParam(name="day", requirements="\d+", default="1", description="jour")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getSensorsWeekAction(Request $request, ParamFetcher $paramFetcher)
    {
        $day = $paramFetcher->get('day');
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $sensors = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->getByWeek(new \DateTime($year.'-'.$month.'-'.$day));

        return $sensors;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/{id}")
     */
    public function getSensorAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        if (NULL ===$sensor) {
            return View::create(['message' => 'Sensor not found'], Response::HTTP_NOT_FOUND);
        }

        return $sensor;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/sensors")
     */
    public function postSensorsAction(Request $request)
    {
        $sensor = new Sensor();
        $form = $this->createForm(SensorType::class, $sensor);
        $form->submit($request->request->all());

        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($sensor);
            $em->flush();
            return $sensor;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/sensors/{id}")
     */
    public function deleteSensorsAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        if ($sensor){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->remove($sensor);
            $em->flush();
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Put("/sensors/{id}")
     */
    public function putSensorsAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        if (NULL ===$sensor) {
            return View::create(['message' => 'Sensor not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(SensorType::class, $sensor);

        $form->submit($request->request->all());
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($sensor);
            $em->flush();
            return $sensor;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Patch("/sensors/{id}")
     */
    public function patchSensorsAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        if (NULL ===$sensor) {
            return View::create(['message' => 'Sensor not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(SensorType::class, $sensor);

        $form->submit($request->request->all(), false);
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($sensor);
            $em->flush();
            return $sensor;
        }
        else {
            return $form;
        }
    }
}
