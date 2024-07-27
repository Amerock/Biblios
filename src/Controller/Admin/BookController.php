<?php

namespace App\Controller\Admin;


use App\Entity\Livre;
use App\Form\LivreType;
use Pagerfanta\Pagerfanta;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book_index', methods: ['GET'])]
    public function index(Request $request, LivreRepository $repository): Response
    {
        $books = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->createQueryBuilder('b')),
            $request->query->get('page', 1),
            20
        );

        return $this->render('admin/book/index.html.twig', [
            'books' => $books,
        ]);
    }
    #[IsGranted('ROLE_AJOUT_DE_LIVRE')]
    #[Route('/new', name: 'app_admin_book_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_book_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Livre $book, Request $request, EntityManagerInterface $manager): Response
    {
        if ($book) {
            $this->denyAccessUnlessGranted('ROLE_EDITION_DE_LIVRE');
        }
        $book ??= new Livre();
        $form = $this->createForm(LivreType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('app_admin_book_index');
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Livre $book): Response
    {
        return $this->render('admin/book/show.html.twig', [
            'book' => $book,
        ]);
    }
}