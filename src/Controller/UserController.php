<?php

namespace App\Controller;
//require_once 'vendor\autoload.php';
use App\Form\PasswordResit;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Twilio\Rest\Client;
use App\Entity\User;
use App\Form\ForgetPasswordType;
use App\Form\ManagerType;
use App\Form\UserType;
use App\Form\AdminType;
use App\Form\CoachType;
use App\Form\LoginType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File;
/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login" ,methods={"GET", "POST"})
     */
    public function Login (Request $request, UserRepository $userRepository,SessionInterface $session) :Response
    {

        $user = new User();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $mail= $user->getMailuser();
            $pass= $user->getPassword();

            if($mail!="" && $pass!="") {
                if ($form->isSubmitted()) {
                    $us = $userRepository->findOneBy(['mailuser' => $mail, 'password' => $pass]);
                    if ($us->getRoleUser() == "0") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "0");
                        return $this->render('user/show.html.twig', [
                            'user' => $us
                        ]);
                    } else if ($us->getRoleUser() == "1") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "1");
                        return $this->render('user/show.html.twig', [
                            'user' => $us
                        ]);
                    } else if ($us->getRoleUser() == "2") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "2");
                        return $this->render('user/show.html.twig', [
                            'user' => $us
                        ]);
                    } else if ($us->getRoleUser() == "3") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "3");
                        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
                    }
                }
            }
                return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }
return $this->render('user/login.html.twig',['formL' => $form->createView()]);
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
     * @Route("/forget", name="app_user_forget", methods={"GET", "POST"})
     */
    public function ForgetPassword(Request $request, MailerInterface $mailer,UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(ForgetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $us=$userRepository->findOneBy(['mailuser' => $user->getMailuser()]);
            $email = (new TemplatedEmail())
                ->from('fourat.halaoua@esprit.tn')
                ->to($user->getMailuser())
                ->subject('OAKFITNESS Password')
                ->htmlTemplate('user/mailmotdepasse.html.twig')
                ->context([
                    'url'=>'user/motdepasse/'.$us->getIduser()
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                var_dump($e->getMessage());
            }
            return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/forgetpassword.html.twig',['formF' => $form->createView()]);
    }
    /**
     * @Route("/newadherent", name="app_user_newadherent", methods={"GET", "POST"})
     */
    public function newadherent(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user->setRoleuser(0);
            $code=random_int(90000, 100000);
            $user->setCodeverification($code);
            $file = $user->getImageuser();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName

                );}catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $user->setImageuser($fileName);


            $entityManager->persist($user);

            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('fourat.halaoua@esprit.tn')
                ->to($user->getMailuser())
                ->subject('OAKFITNESS Password')
                ->htmlTemplate('user/mailverification.html.twig')
                ->context([
                   'url'=> 'user/verificationAccount/'.$user->getCodeverification()
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                var_dump($e->getMessage());
            }
            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
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
     * @Route("/show", name="app_user_show", methods={"GET"})
     */
    public function show(User $user,Request $request,UserRepository $userRepository): Response
    {
        $session=$request->getSession();
        $user=$userRepository->findOneBy($session->get('iduser',0));
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/editadherent", name="app_user_editadherent", methods={"GET", "POST"})
     */
    public function editadherent(Request $request, User $user, EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {$session=$request->getSession();
    var_dump($session);
    die();

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

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
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

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
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

    /**
     * @Route("/verificationAccount/{codeverificationuser}", name="app_user_verif", methods={"GET","POST"})
     */
    public function verifAccount($codeverificationuser,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->findOneBy(['codeverification'=>$codeverificationuser]);
        if($user != null)
        {
            $user->setCodeverification(1);
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('user/verificationaccount.html.twig', [
'user'=>$user
        ]);

    }
    /**
     * @Route("/motdepasse/{iduser}", name="app_user_motdepasse", methods={"GET", "POST"})
     */
    public function passwordresit($iduser,Request $request, User $user,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PasswordResit::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $us=$userRepository->findOneBy(['iduser' =>$iduser ]);
            $us->setPassword($user->getPassword());
            $entityManager->persist($us);
            $entityManager->flush();

            return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/passwordresit.html.twig', [
            'formR' => $form->createView(),
        ]);
    }


}
