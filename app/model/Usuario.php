<?php

namespace App\Model;

use App\Core\DB;
use App\Model\Model;

class Usuario extends Model
{

    protected $schema = 'sistema';

    protected $table = 'usuario';

    protected $Model = 'Usuario';

    protected $primaryKey = 'id_usuario';

    public $fillable = [
        'nome',
        'email',
        'senha'
    ];

    public $hidden = [];

    public function getUserByEmail()
    {
        
    }
}
