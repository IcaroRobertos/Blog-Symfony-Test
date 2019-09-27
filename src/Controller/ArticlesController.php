<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/articles", methods="GET")
     */
    public function create(EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $article = new Article();
        $article->setTitle('Demo de Artigo');
        $article->setText('Demo de texto de artigo loren ipsum dolor set amet');
        
        $entityManager->persist($article);
        $entityManager->flush();

        $repository = $this->getDoctrine()->getRepository(Article::class);
        $product = $repository->find($article->getId());

        $json = $serializer->serialize($product, 'json');

        return new Response($json);
    }
}
