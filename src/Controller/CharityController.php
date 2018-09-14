<?php

namespace App\Controller;

use App\Entity\Charity;
use App\Entity\Category;
//Add Sensio bundles to be able to use route and method annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

// AbstractController gives access to shortcut methods such as render()
class CharityController extends AbstractController
{
    /**
     * @Route("/", name="charity_list")
     * @Method({"GET"})
     */
    public function index()
    {   
        $charities = $this->getDoctrine()->getRepository(Charity::class)->findAll();

        return $this->render('charities/index.html.twig', [
            'charities' => $charities
        ]);
    }

    /**
     * @Route("/charity/new", name="new_charity")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $charity = new Charity();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $form = $this->createFormBuilder($charity)
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            //TODO - Render category name
            ->add('category', ChoiceType::class, ['choices' => [ $categories ], 'attr' => ['class' => 'form-control']])
            ->add('description', TextareaType::class, ['attr' => ['class' => 'form-control']])
            ->add('address', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Create', 'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $charity = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($charity);
            $entityManager->flush();

            return $this->redirectToRoute('charity_list');

        }

        return $this->render('charities/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/charity/edit/{id}", name="edit_charity")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $charity = new Charity();
        $charity = $this->getDoctrine()->getRepository(Charity::class)->find($id);

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $form = $this->createFormBuilder($charity)
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            //TODO - Render category name
            ->add('category', ChoiceType::class, ['choices' => [ $categories ], 'attr' => ['class' => 'form-control']])
            ->add('description', TextareaType::class, ['attr' => ['class' => 'form-control']])
            ->add('address', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Update', 'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('charity_list');

        }

        return $this->render('charities/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //Orther matters so show() needs to come after new() and update()
    /**
     * @Route("/charity/{id}", name="charity_show")
     */
    public function show($id)
    {   
        $charity = $this->getDoctrine()->getRepository(Charity::class)->find($id);
    

        return $this->render('charities/show.html.twig', [
            'charity' => $charity
        ]);
    }

    /**
     * @Route("/charity/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $charity = $this->getDoctrine()->getRepository(Charity::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($charity);
            $entityManager->flush();
        
            //js fetch expects a response
        $response = new Response();
        $response->send();
    }

    //THIS IS NOT TO BE USED as GET requests should not be able to update data on the server, FOR REFERENCE ONLY
    // /**
    //  * @Route("/charity/save")
    //  */
    // public function save()
    // {
    //     $entityManager = $this->getDoctrine()->getManager();

    //     $charity = new Charity();
    //     $category = new Category();
    //     $category->setName('Environmental');
    //     $charity->setCategory($category);
    //     $charity->setName('The Greenpeace Environmental Trust');
    //     $charity->setAddress('Greenpeace, Canonbury Villas, London N1 2PN, UK');
    //     $charity->setDescription('The Greenpeace Environmental Trust is a registered charity (284934) and a company limited by guarantee (company number 1636817).
    //     Founded in 1982 with the objective of “furthering public understanding of and promoting the protection of world ecology and the natural environment”.');
    //     $entityManager->persist($category);
    //     $entityManager->persist($charity);
    //     $entityManager->flush();

    //     return new Response('Charity has been saved');
    // }
}