<?php

namespace App\Controller;

//Add Sensio bundles to be able to use route and method annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// AbstractController gives access to shortcut methods such as render()
class CharityController extends AbstractController
{
    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function index()
    {   
        $charities= ['Charity1', 'Charity2'];

        return $this->render('charities/index.html.twig', [
            'charities' => $charities
        ]);
    }

    /**
     * @Route("/{slug}", name="charity_show")
     */
    public function show($slug)
    {   
        // $slug will equal the dynamic part of the URL
        return $this->render('charities/show.html.twig', [
            'name' => ucwords(str_replace('-', ' ', $slug))
        ]);
    }
}