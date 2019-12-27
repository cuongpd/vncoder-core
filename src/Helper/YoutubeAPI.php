<?php

namespace VnCoder\Helper;

class YoutubeAPI
{
    public static function searchVideo($query)
    {
        $client = self::getClient();
        $service = new \Google_Service_YouTube($client);

        $queryParams = [
            'maxResults' => 10,
            'q' => $query
        ];

        $query = $service->search->listSearch('snippet', $queryParams);

        $data = [];
        if ($query) {
            foreach ($query as $item) {
                $info = collect($item->snippet)->toArray();
                dd($info);
                die;
            }
        }

        return $data;
    }



    public static function uploadVideo($videoPath, $videoTitle, $videoDesc, $videoTags, $videoPrivacy = 'public')
    {
        $client = self::getClient();
        $youtube = new \Google_Service_YouTube($client);

        try {
            $snippet = new \Google_Service_YouTube_VideoSnippet();
            $snippet->setTitle($videoTitle);
            $snippet->setDescription($videoDesc);
            $snippet->setTags(explode(",", $videoTags));

            // https://developers.google.com/youtube/v3/docs/videoCategories/list
            $snippet->setCategoryId("22");

            // Set the video's status to "public". Valid statuses are "public",
            // "private" and "unlisted".
            $status = new \Google_Service_YouTube_VideoStatus();
            $status->privacyStatus = $videoPrivacy;

            // Associate the snippet and status objects with a new video resource.
            $video = new \Google_Service_YouTube_Video();
            $video->setSnippet($snippet);
            $video->setStatus($status);

            // Specify the size of each chunk of data, in bytes. Set a higher value for
            // reliable connection as fewer chunks lead to faster uploads. Set a lower
            // value for better recovery on less reliable connections.
            $chunkSizeBytes = 1 * 1024 * 1024;
            $fileUploadSize = filesize($videoPath);

            $uploadPercent = round($chunkSizeBytes * 100 / $fileUploadSize, 2);

            // Setting the defer flag to true tells the client to return a request which can be called
            // with ->execute(); instead of making the API call immediately.
            $client->setDefer(true);

            // Create a MediaFileUpload object for resumable uploads.
            $media = new \Google_Http_MediaFileUpload(
                $client,
                $youtube->videos->insert("status,snippet", $video),
                'video/*',
                null,
                true,
                $chunkSizeBytes
            );
            $media->setFileSize($fileUploadSize);
//            ob_start();
            // Read the media file and upload it chunk by chunk.
            $status = false;
            $dem = 1;
            $handle = fopen($videoPath, "rb");
            while (!$status && !feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                $status = $media->nextChunk($chunk);
                $d = $uploadPercent * $dem;
                echo "Upload... ".$d."%";
//                ob_flush();
//                flush();
                $dem++;
            }

            fclose($handle);

            // If you want to make other calls after the file upload, set setDefer back to false
            $client->setDefer(false);
            $videoId = $status['id'];

            return $videoId;
        } catch (\Google_Service_Exception $e) {
            $htmlBody = sprintf('<p>A service error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
        } catch (\Google_Exception $e) {
            $htmlBody = sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
        }
        return false;
    }

    protected static function getClient()
    {
        $googleAPI = new GoogleAPI();
        try {
            return $googleAPI->getClient();
        } catch (\Exception $e) {
            info($e->getMessage());
        }
        return false;
    }
}
