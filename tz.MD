Написать простейший новостной сайт с авторизацией и оповещением пользователей о событиях. (Используя basic шаблон фреймворка Yii2)

1 Регистрация и авторизация пользователей (можно использовать готовые
модули/расширения) с подтверждением почтового ящика.+

2 CRUD управление пользователями
- Добавление/редактирование пользователей сделать в модальном окне.+
- Возможность фильтрации списка: по ид, логину, email, дате регистрации, дате последней
авторизации. +
права доступа:
- Доступно только роли администратор+

3 CRUD управление новостями с разграничением прав.
- Добавление/редактирование новости сделать в модальном окне (картинка, краткий текст,
полный текст).+

- Возможность изменения статуса новости (активен, неактивен) прямо в списке без
перезагрузки страницы.+
- Возможность фильтрации списка: по дате добавления (от – до), названию, описанию,
статусу+

права доступа (реализовать с использованием RBAC):
- Анонимный пользователь может просматривать только превью +
- Авторизованный пользователь может просматривать полные новости +
- Менеджер может добавлять новости и редактировать/удалять только свои новости+
- Администратор - все выше описанное. +
--------------------------------------------------------
4 Постраничный вывод превью новостей на главной странице с дальнейшим полным
просмотром. +

У пользователя должна быть возможность изменять количество превью на
странице.+

5 При добавлении новости на сайт, оповещать зарегистрированных пользователей по email+ 
и
всплывающим уведомлением (например bootstrap-alert) с возможностью отметить
уведомление как прочитанное.

6 Сделать в настройках профиля настройку уведомлений (получать уведомления о новых
новостях только на email, в браузер или и то и другое)

7 Оповещать пользователя по email при изменении пароля или создания нового
пользователя администратором (выслать новому пользователю на email ссылку для
активации профиля и ввода нового пароля для дальнейшей авторизации) +

8 Оповещение реализовать используя события Yii2 +

Общие требования/пожелания к выполнению задания

- Разрешается использовать готовые модули/расширения, если они подходят под нужную
функциональность и не вносят лишнюю.
- Следовать принципам SOLID, DRY.+
- В качестве базы данных использовать MySQL.+
- Использовать миграции  +
- Описать проект в Wiki с указанием ссылкой на резюме и по
возможности доступами к демо.
- Работу разместить на репозиторие GitHub или Bitbucket. +
- Плюсом будет наличие функциональных и модульных тестов средствами Yii2.-
- Убедитесь, что ваше приложение работает и не содержит ошибок. Наличие ошибок
негативно скажется на оценке работы.