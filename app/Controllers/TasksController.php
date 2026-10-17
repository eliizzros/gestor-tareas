<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class TasksController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user_id');
        $search = $this->request->getGet('search');
        $sort   = $this->request->getGet('sort') === 'asc' ? 'ASC' : 'DESC';

        $db = \Config\Database::connect();
        $builder = $db->table('tasks')->where('user_id', $userId);

        if (!empty($search)) {
            $builder->like('description', $search);
        }

        $tasks = $builder->orderBy('created_at', $sort)->get()->getResultArray();

        return view('tasks/index', [
            'tasks'       => $tasks,
            'search'      => $search,
            'currentSort' => $sort
        ]);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }
        return view('tasks/create');
    }

    public function store(): RedirectResponse
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $description = $this->request->getPost('description');
        $userId      = session()->get('user_id');

        $db = \Config\Database::connect();
        $db->table('tasks')->insert([
            'user_id'     => $userId,
            'description' => $description,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('tasks')->with('success', 'Tarea creada exitosamente.');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        $task = $db->table('tasks')->where('id', $id)->where('user_id', $userId)->get()->getRowArray();

        if (!$task) {
            return redirect()->to('tasks');
        }

        return view('tasks/edit', ['task' => $task]);
    }

    public function update($id): RedirectResponse
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $description = $this->request->getPost('description');
        $userId      = session()->get('user_id');

        $db = \Config\Database::connect();
        $db->table('tasks')->where('id', $id)->where('user_id', $userId)->update([
            'description' => $description
        ]);

        return redirect()->to('tasks')->with('success', 'Tarea actualizada exitosamente.');
    }

    public function delete($id): RedirectResponse
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        $db->table('tasks')->where('id', $id)->where('user_id', $userId)->delete();

        return redirect()->to('tasks')->with('success', 'Tarea eliminada.');
    }
}
