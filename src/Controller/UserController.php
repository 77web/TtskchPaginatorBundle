<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user_")
 * @Template()
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(UserRepository $repository)
    {
        $users = $repository->findAll();

        return [
            'users' => $users,
        ];
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function show(User $user)
    {
        return [
            'user' => $user,
        ];
    }
}
