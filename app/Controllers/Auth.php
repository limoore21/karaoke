<?php
namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('login');
    }

    public function process()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $token = $this->request->getPost('token');

        if (!empty($username) && !empty($token)) {
            $session->set([
                'username'     => trim($username),
                'yandex_token' => trim($token),
                'isLoggedIn'   => true
            ]);
            return redirect()->to('/');
        }

        return redirect()->back();
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}