<?php

namespace App\Doctrine\Listener;


use App\Entity\Product;
use Symfony\Component\String\Slugger\SluggerInterface;

class EditProductSlugListener 
{
    protected $sluggler;

    public function __construct(SluggerInterface $slugger)
    {
        $this->sluggler = $slugger;
    }

    public function preUpdate(Product $entity)
    {
        $entity->setSlug(strtolower($this->sluggler->slug($entity->getName())));
    }
}

