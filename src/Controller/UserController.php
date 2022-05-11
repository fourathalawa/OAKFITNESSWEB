<?php

namespace App\Controller;
//require_once 'vendor\autoload.php';
use App\Form\PasswordResit;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
                    if($us->getCodeverification()==1)
                    {
                    if ($us->getRoleUser() == "0") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "0");
                        $session->set('image', $us->getImageuser());
                        $session->set('nom',$us->getNomuser());
                        $session->set('prenom',$us->getPrenomuser());

                        return $this->render('user/show.html.twig', [
                            'user' => $us
                        ]);
                    } else if ($us->getRoleUser() == "1") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "1");
                        $session->set('image', $us->getImageuser());
                        $session->set('nom',$us->getNomuser());
                        $session->set('prenom',$us->getPrenomuser());
                        return $this->render('user/show.html.twig', [
                            'user' => $us
                        ]);
                    } else if ($us->getRoleUser() == "2") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "2");
                        $session->set('image', $us->getImageuser());
                        $session->set('nom',$us->getNomuser());
                        $session->set('prenom',$us->getPrenomuser());
                        return $this->render('user/show.html.twig', [
                            'user' => $us
                        ]);
                    } else if ($us->getRoleUser() == "3") {
                        $session->set('iduser', $us->getIduser());
                        $session->set('roleuser', "3");
                        $session->set('image', $us->getImageuser());
                        $session->set('nom',$us->getNomuser());
                        $session->set('prenom',$us->getPrenomuser());
                        return $this->redirectToRoute('app_user_alladherent', [], Response::HTTP_SEE_OTHER);
                    }
                }else
                    {
                        return $this->render('user/notverified.html.twig', []);
                    }

                }
            }
                return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }
