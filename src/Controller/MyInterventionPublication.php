<?php

namespace App\Controller;

use App\Entity\Intervention;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class MyInterventionPublication extends AbstractController
{
    // public function __construct(
    //     private MyInterventionPublishingHandler $myInterventionPublishingHandler
    // ) {}

    #[Route(
        name: 'book_post_publication',
        path: '/books/publication',
        methods: ['GET'],
        defaults: [
            '_api_resource_class' => Intervention::class,
            '_api_item_operation_name' => 'post_publication',
        ],
    )]
    public function __invoke(Intervention $data): Intervention
    {
        $this->myInterventionPublishingHandler->handle($data);

        return $data;
    }
}