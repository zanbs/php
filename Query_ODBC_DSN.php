<?php
//GPT:写一个php程序, 能读连上指定的odbc dsn, 并读取某张表里面的多个字段, 并输出到页面
// 定义DSN，用户名和密码
$dsn = 'MyPHPdevDsn';
$user = 'db_user_in_sql';
$password = '123456';

// 尝试连接到数据库
$conn = odbc_connect($dsn, $user, $password);
if (!$conn) {
    die('Could not connect: ' . odbc_errormsg());
}

// 定义要查询的数据库，表和字段
$database = 'DB1';
$table = 'account';
$fields = ['id', 'account', 'passwd', 'ip'];  // 替换为你需要的字段
$cond = 'id < 50000';
// 构建SQL查询语句
$sql = 'SELECT ' . implode(', ', $fields) . ' FROM ' . $database . '.' . $table . ' where ' . $cond;
echo '<br>------------------------------执行SQL------------------------------<br><br>';
echo $sql . '<br>';
echo '<br>------------------------------结果如下------------------------------<br><br>';
// 执行查询并处理结果
$result = odbc_exec($conn, $sql);
if ($result) {
    // 输出表格头部
    echo "<table border='1' style='text-align: left;'>\n";
    echo "<tr>\n";
    foreach ($fields as $field) {
        echo "<th>" . $field . "</th>";
    }
    echo "</tr>\n";

    // 输出数据
    while ($row = odbc_fetch_array($result)) {
        echo "<tr>\n";
        foreach ($fields as $field) {
            echo "<td>" . $row[$field] . "</td>";
        }
        echo "</tr>\n";
    }

    echo "</table>\n";
} else {
    echo 'Query failed: ' . odbc_errormsg($conn);
}

// 关闭数据库连接
odbc_close($conn);
?>

