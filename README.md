# material-to-do-list

Todo-list is a simple web app for writing to do their work.

## Installation

Use XAMPP server to run on local.

```bash
htdocs/todo-list
```

Run or import attached todolist_db file.

```bash
CREATE DATABASE /*!32312 IF NOT EXISTS*/`todolist_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `todolist_db`;

/*Table structure for table `tbl_tasklist` */

DROP TABLE IF EXISTS `tbl_tasklist`;

CREATE TABLE `tbl_tasklist` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) DEFAULT NULL,
  `list_id` int(100) DEFAULT NULL,
  `task_name` varchar(100) DEFAULT NULL,
  `is_done` int(100) DEFAULT 0,
  `is_important` int(100) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4;

....
```

## MySQL PDO
```bash
<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "todolist_db";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
...
```

## Feature
- Use the materialize for front-end
- Use MySQL PDO for work on 12 different database systems
- Include User Authentication
- Use jQuery and AJAX for requesting to server
