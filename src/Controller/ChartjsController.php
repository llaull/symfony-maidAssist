<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartjsController extends AbstractController
{
    #[Route('/chartjs', name: 'app_chartjs')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                ['label' => 'Cookies eaten 🍪', 'data' => [2, 10, 5, 18, 20, 30, 45], "backgroundColor"=> '#ffbb00', 'borderColor' => "white"],
                ['label' => 'Km walked 🏃‍♀️', 'data' => [10, 15, 4, 3, 25, 41, 25], "backgroundColor"=> '#1197f7', 'borderColor' => "black"],
                ['label' => 'Km walkedwww 🏃‍♀️', 'data' => [13, 17, 74, 73, 75, 71, 75], "color"=> '#1197f7'],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        // $InterventionRepositorys = 
        return $this->render('chartjs/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
