<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\DTREOeilBundle;
use DTRE\OeilBundle\Entity\DailyData;
use DTRE\OeilBundle\Entity\Data;
use DTRE\OeilBundle\Entity\Image;
use DTRE\OeilBundle\Entity\Message;
use DTRE\OeilBundle\Entity\Sensor;
use DTRE\OeilBundle\Form\DailyDataType;
use DTRE\OeilBundle\Form\DataType;
use DTRE\OeilBundle\Form\ImageType;
use DTRE\OeilBundle\Form\MessageType;
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


class MessageController extends Controller
{
    public function MessageNotFound(){
        return View::create(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/chat/message/{id}")
     */
    public function getMessageAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $id =$request->get('id');
        $message = $em
            ->getRepository('DTREOeilBundle:Message')
            ->find($id);

        return $message;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"message"})
     * @Rest\QueryParam(
     *     name="id user",
     *     requirements="\d+",
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
     *     default="100",
     *     description="Max number of image per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="0",
     *     description="The pagination offset"
     * )
     * @Rest\Get("/chat/messages")
     */
    public function getMessagesAction(ParamFetcher $paramFetcher)
    {
        $limit = $paramFetcher->get('limit');
        $offset = $paramFetcher->get('offset');

        $messages = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Message')
            ->findMessages($limit, $offset);

        return $messages;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"message"})
     * @Rest\Get("/chat/messages/{id}")
     */
    public function getMessagesUserAction(Request $request)
    {
        $id = $request->get('id');

        $messagesUser = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Message')
            ->findMessageUser($id);

        return $messagesUser;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"message"})
     * @Rest\QueryParam(name="id", description="Id User")
     * @Rest\Post("/chat/message")
     */
    public function postMessageAction(Request $request,ParamFetcher $paramFetcher)
    {
        $message = new Message();
        $id = $paramFetcher->get('id');
        $message->setDate(new \DateTime());

        $form = $this->createForm(MessageType::class, $message);

        $form->submit($request->request->all());

        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $user = $this
                ->getDoctrine()
                ->getRepository('DTREOeilBundle:User')
                ->find($id);

            if (NULL ===$user) {
                return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }
            $message->setUser($user);
            $em->persist($message);
            $em->flush();
            return $message;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/chat/message/{id}")
     */
    public function deleteMessageAction(Request $request)
    {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $id = $request->get('id');

        $message = $em
            ->getRepository('DTREOeilBundle:Message')
            ->find($id);

        if (NULL === $message) {
            return;
        }

        $em->remove($message);
        $em->flush();
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Put("/chat/message/{id}")
     */
    public function putMessageAction(Request $request)
    {
        $message = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Message')
            ->find($request->get('id'));

        if (NULL === $message) {
            return $this->MessageNotFound();
        }

        $form = $this->createForm(ImageType::class, $message);

        $form->submit($request->request->all());
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($message);
            $em->flush();
            return $message;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Patch("/media/image/{id}")
     */
    public function patchMessageAction(Request $request)
    {
        $message = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:Message')
            ->find($request->get('id'));

        if (NULL === $message) {
            return $this->ImageNotFound();
        }

        $form = $this->createForm(ImageType::class, $message);

        $form->submit($request->request->all(), false);
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($message);
            $em->flush();
            return $message;
        }
        else {
            return $form;
        }
    }
}
