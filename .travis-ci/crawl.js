const HCCrawler = require('headless-chrome-crawler');
const CSVExporter = require('headless-chrome-crawler/exporter/csv');

const exporter = new CSVExporter({
    file: '.travis-ci/crawled.csv',
    fields: ['response.url', 'response.status', 'links.length']
});

(async () => {
    const crawler = await HCCrawler.launch({
        maxDepth: 4,
        jQuery: false,
        allowedDomains: ['localhost'],
        exporter
    });
    await crawler.queue({ url: 'http://localhost/' });
    await crawler.onIdle();
    console.log("Crawler Done");
    await crawler.close();
})();
