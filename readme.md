## Introduction and Core Concepts


### Content
1. [Introduction](https://github.com/bedus-creation/role-permission#introduction)
2. [Installation](https://github.com/bedus-creation/role-permission#installation)


## Introduction 
### Role
Role can be used to define a group of permission. If a user has a editor role, he/she can edit, delete, publish articles. I prefer to use role in most of the cases to allow a group of action.
```
$user->addRole('admin');
```  
* Roles are **case insensetive**. ```$user->addRole('admin');``` and ```$user->addRole('Admin');``` has same meaning.
* Roles not need to create explicitly. ```$user->addRole('admin');``` This function creats a new role **admin** if the given role is not created yet in the database, and then the given role is assign to the given user.  
#### To add permission to role
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
##### Add middlewire in the route middlewire section. ```App\Http\Kernel.php```
```
    protected $routeMiddleware = [
        'role' => \Aammui\RolePermission\Middleware\Role::class,
    ]
```
##### Use Middlewire in anywhere
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

##### Laravel Compatibility 
| Laravel Version | Role Permission Version | Installation |
|-----------------|-------------------------| --- |
| 9.x             | 3.0.0 | ```composer require aammui/role-permission:3.0.0``` |
| 8.x             | 2.0.0 | ```composer require aammui/role-permission:2.0.0``` |
| 7.x             | 1.0.0 | ```composer require aammui/role-permission:1.0.0``` |
| 6.x, 5.x        | 0.7   | ```composer require aammui/role-permission:0.7``` |


#### Publish the assests and run migrations 
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

## Exception
It throws following exception as below.
| Exception | Remarks |
| --- | --- |
| ```Aammui\RolePermission\Exception\UserNotLoginException``` | User is not logged in yet. |
| ```Aammui\RolePermission\Exception\RoleDoesNotExistException``` | A function or route is protected by a role, and logged in user doesn't have that role yet. |

#### UseCase: Exception uses for user redirection.
Suppose we want to redirect not logged in user to login page, which can be done using handling exception in ```app\Exceptions\Handler.php``` class. The purpose of this exception make available is to support full customization. For example you may want to redirect to login page for that user whom don't have right role, or you simply only want to show 403 page.
```php
// App\Exceptions\Handler.php;
use Aammui\RolePermission\Exception\UserNotLoginException;
use Aammui\RolePermission\Exception\RoleDoesNotExistException;

....

public function render($request, Throwable $exception)
{
    if ($exception instanceof UserNotLoginException) {
        return redirect('/login')
            ->with('error', $exception->getMessage());
    }
    
    if ($exception instanceof RoleDoesNotExistException) {
        return redirect('/login')
            ->with('error', $exception->getMessage());
    }

    return parent::render($request, $exception);
}
```
