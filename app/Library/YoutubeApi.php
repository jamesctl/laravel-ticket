<?php

namespace App\Library;

use Google_Client;
use Google_Service_YouTube;
use Carbon\CarbonInterval;

class YoutubeApi 
{
    const SNIPPET_PATH = 'snippet';
    const DETAIL_PATH = 'contentDetails';
    const DEFAULT_LIMIT = 1;

    private $client;
    private $youtube;

    public function __construct()
    {
        $ggApiKey = app()->get('ApiKeys')->googleApiKey;
        $this->client = new Google_Client();
        $this->client->setApplicationName('Teaching');
        $this->client->setDeveloperKey($ggApiKey);

        $this->youtube = new Google_Service_YouTube($this->client);
    }

    public function searchVideo($q = '', $maxResult = 10)
    {
        // set the initial page token to null
        $pageToken = null;

        for ($page = 1; $page <= 2; $page++) {
            $result = $this->youtube->search->listSearch(self::SNIPPET_PATH, [
                'q' => $q,
                'maxResults' => $maxResult
            ]);

            // set the page token if it has been provided
            if ($pageToken) {
                $result->setNextPageToken($pageToken);
            }

            $pageToken = $result->getNextPageToken();
        }

        return $result;
    }

    public function getVideo($videoId)
    {
        try {
            // Specify which parts of the video resource you want to retrieve

            // Call the YouTube API's videos.list method to retrieve the video resource.
            $videoResponse = $this->youtube->videos->listVideos([self::SNIPPET_PATH, self::DETAIL_PATH], array('id' => $videoId));
            // Extract the first video resource from the response.
            $video = $videoResponse[0];
            // Return the video resource.
            return $video;

        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
        }
    }

    public function getTitle($video)
    {
        return $video->snippet->title;
    }

    public function getThumbnail($video, $type = 'high')
    {
        return $video->snippet->thumbnails->$type->url;
    }

    public function getDuration($video, $format = '%I:%S')
    {
        $duration = $video->contentDetails->duration;
        $interval = new CarbonInterval($duration);
        return $interval->format($format);
    }

    // public function getVideoIdFullUrl($url)
    // {
    //     $result = cache()->remember($url, 600, function() use ($url) {
    //         $youtubeApi = new \App\Library\YoutubeApi;
    //         parse_str(parse_url($url)['query'], $params);
    //         return $youtubeApi->searchVideo($params['v']);
    //     });
    //     dd($result);
    // }

    public function getVideoEmbedLinkThumb($url)
    {
        parse_str(parse_url($url)['query'], $params);
        $findVideo = $this->searchVideo($params['v'], self::DEFAULT_LIMIT);
        $thumbnail = $this->getThumbnail($findVideo->items[0]);
        $video = [
            'embed_link' => "https://www.youtube.com/embed/".$params['v']."?autoplay=1",
            'thumbnail' => $thumbnail,
        ];

        return $video;
    }
}