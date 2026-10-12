<?php
namespace App\Models;
use CodeIgniter\Model;

class SongModel extends Model
{
    protected $table = 'songs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'artist', 'audio_path', 'lyrics_path', 'lyrics_text'];
}