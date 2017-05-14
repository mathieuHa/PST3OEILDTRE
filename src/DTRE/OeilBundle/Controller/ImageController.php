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


class ImageController extends Controller
{
    public function ImageNotFound(){
        return View::create(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/media/image/{id}")
     */
    public function getImageAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $id =$request->get('id');
        $image = $em
            ->getRepository('DTREOeilBundle:Image')
            ->find($id);

        return $image;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="10",
     *     description="Max number of image per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @Rest\Get("/media/images")
     */
    public function getImagesAction(ParamFetcherInterface $paramFetcher)
    {
        $imagesPager = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Image')
            ->findAll();

        return $imagesPager;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/media/images/day")
     * @Rest\QueryParam(name="day", requirements="\d+", default="1", description="jour")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getImagesDayAction(ParamFetcher $paramFetcher)
    {
        $day = $paramFetcher->get('day');
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $em = $this
            ->getDoctrine()
            ->getManager();
        $images = $em
            ->getRepository('DTREOeilBundle:Image')
            ->getByDay();

        return $images;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/media/images/shot")
     * @Rest\QueryParam(name="id", requirements="\d+", default="1", description="id")
     */
    public function getPictureAction(ParamFetcher $paramFetcher)
    {
        $id = $paramFetcher->get('id');

        $em = $this
            ->getDoctrine()
            ->getManager();
        $user = $em
            ->getRepository('DTREOeilBundle:User')
            ->find($id);

        $this->takePicture($user);

        return $user;
    }

    public function takePicture ($user){
        $process = new Process('/bin/sh /home/pi/oeildtre/pst3oeildtrearduino/pic.sh '.$user->getId());
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/media/images/week")
     * @Rest\QueryParam(name="day", requirements="\d+", default="1", description="jour")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getImagesWeekAction(ParamFetcher $paramFetcher)
    {
        $day = $paramFetcher->get('day');
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $em = $this
            ->getDoctrine()
            ->getManager();
        $images = $em
            ->getRepository('DTREOeilBundle:Image')
            ->getByWeek();

        return $images;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/media/images/month")
     * @Rest\QueryParam(name="month", requirements="\d+", default="1", description="month")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getImagesMonthAction(ParamFetcher $paramFetcher)
    {
        $month = $paramFetcher->get('month');
        $year = $paramFetcher->get('year');

        $em = $this
            ->getDoctrine()
            ->getManager();
        $images = $em
            ->getRepository('DTREOeilBundle:Image')
            ->getByMonth();

        return $images;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/media/images/year")
     * @Rest\QueryParam(name="year", requirements="\d+", default="2017", description="year")
     */
    public function getImagesYearAction(ParamFetcher $paramFetcher)
    {
        $year = $paramFetcher->get('year');
        $em = $this
            ->getDoctrine()
            ->getManager();
        $images = $em
            ->getRepository('DTREOeilBundle:Image')
            ->getByYear();

        return $images;
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"image"})
     * @Rest\QueryParam(name="token", requirements="\d+", default="1", description="Token User")
     * @Rest\Post("/media/image")
     */
    public function postImageAction(Request $request,ParamFetcher $paramFetcher)
    {
        $image = new Image();
        $tokenV = $paramFetcher->get('token');
        $image->setDate(new \DateTime());

        $form = $this->createForm(ImageType::class, $image);

        $form->submit($request->request->all());

        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $token = $this
                ->getDoctrine()
                ->getRepository('DTREOeilBundle:AuthToken')
                ->findByValue($tokenV);
            return $token;
            $user = $token->getUser();
            if (NULL ===$user) {
                return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }
            $image->setUser($user);
            $em->persist($image);
            $em->flush();
            return $image;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/media/image/{id}")
     */
    public function deleteImageAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $id = $request->get('id');

        $image = $em
            ->getRepository('DTREOeilBundle:Image')
            ->find($id);

        if (NULL === $image) {
            return;
        }

        $em->remove($image);
        $em->flush();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Put("/media/image/{id}")
     */
    public function putImageAction(Request $request)
    {
        $image = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Image')
            ->find($request->get('id'));

        if (NULL === $image) {
            return $this->ImageNotFound();
        }

        $form = $this->createForm(ImageType::class, $image);

        $form->submit($request->request->all());
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($image);
            $em->flush();
            return $image;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Patch("/media/image/{id}")
     */
    public function patchImageAction(Request $request)
    {
        $image = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Image')
            ->find($request->get('id'));

        if (NULL === $image) {
            return $this->ImageNotFound();
        }

        $form = $this->createForm(ImageType::class, $image);

        $form->submit($request->request->all(), false);
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($image);
            $em->flush();
            return $image;
        }
        else {
            return $form;
        }
    }
}
