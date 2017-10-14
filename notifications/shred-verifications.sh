#!/bin/bash
find verify/* -not -newermt '-9 minutes' -type f -exec shred -u "{}" +
sleep 0.1
find verify/* -not -newermt '-9 minutes' -type d -exec rmdir "{}" +
