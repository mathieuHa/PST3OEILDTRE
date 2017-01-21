<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\User;
use DTRE\OeilBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations


class UserController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->findAll();

        return $users;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/users/{id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id'));

        if (NULL ===$user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();
        /*$user
            ->setNom($request->get('nom'))
            ->setPrenom($request->get('prenom'))
            ->setMail($request->get('mail'));*/
        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($user);
            $em->flush();
            return $user;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}")
     */
    public function deleteUsersAction(Request $request)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id'));
        if ($user){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->remove($user);
            $em->flush();
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Put("/users/{id}")
     */
    public function putUsersAction(Request $request)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id'));

        if (NULL ===$user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($user);
            $em->flush();
            return $user;
        }
        else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Patch("/users/{id}")
     */
    public function patchUsersAction(Request $request)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id'));

        if (NULL ===$user) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all(), false);
        if ($form->isValid()){
            $em = $this
                ->getDoctrine()
                ->getManager();
            $em->persist($user);
            $em->flush();
            return $user;
        }
        else {
            return $form;
        }
    }
}
