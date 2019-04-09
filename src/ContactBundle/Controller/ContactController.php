<?php

namespace ContactBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use ContactBundle\Entity\Contact;
use ContactBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ContactController extends Controller
{
    public function showAction()
    {
        // Fetching Objects (contacts) from the Database
        $contacts =$this->getDoctrine()->getRepository(Contact::class)->findAll();
        //add the list of modeles to the render function as input to be sent to the view
        return $this->render('@Contact/Contact/show.html.twig', array(
            'contacts' => $contacts
        ));
    }

    public function createAction(Request $request)
    {
        //create an object to store our data after the form submission
        $contact = new Contact();
        //prepare the form with the function: createForm()
        $form = $this->createForm(ContactType::class, $contact);
        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //if this form is valid
        if($form->isValid())
        {
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();
            //presist the object $contact in the ORM
            $em->persist($contact);
            //update the database with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('createContact');
        }
        return $this->render('@Contact/Contact/create.html.twig',array(
           'form' => $form->createView()
        ));
    }

    public function deleteAction($id)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository(Contact::class)->find($id);
        //remove from the ORM
        $em->remove($contact);
        //update the data base
        $em->flush();
       return $this->showAction();
    }

}
