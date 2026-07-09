const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'resources', 'views', 'admin', 'settings', 'index.blade.php');
let content = fs.readFileSync(filePath, 'utf8');

// Colors
content = content.replace(/background:#161618;/g, 'background:#FFFFFF;');
content = content.replace(/border:1px solid rgba\(255,255,255,\.07\);/g, 'border:1px solid #E2E8F0;box-shadow:0 4px 15px rgba(0,0,0,0.03);');
content = content.replace(/color:#fff;/g, 'color:#0F172A;');
content = content.replace(/color:rgba\(255,255,255,\.6\);/g, 'color:#475569;');
content = content.replace(/color:rgba\(255,255,255,\.4\);/g, 'color:#64748B;');
content = content.replace(/color:rgba\(255,255,255,\.35\);/g, 'color:#64748B;');
content = content.replace(/color:rgba\(255,255,255,\.3\);/g, 'color:#94A3B8;');
content = content.replace(/color:rgba\(255,255,255,\.25\);/g, 'color:#94A3B8;');
content = content.replace(/color:rgba\(255,255,255,\.2\);/g, 'color:#CBD5E1;');

// Yellow to Premium Blue
content = content.replace(/var\(--yellow\)/g, '#0EA5E9');
content = content.replace(/stroke="var\(--yellow\)"/g, 'stroke="#0EA5E9"');
content = content.replace(/background:var\(--yellow\)/g, 'background:#0EA5E9');
// Yellow button text was black, now white
content = content.replace(/color:#000;/g, 'color:#ffffff;');

// Box backgrounds
content = content.replace(/background:rgba\(255,255,255,\.03\);/g, 'background:#F8FAFC;');
content = content.replace(/background:rgba\(255,255,255,\.02\);/g, 'background:#F1F5F9;');
content = content.replace(/background:rgba\(255,255,255,\.05\);/g, 'background:#F1F5F9;');
content = content.replace(/border:1px solid rgba\(255,255,255,\.06\);/g, 'border:1px solid #E2E8F0;');
content = content.replace(/border:1px solid rgba\(255,255,255,\.05\);/g, 'border:1px solid #E2E8F0;');
content = content.replace(/border:1px solid rgba\(255,255,255,\.07\);/g, 'border:1px solid #E2E8F0;');
content = content.replace(/border:1px solid rgba\(255,255,255,\.15\);/g, 'border:1px solid #CBD5E1;');

// Specific elements
// Page Header "Preview Website" button
content = content.replace(/border:1px solid rgba\(255,255,255,\.15\);color:rgba\(255,255,255,\.6\);/g, 'border:1px solid #E2E8F0;color:#475569;background:#FFFFFF;');
content = content.replace(/this\.style\.borderColor='rgba\\(255,255,255,\\.4\\)';this\.style\.color='#fff'/g, "this.style.borderColor='#0EA5E9';this.style.color='#0EA5E9'");
content = content.replace(/this\.style\.borderColor='rgba\\(255,255,255,\\.15\\)';this\.style\.color='rgba\\(255,255,255,\\.6\\)'/g, "this.style.borderColor='#E2E8F0';this.style.color='#475569'");

// "Simpan Semua" button hover
content = content.replace(/this\.style\.background='#E6C200'/g, "this.style.background='#0284C7'");
content = content.replace(/this\.style\.background='var\(--yellow\)'/g, "this.style.background='#0EA5E9'");

// Tab Buttons
content = content.replace(/border-bottom:1px solid rgba\(255,255,255,\.07\);/g, 'border-bottom:1px solid #E2E8F0; padding-bottom: 0.5rem;');
content = content.replace(/border-bottom:2px solid transparent;/g, 'border-radius:99px;');
content = content.replace(/margin-bottom:-1px;/g, 'margin-bottom:0;');
content = content.replace(/\.tab-btn-active \{ border-bottom-color:var\(--yellow\) !important; color:var\(--yellow\) !important; \}/g, '.tab-btn-active { background:#E0F2FE !important; color:#0284C7 !important; }');

// Specific SVG icons
content = content.replace(/stroke="rgba\(255,255,255,\.2\)"/g, 'stroke="#94A3B8"');

// Some inputs and selects need better contrast
content = content.replace(/background:#111;color:#fff;/g, 'background:#ffffff;color:#0F172A;');

// Write back
fs.writeFileSync(filePath, content, 'utf8');
console.log('Styles updated.');