return $this->render('user/login.html.twig',['formL' => $form->createView()]);
    }

    /**
     * @Route("/alladherent", name="app_user_alladherent", methods={"GET"})
     */
    public function alladherent(Request $request,EntityManagerInterface $entityManager): Response
    { $session=$request->getSession();
        $users = $entityManager
            ->getRepository(User::class)
            ->findby(['roleuser'=>0]);

        return $this->render('user/alladherent.html.twig', [
            'users' => $users,
            'image'=> $session->get('image'),
            'nom'=> $session->get('nom'),
            'prenom'=> $session->get('prenom'),
        ]);
    }
    /**
     * @Route("/allcoach", name="app_user_allcoach", methods={"GET"})
     */
    public function allcoach(Request $request,EntityManagerInterface $entityManager): Response
    {$session=$request->getSession();
        $users = $entityManager
            ->getRepository(User::class)
            ->findby(['roleuser'=>1]);

        return $this->render('user/allcoach.html.twig', [
            'users' => $users,
            'image'=> $session->get('image'),
            'nom'=> $session->get('nom'),
            'prenom'=> $session->get('prenom'),        ]);
    }
    /**
     * @Route("/allmanager", name="app_user_allmanager", methods={"GET"})
     */
    public function allmanager(Request $request,EntityManagerInterface $entityManager): Response
    {$session=$request->getSession();
        $users = $entityManager
            ->getRepository(User::class)
            ->findby(['roleuser'=>2]);

        return $this->render('user/allmanager.html.twig', [
            'users' => $users,
            'image'=> $session->get('image'),
            'nom'=> $session->get('nom'),
            'prenom'=> $session->get('prenom'),        ]);
    }
    /**
     * @Route("/alladmin", name="app_user_alladmin", methods={"GET"})
     */
    public function alladmin(Request $request,EntityManagerInterface $entityManager): Response
    {$session=$request->getSession();
        $users = $entityManager
            ->getRepository(User::class)
            ->findby(['roleuser'=>3]);

        return $this->render('user/alladmin.html.twig', [
            'users' => $users,
            'image'=> $session->get('image'),
            'nom'=> $session->get('nom'),
            'prenom'=> $session->get('prenom'),        ]);
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
            $file = $form->get('imageuser')->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $user->setImageuser($fileName);
            $entityManager->persist($user);

            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('fourat.halaoua@esprit.tn')
                ->to($user->getMailuser())
                ->subject('OAKFITNESS Verify Account')
                ->htmlTemplate('user/mailverification.html.twig')
                ->context([
                   'url'=> 'user/verificationAccount/'.$user->getCodeverification()
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                var_dump($e->getMessage());
            }
            return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/newadherent.html.twig', [
            'user' => $user,
            'formU' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newmanager", name="app_user_newmanager", methods={"GET", "POST"})
     */
    public function nawmanager(Request $request,MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(ManagerType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user->setRoleuser(2);
            $code=random_int(90000, 100000);
            $user->setCodeverification($code);
            $file = $form->get('imageuser')->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $user->setImageuser($fileName);
            $entityManager->persist($user);

            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('fourat.halaoua@esprit.tn')
                ->to($user->getMailuser())
                ->subject('OAKFITNESS Verify Account')
                ->htmlTemplate('user/mailverification.html.twig')
                ->context([
                    'url'=> 'user/verificationAccount/'.$user->getCodeverification()
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                var_dump($e->getMessage());
            }

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
    public function newcoach(Request $request,MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $userC = new User();
        $form = $this->createForm(CoachType::class, $userC);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $userC->setRoleuser(1);
            $code=random_int(90000, 100000);
            $userC->setCodeverification($code);
            $file = $form->get('imageuser')->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $userC->setImageuser($fileName);
            $entityManager->persist($userC);

            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from('fourat.halaoua@esprit.tn')
                ->to($userC->getMailuser())
                ->subject('OAKFITNESS Verify Account')
                ->htmlTemplate('user/mailverification.html.twig')
                ->context([
                    'url'=> 'user/verificationAccount/'.$userC->getCodeverification()
                ]);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                var_dump($e->getMessage());
            }

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
    public function show(Request $request,UserRepository $userRepository): Response
    {
        $session=$request->getSession();
        $user=$userRepository->findOneBy(['iduser'=>$session->get('iduser',0)]);
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/editadherent", name="app_user_editadherent", methods={"GET", "POST"})
     */
    public function editadherent(Request $request, EntityManagerInterface $entityManager,UserRepository $userRepository): Response
    {$session=$request->getSession();
        $user = $userRepository->findOneBy(['iduser'=>$session->get('iduser',0)]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $file = $form->get('imageuser')->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $user->setImageuser($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editadherent.html.twig', [
            'user' => $user,
            'formU' => $form->createView(),
        ]);

    }
    /**
     * @Route("/{iduser}/editcoach", name="app_user_editcoach", methods={"GET", "POST"})
     */
    public function editcoach(Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $session=$request->getSession();
        $user = $userRepository->findOneBy(['iduser'=>$session->get('iduser',0)]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $file = $form->get('imageuser')->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $user->setImageuser($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editcoach.html.twig', [
            'user' => $user,
            'formUC' => $form->createView(),
        ]);
    }
    /**
     * @Route("/editmanager", name="app_user_editmanager", methods={"GET", "POST"})
     */
    public function editmanager(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $session=$request->getSession();
        $user = $userRepository->findOneBy(['iduser'=>$session->get('iduser',0)]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $file = $form->get('imageuser')->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $user->setImageuser($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/editmanager.html.twig', [
            'user' => $user,
            'formUM' => $form->createView(),
        ]);
    }
    /**
     * @Route("/editadmin", name="app_user_editadmin", methods={"GET", "POST"})
     */
    public function editadmin(Request $request,UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $session=$request->getSession();
        $user = $userRepository->findOneBy(['iduser'=>$session->get('iduser',0)]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $file = $form->get('imageuser')->getData();
            $fileName= md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('brochures_directory'),$fileName);
            $user->setImageuser($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_show', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/delete/{iduser}", name="app_user_deleteback", methods={"POST"})
     */
    public function deleteback(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getIduser(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_alladmin', [], Response::HTTP_SEE_OTHER);
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

    /**
     * @Route("/loginuser",name="login_mob" ,methods={"GET", "POST"})
     */
    public function loginuser(NormalizerInterface  $Normalizer,Request $request,UserRepository $repository){
        $email = $request->query->get("mailuser");
        $password= $request->query->get("password");
        $user=$repository->findOneBy(['mailuser'=>$email]);

        if ($user) {
            if ( $password == $user->getPassword() ) {
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize($user);
                return new JsonResponse($formatted);

        }else
            {
                return new Response("password not found");
            }
        }
        else {
            return new Response("user not found");
        }

    }



    /**
     * @Route("/deletemobile",name="delete_userjson" ,methods={"GET"})
     */
    public function deleteuser(EntityManagerInterface  $entityManager,Request $request,UserRepository $repository,NormalizerInterface $normalizer):Response
    {
        $id = $request->query->get("IdUser");

        $user=$repository->find($id);
echo $user->getPrenomuser();
        $entityManager->remove($user);
        $entityManager->flush();


        $entityManager->remove($user);
        $entityManager->flush();
        $jsonContent=$normalizer->normalize($user,'json');
        return new Response("Event deleted Sucessfully".json_encode($jsonContent));

    }

    /**
     * @Route("/inscription",name="signup_mob" ,methods={"GET", "POST"})
     */
    public function signupUser(NormalizerInterface  $Normalizer,Request $request,UserRepository $repository){
        $email = $request->query->get("mailuser");
        $password= $request->query->get("password");
        $name = $request->query->get("nomuser");
        $lastname= $request->query->get("prenomuser");
        $role = $request->query->get("roleuser");
        $date= date_create_from_format("d/m/y",$request->get("datenaissanceuser"));
        $telephone = $request->query->get("telephonenumberuser");
        $em=$this->getDoctrine()->getManager();
        $user=$repository->findOneBy(['mailuser'=>$email]);

        if ($user) {



            return new Response("User Exist!!!!");
        }
        else {
            $us=new User();
            $us->setNomuser($name);
            $us->setPrenomuser($lastname);
            $us->setMailuser($email);
            $us->setDatenaissanceuser($date);
            $us->setTelephonenumberuser($telephone);
            $us->setRoleuser($role);
            $us->setPassword($password);
            $em->persist($us);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($us);
            return new JsonResponse($formatted);
        }

    }
}
