<?php
namespace Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Users extends Eloquent
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string
     */
    protected $table = 'users';
    
    /**
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * @var string
     */
    const UPDATED_AT = 'updated_at';


}
