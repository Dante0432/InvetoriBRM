<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $currentUser=$this->getUser();                    
        $form = $this->createFormBuilder()
        ->add('productType', EntityType::class, ['class' => ProductType::class])
        ->add('quantity', IntegerType::class )
        ->add('lot', IntegerType::class )
        ->add('expirationDate', DateType::class, [
            'attr' => [
                'class' => 'child::float-rigth w-25'
            ]
        ])
        ->add('price', NumberType::class )
        ->add('Create', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary float-rigth mt-3'
            ]
        ])
        ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            for ($i = 0; $i < $data['quantity']; ++$i) {
                $product = new Product();
                $product->setLot(intval($data['lot']));
                $product->setExpirationDate($data['expirationDate']);
                $product->setPrice($data['price']);
                $product->setProductType($data['productType']);
                $entityManager->persist($product);
            }
            $entityManager->flush();
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => new Product(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
