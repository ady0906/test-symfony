<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use AppBundle\Entity\Patient;
use AppBundle\Entity\Doctor;

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
        $em = $this->getDoctrine()->getManager();
        
        foreach ($finder as $key => $file) {
            $newPatient = new Patient();
            $newDoctor = new Doctor();
            $contents = $file->getContents();
            $parsedHL7 = $this->parseHL7($contents);
            
            $doctorRPPS = null;
            if ($parsedHL7['ROL'][16][0] == 'RPPS') {
                $doctorRPPS = $parsedHL7['ROL'][4][0];
            }
            
            $fileContents['patient' . $key] = array(
                'Last name' => $parsedHL7['PID'][9][0],
                'First name' => $parsedHL7['PID'][10][0],
                'Date of birth' => $parsedHL7['PID'][17],
                'Gender' => $parsedHL7['PID'][18],
                'Street' => $parsedHL7['PID'][21][0],
                'Postal code' => $parsedHL7['PID'][25][0],
                'City' => $parsedHL7['PID'][29][0]
            );
            $fileContents['doctor' . $key] = array(
                'Last name' => $parsedHL7['ROL'][5][0],
                'First name' => $parsedHL7['ROL'][6][0],
                'RPPS' => $parsedHL7['ROL'][4][0]
            );
            
            $newPatient->setProperties(
                $parsedHL7['PID'][10][0],
                $parsedHL7['PID'][9][0],
                $parsedHL7['PID'][17],
                $parsedHL7['PID'][18],
                $parsedHL7['PID'][21][0],
                $parsedHL7['PID'][25][0],
                $parsedHL7['PID'][29][0]
            );
            $newDoctor->setProperties(
                $parsedHL7['ROL'][6][0],
                $parsedHL7['ROL'][5][0], 
                $parsedHL7['ROL'][4][0]
            );
            // $em->persist($newPatient);
            // $em->persist($newDoctor);
        }
        // $em->flush();
        
        echo '<pre>';
        var_dump($fileContents);
        echo '</pre>';
        die;
    }
    
    public function parseHL7($string)
    {
        $ordered  = array();
        $segments = explode("\n", $string);
        foreach ($segments as $segment) {
            $orderedIndex = substr($segment, 0, 3);
            $ordered[$orderedIndex] = array();
            $subSegments = explode("|", $segment);
            foreach ($subSegments as $subSegment) {
                if (strpos($subSegment, "^") !== false) {
                    $composants = explode("^", $subSegment);
                    foreach ($composants as $key => $composant) {
                        if (strpos($composant, "&") !== false) {
                            $subComposants = explode("&", $composant);
                            $ordered[$orderedIndex][][$key] = $subComposants;
                        } else {
                            $ordered[$orderedIndex][][] = $composant;
                        }
                    }
                } else {
                    $ordered[$orderedIndex][] = $subSegment;
                }
            }
        }
        return $ordered;
    }
}
