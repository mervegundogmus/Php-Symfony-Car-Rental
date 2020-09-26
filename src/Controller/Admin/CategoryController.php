<?php

namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use PhpParser\Node\Scalar\MagicConst\File;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_category_new", methods={"GET","POST"})
     */
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /** @var file $file */
            $file=$form['image']->getData();
            if($file)
            {
                $fileName=$this->generateUniqueFileName() .'.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                try{
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                } catch(FileException $e) {
                    //..handle exception if something happens during file upload

                }
                $category->setImage($fileName);
            }
            //------------------Image Upload--------------//
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_category_index');
        }

        $categories=$categoryRepository->findAll();

        return $this->render('admin/category/new.html.twig', [
            'categories'=>$categories,
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="admin_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryRepository $categoryRepository, Category $category): Response
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $form['image']->getData();
            if($file){
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                //Move the file to the directory where brochures are stored
                try{
                    $file->move(
                        $this->getParameter('images_directory'), // Servis.yaml de tanımladığımız resim yolu
                        $fileName
                    );
                }catch(FileException $e) {
                    //handle exception if something happens during file upload
                }
                $araba->setImage($fileName);
            }





            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_category_index');
        }
        $categories=$categoryRepository->findAll();

        return $this->render('admin/category/edit.html.twig', [
            'categories'=>$categories,
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Category $category): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_category_index');
    }
}