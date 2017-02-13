<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\Data;
use DTRE\OeilBundle\Entity\Sensor;
use DTRE\OeilBundle\Form\DataType;
use DTRE\OeilBundle\Form\SensorType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;


class DataController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"data"})
     * @Rest\Get("/sensors/{id}/data/day")
     * @Rest\QueryParam(name="day", requirements="\d+", default="1", description="jour")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getDataDayAction(Request $request, ParamFetcher $paramFetcher)
    {
        $day = $paramFetcher->get('day');
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $em = $this
            ->getDoctrine()
            ->getManager();
        $id =$request->get('id');
        $data = $em
            ->getRepository('DTREOeilBundle:Data')
            ->getByDay($id, new \DateTime($year.'-'.$month.'-'.$day));

        return $data;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"data"})
     * @Rest\Get("/sensors/{id}/data/month")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getDataMonthAction(Request $request, ParamFetcher $paramFetcher)
    {
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $id =$request->get('id');

        $data = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Data')
            ->getByMonth($id, new \DateTime($year.'-'.$month));

        return $data;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/{id}/data/week")
     * @Rest\QueryParam(name="day", requirements="\d+", default="1", description="jour")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getDataWeekAction(Request $request, ParamFetcher $paramFetcher)
    {
        $day = $paramFetcher->get('day');
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $id =$request->get('id');

        $data = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Data')
            ->getByWeek($id, new \DateTime($year.'-'.$month.'-'.$day));

        return $data;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"data"})
     * @Rest\Get("/sensors/{id}/data")
     */
    public function getDataAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        if (NULL ===$sensor) {
            return View::create(['message' => 'Sensor not found'], Response::HTTP_NOT_FOUND);
        }

        return $sensor->getData();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED,  serializerGroups={"data"})
     * @Rest\Post("/sensors/{id}/data")
     */
    public function postDataAction(Request $request)
    {
        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('id'));

        $data = new Data();
        $form = $this->createForm(DataType::class, $data);
        $form->submit($request->request->all());

        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $sensor->addDatum($data);
            $em->persist($sensor);
            $em->flush();
            return $data;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/sensors/{sensor_id}/data/{id}")
     */
    public function deleteDataAction(Request $request)
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
     * @Rest\Put("/sensors/{sensor_id}/data/{id}")
     */
    public function putDataAction(Request $request)
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
     * @Rest\Patch("/sensors/{sensor_id}/data/{id}")
     */
    public function patchDataAction(Request $request)
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
