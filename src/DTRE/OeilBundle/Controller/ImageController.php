<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\DailyData;
use DTRE\OeilBundle\Entity\Data;
use DTRE\OeilBundle\Entity\Image;
use DTRE\OeilBundle\Entity\Sensor;
use DTRE\OeilBundle\Form\DailyDataType;
use DTRE\OeilBundle\Form\DataType;
use DTRE\OeilBundle\Form\ImageType;
use DTRE\OeilBundle\Form\SensorType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;


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
     * @Rest\Get("/media/images")
     */
    public function getImagesAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $images = $em
            ->getRepository('DTREOeilBundle:Image')
            ->findAll();

        return $images;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"image"})
     * @Rest\Post("/media/image")
     */
    public function postImageAction(Request $request)
    {
        $image = new Image();
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
