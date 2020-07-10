
<?php  if(isset($_COOKIE['isregistr']) && $_COOKIE['isregistr']=='true'){
    echo '<a href="/index.php/auth/logout">Выйти</a>';
}else{ echo '<a href="/index.php/auth">Аутентификация</a>';} ?>


<form method="post" action="/index.php/<?php if(isset($_COOKIE['page'])) echo '?page='.$_COOKIE['page']; ?>">
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
            $desc = '<input type="text" value= "'.$row['description'].'" name="upd['.$i.'][desc]">';
            if($row['is_check'] == 1)  $checked ='checked'; else  $checked ='';
            $check = '<input type="checkbox"  name="upd['.$i.'][check]" '.$checked.'>'.'<input type="hidden"  name="upd['.$i.'][id]" value="'.$row['primarykey'].'">';
            
        }
        else{
            $desc = '<span>'.$row['description'].'</span>';
            if($row['is_check']== 1){
                $check_st = 'Задача выполнена';
            }
            else{
                 $check_st ='';
            }
            $check = '<span>'.$check_st.'</span>';
            
        }
        if($row['is_admin_upd']== 1){
                $is_admin_upd = '<span>Отредактировано администратором</span>';
            }
        else{
            $is_admin_upd = '';
        }
		echo '
                <span>'.$row['email'].'</span>
                <span>'.$row['name'].'</span>
                '.$desc.
                $check.$is_admin_upd.'
            
            <div class="clear"></div>';
        $i++;
	}
     if(isset($_COOKIE['isregistr']) && $_COOKIE['isregistr']=='true'){
         echo '<input type="submit" value="Сохранить">';
     }
    
    ?>
   
</form>


<form method="post" action="/index.php/<?php if(isset($_COOKIE['page'])) echo '?page='.$_COOKIE['page']; ?>">
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
            $class = 'class="active"';
        }
        else{
            $class = '';
        }
        echo  '<a href="?page='.$j.'" '.$class.' >'.$j.'</a>';
	}

echo '
<div class="clear"></div>
<span>'.$message.'</span>'
?>




