<?php

namespace App\Controller;

use App\Entity\Category;

//Add Sensio bundles to be able to use route and method annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

// AbstractController gives access to shortcut methods such as render()
class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="category_list")
     * @Method({"GET"})
     */
    public function index()
    {   
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('categories/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/new", name="new_category")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $category = new Category();

        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Create', 'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $category = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_list');

        }

        return $this->render('categories/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name="edit_category")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, $id)
    {
        $category = new Category();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
  
        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('save', SubmitType::class, ['label' => 'Update', 'attr' => ['class' => 'btn btn-primary mt-3']])
            ->getForm();
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('category_list');

        }

        return $this->render('categories/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/category/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        
            //js fetch expects a response
        $response = new Response();
        $response->send();
    }
}