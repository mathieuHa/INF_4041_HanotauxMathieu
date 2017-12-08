<?php

namespace MHStoreBundle\Controller;

use MHStoreBundle\Entity\Credit;
use MHStoreBundle\Entity\Image;
use MHStoreBundle\Entity\Product;
use MHStoreBundle\Entity\User;
use MHStoreBundle\Form\CreditType;
use MHStoreBundle\Form\ProductAddType;
use MHStoreBundle\Form\ProductEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $products = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->findLastActiveProduct();

        return $this->render('MHStoreBundle:Default:index.html.twig', array(
            'products' => $products
        ));
    }

    public function addAction(Request $request)
    {
        $user = $this->getUser(); // vérification des utilisateurs connectés faite dans le security.yml
        $product = new Product();
        $form = $this
            ->get('form.factory')
            ->create(ProductAddType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            if(NULL == $product->getImage()){
                $image = new Image();
                $image->setAlt("unknown");
                $image->setUrl("unknown.jpg");
                $product->setImage($image);
            }

            $em = $this->getDoctrine()->getManager();
            $product->setSeller($user);
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Product added');

            return $this->redirectToRoute('mh_store_view', array(
                'id' => $product->getId()
            ));
        }

        return $this->render('MHStoreBundle:Default:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, Product $product = null)
    {
        if (null == $product) {
            $request->getSession()->getFlashBag()->add('notice', 'This product does not exist');
            return $this->redirectToRoute('mh_store_list');
        }
        $user = $this->getUser(); // vérification des utilisateurs connectés faite dans le security.yml

        if ($product->getSeller() != $user){
            $request->getSession()->getFlashBag()->add('notice', 'We can not modify a product that does not belong to us!');
            return $this->redirectToRoute('mh_store_sales');
        }

        if ($product->getSold()){
            $request->getSession()->getFlashBag()->add('notice', 'We can not modify a product that we have already sold!');
            return $this->redirectToRoute('mh_store_sales');
        }

        $form = $this
            ->get('form.factory')
            ->create(ProductEditType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product->setSeller($user);
            $em->persist($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Product Updated');

            return $this->redirectToRoute('mh_store_view', array(
                'id' => $product->getId()
            ));
        }

        return $this->render('MHStoreBundle:Default:edit.html.twig', array(
            'form' => $form->createView(),
            'product' => $product
        ));
    }


    public function buyAction(Request $request, Product $product = null)
    {
        if (null == $product) {
            $request->getSession()->getFlashBag()->add('notice', 'This product does not exist');
            return $this->redirectToRoute('mh_store_list');
        }
        $user = $this->getUser(); // vérification des utilisateurs connectés faite dans le security.yml
        $credit = $user->getCredit();

        if ($product->getSeller() == $user){
            $request->getSession()->getFlashBag()->add('notice', 'We can not buy a product that belongs to us!');
            return $this->redirectToRoute('mh_store_view', array(
                'id' => $product->getId()
            ));
        }

        if ($product->getSold()){
            $request->getSession()->getFlashBag()->add('notice', 'We can not buy a product already sold! ');
            return $this->redirectToRoute('mh_store_sales');
        }

        $price = $product->getPrice();

        if ($price<=$credit){
            $form = $this->get('form.factory')->create();

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $product->setBuyer($user);
                $product->setSold(true);
                $product->setSoldDate(new \DateTime());
                $user->setCredit($credit-$price);
                $em->persist($product);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Purchased product');

                return $this->redirectToRoute('mh_store_view', array(
                    'id' => $product->getId()
                ));
            }

            return $this->render('MHStoreBundle:Default:buy.html.twig', array(
                'form' => $form->createView(),
                'product' => $product
            ));
        }
        else {
            $request->getSession()->getFlashBag()->add('notice', 'Not enough credits');
            return $this->render('MHStoreBundle:Default:view.html.twig', array(
                'product' => $product
            ));
        }


    }

    public function rechargeAction(Request $request)
    {
        $user = $this->getUser(); // vérification des utilisateurs connectés faite dans le security.yml
        $credit = new Credit();

        $form = $this->get('form.factory')->create(CreditType::class, $credit);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->recharge($credit->getNumber());
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', $credit->getNumber().' credit(s) bought');

            return $this->redirectToRoute('mh_store_home');
        }

        return $this->render('MHStoreBundle:Default:recharge.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function viewAction(Product $product = null, Request $request)
    {
        if (null == $product) {
            $request->getSession()->getFlashBag()->add('notice', 'This product does not exist');
            return $this->redirectToRoute('mh_store_list');
        }
        return $this->render('MHStoreBundle:Default:view.html.twig', array(
            'product' => $product
        ));
    }

    public function listAction()
    {
        $products = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->findAllActiveProduct();

        return $this->render('MHStoreBundle:Default:list.html.twig', array(
            'products' => $products
        ));
    }

    public function searchAction(Request $request)
    {
        $tag = $request->get('tag');

        if (NULL == $tag)
            return $this->redirectToRoute('mh_store_list'); // recherche nulle = list complète

        $products = $this
            ->getDoctrine()
            ->getRepository(Product::class)
            ->searchProduct($tag);

        return $this->render('MHStoreBundle:Default:search.html.twig', array(
            'products' => $products,
            'tag' => $tag
        ));
    }




    public function salesAction()
    {
        $user = $this->getUser(); // vérification des utilisateurs connectés faite dans le security.yml

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
        $user = $this->getUser(); // vérification des utilisateurs connectés faite dans le security.yml

        $products = $this
            ->getDoctrine()
            ->getRepository('MHStoreBundle:Product')
            ->findByBuyer($user->getId());

        return $this->render('MHStoreBundle:Default:purchases.html.twig', array(
            'products' => $products,
            'user' => $user
        ));
    }

    public function deleteAction(Request $request, Product $product = null)
    {
        if (null == $product) {
            $request->getSession()->getFlashBag()->add('notice', 'This product does not exist');
            return $this->redirectToRoute('mh_store_sales');
        }
        $user = $this->getUser(); // vérification des utilisateurs connectés faite dans le security.yml

        if ($product->getSeller() != $user){
            $request->getSession()->getFlashBag()->add('notice', 'We can not delete a product that does not belong to us! ');
            return $this->redirectToRoute('mh_store_sales');
        }

        if ($product->getSold()){
            $request->getSession()->getFlashBag()->add('notice', 'We can not delete a product already sold! ');
            return $this->redirectToRoute('mh_store_sales');
        }

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this
                ->getDoctrine()
                ->getManager();

            $em->remove($product);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Produit supprimé');

            return $this->redirectToRoute('mh_store_sales');
        }

        return $this->render('MHStoreBundle:Default:delete.html.twig', array(
            'form' => $form->createView(),
            'product' => $product
        ));
    }
}
