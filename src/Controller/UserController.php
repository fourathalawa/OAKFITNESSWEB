<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ManagerType;
use App\Form\UserType;
use App\Form\AdminType;
use App\Form\CoachType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home () :Response
    {
return $this->render('user/home.html.twig');
    }

    /**
     * @Route("/all", name="app_user_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/newadherent", name="app_user_newadherent", methods={"GET", "POST"})
     */
    public function newadherent(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $user->setRoleuser(0);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/newadherent.html.twig', [
            'user' => $user,
            'formU' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newmanager", name="app_user_newmanager", methods={"GET", "POST"})
     */
    public function nawmanager(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(ManagerType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user->setRoleuser(2);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/newmanager.html.twig', [
            'user' => $user,
            'formUM' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newadmin", name="app_user_newadmin", methods={"GET", "POST"})
     */
    public function newadmin(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user->setRoleuser(3);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/newadmin.html.twig', [
            'user' => $user,
            'formUA' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newcoach", name="app_user_newcoach", methods={"GET", "POST"})
     */
    public function newcoach(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userC = new User();
        $form = $this->createForm(CoachType::class, $userC);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $userC->setRoleuser(1);
            $entityManager->persist($userC);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/newcoach.html.twig', [
            'user' => $userC,
            'formUC' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{iduser}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{iduser}/editadherent", name="app_user_editadherent", methods={"GET", "POST"})
     */
    public function editadherent(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editadherent.html.twig', [
            'user' => $user,
            'formU' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{iduser}/editcoach", name="app_user_editcoach", methods={"GET", "POST"})
     */
    public function editcoach(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoachType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirect('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editcoach.html.twig', [
            'user' => $user,
            'formUC' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{iduser}/editmanager", name="app_user_editmanager", methods={"GET", "POST"})
     */
    public function editmanager(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ManagerType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editmanager.html.twig', [
            'user' => $user,
            'formUM' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{iduser}/editadmin", name="app_user_editadmin", methods={"GET", "POST"})
     */
    public function editadmin(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editadmin.html.twig', [
            'user' => $user,
            'formUA' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{iduser}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIduser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }








}
