<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-36</title>
</head>
<body>
    
   <?php
    $dsn = 'mysql:dbname=tb220213db;host=localhost';
    $user = 'tb-220213';
	$password = 'RdBdQrv9rT';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "pw INT(9)"
	.");";
	$stmt = $pdo->query($sql);
	
	if($_POST["name"]!=NULL && $_POST["comment"]!=NULL && $_POST["editornumber"]==NULL){
	           	$name = $_POST["name"];
	            $comment = $_POST["comment"]; 
	            $date = date("Y/m/d H:i:s");
	            $delete = $_POST["delete"];
	            $editor = $_POST["editor"];
	            $pw = $_POST["pw"];
	           
	           $sql = $pdo -> prepare("INSERT INTO newpost (name, comment, date, pw) 
	                                   VALUES (:name, :comment, :date, :pw)");
	           $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	           $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	           $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	           $sql -> bindParam(':pw', $pw, PDO::PARAM_INT);
	           $sql -> execute();

               $sql = 'SELECT * FROM newpost';
	           $stmt = $pdo->query($sql);
	           $results = $stmt->fetchAll();
	           foreach ($results as $row){
		       //$rowの中にはテーブルのカラム名が入る
		       echo $row['id'].'<>';
		       echo $row['name'].'<>';
		       echo $row['comment'].'<>';
		       echo $row['date']."<br>";
	           echo "<hr>";
	      }
    } elseif($_POST["delete"] != NULL){
	    $delete = $_POST["delete"];
	    $pw = $_POST["pw"];
        
        $sql = 'SELECT * FROM newpost';
        $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    
        foreach($results as $row){
                if($row['id']==$delete){
                    if($row['pw'] != ""){
                        if($row['pw'] != $pw){
                        			echo $row['id'].'<>';
		                            echo $row['name'].'<>';
		                            echo $row['comment'].'<>';
		                            echo $row['date']."<br>";
	                                echo "<hr>";
                    } 
                } else {
                            		echo $row['id'].'<>';
		                            echo $row['name'].'<>';
		                            echo $row['comment'].'<>';
		                            echo $row['date']."<br>";
	                                echo "<hr>";
                }
        } else {
                            		echo $row['id'].'<>';
		                            echo $row['name'].'<>';
		                            echo $row['comment'].'<>';
		                            echo $row['date']."<br>";
	                                echo "<hr>";
        }
      }
   } elseif($_POST["editor"]!=NULL){
        $name = $_POST["name"];
	    $comment = $_POST["comment"]; 
	    $date = date("Y/m/d H:i:s");
	    $delete = $_POST["delete"];
	    $editor = $_POST["editor"];
	    $pw = $_POST["pw"];
	    
        $sql = 'SELECT * FROM newpost';
        $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
        foreach($results as $row){
                if($row['id'] == $editor){
                    $editorname = $row['name'];
                    $editorcomment = $row['comment'];
                } 
        }
        
   } 
   
    if($_POST["name"]!=NULL && $_POST["comment"]!=NULL 
        && $_POST["editornumber"]!=""){
       $name = $_POST["name"];
	   $comment = $_POST["comment"]; 
	   $date = date("Y/m/d H:i:s");
	   $delete = $_POST["delete"];
	   $editor = $_POST["editor"];
	   $pw = $_POST["pw"];        
       $editornumber = $_POST["editornumber"];
       
       $sql = 'SELECT * FROM newpost';
       $stmt = $pdo->query($sql);
	   $results = $stmt->fetchAll();
       foreach($results as $row){
                if($row['id'] == $editornumber){
                    if($row['pw'] != ""){
                        if($row['pw'] == $_POST["pw"]){
                            // UPDATE文を変数に格納
                            $sql = "UPDATE newpost SET name = :name, comment = :comment
                                    WHERE id = $editornumber";
                            // 更新する値と該当のIDは空のまま、SQL実行の準備をする
                            $stmt = $pdo->prepare($sql);
                            // 更新する値と該当のIDを配列に格納する
                            $params = array(':name' => $_POST["name"], 
                                            ':comment' => $_POST["comment"]);
                            // 更新する値と該当のIDが入った変数をexecuteにセットしてSQLを実行
                            $stmt->execute($params);
                        }
                    }
                }    
       }
       
       $sql = 'SELECT * FROM newpost';
       $stmt = $pdo->query($sql);
	   $results = $stmt->fetchAll();
        foreach($results as $row){
                echo $row['id'].'<>';
		        echo $row['name'].'<>';
		        echo $row['comment'].'<>';
		        echo $row['date']."<br>";
	            echo "<hr>";
        } 
   }
	
   ?>
   
    <ul style="list-style: none;">
        
    <li><form action="" method="post">
    <label for="name">名前</label>
    <input type="text" name="name" value="<?php if (isset($editorname)){
                                                    echo $editorname;}?>" ></li> 
    
    <li><label for="comment">投稿内容</label>
    <input type="text" name="comment" value="<?php if (isset($editorcomment)){
                                                       echo $editorcomment;}?>" >
    <input type="submit" name="submit"></li>
    
    <li><form action="" method="post">
    <label for="delete">削除番号</label>
    <input type="text" name="delete" >
    <input type="submit" name="submit"></li>
    
    <li><form action="" method="post">
    <label for="pw">PW</label>
    <input type="text" name="pw">
    <input type="submit" name="submit"></li>
    
    <li><form action="" method="post">
    <label for="editor">編集番号</label>
    <input type="text" name="editor">
    <input type="submit" name="submit"></li>
    
    <form action="" method="post">
    <input type="hidden" name="editornumber" size="1"
    value="<?php echo $_POST["editor"] ?>">
    
    </form>
    </ul>
    
</body>
</html>
