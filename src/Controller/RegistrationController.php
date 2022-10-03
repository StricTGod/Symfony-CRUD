<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $em;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $em
    )
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @return Response
     * @Route("/register", name="app_register")
     */
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('registration/register.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @return Response
     * @Route("/user-register", name="user_register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User;
        $plainPassword = "";

        $user->setEmail($request->get('email'));
        $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

        $this->em->persist($user);
        $this->em->flush();

        return new Response('Registration was successful');
    }
}
