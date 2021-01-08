<?php

namespace App\Application\Controller\Action;

use App\Domain\Model\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\Routing\Annotation\Route;
use JMS\Serializer\SerializerInterface;

/**
 * Class PostAction
 * @package App\Application\Controller\Action
 * @Route(name="post_action", path="/api/post", methods={"POST"})
 */
class PostAction
{

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * PostAction constructor.
     */
    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $usuario = $this->serializer->deserialize($content, Usuario::class, "json");

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return new JsonResponse("Usuario cadastrado com sucesso", JsonResponse::HTTP_OK);
    }
}
