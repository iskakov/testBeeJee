
<?php  if(isset($_COOKIE['isregistr']) && $_COOKIE['isregistr']=='true'){
    echo '<a class="numbers" href="/index.php/auth/logout">Выйти</a>';
}else{ echo '<a class="numbers" href="/index.php/auth">Аутентификация</a>';} ?>


<form class="form" method="post" action="/index.php/<?php if(isset($_COOKIE['page'])) echo '?page='.$_COOKIE['page']; ?>">
   <div>
       <span>Сортировка по</span>
       <input type="submit" name="sort[email]" value="Email">
       <input type="submit" name="sort[name]" value="Имя пользователя">
       <input type="submit" name="sort[description]" value="Описание">
    </div>
</form>




<div class="clear"></div>
<form method="post" action="/index.php/<?php if(isset($_COOKIE['page'])) echo '?page='.$_COOKIE['page']; ?>">
   <?php
    extract($data);
    $i=0;
    
	foreach($list as $row)
	{
        if(isset($_COOKIE['isregistr']) && $_COOKIE['isregistr']=='true'){
            $desc = '<input type="text" value= "'.htmlspecialchars($row['description']).'" name="upd['.$i.'][desc]"  class="item">';
            if($row['is_check'] == 1)  $checked ='checked'; else  $checked ='';
            $check = '<input type="checkbox"  name="upd['.$i.'][check]" '.$checked.'>'.'<input type="hidden"  name="upd['.$i.'][id]" value="'.$row['primarykey'].'" class="item">';
            
        }
        else{
            $desc = '<div class="item">'.htmlspecialchars($row['description']).'</div>';
            if($row['is_check']== 1){
                $check_st = 'Задача выполнена';
            }
            else{
                 $check_st ='';
            }
            $check = '<div class="item">'.$check_st.'</div>';
            
        }
        if($row['is_admin_upd']== 1){
                $is_admin_upd = '<div class="item item2">Отредактировано администратором</div>';
            }
        else{
            $is_admin_upd = '';
        }
		echo ' <div class="task">
                <div class="item">'.$row['email'].'</div>
                <div class="item">'.htmlspecialchars($row['name']).'</div>
                '.$desc.
                $check.$is_admin_upd.'
            </div>
            <div class="clear"></div>';
        $i++;
	}
     if(isset($_COOKIE['isregistr']) && $_COOKIE['isregistr']=='true'){
         echo '<input type="submit" value="Сохранить">';
     }
    
    ?>
   
</form>


<form class="form" method="post" action="/index.php/<?php if(isset($_COOKIE['page'])) echo '?page='.$_COOKIE['page']; ?>">
    <label for="desc">Email:</label>
    <input id="desc" name="addTask[email]" type="text" value="<?php if(isset($_POST["addTask"])) echo $_POST["addTask"]['email'] ?>">
    <label for="desc">Имя пользователя:</label>
    <input id="desc" name="addTask[name]" type="text" value="<?php if(isset($_POST["addTask"])) echo $_POST["addTask"]['name'] ?>">
    <label for="desc">Описание задачи:</label>
    <input id="desc" name="addTask[desc]" type="text" value="<?php if(isset($_POST["addTask"])) echo $_POST["addTask"]['desc'] ?>">

    <input type="submit" value="Добавить задачу" >
</form>
<?php
    
    for($j=1; $j<=$countPage; $j++)
	{
		if($page == $j){
            $class = 'class="active numbers"';
        }
        else{
            $class = 'class="numbers"';
        }
        echo  '<a href="?page='.$j.'" '.$class.' >'.$j.'</a>';
	}

echo '
<div class="clear"></div>
<div class="item">'.$message.'</div>'
?>




