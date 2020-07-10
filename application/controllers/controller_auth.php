<?
class Controller_Auth extends Controller
{
	function action_index()
	{
        
		$this->view->generate('auth_view.php', 'template_view.php',$data);
	}
    
    function action_logout(){
        setcookie('isregistr', 'false', time()+60*24*7*60, "/");
        header('Location:/index.php/');
    }
    
    function action_auth()
	{
        $data['auth'] = $_POST["auth"];
        if(isset($_POST["auth"]["login"]) && $_POST["auth"]["login"] != "")
        {
            
            if( isset($_POST["auth"]["password"])&& $_POST["auth"]["password"] != "")
            {
                
                $con = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_BASENAME );
                $query = "SELECT * FROM users WHERE `login` = '".mysqli_real_escape_string($con,$_POST["auth"]["login"])."'";
                $result = $con->query( $query);
                if($result){

                    $row = $result->fetch_assoc();
                    if(!is_null($row))
                    {
                        $pass = $_POST["auth"]["password"];
                        //md5
                        $data['passdb'] = $pass;
                        $data['pass'] = $row["pass"];
                        if($pass == $row["pass"])
                        {
                            $con->close();
                            setcookie('isregistr', 'true', time()+60*24*7*60, "/");
		                      header('Location:/index.php/');
                        }
                        else
                        {
                            $con->close();
                            $data['message'] = 'Неправильный пароль';
                            $this->view->generate('auth_view.php', 'template_view.php',$data);
                        }
                    }
                    else
                    {
                        $con->close();
                        $data['message'] = 'Неправильный логин';
                        $this->view->generate('auth_view.php', 'template_view.php',$data);
                    }
                }

            }
            else
            {

               $this->view->generate('auth_view.php', 'template_view.php',$data);
            }

        }
        else
        {

            $this->view->generate('auth_view.php', 'template_view.php',$data);
        }
	}
    
}