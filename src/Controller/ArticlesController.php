<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\Article;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", methods="GET")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $articlesRepository = $this->getDoctrine()->getRepository(Article::class);
        $allArticles = $articlesRepository->findAll();

        $json = $serializer->serialize($allArticles, 'json');

        return new Response($json);
    }

    /**
     * @Route("/articles", methods="POST")
     */
    public function create(EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request): Response
    {
        
        $data = $request->request;

        $article = new Article();
        $article->setTitle($data->get('title'));
        $article->setText($data->get('text'));
        $article->setAuthor($data->get('author'));
        
        $entityManager->persist($article);
        $entityManager->flush();

        $json = $serializer->serialize($article, 'json');

        return new Response($json);
    }
}
