<?php

namespace App\Doctrine\Listener;

use App\Entity\Category;
use Symfony\Component\String\Slugger\SluggerInterface;

class EditCategorySlugListener 
{
    protected $sluggler;

    public function __construct(SluggerInterface $slugger)
    {
        $this->sluggler = $slugger;
    }

    public function preUpdate(Category $entity)
    {
        $entity->setSlug(strtolower($this->sluggler->slug($entity->getName())));
    }
}

