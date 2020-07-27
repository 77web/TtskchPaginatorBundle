<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post_")
 * @Template()
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $repository)
    {
        $posts = $repository->findAll();

        return [
            'posts' => $posts,
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
