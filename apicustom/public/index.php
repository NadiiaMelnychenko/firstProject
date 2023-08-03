<?php
#Часовий пояс в межах файлу
date_default_timezone_set('Europe/Kiev');
$pdo = new PDO("mysql:host=172.22.75.8;dbname=cms", "cms-user", "123456");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $text = $_POST['text'];
    $title = $_POST['title'];
    $date = date("Y-m-d H:i:s");
    $pdo->query("INSERT INTO news (title,text,date) VALUES ('{$title}','{$text}','{$date}')");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
</head>
<body>
    <form action="" method="post">
        <div>Title:</div>
        <div>
            <input type="text" name="title">
        </div>
        <div>Text:</div>
        <div>
            <textarea name="text"></textarea>
        </div>
        <div>
            <button type="submit">Add</button>
        </div>
    </form>
    <div>
        <h1>News list</h1>
        <table>
            <?php
            $page = 0;
            $offset = 0;
            $limit = 5;

            if(isset($_GET['page'])){
                $page = $_GET['page'];
                $offset = $limit * ($page-1);
            }
            $sth = $pdo->query("SELECT * FROM news LIMIT $offset, $limit");
            $count = $pdo->query("SELECT COUNT(*) as count FROM news")->fetchColumn();

            $pages = ceil($count/$limit);
            while ($row = $sth->fetch()): #fetch отримує один запис
            ?>
            <tr>
                <td><?=$row['id']?></td>
                <td><?=$row['title']?></td>
                <td><?=$row['date']?></td>
            </tr>
            <?php endwhile;?>
        </table>
        <div>
            <?php
            for($j=1; $j < $pages+1; $j++) {
                echo "<a href=?page=$j>".$j."</a>";
            }
            ?>
        </div>
    </div>
</body>
</html>











