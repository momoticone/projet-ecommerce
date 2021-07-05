<?php

namespace App\Doctrine\Listener;

use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class CreateCategorySlugListener 
{
    protected $sluggler;

    public function __construct(SluggerInterface $slugger)
    {
        $this->sluggler = $slugger;
    }

    public function prePersist(Category $entity)
    {
        if(empty($entity->getSlug))
        {
            $entity->setSlug(strtolower($this->sluggler->slug($entity->getName())));
        }
    }
}

