<?php

namespace App\Twig;

use App\Repository\MailTypeRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DisplayMailTypeExtension extends AbstractExtension
{
    private $twig;
    private $mailTypeRepository;
    private $session;

    public function __construct(Environment $twig, MailTypeRepository $mailTypeRepository, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->mailTypeRepository = $mailTypeRepository;
        $this->session = $session;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('mailTypeMenu', [$this, 'renderMailTypeMenu'])
        ];
    }

    public function renderMailTypeMenu()
    {
        $mailTypes = $this->session->get('mailTypesMenu');

        if ($mailTypes === null) {
            $mailTypes = $this->mailTypeRepository->findAllOrdered();

            $this->session->set('mailTypesMenu', $mailTypes);
        }

        return $this->twig->render('twig_extension/_mail-type-menu.html.twig', [
            'mailTypes' => $mailTypes
        ]);
    }
}