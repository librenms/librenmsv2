Commands
------------

The current supported console commands:

### Add New User
```
php artisan user:add <username> 

{username : The username to add}
{password : Optional}
{--realname= : The real name of the user}
{--email= : The email of the user}
{--read : Global Read access}
{--admin : Global Admin access}
```
The user:add command takes a minimum of the `username` parameter, this should be the username you wish to log in with.

ex:
```
php artisan user:add john

 Real Name:
 > John Doe

 Email:
 > johndoe@myawesomedomain.ca

 Password:
 > 

User john created.
```
If you wish to specify other parameters you are able to do so with the extra arguments above.

ex:
```
php artisan user:add john myStr0ngp4ssword --realname=John Doe --email=john@superemaildomain.ca --admin

User john created.
```


### Delete User
```
php artisan user:delete <*username || realname*>
```

The user:delete command takes one parameter, this can be a partial username or realname. It will find every match in the `users` table and display them as a choice. From the choice menu select which user you wish to remove. If there is only one result from the search, you will be asked to confirm the delete.

ex:
```
php artisan user:delete jack

 Who would you like to remove?:
  [0] jackJohnson
  [1] jackSparrow
 > jackJohnson

 Do you wish to remove jackJohnson? (yes/no) [no]:
 > yes

User deleted.
```
