<?php

namespace App\Controller;

use App\Flyaround\FlyschemaSchema\AirportModel;
use PommProject\Foundation\Pomm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AirportController extends AbstractController
{
    private $pomm;

    public function __construct(Pomm $pomm, AirportModel $airportModel)
    {
        $this->pomm = $pomm;
        $this->airportModel = $airportModel;
    }

    /**
     * @Route("/airport", name="airport")
     */
    public function index()
    {
        $airports = $this->get($this->pomm)
            ->getDefaultSession()
            ->getModel(AirportModel::class)
            ->findAll()
        ;

        return $this->render('airport/index.html.twig', [
            'airports' => $airports,
        ]);
    }
}
