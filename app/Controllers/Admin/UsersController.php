<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class UsersController extends BaseController
{
    private function checkAdmin()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAdmin()) return redirect()->to('activities');

        $sort = $this->request->getGet('sort') === 'asc' ? 'ASC' : 'DESC';

        $db = \Config\Database::connect();
        $users = $db->table('users')->orderBy('created_at', $sort)->get()->getResultArray();

        return view('admin/users/index', ['users' => $users, 'currentSort' => $sort]);
    }

    public function show($id)
    {
        if (!$this->checkAdmin()) return redirect()->to('activities');

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) return redirect()->to('admin/users');

        return view('admin/users/show', ['user' => $user]);
    }

    public function create()
    {
        if (!$this->checkAdmin()) return redirect()->to('activities');

        return view('admin/users/edit');
    }

    public function store(): RedirectResponse
    {
        if (!$this->checkAdmin()) return redirect()->to('activities');

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $repPass  = $this->request->getPost('repeat_password');

        if ($password !== $repPass) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
        }

        $db = \Config\Database::connect();
        $db->table('users')->insert([
            'username'    => $username,
            'email'       => $email,
            'password'    => password_hash($password, PASSWORD_BCRYPT),
            'role'        => $this->request->getPost('is_admin') ? 'admin' : 'user',
            'is_verified' => $this->request->getPost('is_verified') ? 1 : 0,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('admin/users')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        if (!$this->checkAdmin()) return redirect()->to('activities');

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $id)->get()->getRowArray();

        if (!$user) return redirect()->to('admin/users');

        return view('admin/users/edit', ['user' => $user]);
    }

    public function update($id): RedirectResponse
    {
        if (!$this->checkAdmin()) return redirect()->to('activities');

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $repPass  = $this->request->getPost('repeat_password');

        $updateData = [
            'username'    => $username,
            'email'       => $email,
            'role'        => $this->request->getPost('is_admin') ? 'admin' : 'user',
            'is_verified' => $this->request->getPost('is_verified') ? 1 : 0
        ];

        if (!empty($password)) {
            if ($password !== $repPass) {
                return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
            }
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $db = \Config\Database::connect();
        $db->table('users')->where('id', $id)->update($updateData);

        return redirect()->to('admin/users/show/' . $id)->with('success', 'Usuario actualizado exitosamente.');
    }

    public function delete($id): RedirectResponse
    {
        if (!$this->checkAdmin()) return redirect()->to('activities');

        $db = \Config\Database::connect();
        $db->table('users')->where('id', $id)->delete();

        return redirect()->to('admin/users')->with('success', 'Usuario eliminado.');
    }
}
