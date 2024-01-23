<?php

namespace App\Providers;


class CommentInfo 
{
    /**
     * Esta clase va a guardar el nombre del usuario para el comentario,
     * el texto del comentario
     * y el id del comentario
     * 
     *  */

    public int $id;
    public string $text;
    public string $userN;
    public $date;
    public function __construct(int $i,string $t,string $u,$date)
    {
        $this->id=$i;
        $this->text=$t;
        $this->userN=$u;
        $this->date=$date;
    }
}
