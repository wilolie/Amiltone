<?php

namespace App\Controller;

use App\Entity\Notes;
use App\Form\NoteType;
use App\Entity\Students;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController
{
    /**
     * @Route("/student/{id}/note/add", name="add_note")
     */
    public function addNote(Request $request, ObjectManager $manager, Students $student)
    {
        $note = new Notes();
        
        $form=$this->createForm(NoteType::class,$note);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $note->setname($student);
        	$manager->persist($note);
        	$manager->flush();
   
        	$this->addFlash(
        		'success',"la note a bien été enregistée.");
        	return $this->redirectToRoute('Show_Student',[ 'id'=>$student->getid()]);
        }
        return $this->render('note/addNote.html.twig',[
            'form' => $form->createView(),
            'student'=> $student,
            'button' => 'enregister'
        ]);
    }
}
