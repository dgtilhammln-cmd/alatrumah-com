const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'resources', 'views', 'admin', 'settings', 'index.blade.php');
let content = fs.readFileSync(filePath, 'utf8');

// 1. Remove from tabs array
const tabsRegex = /'snippet' => \['Snippet & Tag', 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'\],\s*'hero'/g;
content = content.replace(tabsRegex, "'hero'");

const tabsSocialRegex = /'social'\s*=> \['Top Bar & Sosmed'[^\]]+\]\,\s*'theme'\s*=> \['Warna Tema'[^\]]+\]\,\s*'legal'\s*=> \['Legalitas'[^\]]+\]\,/g;
content = content.replace(tabsSocialRegex, '');

// 2. Extract Snippet content
const snippetRegex = /\{\{-- ======== TAB: SNIPPET ======== --\}\}\s*<div id="tab-snippet" class="tab-section" style="display:none;">\s*([\s\S]*?)\s*<\/div>\s*<\/div>\s*<\/div>/;
const snippetMatch = content.match(snippetRegex);

if (snippetMatch) {
    const snippetContent = snippetMatch[1] + "\n  </div>\n"; // Get the inner block

    // Remove snippet tab entirely
    content = content.replace(snippetRegex, '');

    // 3. Move Snippet content into SEO tab
    // Find the end of the SEO tab
    const endOfSeoRegex = /    @endforeach\s*<\/div>\s*<\/div>/;
    content = content.replace(endOfSeoRegex, `    @endforeach\n\n    {{-- Custom Scripts --}}\n    ${snippetContent}\n  </div>\n</div>`);
}

// 4. Delete Social, Legal, Theme tabs
// Find from {{-- ======== TAB: TOP BAR & SOSIAL MEDIA ======== --}} to the end before the form closing tag
const tabToRemoveRegex = /\{\{-- ======== TAB: TOP BAR & SOSIAL MEDIA ======== --\}\}[\s\S]*?(?=<\/form>)/;
content = content.replace(tabToRemoveRegex, '');

// Also remove javascript for running text and social media
const jsToRemoveRegex = /let smArr = \[\];[\s\S]*?function switchTab/m;
content = content.replace(jsToRemoveRegex, 'function switchTab');

fs.writeFileSync(filePath, content, 'utf8');
console.log('Settings page refactored.');
