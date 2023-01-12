<?php

namespace App\Entity;

class Instructor
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstname,
        public readonly string $lastname,
    ) {
    }

   /**
    * @return string
    */
   public function getLink(): string
   {
       return 'instructors/' . $this->id .'-'.urlencode($this->firstname);
   }
}
