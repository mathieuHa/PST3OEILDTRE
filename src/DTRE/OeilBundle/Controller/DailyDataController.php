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
    public function SensorNotFound(){
        return View::create(['message' => 'Sensor not found'], Response::HTTP_NOT_FOUND);;
    }

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

        if (NULL === $sensor) {
            return $this->SensorNotFound();
        }

        return $sensor->getDailyData();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"dailydata"})
     * @Rest\Get("/sensors/{id}/dailydata/week")
     * @Rest\QueryParam(name="day", requirements="\d+", default="1", description="jour")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getDailyDataWeekAction(Request $request, ParamFetcher $paramFetcher)
    {
        $id =$request->get('id');

        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($id);

        if (NULL === $sensor) {
            return $this->SensorNotFound();
        }

        $day = $paramFetcher->get('day');
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');


        $dailydata = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:DailyData')
            ->getByWeek($id, new \DateTime($year.'-'.$month.'-'.$day));

        return $dailydata;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"dailydata"})
     * @Rest\Get("/sensors/{id}/dailydata/month")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getDailyDataMonthAction(Request $request, ParamFetcher $paramFetcher)
    {
        $id =$request->get('id');

        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($id);

        if (NULL === $sensor) {
            return $this->SensorNotFound();
        }

        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');


        $dailydata = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:DailyData')
            ->getByMonth($id, new \DateTime($year.'-'.$month));

        return $dailydata;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"dailydata"})
     * @Rest\Get("/sensors/{id}/dailydata/semester")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getDailyDataSemesterAction(Request $request, ParamFetcher $paramFetcher)
    {
        $id =$request->get('id');

        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($id);

        if (NULL === $sensor) {
            return $this->SensorNotFound();
        }

        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $dailydata = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:DailyData')
            ->getBySemester($id, new \DateTime($year.'-'.$month));

        return $dailydata;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"dailydata"})
     * @Rest\Get("/sensors/{id}/dailydata/semester")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getDailyDataYearAction(Request $request, ParamFetcher $paramFetcher)
    {
        $id =$request->get('id');

        $sensor = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($id);

        if (NULL === $sensor) {
            return $this->SensorNotFound();
        }

        $year = $paramFetcher->get('year');

        $dailydata = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:DailyData')
            ->getByYear($id, new \DateTime($year));

        return $dailydata;
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

        if (NULL === $sensor) {
            return $this->SensorNotFound();
        }

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

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/sensors/{sensor_id}/dailydata/{id}")
     */
    public function deleteDailyDataAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $sensor = $em
            ->getRepository('DTREOeilBundle:Sensor')
            ->find($request->get('sensor_id'));

        if (NULL === $sensor) {
            return;
        }

        $dailydata = $em
            ->getRepository('DTREOeilBundle:DailyData')
            ->find($request->get('id'));

        if (NULL === $dailydata) {
            return;
        }

        $sensor->removeDailydatum($dailydata);
        $em->remove($dailydata);
        $em->flush();
    }

}
