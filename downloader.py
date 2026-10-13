from flask import Flask, request, jsonify
from yandex_music import Client
import os
import requests
import re

app = Flask(__name__)
MEDIA_DIR = os.path.join(os.getcwd(), 'public', 'media')

def get_client(token):
    if not token: return None
    try: return Client(token).init()
    except: return None

def fetch_lrclib(title, artist_str):
    clean_title = re.sub(r'\(.*?\)|\[.*?\]', '', title).strip()
    primary_artist = artist_str.split(',')[0].split('&')[0].split(' feat')[0].strip()
    search_query = f"{clean_title} {primary_artist}"
    
    print(f"\n[LRCLIB] Ищем: '{search_query}'")
    url = "https://lrclib.net/api/search"
    try:
        r = requests.get(url, params={"q": search_query}, headers={"User-Agent": "KaraokeApp/1.0"}, timeout=10)
        if r.status_code == 200:
            data = r.json()
            if isinstance(data, list) and len(data) > 0:
                for i, track in enumerate(data):
                    if track.get('syncedLyrics'):
                        print(f"[LRCLIB] Нашли синхронизацию")
                        return track['syncedLyrics'], 'synced'
    except Exception as e:
        print(f"[LRCLIB] Ошибка: {e}")
    return None, None

@app.route('/api/search', methods=['POST'])
def search_tracks():
    data = request.get_json(silent=True)
    if not data or 'query' not in data or 'token' not in data: return jsonify([])
    client = get_client(data['token'])
    if not client: return jsonify([])
    try:
        search_result = client.search(data['query'])
        if not search_result or not search_result.tracks or not search_result.tracks.results: return jsonify([])
        tracks = []
        for t in search_result.tracks.results[:10]:
            artist_str = ", ".join([a.name for a in t.artists])
            tracks.append({"id": str(t.id), "title": t.title, "artist": artist_str, "has_lyrics": True})
        return jsonify(tracks)
    except: return jsonify([])

@app.route('/api/download', methods=['POST'])
def download_track():
    print("\n=== СТАРТ СКАЧИВАНИЯ ===")
    data = request.get_json(silent=True)
    client = get_client(data.get('token'))
    if not client: return jsonify({"success": False, "error": "Bad token"})

    try:
        track_id = data['track_id']
        track = client.tracks([track_id])[0]
        artist_str = ", ".join([a.name for a in track.artists])
        title = track.title

        mp3_name = f"{track_id}.mp3"
        os.makedirs(MEDIA_DIR, exist_ok=True)
        mp3_path = os.path.join(MEDIA_DIR, mp3_name)
        track.download(mp3_path)
        os.chmod(mp3_path, 0o666)

        lyrics_content, lrc_type = fetch_lrclib(title, artist_str)

        if not lyrics_content:
            lyrics_content = "[00:05.00] ⚠️ Сервер текстов Яндекса недоступен.\n[00:10.00] Попробуйте другую песню (желательно популярный хит)."
            lrc_type = 'synced'

        ext = "lrc" if lrc_type == "synced" else "txt"
        lrc_name = f"{track_id}.{ext}"
        lrc_path = os.path.join(MEDIA_DIR, lrc_name)

        with open(lrc_path, "w", encoding="utf-8") as f:
            f.write(lyrics_content)
        os.chmod(lrc_path, 0o666)

        return jsonify({
            "success": True,
            "title": title,
            "artist": artist_str,
            "audio_path": f"/media/{mp3_name}",
            "lyrics_path": f"/media/{lrc_name}",
            "lyrics_text": lyrics_content
        })
    except Exception as e:
        return jsonify({"success": False, "error": str(e)})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
