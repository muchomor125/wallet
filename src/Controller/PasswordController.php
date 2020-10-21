<?php
declare(strict_types=1);
namespace App\Controller;

use App\Entity\User;
use App\Decoder\OwnPasswordDecoder;
use App\DTO\PasswordCreateDTO;
use App\Entity\Password;
use App\Form\PasswordCreateDTOFormType;
use App\Repository\Password\PasswordRepository;
use App\Service\PasswordCreator;
use Doctrine\ORM\Cache\TimestampCacheKey;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/password", name="password")
 */
class PasswordController extends AbstractController
{
    /**
     * @Route("/add", name="_add")
     */
    public function addPassword(
        Request $request,
        PasswordCreator $passwordCreator
    ): Response {
        $passwordCreateDTO = new PasswordCreateDTO();
        $form = $this->createForm(PasswordCreateDTOFormType::class, $passwordCreateDTO);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $passwordCreator->createPassword($passwordCreateDTO);
        }

        return $this->render(
            'panel/addPassword.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/index", name="_index")
     */
    public function index(
        PasswordRepository $passwordRepository,
        TokenStorageInterface $tokenStorage
    ) : Response {
        $user = $tokenStorage->getToken()->getUser();
        $passwords = $passwordRepository->findBy(['user' => $user]);
        return $this->render(
            'panel/password_index.html.twig',
            [
                'passwords' => $passwords,
            ]
        );
    }

    /**
     * @Route("/show/{id}", name="_show")
     */
    public function show(
        Password $password,
        OwnPasswordDecoder $ownPasswordDecoder
    ) : Response {

        $encodedPassword = $ownPasswordDecoder->ownDecoder($password->getPassword(), '123');
        return $this->render(
            'panel/password_show.html.twig',
            [
                'password' => $password,
                'encodedPassword' => $encodedPassword,
            ]
        );
    }
}
