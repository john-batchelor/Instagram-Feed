<?php
/**

Author John Batchelor
Website: www.john-batchelor.com

This class contains methods to access a public instagram feed. Including the username, biography, full name and their media (photos and videos)

**/
class IGFeed
{
    public $url; //username of the feed you wish to access.
    
    function __construct($url)
    {
        $this->jsonFeed = file_get_contents("https://www.instagram.com/" . $url . "/?__a=1");
    }
    
    function getFeed()
    {
        $jsonFeed = $this->jsonFeed;

        $igFeed = json_decode($jsonFeed, true);
    
        return $igFeed;
    }

    function getUser()
    {
        $igFeed = $this->getFeed();
        $user = $igFeed["user"];
        return $user;
    }

    function getHDProfilePicture()
    {
        $user = $this->getUser();
        return $user["profile_pic_url_hd"];
    }

    function getProfilePicture()
    {
        $user = $this->getUser();
        return $user["profile_pic_url_hd"];
    }

    function getFollowers()
    {
        $user = $this->getUser();
        return $user["followed_by"]["count"];
    }

    function getName()
    {
        $user = $this->getUser();
        return $user["full_name"];
    }

    function getFollowing()
    {
        $user = $this->getUser();
        return $user["following"];
    }

    function getBio()
    {
        $user = $this->getUser();
        return $user["biography"];
    }

    function getUsername()
    {
        $user = $this->getUser();
        return $user["username"];
    }

    function getMedia()
    {
        $user = $this->getUser();
        return $user["media"]["nodes"];
    }

    function getMediaCount()
    {
        $user = $this->getUser();
        return $user["media"]["count"];
    }

    function getMediaURL($index)
    {
        return $index["display_src"];
    }

    function getMediaCaption($index)
    {
        return $index["caption"];
    }

    function getMediaComments($index)
    {
        return $index["comments"];
    }

    function getLikes($index)
    {
        return $index["likes"]["count"];
    }

    function getVideos()
    {
        $data = $this->getMedia();
        $videos = array();
        for($i = 0; $i<count($data); $i++)
        {
             if($data[$i]["is_video"] == 1)
             {
                 array_push($videos, $data[$i]);
             }
        }
        
        return $videos;
    }

    function getPhotos()
    {
        $data = $this->getMedia();
        $photos = array();
        for($i = 0; $i<count($data); $i++)
        {
             if($data[$i]["is_video"] != 1)
             {
                 array_push($photos, $data[$i]);
             }
        }
        
        return $photos;
    }

    function getMediaDate($index)
    {
        return gmdate("d F Y", $index["date"]);
    }

    function isVideo($index)
    {
        if($index["is_video"] == "1")
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function getThumbnail($index, $thumbSize)
    {
        switch($thumbSize)
        {
            case "xs":
                $size = 0;
                break;
            case "s":
                $size = 1;
                break;
            case "m":
                $size = 2;
                break;
            case "l":
                $size = 3;
                break;
            case "xl":
                $size = 4;
                break;
                
             default:
                $size = 0;
        }
        
        return $index["thumbnail_resources"][$size]["src"];
    }

    function getMediaWidth($index)
    {
        return $index["dimensions"]["width"];
    }

    function getMediaHeight($index)
    {
        return $index["dimensions"]["height"];
    }
}

?>
