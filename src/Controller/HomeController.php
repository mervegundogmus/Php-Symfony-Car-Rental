<?php

namespace App\Controller;

use App\Entity\Araba;
use App\Repository\ArabaRepository;
use App\Repository\ImageRepository;
use App\Repository\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
     /**
     * @Route("/", name="home")
     */
    public function index(ArabaRepository $arabaRepository, SettingRepository $settingRepository)
    {
        $slider = $arabaRepository->findBy([], ['title' => 'ASC'], 6);
        $allcar = $arabaRepository->findBy([], ['title' => 'ASC']);
        $newcar = $arabaRepository->findBy([], ['title' => 'ASC'], 9);
        $data = $settingRepository->findBy(['id' => 1]);


        return $this->render('home/index.html.twig', [
            'slider' => $slider,
            'allcar' => $allcar,
            'newcar' => $newcar,
            'data' => $data,
        ]);
    }





    /**
     * @Route("araba/{id}", name="car_show", methods={"GET"})
     */
    public function show(Araba $araba, $id, ImageRepository $imageRepository): Response
    {

        $images = $imageRepository->findBy(["araba" => $id]);

        return $this->render('home/singlecar.html.twig', [
            'car' => $araba,
            'image' => $images,
        ]);
    }
}


