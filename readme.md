# php-filemirror
A slightly improved default web folder index with the capability to open files of various formats, including all common image and video types as well as 3D objects and some documents. Designed to be as lightweight and minimal for the client as possible while keeping a clean look.

> Note: I do not recommend using this in a production environment

## Config and features
- Passwords
    - Create a `.password` file in the root of a directory.
    - Applies to that directory + it's files only
- Storage path config
- Configurable caching
    - Unsupported formats are auto-converted and kept as cached versions
    - How long are the cached files kept is configurable

## Suggested Dependencies
> as stated in requirements.txt
- imagemagick (convert) - used to convert images
- ffmpeg - used for video and audio conversion
- blender - blend file support
- timidity - midi file support

## Libraries and licenses
This project utilises the following javascript libraries (the /js folder)
- EditArea - https://www.cdolivet.com/editarea/ - LGPL license
- Online3DViewer - https://github.com/kovacsv/Online3DViewer - MIT license
Some php files can also be used externally as libraries:
- paths.php - UNILICENSE
