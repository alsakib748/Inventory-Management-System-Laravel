<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        // User Active Now
        public function UserOnline(){
            return Cache::has('user-is-online' . $this->id);
        }

        public static function getpermissionGroups(){

            $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
            return $permission_groups;
        } // End Method

        public static function getpermissionByGroupName($group_name){
            $permissions = DB::table('permissions')
                            ->select('name','id')
                            ->where('group_name',$group_name)
                            ->get();
            return $permissions;
        }// End Method


        public static function roleHasPermissions($role,$permissions){

            $hasPermission = true;
            foreach($permissions as $permission){
                if (!$role->hasPermissionTo($permission->name)) {
                    $hasPermission = false;
                    return $hasPermission;
                }
                return $hasPermission;
            }

        }// End Method

}
