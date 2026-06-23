const { chromium } = require('playwright');
const path = require('path');

const BASE = 'http://127.0.0.1:8005';
const SS = 'C:\\Project\\latihan\\lsp_ukm\\test1\\screenshots';

const ADM = { email: 'wadir3@poliban.ac.id', password: 'admin123' };

async function shot(page, name) {
  await page.waitForLoadState('networkidle');
  await page.waitForTimeout(500);
  await page.screenshot({ path: path.join(SS, `${name}.png`), fullPage: true });
  console.log(`✔ ${name}.png`);
}

(async () => {
  const browser = await chromium.launch({ headless: true });
  const ctx = await browser.newContext({ viewport: { width: 1366, height: 768 } });
  const p = await ctx.newPage();

  // 1. Login page
  await p.goto(`${BASE}/login`);
  await shot(p, 'tampilan1_login');

  // 2. Login form filled
  await p.fill('input[name="email"]', ADM.email);
  await p.fill('input[name="password"]', ADM.password);
  await shot(p, 'tampilan2_form_login');

  // 3. Submit → Dashboard
  await p.click('button[type="submit"]');
  await p.waitForURL('**/dashboard');
  await shot(p, 'tampilan3_dashboard');

  // 4. Mahasiswa index
  await p.goto(`${BASE}/mahasiswa`);
  await shot(p, 'tampilan4_mahasiswa');

  // 5. Tambah Mahasiswa
  await p.goto(`${BASE}/mahasiswa/create`);
  await shot(p, 'tampilan5_tambah_mahasiswa');

  // 6. UKM index
  await p.goto(`${BASE}/ukm`);
  await shot(p, 'tampilan6_ukm');

  // 7. UKM create (dialog — click trigger)
  const addUkmTrigger = p.locator('button').filter({ hasText: 'Tambah UKM' }).first();
  if (await addUkmTrigger.isVisible()) {
    await addUkmTrigger.click();
    await p.waitForTimeout(400);
    await shot(p, 'tampilan7_tambah_ukm');
    await p.keyboard.press('Escape');
    await p.waitForTimeout(300);
  } else {
    // fallback: just take current page
    await shot(p, 'tampilan7_tambah_ukm');
  }

  // 8. Pendaftaran
  await p.goto(`${BASE}/pendaftaran`);
  await shot(p, 'tampilan8_pendaftaran');

  // 9. Anggota UKM
  await p.goto(`${BASE}/admin/anggota`);
  await shot(p, 'tampilan9_anggota_ukm');

  // 10. Tambah Anggota form
  await p.goto(`${BASE}/admin/anggota/create`);
  await shot(p, 'tampilan10_tambah_anggota');

  // 11. Search UKM
  await p.goto(`${BASE}/ukm`);
  await p.fill('input[name="keyword"]', 'Wasi');
  await p.click('button[type="submit"]');
  await shot(p, 'tampilan11_pencarian');

  // 12. Cetak UKM
  await p.goto(`${BASE}/ukm/cetak`);
  await shot(p, 'tampilan12_cetak');

  // 13. Kegiatan
  await p.goto(`${BASE}/kegiatan`);
  await shot(p, 'tampilan13_kegiatan');

  // 14. Dashboard with Profile dialog open
  await p.goto(`${BASE}/dashboard`);
  // Click profile area (sidebar footer avatar)
  const profileTrigger = p.locator('[href="#"]').filter({ has: p.locator('text=Raditya') }).first();
  if (await profileTrigger.isVisible()) {
    await profileTrigger.click();
    await p.waitForTimeout(400);
  }
  await shot(p, 'tampilan14_profile');

  await browser.close();
  console.log('\n✅ Done — 14 screenshots captured');
})();
