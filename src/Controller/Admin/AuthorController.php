<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/author')]
class AuthorController extends AbstractController
{
    #[Route('', name: 'app_admin_author_index', methods: ['GET'])]
    public function index(AuteurRepository $repository): Response
    {
        $authors = $repository->findAll();

        return $this->render('admin/author/index.html.twig', [
            'controller_name' => 'AuthorController',
            'authors' => $authors,
        ]);
    }
    #[IsGranted('ROLE_AJOUT_DE_LIVRE')]
    #[Route('/new', name: 'app_admin_author_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_author_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Auteur $author, Request $request, EntityManagerInterface $manager): Response
    {
        if (null== $author) {
            $this->denyAccessUnlessGranted(attribute:'ROLE_EDITION_DE_LIVRE');
        }
        $author ??= new Auteur();
        $form = $this->createForm(AuteurType::class, $author);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($author);
            $manager->flush();

            return $this->redirectToRoute('app_admin_author_index');
        }

        return $this->render('admin/author/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_admin_author_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Auteur $auteur): Response
    {
        return $this->render('admin/author/show.html.twig', [
        'author' => $auteur,
    ]);
}
}