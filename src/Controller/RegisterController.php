<?php
declare(strict_types=1);
namespace App\Controller;

use App\Decoder\OwnPasswordDecoder;
use App\Entity\User;
use App\Form\PasswordFormType;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        OwnPasswordDecoder $OwnPasswordEncoder
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('panel');
        }
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $u_salt = random_bytes(10);
            $user->setSalt($u_salt);
            //$user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setPassword($OwnPasswordEncoder->saltEncoder($user->getPassword(),$u_salt));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_login'
            );
        }

        return $this->render(
            'security/register.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
    /**
     * @Route("/auth/edit", name="auth_edit")
     */
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $user = $tokenStorage->getToken()->getUser();
        $form = $this->createForm(PasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $u_salt = random_bytes(10);
            $user->setSalt($u_salt);
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute(
                'app_login'
            );
        }

        return $this->render(
            'panel/change_password.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
