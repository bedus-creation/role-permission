## Introduction and Core Concepts
### Role
Role can be used to define a group of permission. If a user has a editor role, he/she can edit, delete, publish articles. I prefer to use role in most of the cases to allow a group of action.
```
$user->addRole('admin');
```  
* Roles are **case insensetive**. ```$user->addRole('admin');``` and ```$user->addRole('Admin');``` has same meaning.
* Roles not need to create explicitly. ```$user->addRole('admin');``` This function created a new role **admin** if the given role is not created yet in the database, and then the given role is assign to the given user.
To add permission to role
```
$role->addPermission('read article');
// or 
$role->addPermission(['read article','update article']);
```
To attach a CRUD of permission to Role.
```
$role->addResourcePermission('article');
```
It will add create article, read article, update article, delete article permission to the given role. 

### Permission
Permission can be used to **deny** a particular action. I assume in most of the cases the actions are associated with roles. So, if read, write, delete article action is associated with a Editor role, then you can deny Editor to delete article by:
```  
$user->removePermission('delete article');
```
### Middleware
Use either permission or role as a middleware to protect the resources. Use `|` to use multiple role or permission in a  middleware. If both role and permission middleware are defined both middleware should passed to access the resources. Here, you can deny to publish a article even he has got a editor role.
```
Route::group(['middleware' => ['role:system admin|database admin','permission:read article']], function () {
    //
});
```
above can interpret as user should have sytem admin or database admin role **and** read article permission **is not** denied.

## Installation
```
composer require aammui/role-permission
```
## Publish the assests and run migrations 
```
php artisan vendor:publish --provider="Aammui\RolePermission\RolePermissionServiceProvider"
php artisan migrate
```

## Uses
Use a trait ```HasRole``` to your user model.
```
use Aammui\RolePermission\Traits\HasRole;

class User extends Authenticatable
{
    use Notifiable, HasRole;
}
```
and then following api are available to you.
* ```public function addRole($role): void ```  
This **sync** the roles, if a user has admin role and then you send only editor, it will remove admin role and then user will only have editor role. Send all roles to update the roles.
* ```public function getRoles(): array```  
It returns roles in array.
* ```public function hasGotRole(array $roles): bool```