#!/bin/sh
echo Launching WinMergeU.exe: $1 $2
"/c/Program Files (x86)/WinMerge/WinMergeU.exe" 
git /e /u /dl "Base" /dr "Mine" "$1" "$2"
