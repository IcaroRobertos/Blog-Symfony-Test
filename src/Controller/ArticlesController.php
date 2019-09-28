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
    // /**
    //  * @Route("/articles", name="articles")
    //  */
    // public function index()
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/ArticlesController.php',
    //     ]);
    // }

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
