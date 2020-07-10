<?
class Controller_ListTasks extends Controller
{
	function action_index()
	{
        
        if(isset($_POST["sort"])){
            $res = $this->custom_sort();
        }
        if(isset($_POST["addTask"])){
            $res = $this->addTask();
        }
        if(isset($_POST["upd"])){
            $res = $this->save();
        }
        $page= 1;
        if(isset($_GET['page'])){
            $page= $_GET['page'];
            setcookie('page', $page, time()+60*24*7*60, "/");
            $_COOKIE['page']= $page;
        }
        else{
           if(isset($_COOKIE['page'])){
                $page = $_COOKIE['page'];
            } 
        }
        
        
        $data['list'] = $this->checkTask($page);
        $data['countPage'] = ceil($this->checkCountPages()/LIMIT);
        $data['page'] = $page;
        if(isset($res)){
          $data['message'] = $res;  
        }
       
        $this->view->generate('list_tasks_view.php', 'template_view.php',$data);
       
    }
    
    function save()
	{
        $prov = true;
        if($_COOKIE['isregistr']=='false'){
            header('Location:/index.php/auth');
        }
        else{
            foreach($_POST['upd'] as $val){
            if($val['desc'] != ''){
                $con = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_BASENAME );
                if(isset($val['check'])){
                    $query1 = 'is_check = 1';
                }
                else{
                    $query1 = 'is_check = 0';
                }
                $query = "SELECT * FROM tasks WHERe `primarykey`=".$val['id'];
       
                $result = $con->query( $query);
                //$mass[] = array();

                if($result){
                    if( ($row = $result->fetch_assoc()) != null)
                    {
                         $row1 = $row;
                    }
                }
               
                if($row1['description'] != $val['desc']){
                    $query = "UPDATE tasks SET `description` = '".mysqli_real_escape_string($con,$val['desc'])."', `is_admin_upd` = 1   WHERE       `primarykey` = '".$val['id']."'";
                    $con->query( $query);
                    
                }
                $query = "UPDATE tasks SET ".$query1."  WHERE `primarykey` = '".$val['id']."'";
                $con->query( $query);
                $con->close();
                
            } 
            else{
                $prov = false;
            }
        }
        if($prov){
            return "Успешно";
        }
        else{
            return 'Поле описание не должно быть пустым';
        }
        }
        
    }
    
    function custom_sort()
	{
        
        if(isset($_POST['sort']['email'])){
            
            if(isset($_COOKIE['sort'])){
                $mass = json_decode( $_COOKIE['sort']);
                
                if(isset($mass->email)){
                    if($mass->email == 'ASC'){
                        $mass->email = 'DESC'; 
                    }
                    else{
                       unset($mass->email); 
                    }
                }
                else{
                     $mass->email = 'ASC'; 
                }
                $_COOKIE['sort'] = json_encode($mass);
                setcookie('sort', json_encode($mass), time()+60*24*7*60, "/");
                
                   
            }
            else{
                $mass['email'] = 'ASC';  
                $_COOKIE['sort'] = json_encode($mass);
                
                setcookie('sort', json_encode($mass), time()+60*24*7*60, "/");
            }    
               
        }
        
        if(isset($_POST['sort']['name'])){
            
            if(isset($_COOKIE['sort'])){
                $mass = json_decode( $_COOKIE['sort']);
                
                if(isset($mass->name)){
                    if($mass->name == 'ASC'){
                        $mass->name = 'DESC'; 
                    }
                    else{
                        unset($mass->name);   
                    }
                }
                else{
                    $mass->name = 'ASC'; 
                }
                $_COOKIE['sort'] = json_encode($mass);
                
                setcookie('sort', json_encode($mass), time()+60*24*7*60, "/");
                
                   
            }
            else{
                $mass['name'] = 'ASC'; 
                $_COOKIE['sort'] = json_encode($mass);
                
                setcookie('sort', json_encode($mass), time()+60*24*7*60, "/");
            }    
               
        }
        
         if(isset($_POST['sort']['description'])){
            
            if(isset($_COOKIE['sort'])){
                $mass = json_decode( $_COOKIE['sort']);
                
                if(isset($mass->description)){
                    if($mass->description == 'ASC'){
                        $mass->description = 'DESC'; 
                    }
                    else{
                        unset($mass->description);   

                    }
                }
                else{
                    $mass->description = 'ASC';
                }
                $_COOKIE['sort'] = json_encode($mass);
                
                setcookie('sort', json_encode($mass), time()+60*24*7*60, "/");
                
                   
            }
            else{
                $mass['description'] = 'ASC';  
                $_COOKIE['sort'] = json_encode($mass);
                
                setcookie('sort', json_encode($mass), time()+60*24*7*60, "/");
            }    
               
        }
    }
    
    function addTask()
	{
        // adds
        if($_POST["addTask"]["email"] != "") {
            // проверка корректности
            
            if(preg_match('/^[a-z0-9][a-z0-9_\.-]*@[a-z0-9\.-]+\.[a-z0-9\-]{2,8}$/i',$_POST["addTask"]["email"]))
            {
                if($_POST["addTask"]["name"] != "") {
                    if($_POST["addTask"]["desc"] != "") {
                        $con = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_BASENAME);
                        $query = "INSERT INTO tasks ( `email`, `name`, `description`, `is_check`,`is_admin_upd`) VALUES ('" . mysqli_real_escape_string($con, $_POST["addTask"]["email"]) . "', '" . mysqli_real_escape_string($con, $_POST["addTask"]["name"]) ."', '"  . mysqli_real_escape_string($con, $_POST["addTask"]["desc"]) . "', 0,0)";
                        $con->query($query);
                        $con->close();
                        return 'Успешно';
                    }
                    else
                        return 'Поле описание не должно быть пустым';

                }
                else{
                    return 'Поле имя не должно быть пустым';
                }
            }
            else
                return 'Поле email заполнено некорректо';       
        }
        else{
            return 'Ошибка валидации';
        }
        
    }
    
    
    
    public function checkCountPages()
    {
        $con = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_BASENAME );
        
        $query = "SELECT COUNT(*) as count FROM tasks ";
        $result = $con->query( $query);
        //$mass[] = array();
        $row1 ="";
        if($result){
            if( ($row = $result->fetch_assoc()) != null)
            {
                $row1 = $row['count'];
            }
        }
        $con->close();
        return $row1;
    }
    
    function checkTask($page)
    {
        $con = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_BASENAME );
        
        $pageId = ceil(($page-1)*LIMIT);
        $order = '';
        if(isset($_COOKIE['sort'])){
            $mass2= json_decode($_COOKIE['sort']);
            $prov = false;
            foreach ($mass2 as $key => $value){
                if($value != null){
                    $order2[] = ''.$key. ' '.$value;
                    $prov = true;
                }
            }
            if($prov) 
                $order = 'ORDER BY ' . implode(",", $order2);
        }
        
        $query = "SELECT * FROM tasks ".$order." LIMIT ".$pageId.",".LIMIT. " ";
       
        $result = $con->query( $query);
        //$mass[] = array();

        if($result){
            while( ($row = $result->fetch_assoc()) != null)
            {
                $mass[] = $row;
            }
        }
        $con->close();
        return $mass;
    }
}