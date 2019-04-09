<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Topic;
use ForumBundle\Form\TopicType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ForumBundle\Entity\Forum;
use ForumBundle\Entity\Post;

class TopicController extends Controller
{
    public function createTopicAction(Request $request, $forum_id)
    {
        //create an entity manager object
        $em = $this->getDoctrine()->getManager();

        //get the forum
        $forum = $em->getRepository(Forum::class)->find($forum_id);

        //create an object to store our data after the form submission
        $topic = new Topic();
        $topic->setUser($this->container->get('security.token_storage')->getToken()->getUser());
        $topic->setForum($forum);

        //prepare the form with the function: createForm()
        $form = $this->createForm(TopicType::class, $topic);
        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //if this form is valid
        if($form->isValid())
        {
            //presist the object $topic in the ORM
            $em->persist($topic);
            //create a post object
            $post = new Post();
            $post->setContent($form["postContent"]->getData());
            $post->setUser($this->container->get('security.token_storage')->getToken()->getUser());
            $post->setTopic($topic);

            //presist the object $post in the ORM
            $em->persist($post);
            //update the database with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('showPosts');
        }
        return $this->render('@Forum/Topic/create.html.twig',array(
            'form' => $form->createView(),
            'parent_forum' => $forum
        ));
    }

    public function deleteTopicAction($id, $parent_id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository(Topic::class)->find($id);
        //remove from the ORM
        $em->remove($topic);
        //update the data base
        $em->flush();
        return $this->redirectToRoute('sub_forums', array('id' => $parent_id));
    }

    public function pinTopicAction($id, $parent_id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository(Topic::class)->find($id);
        $topic->setPinned(true);
        $em->flush();
        return $this->redirectToRoute('sub_forums', array('id' => $parent_id));
    }

    public function unpinTopicAction($id, $parent_id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository(Topic::class)->find($id);
        $topic->setPinned(false);
        $em->flush();
        return $this->redirectToRoute('sub_forums', array('id' => $parent_id));
    }

    public function closeTopicAction($id, $parent_id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository(Topic::class)->find($id);
        $topic->setClosed(true);
        $em->flush();
        return $this->redirectToRoute('sub_forums', array('id' => $parent_id));
    }

    public function openTopicAction($id, $parent_id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository(Topic::class)->find($id);
        $topic->setClosed(false);
        $em->flush();
        return $this->redirectToRoute('sub_forums', array('id' => $parent_id));
    }

}
