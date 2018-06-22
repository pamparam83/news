<p align="center">
    <a href="http://news.pamdev.ru" target="_blank">
        <h1 align="center">News</h1>
    </a>    
    admin admin/demo123, manager manager/demo123
</p>

Вся логика находится в директория core
в  core/entities все сущности 
в  core/repositories основная работа с бД
в  core/forms обработка форм
в  core/services вся логическая работа


### Реализовано на проекте

1 Регистрация и авторизация пользователей (можно использовать готовые
модули/расширения) с подтверждением почтового ящика.

2 CRUD управление пользователями
- Добавление/редактирование пользователей сделать в модальном окне.
- Возможность фильтрации списка: по ид, логину, email, дате регистрации, дате последней
авторизации. 
права доступа:
- Доступно только роли администратор

3 CRUD управление новостями с разграничением прав.
- Добавление/редактирование новости сделать в модальном окне (картинка, краткий текст,
полный текст).

- Возможность изменения статуса новости (активен, неактивен) прямо в списке без
перезагрузки страницы.
- Возможность фильтрации списка: по дате добавления (от – до), названию, описанию,
статусу

права доступа (реализовать с использованием RBAC):
- Анонимный пользователь может просматривать только превью 
- Авторизованный пользователь может просматривать полные новости 
- Менеджер может добавлять новости и редактировать/удалять только свои новости
- Администратор - все выше описанное. 

4 Постраничный вывод превью новостей на главной странице с дальнейшим полным
просмотром. 

У пользователя должна быть возможность изменять количество превью на
странице.

5 При добавлении новости на сайт, оповещать зарегистрированных пользователей по email 

7 Оповещать пользователя по email при изменении пароля или создания нового
пользователя администратором (выслать новому пользователю на email ссылку для
активации профиля и ввода нового пароля для дальнейшей авторизации)

8 Оповещение реализовать используя события Yii2

### Не выполнено
1 всплывающие уведомления (например bootstrap-alert) с возможностью отметить
уведомление как прочитанное.

2 нет тестов


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      migrations/          contains database migrations
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources
      
      core                logic project                     
          entities/            contains entities
          forms/               contains forms activeRecords
          repositories/        contains repositories
          services/            contains service 


INSTALLATION
------------

~~~
git clone https://github.com/pamparam83/news.git
~~~


~~~
composer install
~~~



### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

### MIGRATION
~~~
yii migrate --migrationPath=@yii/rbac/migrations

yii migrate/up
~~~
### ROLE
~~~
 yii role/assign 
 Enter
 Username: admin
 Role: admin
 
 yii role/assign 
 Enter
 Username: manager
 role: manager
~~~