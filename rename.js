const fs = require('fs');
const path = require('path');

const dirs = [
    path.join(__dirname, 'app'),
    path.join(__dirname, 'resources')
];

const patterns = [
    { search: /CV\.?\s*Karya Perdana Teknik/gi, replace: 'Cyclevent' },
    { search: /CV\.?\s*Karya Perdana/gi, replace: 'Cyclevent' },
    { search: /Karya Perdana Teknik/gi, replace: 'Cyclevent' },
    { search: /Karya Perdana/gi, replace: 'Cyclevent' },
    { search: /KPT/g, replace: 'Cyclevent' }
];

function processDir(dir) {
    if (!fs.existsSync(dir)) return;
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            processDir(fullPath);
        } else {
            let content = fs.readFileSync(fullPath, 'utf8');
            let originalContent = content;
            
            for (const p of patterns) {
                content = content.replace(p.search, p.replace);
            }
            
            if (content !== originalContent) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log('Updated: ' + fullPath);
            }
        }
    }
}

for (const dir of dirs) {
    processDir(dir);
}
console.log('Done.');
