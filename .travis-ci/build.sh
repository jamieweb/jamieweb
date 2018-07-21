#!/bin/bash
node .travis-ci/crawl.js
printf "\nCrawled Pages:\n$(cat .travis-ci/crawled.csv)\n\nContent Security Policy Reports:\n$(cat .travis-ci/csp-reports.txt)"
