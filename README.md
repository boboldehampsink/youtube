DEPRECATED - YouTube Upload plugin for Craft CMS [![Build Status](https://travis-ci.org/boboldehampsink/youtube.svg?branch=develop)](https://travis-ci.org/boboldehampsink/youtube) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/boboldehampsink/youtube/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/boboldehampsink/youtube/?branch=develop) [![Code Coverage](https://scrutinizer-ci.com/g/boboldehampsink/youtube/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/boboldehampsink/youtube/?branch=develop) [![Latest Stable Version](https://poser.pugx.org/boboldehampsink/youtube/v/stable)](https://packagist.org/packages/boboldehampsink/youtube) [![Total Downloads](https://poser.pugx.org/boboldehampsink/youtube/downloads)](https://packagist.org/packages/boboldehampsink/youtube) [![Latest Unstable Version](https://poser.pugx.org/boboldehampsink/youtube/v/unstable)](https://packagist.org/packages/boboldehampsink/youtube) [![License](https://poser.pugx.org/boboldehampsink/youtube/license)](https://packagist.org/packages/boboldehampsink/youtube)
=================

Plugin/FieldType that uploads video assets to YouTube and is able to output their YouTube URL's in the front-end.

__Important__  
 - The plugin's folder should be named "youtube"  
 - This plugin requires [Dukt's OAuth](https://dukt.net/craft/oauth) plugin to be installed
 
Deprecated
=================
With the release of Craft 3 on 4-4-2018, this tool has been deprecated. You can still use this with Craft 2 but you are encouraged to use (and develop) a Craft 3 version. At this moment, I have no plans to do so.

Usage
=================
This plugin provides an YouTube Upload FieldType that works like the Asset FieldType.  
You can upload a video, and the plugin starts a background task to upload this video to YouTube.  
Once it is done it saves the YouTube video URL to the database.  
It is then able to return a model that contains the YouTube ID and URL's for watching and embedding.

Known issues
=================
There appears to be a problem when uploading the same video more than once in a session.
It looks like it might be a YouTube bug, and I've reported it here: [https://code.google.com/p/gdata-issues/issues/detail?id=7326&thanks=7326&ts=1434712883](https://code.google.com/p/gdata-issues/issues/detail?id=7326&thanks=7326&ts=1434712883)

Roadmap
=================
 - Better OAuth plugin integration and dependency management
 - Better YouTube upload progress indication

Development
=================
Run this from your Craft installation to test your changes to this plugin before submitting a Pull Request
```bash
phpunit --bootstrap craft/app/tests/bootstrap.php --configuration craft/plugins/youtube/phpunit.xml.dist --coverage-text craft/plugins/youtube/tests
```

Changelog
=================
### 0.7.2 ###
 - Added missing dutch translation
 - Updated dependencies

### 0.7.1 ###
 - Fixed rare cases of validation issues
 - Updated dependencies

### 0.7.0 ###
 - Added interface for deleting hashes, so you can re-upload video's that you deleted from YouTube.
 - Updated dependencies

### 0.6.5 ###
 - Updated dependencies and fixed unit tests

### 0.6.4 ###
 - Updated Google API client to 2.0.0

### 0.6.3 ###
 - Updated plugin to work with OAuth Plugin 1.0+
 - Fix search keywords criteria

### 0.6.2 ###
 - Removed the ability to manually set a timeout per step via the config
 - Added user who created the task to the Task Manager plugin table, if installed
 - Updated YouTube API

### 0.6.1 ###
 - Finish task when element doesn't exist anymore
 - Only save element id values

### 0.6.0 ###
 - Verify if element still exists before starting a task
 - Updated YouTube API and implementation
 - Updated OAuth plugin dependency

### 0.5.0 ###
 - Added the ability to manually set a timeout per step via the config
 - Clean up the temporary video file after conversion
 - Improved unit tests for development

### 0.4.0 ###
 - Now handles duplicate video's

### 0.3.1 ###
 - Fixed a bug where the existing content could incorrectly be null
 - Catch unknown exceptions
 - Added unit tests

### 0.3.0 ###
 - Fixed a bug where saving the element without changing the YouTube field would override the YouTube ID's with Asset ID's

### 0.2.0 ###
 - Fixed a bug that could lead to asset id's returning instead of YouTube video id's

### 0.1.9 ###
 - Fixed a bug where tasks would hang

### 0.1.8 ###
 - Fixed a bug where multiple video's on a field couldn't be saved
 - Fixed a bug where getting the right assets could go wrong

### 0.1.7 ###
 - Always handle asset processing before starting the youtube upload task

### 0.1.6 ###
 - Fixed a bug that occured when the youtube field was empty

### 0.1.5 ###
 - Fixed bug when post data is missing

### 0.1.4 ###
 - Fixed field not showing multiple values
 - Try to only process new video's

### 0.1.3 ###
 - Remove the temporary video asset to save space
 - Always produce an array for the front-end

### 0.1.2 ###
 - Don't run uploads task when there's no assets on the field

### 0.1.1 ###
 - Fixed plugin's output not being valid when there was no file connected

### 0.1.0 ###
 - Initial release
