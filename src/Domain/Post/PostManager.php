<?php

namespace Domain\Post;

use App\Entity\Post;
use App\Repository\PostRepository;

class PostManager
{
    private PostRepository $repository;

    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function addPost(?string $title, ?string $content)
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);
        $this->repository->add($post, true);
    }

    public function findPost(int $id): Post
    {
        return $this->repository->findOneBy(['id' => $id]);
    }
}
