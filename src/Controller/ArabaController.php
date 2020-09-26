<?php

namespace App\Controller;

use App\Entity\Araba;
use App\Form\Araba1Type;
use App\Repository\ArabaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/araba")
 */
class ArabaController extends AbstractController
{
    /**
     * @Route("/", name="user_araba_index", methods={"GET"})
     */
    public function index(ArabaRepository $arabaRepository): Response
    {
        return $this->render('araba/index.html.twig', [
            'arabas' => $arabaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_araba_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $araba = new Araba();
        $form = $this->createForm(Araba1Type::class, $araba);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($araba);
            $entityManager->flush();

            return $this->redirectToRoute('user_araba_index');
        }

        return $this->render('araba/new.html.twig', [
            'araba' => $araba,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_araba_show", methods={"GET"})
     */
    public function show(Araba $araba): Response
    {
        return $this->render('araba/show.html.twig', [
            'araba' => $araba,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_araba_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Araba $araba): Response
    {
        $form = $this->createForm(Araba1Type::class, $araba);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_araba_index');
        }

        return $this->render('araba/edit.html.twig', [
            'araba' => $araba,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_araba_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Araba $araba): Response
    {
        if ($this->isCsrfTokenValid('delete'.$araba->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($araba);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_araba_index');
    }
}
