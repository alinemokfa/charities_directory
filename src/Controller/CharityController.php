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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('charities/index.html.twig', [
            'charities' => $charities,
            'categories' => $categories
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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                }
            ])
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
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function ($category) {
                    return $category->getName();
                }
            ])
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

    //Order matters so show() needs to come after new() and update()
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

    /**
     * @Route("/charities/{catId}")
     * @Method({"GET"})
     */
    public function filter($catId)
    {   
        $category = $this->getDoctrine()->getRepository(Category::class)->find($catId);
        $charities = $this->getDoctrine()->getRepository(Charity::class)->findByCategory($category);
        
        return $this->render('charities/filter.html.twig', [
            'charities' => $charities
        ]);
    }
}