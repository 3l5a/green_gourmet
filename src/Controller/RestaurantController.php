<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\SearchRestaurantType;
use App\Repository\CategoryRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurantController extends AbstractController
{
    
    #[Route('/restaurant/search', name: 'app_search_restaurant')]
    public function search(Request $request, SearchRestaurantType $searchRestaurantType ,RestaurantRepository $restaurantRepository): Response
    {
        
        $restaurants = $restaurantRepository->findAll();
        $restaurant = new Restaurant;
        $form = $this->createForm(SearchRestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid($restaurant) ) {
            $category = $restaurant->getCategory();
            $city = $restaurant->getCity();
            $restaurants= $restaurantRepository->findByCategoryAndCity($category, $city);
            
            return $this->render('restaurant/index.html.twig', [
                'restaurants' => $restaurants,
                'formView' => $form->createView(),

    
            ]);
        }
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurants,
            'formView' => $form->createView(),

        ]);
    }



    #[Route('/restaurant/view/{id}', name: 'app_restaurant')]
    public function restaurantView($id, RestaurantRepository $restaurantRepository, CategoryRepository $categoryRepository): Response
    {   
        $restaurant = $restaurantRepository->findOneBy(['id' => $id]);
        
        return $this->render('restaurant/restaurant.html.twig', [
            
            'restaurant' => $restaurant,
        ]);
    }
    
}
