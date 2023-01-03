<?php

namespace App\Model;

use App\Model\Model;

class Depoimento extends Model
{

    protected $schema = 'sistema';

    protected $table = 'depoimento';

    protected $Model = 'Depoimento';

    protected $primaryKey = 'id_depoimento';

    public $fillable = [
        'titulo',
        'depoimento',
    ];

    public $hidden = [];
}
