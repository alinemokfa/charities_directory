<?php

namespace App\Controller;

//route annotation, instead of using routes.yaml
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// AbstractController gives access to shortcut methods such as render()
class CharityController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('TODO');
    }

    /**
     * @Route("/charities/{slug}")
     */
    public function show($slug)
    {   // $slug will equal the dynamic part of the URL
        return $this->render('charity/show.html.twig', [
            'name' => ucwords(str_replace('-', ' ', $slug))
        ]);
    }
}