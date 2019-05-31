<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\StudentType;
use App\Repository\NotesRepository;
use App\Repository\StudentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->redirectToRoute('liste_Students');
    }
    /**
     * @Route("/Students/liste", name="liste_Students")
     */
    public function listeStudents(StudentsRepository $repo )
    {
        $students = $repo->findAll();
        
        return $this->render('student/liste.html.twig',[
            'students' => $students
        ]); 
    }
    /**
     * @Route("/Students/{id}/show", name="Show_Student")
     */
    public function ShowStudents(Students $student, NotesRepository $repo )
    {
        $Notes = $repo->findBy(['name'=> $student->getId()]);
        
        return $this->render('student/Show.html.twig',[
            'student' => $student,
            'Notes' =>$Notes
        ]); 
    }

    /**
     * @Route("/addStudent", name="add_Student")
     */
    public function addStudent(Request $request, ObjectManager $manager )
    {
        $student = new Students();
        
        $form=$this->createForm(StudentType::class,$student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
           
        	$manager->persist($student);
        	$manager->flush();
   
        	$this->addFlash(
        		'success',"l'élève a bien été créé.");
        	return $this->redirectToRoute('liste_Students');
        }
        return $this->render('student/addStudent.html.twig',[
            'form' => $form->createView(),
            'role' => 'Ajouter'
        ]);
    }





    /**
     * @Route("/Student/{id}/modify", name="modify_Student")
     */
    public function modifyStudent(Request $request, ObjectManager $manager, Students $student )
    {
                
        $form=$this->createForm(StudentType::class,$student);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
           
        	$manager->persist($student);
        	$manager->flush();
   
        	$this->addFlash(
        		'success',"l'élève a bien été modifié.");
        	return $this->redirectToRoute('home');
        }
        return $this->render('student/addStudent.html.twig',[
            'form' => $form->createView(),
            'role' => 'Modifier'
        ]);
    }
    /**
     * @Route("/student/{id}/delete", name="delete_Student")
     */
    public function deleteStudents(Students $student )
    {
        
        return $this->render('student/confirmation.html.twig',[
            'student' => $student
        ]); 
    }
    /**
     * @Route("/student/{id}/delete/yes", name="delete_Student_yes")
     */
    public function deleteStudentsYes(ObjectManager $manager,Students $student, NotesRepository $repo )
    {
        $Notes = $repo->findBy(['name'=> $student->getId()]);
        dump($Notes);
        foreach($Notes as $Note)
        {
            $manager->remove($Note);
        }
        

        $manager->remove($student);
        $manager->flush();
        $this->addFlash(
            'success',"l'élève a bien été suprimé.");
        return $this->redirectToRoute('liste_Students');
        
    }
}
