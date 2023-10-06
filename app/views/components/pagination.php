<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="paging">           
        <div class="pagination">
            <?php 
                $start_index = $data["page_number"];
                $max_page = $data["max_page"];
                $prev_index = $start_index <= 1 ? 1 : $start_index-1;
                if($start_index > 1){
                    $prev_index = $start_index-1;
                    echo "<a href='/admin/$href/page=$prev_index'>PREV</a>";
                }
                for($i = $prev_index; $i < $start_index+2;$i++){
                    if($i == $max_page){
                        break;
                    }
                    if($i == $start_index){
                        echo "<a class='pagination-active' style='background-color:#9e51d8;color:white;' id='pagination-active'>$i</a>";
                    }else{
                        echo "<a href='/admin/$href/page=$i' id='pagination-number'>$i</a>";
                    }
                }
                if($start_index < $max_page-2){
                    echo "<a>...</a>";
                }
                if($start_index == $max_page){
                    echo "<a style='background-color:#9e51d8;color:white;' href='/admin/$href/page=$max_page'>$max_page</a>";
                }else{
                    echo "<a href='/admin/$href/page=$max_page'>$max_page</a>";
                }
                if($start_index < $max_page){
                    $next_index = $start_index + 1;
                    echo "<a href='/admin/$href/page=$next_index'> &nbsp;  NEXT</a>";
                }
            ?>
        </div>
    </div>
</body>
</html>