<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Repository\InterventionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(InterventionRepository $interventionRepository, CustomerRepository $customerRepository, ChartBuilderInterface $chartBuilder): Response
    {

        $bigArray = array();
        //my custumer
        $mycustomer = $customerRepository->findBy(['user' => $this->getUser()]);

        // dd($mycustomer);

        foreach ($mycustomer as $customers) {
            // dump($customers->getId());

            $total = $interventionRepository->getCountInterventionByMonth($this->getUser(), $customers->getId());

            // $nbIntervention = array();
            $month = array();

            for ($i = 1; $i < 13; $i++) {
                $nbIntervention[$i] = 0;
                for ($y = 0; $y < count($total); $y++) {
                    if ($total[$y]['month'] == $i) {
                        $nbIntervention[$i] =  $total[$y]['nbIntervention'];
                    }
                }
            }

            $bigArray[] =
                ['label' => $customers->getName(), 'data' => $nbIntervention, "backgroundColor" => '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6), 'borderColor' => "white"];
        }

        dump($bigArray);
        // die();

        // $total = $interventionRepository->getCountInterventionByMonth($this->getUser());

        // $nbIntervention = array();
        // $month = array();

        // for ($i = 1; $i < 13; $i++) {
        //     $nbIntervention[$i] = 0;
        //     for ($y = 0; $y < count($total); $y++) {
        //         if ($total[$y]['month'] == $i) {
        //             $nbIntervention[$i] =  $total[$y]['nbIntervention'];
        //         }
        //     }
        // }

        // dump($bigArray[0][0]['data']);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            // 'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July','aout','setp','octo','nov','dec'],
            'datasets' => $bigArray,
            // 'datasets' => [
                // ['label' => 'Cookies eaten 🍪', 'data' => [2, 10, 5, 18, 20, 30, 45], "backgroundColor"=> '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6), 'borderColor' => '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)],
            //     ['label' => 'Km walked 🏃‍♀️', 'data' => [10, 15, 4, 3, 25, 41, 25], "backgroundColor"=> '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6),  'borderColor' => '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)],
                // ['label' => 'Km walkedwww 🏃‍♀️', 'data' => [13, 17, 74, 73, 75, 71, 75], "color"=> '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6),
                // 'borderColor' => '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6)],
            // ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    // 'suggestedMax' => 100,
                ],
            ],
        ]);


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'chart' => $chart,
        ]);
    }
}
