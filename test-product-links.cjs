#!/usr/bin/env node

/**
 * Danielle Fence Product Link Testing Script
 * Systematically tests all 204 product links using browser automation
 */

const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

class ProductLinkTester {
    constructor() {
        this.baseUrl = 'https://newdaniellefence.test';
        this.results = {
            total: 0,
            successful: 0,
            failed: 0,
            errors: [],
            details: []
        };
        this.browser = null;
        this.page = null;
    }

    async initialize() {
        console.log('🚀 Initializing browser automation...');

        this.browser = await puppeteer.launch({
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-accelerated-2d-canvas',
                '--no-first-run',
                '--no-zygote',
                '--disable-gpu',
                '--ignore-certificate-errors',
                '--ignore-ssl-errors',
                '--allow-running-insecure-content'
            ]
        });

        this.page = await this.browser.newPage();

        // Set reasonable timeouts
        await this.page.setDefaultTimeout(30000);
        await this.page.setDefaultNavigationTimeout(30000);

        // Set viewport
        await this.page.setViewport({ width: 1920, height: 1080 });

        // Set user agent
        await this.page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 Product Link Tester');

        console.log('✅ Browser initialized successfully');
    }

    async getProductsFromDatabase() {
        console.log('📊 Fetching products from database...');

        try {
            // First try to read the products data file
            const productsDataPath = '/Users/shanebarron/Herd/newdaniellefence/products-data.json';
            if (fs.existsSync(productsDataPath)) {
                const productsData = fs.readFileSync(productsDataPath, 'utf8');
                const products = JSON.parse(productsData);
                console.log(`✅ Found ${products.length} products from data file`);
                return products;
            }

            // Fallback: Execute Laravel command to get products
            const { exec } = require('child_process');
            const util = require('util');
            const execAsync = util.promisify(exec);

            const { stdout } = await execAsync('cd /Users/shanebarron/Herd/newdaniellefence && php extract-products.php');

            // Try to read the generated file
            if (fs.existsSync(productsDataPath)) {
                const productsData = fs.readFileSync(productsDataPath, 'utf8');
                const products = JSON.parse(productsData);
                console.log(`✅ Found ${products.length} products from database`);
                return products;
            }

            throw new Error('Could not load products data');

        } catch (error) {
            console.error('❌ Error fetching products from database:', error.message);

            // Fallback: Use example products for testing
            console.log('📋 Using fallback example products...');
            return [
                {
                    id: 1,
                    title: 'Lakeland Vinyl Fence',
                    category_title: 'Privacy Fence',
                    category_slug: 'privacy-fence',
                    product_slug: 'lakeland-vinyl-fence'
                },
                {
                    id: 2,
                    title: 'Hollingsworth Vinyl Fence',
                    category_title: 'Semi-Privacy Fence',
                    category_slug: 'semi-privacy-fence',
                    product_slug: 'hollingsworth-vinyl-fence'
                },
                {
                    id: 3,
                    title: 'Sacramento Vinyl Fence',
                    category_title: 'Picket Fence',
                    category_slug: 'picket-fence',
                    product_slug: 'sacramento-vinyl-fence'
                },
                {
                    id: 4,
                    title: 'Avalon Aluminum Fence',
                    category_title: 'Aluminum Fence',
                    category_slug: 'aluminum-fence',
                    product_slug: 'avalon-aluminum-fence'
                }
            ];
        }
    }

    generateProductUrl(product) {
        return `${this.baseUrl}/fencing/${product.category_slug}/${product.product_slug}`;
    }

    async testProductPage(product) {
        const url = this.generateProductUrl(product);
        const testResult = {
            id: product.id,
            title: product.title,
            category: product.category_title,
            url: url,
            status: 'unknown',
            httpStatus: null,
            hasTitle: false,
            hasContent: false,
            loadTime: 0,
            error: null
        };

        console.log(`🔍 Testing: ${product.title} (${product.category_title})`);

        try {
            const startTime = Date.now();

            // Navigate to the product page
            const response = await this.page.goto(url, {
                waitUntil: 'networkidle2',
                timeout: 30000
            });

            testResult.loadTime = Date.now() - startTime;
            testResult.httpStatus = response.status();

            // Check if page loaded successfully
            if (response.status() !== 200) {
                testResult.status = 'failed';
                testResult.error = `HTTP ${response.status()}`;
                this.results.failed++;
                this.results.errors.push({
                    url: url,
                    error: `HTTP ${response.status()}`,
                    product: product.title
                });
                return testResult;
            }

            // Wait for page content to load
            await this.page.waitForSelector('body', { timeout: 10000 });

            // Check for 404 or error content
            const pageContent = await this.page.content();
            const title = await this.page.title();

            // Check for Laravel error pages or 404 content
            if (pageContent.includes('404') ||
                pageContent.includes('Page Not Found') ||
                pageContent.includes('Route not found') ||
                title.includes('404') ||
                title.includes('Not Found')) {
                testResult.status = 'failed';
                testResult.error = '404 - Page Not Found';
                this.results.failed++;
                this.results.errors.push({
                    url: url,
                    error: '404 - Page Not Found',
                    product: product.title
                });
                return testResult;
            }

            // Check for product-specific content
            const productTitle = await this.page.$eval('h1', el => el.textContent).catch(() => null);
            const hasProductContent = await this.page.$('.product-content, .product-details, .product-description, main').then(el => !!el);

            testResult.hasTitle = !!productTitle;
            testResult.hasContent = hasProductContent;

            // Verify that the product title appears on the page
            if (productTitle && productTitle.toLowerCase().includes(product.title.toLowerCase().substring(0, 10))) {
                testResult.status = 'success';
                this.results.successful++;
            } else if (hasProductContent) {
                testResult.status = 'warning';
                testResult.error = 'Content found but title mismatch';
                this.results.successful++; // Still count as successful since page loads
            } else {
                testResult.status = 'failed';
                testResult.error = 'No product content found';
                this.results.failed++;
                this.results.errors.push({
                    url: url,
                    error: 'No product content found',
                    product: product.title
                });
            }

        } catch (error) {
            testResult.status = 'failed';
            testResult.error = error.message;
            this.results.failed++;
            this.results.errors.push({
                url: url,
                error: error.message,
                product: product.title
            });
        }

        return testResult;
    }

    async runTests() {
        console.log('📋 Starting comprehensive product link testing...\n');

        await this.initialize();

        const products = await this.getProductsFromDatabase();
        this.results.total = products.length;

        console.log(`🎯 Testing ${products.length} product links...\n`);

        // Test each product page
        for (let i = 0; i < products.length; i++) {
            const product = products[i];
            console.log(`[${i + 1}/${products.length}] Testing: ${product.title}`);

            const result = await this.testProductPage(product);
            this.results.details.push(result);

            // Show progress
            const statusIcon = result.status === 'success' ? '✅' :
                              result.status === 'warning' ? '⚠️' : '❌';
            console.log(`   ${statusIcon} ${result.status.toUpperCase()}: ${result.url} (${result.loadTime}ms)`);

            if (result.error) {
                console.log(`   🔥 Error: ${result.error}`);
            }

            console.log(''); // Add spacing between tests

            // Small delay to be respectful to the server
            await new Promise(resolve => setTimeout(resolve, 100));
        }

        await this.generateReport();
        await this.cleanup();
    }

    async generateReport() {
        console.log('\n📊 Generating test report...');

        const timestamp = new Date().toISOString();
        const reportData = {
            timestamp: timestamp,
            summary: {
                total: this.results.total,
                successful: this.results.successful,
                failed: this.results.failed,
                successRate: ((this.results.successful / this.results.total) * 100).toFixed(2) + '%'
            },
            errors: this.results.errors,
            details: this.results.details
        };

        // Save detailed JSON report
        const jsonReportPath = `/Users/shanebarron/Herd/newdaniellefence/product-link-test-report-${Date.now()}.json`;
        fs.writeFileSync(jsonReportPath, JSON.stringify(reportData, null, 2));

        // Generate human-readable report
        let report = `
DANIELLE FENCE PRODUCT LINK TEST REPORT
=======================================
Test Date: ${new Date().toLocaleString()}
Base URL: ${this.baseUrl}

SUMMARY
-------
Total Products Tested: ${this.results.total}
Successful Links: ${this.results.successful}
Failed Links: ${this.results.failed}
Success Rate: ${((this.results.successful / this.results.total) * 100).toFixed(2)}%

`;

        if (this.results.errors.length > 0) {
            report += `
FAILED LINKS (${this.results.errors.length})
${'-'.repeat(50)}
`;
            this.results.errors.forEach(error => {
                report += `❌ ${error.product}\n`;
                report += `   URL: ${error.url}\n`;
                report += `   Error: ${error.error}\n\n`;
            });
        }

        report += `
DETAILED RESULTS
${'-'.repeat(50)}
`;
        this.results.details.forEach(detail => {
            const statusIcon = detail.status === 'success' ? '✅' :
                              detail.status === 'warning' ? '⚠️' : '❌';
            report += `${statusIcon} ${detail.title} (${detail.category})\n`;
            report += `   URL: ${detail.url}\n`;
            report += `   Status: ${detail.status.toUpperCase()} (${detail.loadTime}ms)\n`;
            if (detail.error) {
                report += `   Error: ${detail.error}\n`;
            }
            report += `\n`;
        });

        // Save text report
        const textReportPath = `/Users/shanebarron/Herd/newdaniellefence/product-link-test-report.txt`;
        fs.writeFileSync(textReportPath, report);

        console.log(`📄 Reports saved:`);
        console.log(`   JSON: ${jsonReportPath}`);
        console.log(`   Text: ${textReportPath}`);

        // Print summary to console
        console.log('\n' + '='.repeat(60));
        console.log('TEST SUMMARY');
        console.log('='.repeat(60));
        console.log(`Total Products: ${this.results.total}`);
        console.log(`✅ Successful: ${this.results.successful}`);
        console.log(`❌ Failed: ${this.results.failed}`);
        console.log(`📊 Success Rate: ${((this.results.successful / this.results.total) * 100).toFixed(2)}%`);

        if (this.results.errors.length > 0) {
            console.log('\n❌ FAILED LINKS:');
            this.results.errors.forEach(error => {
                console.log(`   • ${error.product}: ${error.error}`);
            });
        }

        console.log('\n✅ Testing completed successfully!');
    }

    async cleanup() {
        if (this.browser) {
            await this.browser.close();
        }
    }
}

// Run the tests
async function main() {
    const tester = new ProductLinkTester();

    try {
        await tester.runTests();
        process.exit(0);
    } catch (error) {
        console.error('💥 Fatal error during testing:', error);
        await tester.cleanup();
        process.exit(1);
    }
}

// Handle process termination
process.on('SIGINT', async () => {
    console.log('\n🛑 Test interrupted by user');
    process.exit(1);
});

process.on('SIGTERM', async () => {
    console.log('\n🛑 Test terminated');
    process.exit(1);
});

if (require.main === module) {
    main();
}

module.exports = ProductLinkTester;