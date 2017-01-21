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
     * @Rest\View()
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
     * @Rest\View()
     * @Rest\Get("/users/{id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id'));

        if (NULL ===$user) {
            return new JsonResponse(['message' => 'Sensor not found'], Response::HTTP_NOT_FOUND);
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
}
