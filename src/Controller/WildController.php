<?php


namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\ProgramSearchType;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/", name="wild_index")
     * @return Response
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException("No program found in program's table.");
        }

        return $this->render('wild/index.html.twig', [
            'programs' => $programs
        ]);

    }

    /**
     * @Route("wild/show/{slug<^[a-z0-9-]+$>}",  defaults={"slug" = null}, name="show", )
     * @param $slug
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException("Aucune série sélectionnée, veuillez choisir une série");
        }

        $slug = ucwords(trim(str_replace('-', ' ', $slug)));

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);


        if (!$program) {
            throw $this->createNotFoundException(
                "No program with '.$slug.' title, found in program's table."
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("wild/category/{categoryName<^[a-z0-9-]+$>}", name="show_category").
     * @param string $categoryName
     * @return Response
     */
    public function showByCategory(string $categoryName)
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException('Aucune catégorie sélectionnée, veuillez choisir une catégorie');
        }
        $categoryName = ucwords(trim(str_replace('-', ' ', $categoryName)));

        /*Permet de retourner une liste d'entités, sauf qu'elle est capable d'effectuer un filtre
          pour ne retourner que les entités correspondant à un critère. Elle peut aussi trier les entités,
          et même n'en récupérer qu'un certain nombre */
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);

        $categoryId = $category->getId();/* recupere L'ID du dossier repository class category*/


        if (!$category) {
            throw $this->createNotFoundException(
                "No category with '.$categoryName.' title, found in program's table."
            );
        }
        /*elle permet de retourner une liste d'entités,
          sauf qu'elle est capable d'effectuer un filtre pour ne retourner que les entités correspondant à
          un critère. Elle peut aussi trier les entités, et même n'en récupérer qu'un certain nombre*/
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $categoryId], ['id' => 'desc'], 3, 0);

        if (!$program) {
            throw $this->createNotFoundException(
                "No program with '.$categoryName.' title, found in program's table."
            );
        }

        return $this->render('wild/category.html.twig', [
            'category' => $categoryName,
            'programs' => $program
        ]);
    }

    /**
     * @Route("wild/program/{id}", name="show_program")
     * @param ProgramRepository $repo
     * @param $id
     * @return Response
     */
    public function showByProgram(ProgramRepository $repo, $id)
    {
        $program = $repo->find($id);

        $repo = $this->getDoctrine()->getRepository(Season::class);
        $seasons = $repo->findAll();


        return $this->render('wild/program.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    /**
     * @Route("wild/season/{id}", name="show_season")
     * @param int $id
     * @return Response
     */
    public function showBySeason(int $id){

        //$seasonId = $season->getProgram();
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($id);


        $episodes = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findAll();


        return $this->render('wild/season.html.twig', [
            'season' => $season,
            'episodes' =>$episodes
        ]);

    }

    /**
     * @Route("wild/episode/{id}", name= "show_episode")
     * @param Episode $episode
     * @return Response
     */
    public function showByEpisode(Episode $episode)
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();

        return $this->render('wild/episode.html.twig',[
            'episode' => $episode,
            'season' => $season,
            'program' => $program
        ]);
    }
    /**
     * @Route("actor/{slug}", name="show_actor")
     * @param Actor $actor
     * @return Response
     */
    public function showByActor(Actor $actor)
    {
        $programs=$actor->getPrograms();

        return $this->render('actor/index.html.twig', [
            'actor' => $actor,
            'programs' => $programs
        ]);
    }
}
