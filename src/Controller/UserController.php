<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Ttskch\PaginatorBundle\Context;
use Ttskch\PaginatorBundle\Doctrine\Counter;
use Ttskch\PaginatorBundle\Doctrine\Slicer;

/**
 * @Route("/user", name="user_")
 * @Template()
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(UserRepository $repository, Context $context)
    {
        $qb = $repository->createQueryBuilder('u');
        $context->initialize('id', new Slicer($qb), new Counter($qb));

        return [
            'users' => $context->slice,
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
