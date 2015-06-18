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

Changelog
=================
###0.1.0###
 - Initial release