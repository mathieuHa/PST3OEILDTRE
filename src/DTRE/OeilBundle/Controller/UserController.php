<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\User;
use DTRE\OeilBundle\Form\UserType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations


class UserController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_OK)
     * @Rest\Get("/users")
     */
    public function getUsersAction()
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
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"user"})
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, ['validation_groups'=>['Default', 'New']]);

        $form->submit($request->request->all());
        if ($form->isValid()){
            $encoder = $this->get('security.password_encoder');
            // le mot de passe en claire est encodé avant la sauvegarde
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
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
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $options = ['validation_groups'=>['Default', 'FullUpdate']];
        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all());
        if ($form->isValid()){
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
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
     * @Rest\View(statusCode=Response::HTTP_OK,  serializerGroups={"user"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUsersAction(Request $request)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id'));

        if (NULL ===$user) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
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
