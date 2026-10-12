<?php
namespace App\Controllers;
use App\Models\SongModel;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('player', [
            'title' => 'Караоке-плеер',
            'song'  => (new SongModel())->orderBy('id', 'DESC')->first()
        ]);
    }

    public function add()
    {
        return view('add', ['results' => []]);
    }

    public function search()
    {
        $query = $this->request->getPost('search_query');
        $userToken = session()->get('yandex_token'); // <-- Достаем токен

        $ch = curl_init('http://python-api:5000/api/search');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'query' => $query,
                'token' => $userToken // <-- Отправляем токен в Python
            ]),
            CURLOPT_TIMEOUT => 20
        ]);

        return view('add', [
            'results' => json_decode(curl_exec($ch), true) ?? [],
            'query' => $query
        ]);
    }

    public function download()
    {
        $track_id = $this->request->getPost('track_id');
        if (!$track_id) {
            return "Ошибка: Не передан ID трека.";
        }

        $userToken = session()->get('yandex_token'); // <-- Достаем токен

        $ch = curl_init('http://python-api:5000/api/download');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'track_id' => $track_id,
                'token'    => $userToken // <-- Отправляем токен в Python
            ]),
            CURLOPT_TIMEOUT => 120
        ]);

        $response = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            return "Ошибка соединения с Python API: " . $curl_error;
        }

        $result = json_decode($response, true);

        if ($result && !empty($result['success'])) {
            try {
                $model = new \App\Models\SongModel();
                $model->insert([
                    'title'       => $result['title'] ?? 'Неизвестно',
                    'artist'      => $result['artist'] ?? 'Неизвестно',
                    'audio_path'  => $result['audio_path'] ?? '',
                    'lyrics_path' => $result['lyrics_path'] ?? '',
                    'lyrics_text' => $result['lyrics_text'] ?? ''
                ]);
            } catch (\Exception $e) {
                return "Ошибка базы данных: " . $e->getMessage();
            }
        } else {
            $apiError = $result['error'] ?? 'Неизвестная ошибка на стороне Python';
            return "Ошибка при скачивании трека с Яндекса: " . $apiError;
        }

        return redirect()->to('/');
    }

}