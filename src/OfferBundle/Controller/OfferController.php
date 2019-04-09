<?php

namespace OfferBundle\Controller;

use OfferBundle\Form\OfferType;
use Symfony\Component\HttpFoundation\Request;
use OfferBundle\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OfferController extends Controller
{
    public function showAction()
    {
        // Fetching Objects (contacts) from the Database
        $offers =$this->getDoctrine()->getRepository(Offer::class)->findAll();
        //add the list of modeles to the render function as input to be sent to the view
        return $this->render('@Offer/Offer/show.html.twig', array(
            'offers' => $offers
        ));
    }

    public function showSingleAction($id)
    {
        //get the object to be shown given the submitted id
        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository(Offer::class)->find($id);
        return $this->render('@Offer/Offer/showSingle.html.twig', array(
            'offer' => $offer
        ));

    }

    public function createServiceAction(Request $request)
    {
        //create an object to store our data after the form submission
        $offer = new Offer();
        //prepare the form with the function: createForm()
        $form = $this->createForm(OfferType::class, $offer);
        //extract the form answer from the received request
        $form = $form->handleRequest($request);
        //if this form is valid
        if($form->isValid())
        {
            $offer->setOwner($this->container->get('security.token_storage')->getToken()->getUser());
            //create an entity manager object
            $em = $this->getDoctrine()->getManager();
            //presist the object $contact in the ORM
            $em->persist($offer);
            //update the database with flush
            $em->flush();
            //redirect the route after the add
            return $this->redirectToRoute('showOffers');
        }
        return $this->render('@Offer/Offer/create.html.twig',array(
            'form' => $form->createView()
        ));
    }


}
