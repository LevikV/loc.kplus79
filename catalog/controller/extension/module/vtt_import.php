<?php
class ControllerExtensionModuleVttImport extends Controller {
    public function index() {
        echo 'Привет, Евгения!';
        $wsdl_url = 'http://api.vtt.ru:8048/Portal.svc?singleWsdl'; //ссылка для обращения к API
        $login = 'am-072'; // логин
        $password = '211212'; // пароль

        //Загружаем все данные с сервера поставщика
        $result = $this->load_alldata();

        echo '<pre>';
        print_r($result);
        echo '<pre>';

    }

    //Функция загрузки всех товаров с портала ВТТ
    function load_alldata()
    {
        global $wsdl_url, $login, $password;
        $params = array("login" => $login , "password" => $password);
        try
        {
            $client = new SoapClient($wsdl_url, $params);
            $dates = $client->GetItems($params);
            //write_to_log("Данные с портала ВТТ успешно получены.");
            return $dates;
        }
        catch (SoapFault $E)
        {
            //write_to_log("Ошибка получения данных с портала ВТТ: ".$E->faultstring);
            $subject = "Интернет магазин Картридж+ - ОШИБКА получения прайса с ВТТ";
            $message = "Произошла ошибка при получении данных с портала ВТТ \r\n";
            $message = $message . "Ошибка: " . $E->faultstring;
            //send_mail($subject, $message);
            echo $message;
            die;
        }
    }
}
