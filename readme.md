# Introduction

#### Role
Role can be used to define a group of permission. If a user has a editor role, he/she can edit, delete, publish articles. To attach a permission to a role;
```
$user->addRole('admin');
```
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

#### Permission
Permission can be used to define a particular action. For example Edit article permission, Read article permission.

#### Deny a particular action:
Suppose a user has a role ***Editor*** and you want him to deny a publish a article action, then you can do:
```
$user->removePermission('publish article');
```
#### Middleware
Use either permission or role as a middleware to protect the resources. Use `|` to use multiple role or permission in a  middleware. If both role and permission middleware are defined both middleware should passed to access the resources. Here, you can deny to publish a article even he has got a editor role.
```
Route::group(['middleware' => ['role:system admin|database admin','permission:read article']], function () {
    //
});
```
above can interpret as user should have sytem admin or database admin role **and** read article permission **is not** denied.