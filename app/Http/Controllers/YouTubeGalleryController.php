<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class YouTubeGalleryController extends Controller
{
    public function index(Request $request)
    {
        $apiKey = config('services.youtube.key');
        $channelId = config('services.youtube.channel_id');
        $max = (int) config('services.youtube.max_results', 12);
        $pageToken = $request->query('pageToken');

        // 1) Resolve uploads playlist id (cache it hard)
        $uploadsPlaylistId = Cache::remember("yt_uploads_playlist:{$channelId}", now()->addDays(7), function () use ($apiKey, $channelId) {
            $res = Http::get('https://www.googleapis.com/youtube/v3/channels', [
                'part' => 'contentDetails',
                'id' => $channelId,
                'key' => $apiKey,
            ])->throw()->json();

            return data_get($res, 'items.0.contentDetails.relatedPlaylists.uploads');
        });

        abort_if(! $uploadsPlaylistId, 500, 'Could not resolve uploads playlist id.');

        // 2) Fetch playlist items (cache short because new uploads happen)
        $cacheKey = "yt_gallery:{$uploadsPlaylistId}:{$max}:".($pageToken ?: 'first');
        $data = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($apiKey, $uploadsPlaylistId, $max, $pageToken) {
            $params = [
                'part' => 'snippet,contentDetails',
                'playlistId' => $uploadsPlaylistId,
                'maxResults' => $max,
                'key' => $apiKey,
            ];
            if ($pageToken) {
                $params['pageToken'] = $pageToken;
            }

            return Http::get('https://www.googleapis.com/youtube/v3/playlistItems', $params)
                ->throw()
                ->json();
        });

        // 3) Normalize output for your frontend
        $items = collect(data_get($data, 'items', []))->map(function ($it) {
            return [
                'videoId' => data_get($it, 'contentDetails.videoId'),
                'title' => data_get($it, 'snippet.title'),
                'publishedAt' => data_get($it, 'snippet.publishedAt'),
                'thumb' => data_get($it, 'snippet.thumbnails.medium.url')
                            ?: data_get($it, 'snippet.thumbnails.default.url'),
            ];
        })->values();

        return response()->json([
            'items' => $items,
            'nextPageToken' => data_get($data, 'nextPageToken'),
        ]);
    }
}
