# CMSMS-Plugins
This is plugin repository for CMS Made Simple.

## Available Plugins
### Boxifier
Boxifier is a Shadowbox Plugin for uploaded Images. 
Boxifier builds a thumbnail listing out of an image folder and provides integration with Shadowbox.

Usage:

`{boxifier picFolder="uploads/images/yourFolder"}`

Options:

* `gTitle`: sets the Title of the Gallery [default=Gallery] 
* `ulClass`: sets the html class for the UL element [Default=picturelist]
* `picFolder`: sets the path to the image folder
* `sortBy`: use sortby="name" to sort alphabetically or "date" to sort by last modified date [Default=name]
* `sortByOrder`: use **asc** to sort ascending
                 or **desc** to sort descending. (only makes sense in combination with the parameter **sortBy**) [Default=asc]

### Video

Plugin to include videos uploaded to the most popular video sharing portals.
Suported services: youtube.com, video.google.com, 5min.com, dailymotion.com, vimeo.com.

Usage:

`{video url="<Url-of-Detail-Page"}`

Options:

* `height`: sets the height of the video
* `width`: sets the width of the video
