const { chromium } = require('playwright');
const fs = require('fs');
const path = require('path');

const SCREENSHOT_DIR = path.join(__dirname, 'screenshots');
const BASE_URL = 'http://localhost:8000';

async function takeScreenshot(page, name) {
    if (!fs.existsSync(SCREENSHOT_DIR)) {
        fs.mkdirSync(SCREENSHOT_DIR, { recursive: true });
    }
    const screenshotPath = path.join(SCREENSHOT_DIR, `${name}.png`);
    await page.screenshot({ path: screenshotPath, fullPage: true });
    console.log(`Screenshot saved: ${name}.png`);
    return screenshotPath;
}

(async () => {
    const browser = await chromium.launch({ headless: true });
    const context = await browser.newContext({ viewport: { width: 1366, height: 768 } });
    const page = await context.newPage();

    const screenshots = [];

    try {
        console.log('\n=== MEMULAI SCREENSHOT OTOMATIS ===\n');

        // Tampilan 1: Halaman Login
        console.log('1. Halaman login...');
        await page.goto(`${BASE_URL}/login`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan1_login');

        // Tampilan 2: Form Login diisi
        console.log('2. Form login...');
        await page.fill('input[name="username"]', 'admin');
        await page.fill('input[name="password"]', 'admin123');
        await takeScreenshot(page, 'tampilan2_form_login');

        // Tampilan 3: Dashboard
        console.log('3. Dashboard...');
        await page.click('button[type="submit"]');
        await page.waitForURL('**/dashboard', { timeout: 10000 }).catch(async () => {
            await page.goto(`${BASE_URL}/dashboard`);
        });
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan3_dashboard');

        // Tampilan 4: Menu Mahasiswa
        console.log('4. Menu Mahasiswa...');
        await page.goto(`${BASE_URL}/mahasiswa`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan4_mahasiswa');

        // Tampilan 5: Tambah Mahasiswa
        console.log('5. Tambah Mahasiswa...');
        await page.goto(`${BASE_URL}/mahasiswa/create`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan5_tambah_mahasiswa');

        // Tampilan 6: Menu UKM
        console.log('6. Menu UKM...');
        await page.goto(`${BASE_URL}/ukm`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan6_ukm');

        // Tampilan 7: Tambah UKM
        console.log('7. Tambah UKM...');
        await page.goto(`${BASE_URL}/ukm/create`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan7_tambah_ukm');

        // Tampilan 8: Menu Pendaftaran
        console.log('8. Menu Pendaftaran...');
        await page.goto(`${BASE_URL}/pendaftaran`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan8_pendaftaran');

        // Tampilan 9: Anggota UKM
        console.log('9. Menu Anggota UKM...');
        await page.goto(`${BASE_URL}/admin/anggota`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan9_anggota_ukm');

        // Tampilan 10: Tambah Anggota
        console.log('10. Tambah Anggota...');
        await page.goto(`${BASE_URL}/admin/anggota/create`);
        await page.waitForTimeout(2000);
        await takeScreenshot(page, 'tampilan10_tambah_anggota');

        // Tampilan 11: Pencarian
        console.log('11. Pencarian...');
        await page.goto(`${BASE_URL}/mahasiswa`);
        await page.waitForTimeout(1000);
        const searchInput = await page.$('input[name="keyword"]');
        if (searchInput) {
            await searchInput.fill('admin');
        }
        await takeScreenshot(page, 'tampilan11_pencarian');

        // Tampilan 12: Cetak
        console.log('12. Halaman cetak...');
        const page2 = await context.newPage();
        await page2.goto(`${BASE_URL}/mahasiswa/cetak`);
        await page2.waitForTimeout(2000);
        await page2.screenshot({ path: path.join(SCREENSHOT_DIR, 'tampilan12_cetak.png'), fullPage: true });
        await page2.close();

        console.log('\n=== SCREENSHOT SELESAI ===\n');
        console.log(`Total screenshot: 12 file`);
        console.log(`Lokasi: ${SCREENSHOT_DIR}`);

    } catch (error) {
        console.error('Error:', error.message);
    } finally {
        await browser.close();
    }
})();
