<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $fileContents = array();
        $finder = new Finder();
        $finder->files()->in('files');
        
        foreach ($finder as $file) {
            $contents = $file->getContents();
            $this->parsePatientInfo($contents);
            // $fileContents[] = $contents;
        }

        print_r($fileNames);
        die;
        // // replace this example code with whatever you need
        // return $this->render('default/index.html.twig', array(
        //     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        // ));
    }
    
    public function parsePatientInfo($string)
    {
        print_r($string);
        die;
    }
}
