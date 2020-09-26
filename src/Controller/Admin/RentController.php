<?php

namespace App\Controller\Admin;

use App\Entity\Admin\Rent;
use App\Form\Admin\RentType;
use App\Repository\Admin\RentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/rent")
 */
class RentController extends AbstractController
{
    /**
     * @Route("/{slug}", name="admin_rent_index", methods={"GET"})
     */
    public function index($slug,RentRepository $rentRepository): Response
    {
        $rents = $rentRepository->getRents($slug);

        return $this->render('admin/rent/index.html.twig', [
            'rents' => $rents,
        ]);
    }

    /**
     * @Route("/new", name="admin_rent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentType::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rent);
            $entityManager->flush();

            return $this->redirectToRoute('admin_rent_index');
        }

        return $this->render('admin/rent/new.html.twig', [
            'rent' => $rent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="admin_rent_show", methods={"GET"})
     */
    public function show($id,RentRepository $rentRepository): Response
    {
        $rent = $rentRepository->getRent($id);

        return $this->render('admin/rent/show.html.twig', [
            'rent' => $rent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_rent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rent $rent): Response
    {
        $form = $this->createForm(RentType::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
               $status = $form['status']->getData();

            return $this->redirectToRoute('admin_rent_index',['slug'=>$status]);
        }

        return $this->render('admin/rent/edit.html.twig', [
            'rent' => $rent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_rent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rent $rent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_rent_index');
    }
}
