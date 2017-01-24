<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\Sensor;
use DTRE\OeilBundle\Form\SensorType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;


class SensorController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors")
     */
    public function getSensorsAction()
    {
        $sensors = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->findAll();

        return $sensors;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/day")
     */
    public function getSensorsDayAction(Request $request)
    {
        $sensors = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->getByDay(new \DateTime('2017-01-01'));

        return $sensors;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/month")
     */
    public function getSensorsMonthAction(Request $request)
    {
        $sensors = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->getByMonth(new \DateTime('2017-02'));

        return $sensors;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/sensors/week")
     */
    public function getSensorsWeekAction(Request $request)
    {
        $sensors = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Sensor')
            ->getByWeek(new \DateTime('2017-01-10'));

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
