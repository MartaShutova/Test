<?php
namespace Controllers;

use Models;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Response;

class Users extends Base
{
    /**
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @return boolean|Slim\Http\Response
     */
    public function get($request, $response)
    {
        $users = Models\Users::get();
        $result = [];
        foreach ( $users as $key => $user) {
            $result[$key] = $user->toArray();
            $result[$key]['birthday'] = self::extractDate($result[$key]['pesel']);
            $result[$key]['sex'] = self::extractSex($result[$key]['pesel']);
        }

        $this->container->view->render($response, 'users.html', ['users' => $result]);
    }

    /**
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return boolean|Slim\Http\Response
     */
    public function getById($request, $response, $args)
    {
        $id = $args['id'];
        
        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        }

		$user = Models\Users::find($id);
        $response = $response->withJson($user);
		
		return $response->withStatus(200);
    }
    
    /**
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @return Slim\Http\Response
     */
    public function set($request, $response)
    {
        $data = $request->getParams();

        foreach ($data as $elem) {
            if ($elem == '') {
                return $response->withStatus(400);
            }
        }

		$user = new Models\Users;
		$user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->address = $data['address'];
        $user->pesel = $data['pesel'];
        $user->created_at = new \DateTime('now');
		$user->save();

		return $response->withStatus(200);
    }
    
    /**
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return boolean|Slim\Http\Response
     */
    public function update($request, $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParams();

        foreach ($data as $elem) {
            if ($elem == '') {
                return $response->withStatus(400);
            }
        }
        $user = Models\Users::find($id);

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->address = $data['address'];
        $user->pesel = $data['pesel'];
        $user->updated_at = new \DateTime('now');
        $user->save();

        return $response->withStatus(200);
    }
    
    /**
     * @param Slim\Http\Request $request
     * @param Slim\Http\Response $response
     * @param array $args
     * @return boolean|Slim\Http\Response
     */
    public function delete($request, $response, $args)
    {
        $id = $args['id'];

        $validations = [
            v::intVal()->validate($id)
        ];

        if ($this->validate($validations) === false) {
            return $response->withStatus(400);
        }
		
		$user = Models\Users::find($id);

		if ($user) {
			$user->delete();
            return $response->withStatus(200);
		}
        return $response->withStatus(404);
    }

    public static function extractSex($pesel)
    {
        return intval(substr($pesel, 9, 1)) % 2 == 0 ? 'Man' : 'Woman';
    }

    public static function extractDate($pesel)
    {
        list($year, $month, $day) = sscanf($pesel, '%02s%02s%02s');
        switch (substr($month, 0, 1)) {
            case 2:
            case 3:
                $month -= 20;
                $year += 2000;
                break;
            case 4:
            case 5:
                $month -= 40;
                $year += 2100;
            case 6:
            case 7:
                $month -= 60;
                $year += 2200;
                break;
            case 8:
            case 9:
                $month -= 80;
                $year += 1800;
                break;
            default:
                $year += 1900;
                break;
        }
        return $year . '-' . $month . '-' . $day;
    }
}
