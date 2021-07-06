<?php

namespace App\Doctrine\Listener;

use App\Entity\Product;
use Symfony\Component\String\Slugger\SluggerInterface;

class CreateProductSlugListener 
{
    protected $sluggler;

    public function __construct(SluggerInterface $slugger)
    {
        $this->sluggler = $slugger;
    }

    public function prePersist(Product $entity)
    {
        if(empty($entity->getSlug))
        {
            $entity->setSlug(strtolower($this->sluggler->slug($entity->getName())));
        }
    }
}

