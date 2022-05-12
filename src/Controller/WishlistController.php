<?php

namespace App\Controller;

use App\Entity\Wishlist;
use App\Form\WishlistType;
use App\Repository\WishlistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wishlist")
 */
class WishlistController extends AbstractController
{
    /**
     * @Route("/", name="app_wishlist_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $wishlists = $entityManager
            ->getRepository(Wishlist::class)
            ->findAll();

        return $this->render('wishlist/index.html.twig', [
            'wishlists' => $wishlists,
        ]);
    }

    /**
     * @Route("/new", name="app_wishlist_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wishlist = new Wishlist();
        $form = $this->createForm(WishlistType::class, $wishlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($wishlist);
            $entityManager->flush();

            return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wishlist/new.html.twig', [
            'wishlist' => $wishlist,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/news/{id}", name="app_wishlist_newfront", methods={"GET", "POST"})
     */
    public function newfront(Request $request, EntityManagerInterface $entityManager,$id,WishlistRepository $repo): Response
    {

        $wishlist = new Wishlist();

        $session=$request->getSession();
        $iduser = $session->get('iduser');

        $wishlist->setIdproduit($id);
        $wishlist->setIduser($iduser);
        echo $wishlist->getIduser();

        $wishlist->setNote("Test");
        try {
            $repo->add($wishlist);

        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
        }
        return $this->redirectToRoute('app_produit_indexfront');
    }

    /**
     * @Route("/{idwishlist}", name="app_wishlist_show", methods={"GET"})
     */
    public function show(Wishlist $wishlist): Response
    {
        return $this->render('wishlist/show.html.twig', [
            'wishlist' => $wishlist,
        ]);
    }

    /**
     * @Route("/{idwishlist}/edit", name="app_wishlist_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Wishlist $wishlist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WishlistType::class, $wishlist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('wishlist/edit.html.twig', [
            'wishlist' => $wishlist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idwishlist}", name="app_wishlist_delete", methods={"POST"})
     */
    public function delete(Request $request, Wishlist $wishlist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wishlist->getIdwishlist(), $request->request->get('_token'))) {
            $entityManager->remove($wishlist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_wishlist_index', [], Response::HTTP_SEE_OTHER);
    }
}
