## **Assessment - User Roles Management with Email integration**

The task to create a user with specific role and after login user can only have functionality available which permissions are given on specific role, there will be a super administrator role which can not be change able and should have all the access to the application based on role(not hard-coded), also by default there will be a default user as well.

Please use the following wireframe to build the application: https://design.visualspec.co.uk/?p=Interview.User.Stories&user=1

We would request that you undergo this task using the following technology stack:

- Symfony latest version
- Maria DB latest version
- Doctrine ORM
- Twig

1. please send to us via using any git and share the repository with us
2. if there are any dependencies please add those to the Readme and we will follow accordingly

## **Project Setup**

- switch to PHP 7.4 version
- `git clone <repo link here>`
- update `DATABASE_URL="mysql://root:123456@127.0.0.1:3306/assessment?serverVersion=5.7"`
  in `.env` file according to your environment db settings
- run `composer install`
- run `php bin/console doctrine:database:create`
- run `php bin/console doctrine:migrations:migrate`
- run `php bin/console doctrine:fixtures:load`
- run `symfony server:start`

## **What is Done**

- role crud
- user crud
- db changes and migrations
- link roles with users
- archive (soft delete) roles and users
- search roles and users
- user authentication
- redirect user to home page screen if not logged in
- duplicate roles

## **What is Remaining**

- Email templates CRUD using CK-Editor
- Forgot Password Functionality
