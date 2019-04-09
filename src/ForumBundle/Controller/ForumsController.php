<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Forum;
use ForumBundle\Entity\Topic;
use ForumBundle\Form\ForumType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ForumsController extends Controller
{
    /* Main Forums CRUD   */
    public function indexAction(Request $request)
    {
        // Fetching Objects (forums) from the Database
        $forums =$this->getDoctrine()->getRepository(Forum::class)->findAll(array('parent'=> null));

        $dql = "SELECT forum FROM ForumBundle:Forum forum WHERE forum.parent IS NULL ORDER BY forum.addedDate DESC ";
        $query = $this->getDoctrine()->getManager()->createQuery($dql);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 6)

        );

        //add the list of modeles to the render function as input to be sent to the view
        return $this->render('@Forum/Forum/Forums.html.twig', array(
            'forums' => $result
        ));
    }

    public function deleteForumAction($id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $forum = $em->getRepository(Forum::class)->find($id);
        //remove from the ORM
        $em->remove($forum);
        //update the data base
        $em->flush();
        return $this->redirectToRoute("forums_homepage");
    }


    public function createForumAction(Request $request)
    {
        //create an object to store our data after the form submission
        $forum = new Forum();
        $forum->setUserId($this->container->get('security.token_storage')->getToken()->getUser());
        $forum->addModerator($this->container->get('security.token_storage')->getToken()->getUser());
        //prepare the form with the function: createForm()
        $form = $this->createForm(ForumType::class, $forum);
        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //if this form is valid
        if($form->isValid() and $form->isSubmitted())
        {
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();

            // $file stores the uploaded PNG file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $forum->getWallpaper();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('forum_wallpapers_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $forum->setWallpaper($fileName);

            //presist the object $forum in the ORM
            $em->persist($forum);
            //update the database with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('forums_homepage');
        }
        return $this->render('@Forum/Forum/create.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function updateForumAction(Request $request, $id)
    {
        $forum = $this->getDoctrine()->getRepository(Forum::class)->find($id);
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em ->persist($forum);
            $em ->flush();
            return $this->redirectToRoute('forums_homepage');
        }
        return $this->render('@Forum/Forum/update.html.twig',
            array("form" => $form->createView(),
            "forum" => $forum
            ));

    }

    /* Sub Forums CRUD */
    public function showSubForumsAction(Request $request, $id)
    {
        $parent_main = false;
        // Fetching Objects (forum) from the Database
        $sub_forums = $this->getDoctrine()->getRepository(Forum::class)->findBy(array('parent' => $id));
        $parent = $this->getDoctrine()->getRepository(Forum::class)->find($id);
        if($parent->getParent() == null)
        {
            $parent_main = true;
        }
        $dql = "SELECT forum FROM ForumBundle:Forum forum WHERE forum.parent = $id ORDER BY forum.addedDate DESC";
        $query = $this->getDoctrine()->getManager()->createQuery($dql);

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)

        );

        // Fetching Objects (topics) from the database
        $topics = $this->getDoctrine()->getRepository(Topic::class )->findBy(array('forum' =>$id));
        $dql = "SELECT topic FROM ForumBundle:Topic topic WHERE topic.forum = $id ORDER BY topic.pinned DESC ";
        $query = $this->getDoctrine()->getManager()->createQuery($dql);

        $topics_result = $paginator->paginate(
            $query,
            $request->query->getInt('otherpage', 1),
            $request->query->getInt('otherlimit', 7)
        );

        //add the list of modeles to the render function as input to be sent to the view
        return $this->render('@Forum/Forum/sub_forums.html.twig', array(
            'sub_forums' => $result,
            'parent_id' => $id,
            'forum_topics' =>$topics_result,
            'parent_main' => $parent_main
        ));
    }

    public function createSubForumAction(Request $request, $parent_id)
    {
        //create an entity manager object
        $em = $this->getDoctrine()->getManager();

        //get the parent forum
        $parent = $em->getRepository(Forum::class)->find($parent_id);

        //create an object to store our data after the form submission
        $forum = new Forum();
        $forum->setUserId($this->container->get('security.token_storage')->getToken()->getUser());
        $forum->addModerator($this->container->get('security.token_storage')->getToken()->getUser());
        $forum->setParent($parent);
        //prepare the form with the function: createForm()
        $form = $this->createForm(ForumType::class, $forum);
        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //if this form is valid
        if($form->isValid() and $form->isSubmitted())
        {
            // $file stores the uploaded PNG file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $forum->getWallpaper();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('forum_wallpapers_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $forum->setWallpaper($fileName);

            //presist the object $forum in the ORM
            $em->persist($forum);
            //update the database with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('sub_forums', array('id' => $parent_id));
        }
        return $this->render('@Forum/Forum/create_sub_forum.html.twig',array(
            'form' => $form->createView(),
            'parent_id' => $parent_id,
            'parent' => $parent
        ));
    }

    public function deleteSubForumAction($id, $parent_id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $forum = $em->getRepository(Forum::class)->find($id);
        //remove from the ORM
        $em->remove($forum);
        //update the data base
        $em->flush();
        return $this->redirectToRoute("sub_forums", array('id' => $parent_id));
    }

    public function updateSubForumAction(Request $request, $id, $parent_id)
    {
        $forum = $this->getDoctrine()->getRepository(Forum::class)->find($id);
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em ->persist($forum);
            $em ->flush();
            return $this->redirectToRoute('sub_forums', array('id' => $parent_id));
        }
        return $this->render('@Forum/Forum/update_sub_forum.html.twig',
            array("form" => $form->createView(),
                "forum" => $forum,
                "parent_id" => $parent_id
            ));

    }

    /* Common utilities */

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}
