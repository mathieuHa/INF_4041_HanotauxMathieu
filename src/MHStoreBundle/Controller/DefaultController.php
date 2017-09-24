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
        $user = $this->getUser();
        $product = new Product();
        $form = $this
            ->get('form.factory')
            ->create(ProductType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product->setSeller($user);
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

    public function buyAction($id, Request $request)
    {
        $user = $this->getUser();

        $product = $this
            ->getDoctrine()
            ->getRepository('MHStoreBundle:Product')
            ->find($id);
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product->setBuyer($user);
            $product->setSold(true);
            $product->setSoldDate(new \DateTime());
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Produit acheté');

            return $this->redirectToRoute('mh_store_view', array(
                'id' => $product->getId()
            ));
        }

        return $this->render('MHStoreBundle:Default:buy.html.twig', array(
            'form' => $form->createView(),
            'product' => $product
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
            ->findAllActiveProduct();

        return $this->render('MHStoreBundle:Default:list.html.twig', array(
            'products' => $products
        ));
    }

    public function salesAction()
    {
        $user = $this->getUser();

        $products = $this
            ->getDoctrine()
            ->getRepository('MHStoreBundle:Product')
            ->findBySeller($user->getId());

        return $this->render('MHStoreBundle:Default:sales.html.twig', array(
            'products' => $products,
            'user' => $user
        ));
    }

    public function purchasesAction()
    {
        $user = $this->getUser();

        $products = $this
            ->getDoctrine()
            ->getRepository('MHStoreBundle:Product')
            ->findByBuyer($user->getId());

        return $this->render('MHStoreBundle:Default:purchases.html.twig', array(
            'products' => $products,
            'user' => $user
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
