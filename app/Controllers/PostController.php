<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * CREATE TABLE `post` (
 *   id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
 *   `title` VARCHAR(55) NOT NULL DEFAULT '',
 *   `content` VARCHAR(1024) NOT NULL DEFAULT '',
 *   INDEX `id` (`id`)
 * ) COLLATE='utf8_general_ci' ENGINE=InnoDB;
 */
class PostController extends BaseController
{
    protected $db;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->db = $this->container->db;
    }

    public function index(Request $request, Response $response, array $args)
    {
        $this->db->orderBy('id', 'desc');
        $rows = $this->db->get('post');

        return $response->withJson($rows);
    }

    public function show(Request $request, Response $response, array $args)
    {
        $this->db->where('id', intval($args['id']));
        $row = $this->db->getOne('post');

        if (empty($row)) {
            return $response->withJson('Post not found.');
        } else {
            return $response->withJson($row);
        }
    }

    public function update(Request $request, Response $response, array $args)
    {
        $id = intval($args['id']);

        $this->db->where('id', $id);
        $row = $this->db->getOne('post');

        if (empty($row)) {
            return $response->withJson('Post not found.');
        }

        $msg = null;
        $body = $request->getParsedBody();
        if (!isset($body['title'])) {
            $msg = 'The title field is required.';
        } elseif (!isset($body['content'])) {
            $msg = 'The content field is required.';
        }

        if ($msg !== null) {
            return $response->withJson($msg);
        }

        $this->db->where('id', $id);
        $res = $this->db->update('post', array(
            'title' => $body['title'],
            'content' => $body['content'],
        ), 1);

        if ($res) {
            return $response->withJson('Successful.');
        } else {
            return $response->withJson('Failed.');
        }
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $this->db->where('id', intval($args['id']));
        $this->db->delete('post', 1);

        return $response->withJson('Successful.');
    }

    public function save(Request $request, Response $response, array $args)
    {
        $msg = null;
        $body = $request->getParsedBody();
        if (!isset($body['title'])) {
            $msg = 'The title field is required.';
        } elseif (!isset($body['content'])) {
            $msg = 'The content field is required.';
        }

        if ($msg !== null) {
            return $response->withJson($msg);
        }

        $res = $this->db->insert('post', array(
            'title' => $body['title'],
            'content' => $body['content'],
        ));

        if ($res) {
            return $response->withJson('Successful.');
        } else {
            return $response->withJson('Failed.');
        }
    }
}
