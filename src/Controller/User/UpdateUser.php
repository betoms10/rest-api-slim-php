<?php

namespace App\Controller\User;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Update User Controller.
 */
class UpdateUser extends BaseUser
{
    /**
     * Update a user.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke($request, $response, $args)
    {
        $this->setParams($request, $response, $args);
        $input = $this->getInput();
        if ($this->args['id'] != $input['decoded']->sub) {
            throw new \Exception('User permission failed.', 400);
        }
        $user = $this->getUserService()->updateUser($input, $this->args['id']);
        if ($this->useRedis() === true) {
            $this->saveInCache($this->args['id'], $user);
        }

        return $this->jsonResponse('success', $user, 200);
    }
}
