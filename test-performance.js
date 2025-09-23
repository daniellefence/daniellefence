#!/usr/bin/env node

import lighthouse from 'lighthouse';
import * as chromeLauncher from 'chrome-launcher';

async function runLighthouse() {
  const chrome = await chromeLauncher.launch({chromeFlags: ['--headless']});
  const options = {
    logLevel: 'info',
    output: 'json',
    onlyCategories: ['performance'],
    port: chrome.port,
    formFactor: 'mobile',
    throttling: {
      rttMs: 150,
      throughputKbps: 1638.4,
      cpuSlowdownMultiplier: 4,
    },
  };

  try {
    const runnerResult = await lighthouse('https://newdaniellefence.test', options);
    const score = runnerResult.lhr.categories.performance.score * 100;

    console.log('\n🚀 Performance Score:', Math.round(score) + '%');
    console.log('\n📊 Core Web Vitals:');

    const audits = runnerResult.lhr.audits;
    console.log('LCP:', audits['largest-contentful-paint'].displayValue);
    console.log('FID:', audits['max-potential-fid'].displayValue);
    console.log('CLS:', audits['cumulative-layout-shift'].displayValue);

    console.log('\n⚡ Performance Metrics:');
    console.log('First Contentful Paint:', audits['first-contentful-paint'].displayValue);
    console.log('Speed Index:', audits['speed-index'].displayValue);
    console.log('Total Blocking Time:', audits['total-blocking-time'].displayValue);

  } catch (error) {
    console.error('Error running Lighthouse:', error);
  } finally {
    await chrome.kill();
  }
}

runLighthouse();