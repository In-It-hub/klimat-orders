<?php 
/**Создадим константы с именами путей к каталогам нашего приложения 
 * __DIR__ Констант которая указывает текущую директорию
 * DIRECTORY_SEPARATOR - Предопределенная константа содержащая разделитель Для Windows это «\», для Linux и остальных — «/»
*/
require_once 'config.php';
session_start();
const COCKPIT = 'http://cockpit/cockpit/';
const ROOT = __DIR__ . DIRECTORY_SEPARATOR;
const APP = ROOT . 'app' . DIRECTORY_SEPARATOR;
const CONTROLLER = ROOT . 'app' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR;
const CORE = ROOT . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR;
const VIEW = ROOT . 'app' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR;
const MODEL = ROOT . 'app' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR;
const DATA = ROOT . 'app' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
$modules = [ROOT,APP,CORE,CONTROLLER,DATA];

/* set_include_path() - Устанавливает значение настройки конфигурации include_path
get_include_path() - ВОзвращает путь к текущей папке файла
PATH_SEPARATOR - Точка с запятой в Windows, двоеточие в других системах
implode(Роздлитель, масив) - соединяет все элементы масива в строку с раздлителем
*/


set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));

spl_autoload_register('spl_autoload', false);

new Application();

