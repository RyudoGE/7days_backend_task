<?php

namespace Infrastructure\Service\PostGenerator;

use DateTime;
use Domain\Post\PostManager;
use http\Exception\RuntimeException;
use joshtronic\LoremIpsum;
use Throwable;

class PostGeneratorService
{
    private LoremIpsum $loremIpsum;
    private PostManager $postManager;

    public function __construct(
        PostManager $postManager,
        LoremIpsum $loremIpsum
    ) {
        $this->postManager = $postManager;
        $this->loremIpsum = $loremIpsum;
    }

    /**
     * @param DateTime $dateTime
     * @return void
     */
    public function generatePostByDateTime(DateTime $dateTime): void
    {
        try {
            $paragraphsCount = 2;

            // @TODO: ask about business logic, can we believe our server datetime?
            // Different type of post on 12pm
            if ($dateTime->format('H') === '12') {
                $paragraphsCount = 1;
                $title = sprintf('Summary %s', $dateTime->format('Y-m-d'));
            } else {
                $title = $this->loremIpsum->words(mt_rand(4, 6));
            }
            $content = $this->loremIpsum->paragraphs($paragraphsCount);

            $this->postManager->addPost($title, $content);
        } catch (Throwable $e) {
            throw new RuntimeException('Post not generated', $e->getCode(), $e);
        }
    }
}