<?
namespace App\Controller;
/* use App\Model\HomeModel; */
use \Slim\Views\PhpRenderer;
require '../model/HomeModel.php';

class HomeController
{
    private $container;

    public function __construct($container) {
        $this->container = $container;
    }
    public function home($request, $response, $args) {
      // your code here
      
      // use $this->view to render the HTML
      //return $response;
      $model = new \App\Model\HomeModel($this->container);
      $data = $model->getAllObjects();
      $this->container->view->render($response, 'index.phtml', ['data'=>$data]);
    }
}