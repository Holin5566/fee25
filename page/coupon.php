<?php
require($_SERVER['DOCUMENT_ROOT'] . "/project/project-conn.php");
if (!isset($_GET["p"])) {
     $p = 1;
} else {
     $p = $_GET["p"];
}

//計算總共有幾筆資料
$sql = "SELECT * FROM coupon ";
$result = $conn->query($sql);
$total = $result->num_rows;
//與總共要計算幾筆分頁有關係

//計算分頁
$per_page = 5;
$start = ($p - 1) * $per_page;
$sql = "SELECT * FROM coupon  LIMIT $start,$per_page";
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

$page_count = CEIL($total / $per_page);
//總共會有幾頁




//兩個接受的值不同就不衝突.
//假設又要在抓一筆資料的時候

?>



<h3>優惠券一覽</h3>
<div class="row">

     <table class="table table-striped table-hover my-3">
          <thead>
               <tr>
                    <th>編號</th>
                    <th>優惠券</th>
                    <th>序號</th>
                    <th>折扣%</th>
                    <th>使用期限</th>
                    <th>使用次數</th>
                    <th>啟用</th>
                    <th scope="col"><?php
                                        $title = "新增優惠券";
                                        $formType = "post-coupon";
                                        require("../components/post-offcanvas.php") ?></th>
               </tr>
          </thead>
          <tbody>
               <!-- 標準欄位 -->
               <?php foreach ($rows as $row) : ?>

                    <tr>
                         <td># <?= $row["id"] ?></td>
                         <td><?= $row["name"] ?></td>
                         <td><?= $row["code"] ?></td>
                         <td><?= $row["discount"] ?>%</td>
                         <td colspan="2"><?= $row["expiry"] ?></td>
                         <td><?= $row["limited"] ?></td>
                         <td><?= $row["valid"] ?></td>
                    </tr>
                    <tr>
                         <td class="text-center"><img style="width: 1.5rem;" src="../img/icon/sticky-notes.png" alt=""></td>
                         <td colspan="5">
                              <span class="text-muted"><small>備註內容</small></span>
                         </td>
                         <td colspan="2" class="text-center">

                              <button type="button" class="btn-sm btn-info ">
                                   <a class="text-white" href="/project/page/index.php?id_type=coupon_id&id=<?= $row["id"] ?>&current=coupon_valid_product">詳細資訊</a></button>
                              <button type="button" class="btn-sm btn-warning ">
                                   <a class="text-white" href="/project/api/coupon/備用/form-post-edit.php?id=<?= $row["id"] ?>">編輯</a></button>
                              <button type="button" class="btn-sm btn-danger ">
                                   <a class="text-white" href="/project/api/coupon/備用/form-post-delete.php?id=<?= $row["id"] ?>">刪除</a></button>
                         </td>
                    </tr>

               <?php endforeach; ?>



          </tbody>
     </table>
     <nav aria-label="Page navigation example">
          <ul class="pagination">
               <?php for ($i = 1; $i <= $page_count; $i++) : ?>
                    <li class="page-item <?php if ($i == $p) echo "active" ?>"><a class="page-link" href="index.php?current=coupon&p=<?= $i ?>"><?= $i ?></a></li>
               <?php endfor ?>
          </ul>

          <div class="py-2 text-end">
               第<?= $p ?> 頁 , 共<?= $page_count ?>頁 , 共<?= $total ?> 筆資料
          </div>

     </nav>
</div>