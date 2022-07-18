<?php

namespace App\Controller;

use App\Entity\Intervention;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class CreateBookPublication extends AbstractController
{
    private $bookPublishingHandler;

    // public function __construct(BookPublishingHandler  $bookPublishingHandler)
    // {
    //     $this->bookPublishingHandler = $bookPublishingHandler;
    // }

    public function __invoke(Intervention $data): Intervention
    {
        $this->bookPublishingHandler->handle($data);

        return $data;
    }
}