<?php
    session_start();
    include 'includes/common.php';

    $cur_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT t1.*, t2.done_count FROM (SELECT * FROM tbl_todolist WHERE user_id = '$cur_id') t1 LEFT JOIN (SELECT list_id, COUNT(is_done) AS done_count FROM tbl_tasklist WHERE is_done = '0' GROUP BY list_id) t2 ON t1.id = t2.list_id");
    $stmt->execute();

    $qr_result = $stmt->fetchAll();

    $stmt1 = $conn->prepare("SELECT * FROM (SELECT tbl_tasklist.*, tbl_todolist.name AS list_name FROM tbl_tasklist LEFT JOIN tbl_todolist ON tbl_tasklist.list_id = tbl_todolist.id WHERE is_important = '1') t1 WHERE user_id = '$cur_id'");
    $stmt1->execute();

    $qr_important = $stmt1->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="assets/css/materialize.min.css"  media="screen,projection"/>

    <!-- customize css -->
    <link
    href="assets/css/style.css"
    rel="stylesheet"
    />

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo-list</title>
    <link rel="icon" href="favicon.png" type="image/gif" sizes="16x16">
</head>
<body>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="assets/js/materialize.min.js"></script>
    <script type="text/javascript" src="assets/js/script.js"></script>


    <ul id="slide-out" class="side-nav fixed">
        <li>
            
            <div class="user-view">
                <div class="background">
                    <img src="assets/images/office.jpg">
                </div>
                <a href="index.php"><i class="material-icons btn-logout">login</i></a>
                <a href="#"><img class="circle" src="<?php echo $_SESSION["avatar"]; ?>"></a>
                <a href="#"><span class="white-text name"><?php echo $_SESSION["firstname"]; ?></span></a>
                <a href="#"><span class="white-text email"> <?php echo $_SESSION["email"]; ?> </span></a>
            </div>
        </li>
        
        <li id="important"><a class="waves-effect" href="#"><i class="material-icons">star_border</i>Important</a></li>
        <li><div class="divider"></div></li>
        <li><a class="subheader">Todo-List</a></li>
        <div id="todolists">
            <?php foreach($qr_result as $row){ ?>
                <li data-value="<?php echo $row['id']; ?>">
                    <a class="waves-effect" href="#">
                        <i class="material-icons">playlist_add_check</i>
                        <?php echo $row['name']; ?>
                        <?php if(!empty($row['done_count'])) {?>
                            <span class="badge"><?php echo $row['done_count']; ?></span>
                        <?php }else{?>
                            <span class="badge"><?php echo ""; ?></span>
                        <?php }?>
                    </a>
                </li>
            <?php }?>
        </div>
        <li><a class="waves-effect it-text modal-trigger" href="#modal1"><i class="material-icons">add</i>New List</a></li>
    </ul>
    <div class="ps-collapse-button">
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons hamburger-menu">menu</i></a>
    </div>
    

    <main class="main-body">
        <div class="task-list">
            <h4 class="todo-title" id="todo_title" data-value="list_id">Important</h4>
            <div class="task-body" id="task_list">
                <?php foreach($qr_important as $row){ ?>
                    <div class="card br-card">
                        <div class="card-content" style="padding:0px;">
                            <div class="row" style="margin-bottom:0px">
                                <div class="col-sm-12 m-flex">
                                    <div>
                                        <i class="material-icons btn-important r-im">star_border</i>
                                    </div>
                                    <div>
                                        <div class="i-task-title"><?php echo $row['task_name']; ?></div>
                                        <div class="i-list-title">(<?php echo $row['list_name']; ?>)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <div class="card" style="display:none">
                    <div class="card-content" style="padding:0px;">
                        <div class="row" style="margin-bottom:0px">
                            <div class="col-sm-12 d-flex">
                                <div>
                                    <input type="checkbox" class="filled-in" id="filled-in-box-1" checked="checked" />
                                    <label for="filled-in-box-1">A bottle of olive oil</label>
                                </div>
                                <div>
                                    <i class="material-icons btn-important">star_border</i>
                                    <i class="material-icons btn-delete">delete_forever</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card ps-card">
            <div class="card-content" style="padding:0px;">
                <div class="row" style="margin-bottom:0px">
                    <div class="input-field col s11 inline">
                        <i class="material-icons prefix pf-fix">add</i>
                        <input id="add_task" type="text" class="validate" required>
                        <label for="add_task" data-error="wrong" data-success="right">Add a Task</label>
                    </div>
                    <div class="col s1" style="padding-top:15px;">
                        <i class="material-icons btn-send" id="btn_addtask">send</i>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="row">
                <h4>Add List</h4>
                <div class="input-field col s10">
                    <i class="material-icons prefix pf-fix">playlist_add</i>
                    <input id="add_list" name="add_list" type="text" class="validate" required>
                    <label for="password">Input List Name</label>
                </div>
                <div class="col s2" style="padding-top:22px;">
                    <button class="btn waves-effect waves-light" type="button" id="btn_list_add">Add</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>