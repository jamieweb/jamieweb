#!/bin/bash
node .travis-ci/crawl.js
printf "\nCrawled Pages:\n$(cat .travis-ci/crawled.csv)\n\n"
if [ -s .travis-ci/csp-reports.txt ]; then printf "Content Security Policy Reports:\n$(cat .travis-ci/csp-reports.txt)"; else printf "No Reports Generated! Success!"; fi
