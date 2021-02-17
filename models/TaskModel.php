<?php

use System\Sessions\Session;
use System\Sql\DataBase;

class TaskModel extends System\Model
{
    private $statusesLang = [
        0 => 'Неизвестно',
        1 => 'Не выполнено',
        2 => 'В работе',
        3 => 'Выполнено',
    ];

    private $userNameDef = 'Anonymous';

    public function __construct()
    {
        parent::__construct();

        Session::start();
        DataBase::getInstance();
    }

    public function saveData($item)
    {
        $authData = Session::get('auth_data');
        $uid = !empty($authData['id']) ? (int)$authData['id'] : 0;

        if (empty($authData['id'])) {
            $item['status'] = 1;
        }

        return DataBase::query('
            INSERT INTO
              tasks
              (user_id, name, description, email, status)
            VALUES
              (:uid, :name, :description, :email, :status)
        ',
        false,
        [
            'uid' => $uid,
            'name' => $item['name'],
            'description' => $item['description'],
            'email' => $item['email'],
            'status' => $item['status'],
        ]);
    }

    public function getData($param)
    {
        $result = [];
        $authData = Session::get('auth_data');
        $isAuth = !empty($authData['id']);
        $data = DataBase::query('
            SELECT
              t.id, CONCAT(u.first_name, " ", u.last_name) as user_name, t.name, t.description, t.email, t.status
            FROM
              tasks AS t
            LEFT JOIN
              users AS u
            ON
              t.user_id = u.id
            WHERE
              t.deleted = 0
            ORDER BY
              t.id DESC
        ',
        true);

        if (!empty($data->rows)) {
            $rows = $data->rows;

            foreach ($rows as $key => $row) {
                $row['author'] = !empty($row['user_name']) ? $row['user_name'] : $this->userNameDef;

                if (isset($this->statusesLang[$row['status']])) {
                    $row['status'] = $this->statusesLang[$row['status']];
                } else {
                    $row['status'] = $this->statusesLang[0];
                }

                $result[$key] = [
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['author'],
                    $row['email'],
                    $row['status'],
                ];

                if ($isAuth) {
                    $result[$key][] = 'operations';
                }
            }
        }

        return $result;
    }

    public function getById($id)
    {
        $result = [];
        $data = DataBase::query('
            SELECT
              t.id, CONCAT(u.first_name, " ", u.last_name) as user_name, t.name, t.description, t.email, t.status
            FROM
              tasks AS t
            LEFT JOIN
              users AS u
            ON
              t.user_id = u.id
            WHERE
              t.deleted = 0
              AND t.id = :id
            ORDER BY
              t.id DESC
        ',
        true,
        [
            'id' => $id
        ]);

        if (!empty($data->row)) {
            $row = $data->row;

            $row['author'] = !empty($row['user_name']) ? $row['user_name'] : $this->userNameDef;

            $result = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
                'author' => $row['author'],
                'email' => $row['email'],
                'status' => $row['status'],
            ];
        }

        return $result;
    }

    public function editById($id, $data) {
        $authData = Session::get('auth_data');
        $isAdmin = !empty($authData['role']) && $authData['role'] === 'admin';

        if (!$isAdmin) {
            return false;
        }

        return DataBase::query('
            UPDATE
              tasks
            SET
              name = :name,
              description = :description,
              author = :author,
              email = :email,
              status = :status
            WHERE
              id = :id
              AND deleted = 0
        ',
        false,
        [
           'id' => $id,
           'name' => $data['name'],
           'description' => $data['description'],
           'author' => $data['author'],
           'email' => $data['email'],
           'status' => $data['status'],
        ]);
    }

    public function removeById($id) {
        $authData = Session::get('auth_data');
        $isAdmin = !empty($authData['role']) && $authData['role'] === 'admin';

        if (!$isAdmin) {
            return false;
        }

        return DataBase::query('
            UPDATE
              tasks
            SET
              deleted = 1
            WHERE
              id = :id
        ',
        false,
        [
            'id' => $id,
        ]);
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
