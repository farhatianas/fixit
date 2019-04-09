<?php

namespace OfferBundle\Controller;

use OfferBundle\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OfferBundle\Entity\Categorie;

class CategorieController extends Controller
{

    public function showAction()
    {
        // Fetching Objects (contacts) from the Database
        $categories =$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        //add the list of modeles to the render function as input to be sent to the view
        return $this->render('@Offer/Categorie/ManageCategories.html.twig', array(
            'categories' => $categories
        ));
    }


    public function createAction(Request $request)
    {
        //create an object to store our data after the form submission
        $categorie = new Categorie();
        //prepare the form with the function: createForm()
        $form = $this->createForm(CategorieType::class, $categorie);
        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //if this form is valid
        if($form->isValid())
        {
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();
            //presist the object $contact in the ORM
            $em->persist($categorie);
            //update the database with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('showCategories');
        }
        return $this->render('@Offer/Categorie/createCategorie.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository(Categorie::class)->find($id);
        //remove from the ORM
        $em->remove($category);
        //update the data base
        $em->flush();
        return $this->showAction();
    }

}
