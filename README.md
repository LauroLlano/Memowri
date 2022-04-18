# Memowri
_A web app where you can create and organize your own notes._

**Memowri** is a web application which allows you to create your own notes, organize them in different categories you create, and allows customization on your background.

***This page has been made for learning and personal purposes.***

## About project 🗒

Once the user signs in, he'll be redirected to the dashboard. On the page, you can see your created categories and notes. If you want to create a new note, you can press the green button on the lower right of the page, or you can open the application menu on the top right corner, and select `Create new note`. If you haven't created categories, it will redirect you to create a new category.

With your created notes you can move, reorganize, and change categories. You can edit and delete your notes and categories. By deleting a category, all notes inside the category will be deleted too.

Additionally, you can change your password for your account, and change the background for your account. You can change the background color, background image, and the image opacity in the background.

### Pre-requisites ⚙️
If you want to edit and play with the code, you need a text editor for that. You can use pretty much anything; even good ol' notepad. I recommend using [Visual Studio Code](https://code.visualstudio.com/).

Some of the tools you'll be needing:

* _[PHP and MySQL/XAMPP](https://www.apachefriends.org/) - You need PHP and MySQL for the application to work. If you want to save steps, you can install XAMPP, a local server which can include both things. PHP version must be above 7.0 at least. I used version 8.1.2._
* _[Composer](https://getcomposer.org/) - With Composer, you'll be able to install the project dependencies. You can run the command line, or you can run the installer._

### Installing project 🔧

Before starting, you have to create a new database in MySQL. You can open `phpmyadmin` from XAMPP to create a new database.

You can download the project by pressing the `Code` button in the main project, and download the ZIP. However, if you'd like to use [Git](https://git-scm.com/) to clone the project, you can run the next line:

```
git clone https://github.com/LauroLlano/Memowri/
```
If you'd like to download a specific branch, you can use:
```
git clone -b BRANCH_NAME https://github.com/LauroLlano/Memowri/
```


Once you've downloaded/cloned the files, you have to set up your configuration in order to run the project.

1. _Open a terminal on your computer, and move inside of the project folder._
2. _To install the project dependencies, run the next command on the terminal:_
   ```sh
   composer install
   ```
3. _Copy the `.env.example` file on the root folder, with the new name `.env`. That file will be the main configuration of the project._
4. _On the `.env` file, change the next lines:_
   ```sh
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=YOUR_DATABASE_PORT
   DB_DATABASE=YOUR_DATABASE_NAME
   DB_USERNAME=YOUR_DATABASE_USERNAME
   DB_PASSWORD=YOUR_DATABASE_PASSWORD
   ```
   _If you haven't changed the settings for username and password in XAMPP, most likely the username will be `root`, and password will be left empty._

5. _Write the next line in the terminal to generate an API key to the application:_
   ```sh
   php artisan key:generate
   ```
6. _After creating the `.env` file and your database, we'll have to first migrate the tables to your database using artisan. Run on the terminal the next line to create the tables:_
   ```sh
   php artisan migrate
   ```
After running the command, the project is ready to run.

### Starting the server 🚀

To run the project, start MySQL, and start the local server with the next line:
```
php artisan serve
```
To access the page, open the [localhost](http://127.0.0.1:8000/) page.

### Technologies used ⌨️

* ***Bootstrap v5.1*** - Used in front-end design
* ***Vanilla javascript*** - Used for validating fields and managing submits
* ***Laravel v9.5.1*** - Used for the back-end. Tables are also created with Laravel using its migration feature

---
Project developed by [Lauro Llano 👾](https://github.com/LauroLlano)
