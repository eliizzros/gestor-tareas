<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class AuthController extends BaseController
{
    public function setLanguage($lang = 'es'): RedirectResponse
    {
        if (in_array($lang, ['es', 'en'])) {
            session()->set('lang', $lang);
        }
        return redirect()->back();
    }

    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('home');
        }
        return view('auth/landing');
    }

    public function showLogin()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('home');
        }
        return view('auth/login');
    }

    public function showRegistration()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('home');
        }
        return view('auth/register');
    }

    public function showForgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function activities()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión para acceder.');
        }
        return view('activities');
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', session()->get('user_id'))->get()->getRowArray();
        
        session()->set('profile_image', $user['profile_image'] ?? null);

        return view('profile');
    }

    public function editProfile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }
        return view('profile/edit');
    }

    public function changePasswordView()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }
        return view('profile/change_password');
    }

    public function changeImageView()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }
        return view('profile/change_image');
    }

    public function updateImage(): RedirectResponse
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $img = $this->request->getFile('profile_image');

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            
            $uploadPath = ROOTPATH . 'public/uploads/profiles/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $img->move($uploadPath, $newName);

            $userId = session()->get('user_id');
            $db = \Config\Database::connect();
            $db->table('users')->where('id', $userId)->update([
                'profile_image' => $newName
            ]);

            session()->set('profile_image', $newName);

            return redirect()->to('profile')->with('success', '¡Imagen de perfil actualizada exitosamente!');
        }

        return redirect()->back()->with('error', 'Por favor selecciona una imagen válida.');
    }

    public function deleteImage(): RedirectResponse
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        
        $db->table('users')->where('id', $userId)->update([
            'profile_image' => null
        ]);

        session()->remove('profile_image');

        return redirect()->to('profile')->with('success', 'Imagen de perfil eliminada exitosamente.');
    }

    public function updatePassword(): RedirectResponse
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');
        $repeatPassword  = $this->request->getPost('repeat_password');
        $userId          = session()->get('user_id');

        if ($newPassword !== $repeatPassword) {
            return redirect()->back()->with('error', 'Las nuevas contraseñas no coinciden.');
        }

        $db   = \Config\Database::connect();
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        if ($user && password_verify($currentPassword, $user['password'])) {
            $db->table('users')->where('id', $userId)->update([
                'password' => password_hash($newPassword, PASSWORD_BCRYPT)
            ]);

            return redirect()->to('profile')->with('success', '¡Contraseña actualizada exitosamente!');
        }

        return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
    }

    public function verifyProfileStep(): RedirectResponse
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        session()->set('pending_profile_update', [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email')
        ]);

        return redirect()->to('profile/confirm-password');
    }

    public function confirmPasswordView()
    {
        if (!session()->get('isLoggedIn') || !session()->has('pending_profile_update')) {
            return redirect()->to('profile');
        }
        return view('profile/confirm_password');
    }

    public function updateProfile(): RedirectResponse
    {
        if (!session()->get('isLoggedIn') || !session()->has('pending_profile_update')) {
            return redirect()->to('profile');
        }

        $password = $this->request->getPost('password');
        $userId   = session()->get('user_id');

        $db   = \Config\Database::connect();
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            $pendingData = session()->get('pending_profile_update');

            $db->table('users')->where('id', $userId)->update([
                'username' => $pendingData['username'],
                'email'    => $pendingData['email']
            ]);

            session()->set([
                'username' => $pendingData['username'],
                'email'    => $pendingData['email']
            ]);

            session()->remove('pending_profile_update');

            return redirect()->to('profile')->with('success', '¡Perfil actualizado exitosamente!');
        }

        return redirect()->back()->with('error', 'Contraseña incorrecta. Inténtalo de nuevo.');
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();
        setcookie('remember_token', '', time() - 3600, "/");
        return redirect()->to('/')->with('success', 'Has cerrado sesión exitosamente.');
    }

    public function processLogin(): RedirectResponse
    {
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember_me');

        $user = $db->table('users')->where('email', $email)->get()->getRowArray();

        if ($user && password_verify($password, $user['password'])) {
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $db->table('users')->where('id', $user['id'])->update(['remember_token' => $token]);
                setcookie('remember_token', $token, time() + (86400 * 30), "/");
            }

            session()->set([
                'user_id'       => $user['id'],
                'username'      => $user['username'],
                'email'         => $user['email'],
                'role'          => $user['role'] ?? 'user',
                'profile_image' => $user['profile_image'] ?? null,
                'isLoggedIn'    => true,
                'lang'          => session()->get('lang') ?? 'es'
            ]);

            return redirect()->to('home')->with('success', '¡Inicio de sesión exitoso! Bienvenido de nuevo.');
        }

        return redirect()->back()->with('error', 'Credenciales incorrectas. Verifique su correo o contraseña.');
    }

    public function processRegistration()
    {
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $exists = $db->table('users')->where('email', $email)->countAllResults();
        if ($exists > 0) {
            return redirect()->back()->with('error', 'El correo electrónico ya está registrado.');
        }

        $token = bin2hex(random_bytes(16));

        $db->table('users')->insert([
            'username'           => $username,
            'email'              => $email,
            'role'               => 'user',
            'password'           => password_hash($password, PASSWORD_BCRYPT),
            'is_verified'        => 0,
            'verification_token' => $token,
            'created_at'         => date('Y-m-d H:i:s')
        ]);

        $emailService = \Config\Services::email();
        $emailService->clear(true);
        $emailService->setFrom('svelasquezr8@miumg.edu.gt', 'Sandra');
        $emailService->setTo($email);
        $emailService->setSubject('Verifica tu cuenta');
        
        $verifyLink = base_url("verify-email?token={$token}");
        
        $body = "
        <div style='font-family: Arial, sans-serif; background-color: #fafaf9; padding: 20px; color: #1c1917;'>
            <div style='max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e7e5e4;'>
                <h2 style='color: #d97706; margin-top: 0;'>Hola {$username}</h2>
                <p>este es el boton para validar su cuenta</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$verifyLink}' style='background-color: #d97706; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;'>Validar cuenta</a>
                </div>
                <p style='font-size: 0.85em; color: #78716c;'>Si no solicitaste este registro, puedes ignorar este correo.</p>
            </div>
        </div>";

        $emailService->setMessage($body);

        if ($emailService->send()) {
            return redirect()->to('register')->with('success', 'Registro completado. Hemos enviado un correo de verificación a ' . esc($email));
        } else {
            $db->table('users')->where('email', $email)->delete();
            return redirect()->to('register')->with('error', 'No se pudo enviar el correo de verificación. Intenta nuevamente.');
        }
    }

    public function verifyEmail(): RedirectResponse
    {
        $token = $this->request->getGet('token');
        $db = \Config\Database::connect();

        $user = $db->table('users')->where('verification_token', $token)->get()->getRowArray();

        if ($user) {
            $db->table('users')->where('id', $user['id'])->update([
                'is_verified' => 1
            ]);
            return redirect()->to('login')->with('success', '¡Cuenta verificada exitosamente! Ya puedes iniciar sesión.');
        }

        return redirect()->to('login')->with('error', 'El enlace de verificación no es válido.');
    }

    public function sendReset(): RedirectResponse
    {
        $db = \Config\Database::connect();
        $email = $this->request->getPost('email');

        $user = $db->table('users')->where('email', $email)->get()->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'El correo ingresado no pertenece a ninguna cuenta.');
        }

        $resetToken = $user['reset_token'] ?? bin2hex(random_bytes(16));
        $db->table('users')->where('id', $user['id'])->update(['reset_token' => $resetToken]);

        $emailService = \Config\Services::email();
        $emailService->clear(true);
        $emailService->setFrom('svelasquezr8@miumg.edu.gt', 'Sandra');
        $emailService->setTo($email);
        $emailService->setSubject('Restablecer tu contraseña');

        $resetLink = base_url("reset-password?token={$resetToken}");

        $body = "
        <div style='font-family: Arial, sans-serif; background-color: #fafaf9; padding: 20px; color: #1c1917;'>
            <div style='max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e7e5e4;'>
                <h2 style='color: #d97706; margin-top: 0;'>Recuperación de Contraseña</h2>
                <p>Hemos recibido una solicitud para cambiar tu contraseña. Haz clic en el botón para ingresar tu nueva clave:</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$resetLink}' style='background-color: #d97706; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold;'>Restablecer Contraseña</a>
                </div>
                <p style='font-size: 0.85em; color: #78716c;'>Si no solicitaste este cambio, puedes ignorar este mensaje de forma segura.</p>
            </div>
        </div>";

        $emailService->setMessage($body);
        $emailService->send();

        return redirect()->back()->with('success', 'Hemos enviado un enlace de recuperación a tu correo electrónico.');
    }

    public function showResetForm()
    {
        $token = $this->request->getGet('token');
        $db = \Config\Database::connect();

        $user = $db->table('users')->where('reset_token', $token)->get()->getRowArray();

        if (!$user || empty($token)) {
            return redirect()->to('login')->with('error', 'El enlace de recuperación no es válido.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    public function processResetPassword(): RedirectResponse
    {
        $token           = $this->request->getPost('token');
        $password        = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden.');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('reset_token', $token)->get()->getRowArray();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Token no válido.');
        }

        $db->table('users')->where('id', $user['id'])->update([
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);

        return redirect()->to('login')->with('success', '¡Contraseña actualizada exitosamente! Ya puedes iniciar sesión con tu nueva clave.');
    }
}
