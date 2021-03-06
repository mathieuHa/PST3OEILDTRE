<?php

namespace DTRE\OeilBundle\Controller;

use DTRE\OeilBundle\Entity\User;
use DTRE\OeilBundle\Form\UserType;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process; // alias pour toutes les annotations
use DTRE\OeilBundle\Form\CredentialsType;


class UserController extends Controller
{

    public function createUserOnDisk($name)
    {
        $process = new Process('/bin/sh /home/pi/oeildtre/pst3oeildtrearduino/new_user.sh ' . $name);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"user"})
     * @Rest\Get("/users/new-pass/{id}")
     */
    public function getUserNewPassAction(Request $request)
    {
        $user = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        if (NULL === $user) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $mail = $user->getMail();
        $name = $user->getLogin();
        $password = $this->generateRandomString();
        $user->setPlainpassword($password);

        $encoder = $this->get('security.password_encoder');
        // le mot de passe en claire est encodé avant la sauvegarde
        $encoded = $encoder->encodePassword($user, $password);
        $user->setPassword($encoded);

        $message = \Swift_Message::newInstance()
            ->setSubject('Oeil DTRE Nouveau mot de passe')
            ->setFrom('oeildtre@gmail.com')
            ->setTo($mail)
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Template/new_pass.html.twig',
                    array('name' => $name, 'password' => $password)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();
        return $user;
    }


    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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

        if ($form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            // le mot de passe en claire est encodé avant la sauvegarde
            $encoded = $encoder->encodePassword($user, $this->generateRandomString(25));
            $user->setPassword($encoded);
            $user->setColor("000000");
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"user"})
     * @Rest\Get("/users")
     */
    public function getUsersAction()
    {
        $users = $this
            ->getDoctrine()
            ->getRepository('DTREOeilBundle:User')
            ->findAll();

        if (NULL ===$users) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return $users;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_OK, serializerGroups={"user"})
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
     * @Rest\View(serializerGroups={"user"}, serializerGroups={"user"})
     * @Rest\Put("/users/{id}")
     */
    public function updateUserAction(Request $request)
    {
        return $this->updateUser($request, true);
    }

    /**
     * @Rest\View(serializerGroups={"user"}, serializerGroups={"user"})
     * @Rest\Patch("/users/{id}")
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    private function updateUser(Request $request, $clearMissing)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('DTREOeilBundle:User')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($user)) {
            return $this->userNotFound();
        }

        if ($clearMissing) { // Si une mise à jour complète, le mot de passe doit être validé
            $options = ['validation_groups'=>['Default', 'FullUpdate']];
        } else {
            $options = []; // Le groupe de validation par défaut de Symfony est Default
        }

        $form = $this->createForm(UserType::class, $user, $options);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            // Si l'utilisateur veut changer son mot de passe
            if (!empty($user->getPlainPassword())) {
                $encoder = $this->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $em->merge($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    private function userNotFound()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
