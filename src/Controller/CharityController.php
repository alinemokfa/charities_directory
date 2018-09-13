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
        return $this->render('charity/index.html.twig');
    }

    /**
     * @Route("/{slug}", name="charity_show")
     */
    public function show($slug)
    {   
        // $slug will equal the dynamic part of the URL
        return $this->render('charity/show.html.twig', [
            'name' => ucwords(str_replace('-', ' ', $slug))
        ]);
    }
}