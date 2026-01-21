<?php

namespace App\Controller;

use App\Service\Seo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Seo $seo): Response
    {
        return $this->render('home/index.html.twig', [
            'seo' => $seo->home()
        ]);
    }

    #[Route('/destinations', name: 'destinations')]
    public function destinations(Seo $seo): Response
    {
        return $this->render('destinations/destinations.html.twig', ['seo' => $seo->destinations()]);
    }

    #[Route('/tours', name: 'tours')]
    public function tours(Seo $seo): Response
    {
        return $this->render('tours/tours.html.twig', ['seo' => $seo->home()]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Seo $seo): Response
    {
        return $this->render('contact/contact.html.twig', ['seo' => $seo->contact()]);
    }
}
