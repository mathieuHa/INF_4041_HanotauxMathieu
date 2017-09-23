<?php

namespace MHStoreBundle\Controller;

use MHStoreBundle\Entity\Product;
use MHStoreBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MHStoreBundle:Default:index.html.twig');
    }

    public function addAction(Request $request)
    {
        $product = new Product();
        $form = $this
            ->get('form.factory')
            ->create(ProductType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Produit ajouté');

            return $this->redirectToRoute('mh_store_view', array(
                'id' => $product->getId()
            ));
        }

        return $this->render('MHStoreBundle:Default:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function viewAction($id)
    {
        $product = $this
            ->getDoctrine()
            ->getRepository('MHStoreBundle:Product')
            ->find($id);

        return $this->render('MHStoreBundle:Default:view.html.twig', array(
            'product' => $product
        ));
    }

    public function listAction()
    {
        $products = $this
            ->getDoctrine()
            ->getRepository('MHStoreBundle:Product')
            ->findAll();

        return $this->render('MHStoreBundle:Default:list.html.twig', array(
            'products' => $products
        ));
    }

    public function deleteAction($id)
    {
        $product = $this
            ->getDoctrine()
            ->getRepository('MHStoreBundle:Product')
            ->find($id);
        $em = $this
            ->getDoctrine()
            ->getManager();

        $em->remove($product);
        $em->flush();

        return $this->render('MHStoreBundle:Default:index.html.twig');
    }
}
