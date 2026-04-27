<?php
namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InkomaneUser extends Model {
    protected $table = 'inkomane_users';
    
    protected $fillable = [
        'name', 'email', 'role', 'department', 
        'category', 'subject', 'description', 
        'status', 'payment', 'clickthrough'
    ];
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('is_enabled')->default(false); 
    });
}

}