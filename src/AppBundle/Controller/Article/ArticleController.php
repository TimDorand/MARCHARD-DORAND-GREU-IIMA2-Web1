<?php

namespace AppBundle\Controller\Article;

use AppBundle\Entity\Article\Article;
//use AppBundle\Form\article\ArticleType;
use AppBundle\Form\Article\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{

    /**
     *
     *
     *
     */

    /**
     * @Route("/{id}", requirements={"id" = "\d+"}, name="article_show")
     *
     * @param $id
     *
     * @return Response
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('AppBundle:Article\Article')->find($id);

        return $this->render('AppBundle:Article:show.html.twig', array(
            'blog'      => $blog,
        ));
    }

    /**
     * @Route("/list", name="article_list")
     */
    public function listAction()
    {

        $em = $this->getDoctrine()->getManager();
        $articleRepository = $em->getRepository('AppBundle:Article\Article');

        $author = "moi";

        $articleRepository->findBy([
            'author' => $author
        ]);

        return new Response('List of Article');
    }

    /**
     * @Route("/new", name="article_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(ArticleType::class);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
        }

        return $this->render('AppBundle:Article:new.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}