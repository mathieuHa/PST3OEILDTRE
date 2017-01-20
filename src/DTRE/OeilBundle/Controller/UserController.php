<?php

namespace DTRE\OeilBundle\Controller;

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
}
