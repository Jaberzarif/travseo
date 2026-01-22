<?php

namespace App\Controller;



use App\Service\Seo;
use App\Entity\Destination;
use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $em, Seo $seo, Request $request): Response
    {
        $limit = 6; // initial load
        $offset = $request->query->getInt('offset', 0); // used for "Load more"

        $destinations = $em->getRepository(Destination::class)->findBy(
            [],
            ['id' => 'ASC'],
            $limit,
            $offset
        );

        // Detect AJAX request
        if ($request->isXmlHttpRequest()) {
            return $this->render('partials/_destinations_grid.html.twig', [
                'destinations' => $destinations
            ]);
        }

        return $this->render('home/index.html.twig', [
            'destinations' => $destinations,
            'seo' => $seo->home()
        ]);
    }


    #[Route('/destinations', name: 'destinations')]
    public function destinations(EntityManagerInterface $em, Seo $seo): Response
    {
        // Fetch all destinations from database
        $destinations = $em->getRepository(Destination::class)->findAll();
        return $this->render('destinations/destinations.html.twig', [
            'destinations' => $destinations,
            'seo' => $seo->destinations(),
        ]);
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

    // #[Route('/destinations/{slug}', name: 'destination_show')]
    // public function show(string $slug, EntityManagerInterface $em, Seo $seo): Response
    // {
    //     $destination = $em->getRepository(Destination::class)->findOneBy([
    //         'slug' => $slug
    //     ]);

    //     if (!$destination) {
    //         throw $this->createNotFoundException('Destination not found');
    //     }

    //     return $this->render('destinations/show.html.twig', [
    //         'destination' => $destination,
    //         'seo' => $seo->singlePost($destination),
    //     ]);
    // }

    #[Route('/destinations/{slug}', name: 'destination_show')]
    public function show(string $slug, EntityManagerInterface $em, Request $request, Seo $seo): Response
    {
        $destination = $em->getRepository(Destination::class)->findOneBy(['slug' => $slug]);

        if (!$destination) {
            throw $this->createNotFoundException('Destination not found');
        }

        $booking = new Booking();
        $form = $this->createFormBuilder($booking)
            ->add('fullName', TextType::class, ['label' => 'Full Name'])
            ->add('email', EmailType::class)
            ->add('people', IntegerType::class, ['label' => 'Number of People', 'attr' => ['min' => 1]])
            ->add('date', DateType::class, ['widget' => 'single_text'])
            ->add('message', TextareaType::class, ['required' => false])
            ->add('submit', SubmitType::class, [
                'label' => 'Book Now',
                'attr' => [
                    'class' => 'bg-indigo-600 text-white py-2 px-6 rounded-full hover:bg-indigo-700'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setDestination($destination);
            $booking->setPrice($destination->getPrice() * $booking->getPeople());
            $em->persist($booking);
            $em->flush();

            $this->addFlash('success', 'Your booking has been received!');
            return $this->redirectToRoute('destination_show', ['slug' => $slug]);
        }

        return $this->render('destinations/show.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
            'seo' => $seo->singlePost($destination),
        ]);
    }
}
