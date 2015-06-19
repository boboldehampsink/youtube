YouTube Upload plugin for Craft CMS
=================

Plugin/FieldType that uploads video assets to YouTube and is able to output their YouTube URL's in the front-end.

Important:
The plugin's folder should be named "youtube"

Usage
=================
This plugin provides an YouTube Upload FieldType that works like the Asset FieldType.  
You can upload a video, and the plugin starts a background task to upload this video to YouTube.  
Once it is done it saves the YouTube video URL to the database.  
It is then able to return a model that contains the YouTube ID and URL's for watching and embedding.

Known issues
=================
There appears to be a problem when uploading the same video more than once in a session.
It looks like it might be a YouTube bug, and I've reported it here: https://code.google.com/p/gdata-issues/issues/detail?id=7326&thanks=7326&ts=1434712883

Roadmap
=================
 - Better OAuth plugin integration and dependency management
 - Better YouTube upload progress indication

Changelog
=================
###0.1.2###
 - Don't run uploads task when there's no assets on the field

###0.1.1###
 - Fixed plugin's output not being valid when there was no file connected

###0.1.0###
 - Initial release