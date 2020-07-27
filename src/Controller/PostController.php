<?php

declare(strict_types=1);

namespace App\Controller;

use App\Criteria\Form\PostSearchType;
use App\Criteria\PostCriteria;
use App\Entity\Post;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Ttskch\PaginatorBundle\Context;
use Ttskch\PaginatorBundle\Doctrine\Counter;
use Ttskch\PaginatorBundle\Doctrine\Slicer;

/**
 * @Route("/post", name="post_")
 * @Template()
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $repository, Context $context)
    {
        $qb = $repository->createQueryBuilder('u');
        $context->initialize(
            'id',
            [$repository, 'sliceByCriteria'],
            [$repository, 'countByCriteria'],
            PostCriteria::class,
            PostSearchType::class
        );

        return [
            'posts' => $context->slice,
            'form' => $context->form->createView(),
        ];
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function show(Post $post)
    {
        return [
            'post' => $post,
        ];
    }
}
