<?php 

function get_db_connect(){
  // MySQL用のDSN文字列
  $dsn = 'mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset='.DB_CHARSET;
 
  try {
    // データベースに接続
    $dbh = new PDO($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    //エラーモードの設定(エラーが発生した場合、例外として、PDOExceptionを投げる)
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //プリペアドステートメントの設定(SQLを実行前にいろいろと準備して実行)
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    exit('接続できませんでした。理由：'.$e->getMessage() );
  }
  return $dbh;
}

//一行だけデータを取得
function fetch_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    $statement->execute($params);
    //返り値は一行だけ取得
    return $statement->fetch();
  }catch(PDOException $e){
    set_message('データ取得に失敗しました。');
  }
  return false;
}

//すべての結果行のデータを取得
function fetch_all_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    $statement->execute($params);
    //返り値はすべての行を取得
    return $statement->fetchAll();
  }catch(PDOException $e){
    set_message('データ取得に失敗しました。');
  }
  return false;
}

function execute_query($db, $sql, $params = array()){
  try{
    $statement = $db->prepare($sql);
    //SQLを実行した値を返す
    return $statement->execute($params);
  }catch(PDOException $e){
    set_message('更新に失敗しました。');
  }
  return false;
}

?>