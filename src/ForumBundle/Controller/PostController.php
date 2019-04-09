<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{
    public function showPostsAction()
    {
        return $this->render('@Forum/Post/posts.html.twig');
    }
}
