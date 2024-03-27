<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function indexAction(Request $request)
    {

        $strCadena = "Hola Anderson";
        $boolPrueba = true;
        $intNumero = 10;
        $arrayPrueba =[
            'manzana',
            'pera',
            'durazno',
        ];

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..').DIRECTORY_SEPARATOR,
            'strCadena'=>$strCadena,
            'boolPrueba'=>$boolPrueba,
            'intNumero'=>$intNumero,
            'arrayPrueba'=>$arrayPrueba
        ));
    }
}
