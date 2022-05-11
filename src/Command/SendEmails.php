<?php

namespace App\Command;



use App\Entity\Evenement;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;

class SendEmails extends Command
{
    protected static $defaultName = 'app:EventAlertDay1';
    private $em;
    private $mailer;
    private $eventstoemail;
    private $twig;

    public function __construct(EntityManagerInterface $em,\Swift_Mailer $mailer,Environment $twig)
    {
        $this->em= $em;
        $this->eventstoemail = $em
            ->getRepository(Evenement::class)
            ->get1Day();
        $this->emailtosend = $em
            ->getRepository(User::class)
            ->getallemails();
        foreach($this->emailtosend as $k=>$v) {
            $this->emailtosendfinal[$k] = $v['mailuser'];
        }
        var_dump($this->emailtosendfinal);
        $this->mailer= $mailer;
        $this->twig = $twig;
        parent::__construct();
    }

    public function configure()
    {
        $this->setDescription('Send Emails everyday for events that are 1 day from now.');

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {


        $email = (new \Swift_Message('your next day events in a bundle'))
            ->setFrom('oakfitness.noreply@gmail.com')
            ->setTo($this->emailtosendfinal);
            $twitter = $email->embed(\Swift_Image::fromPath('public/back/images/email/image-3.png'));
        $linkedin = $email->embed(\Swift_Image::fromPath('public/back/images/email/image-9.png'));
        $instagram = $email->embed(\Swift_Image::fromPath('public/back/images/email/image-6.png'));
        $youtube = $email->embed(\Swift_Image::fromPath('public/back/images/email/image-5.png'));
        $gif = $email->embed(\Swift_Image::fromPath('public/back/images/email/image-10.gif'));
        $email
                ->setBody($this->twig->render(
                'event/email.html.twig',
                array(
                    'evenements' => $this->eventstoemail,
                    'twitter' => $twitter,
                    'linkedin' => $linkedin,
                    'instagram' => $instagram,
                    'youtube' => $youtube,
                    'gif'=>$gif

                ))
            ,'text/html');
        $this->mailer->send($email);
        $output->write('Emails Sent.');


    }



}