const fs = require('fs');
const path = require('path');
const root = process.cwd();
function walk_dir(dir){
  const results = [];
  for(const entry of fs.readdirSync(dir,{withFileTypes:true})){
    const p = path.join(dir, entry.name);
    if(entry.isDirectory()) results.push(...walk_dir(p));
    else results.push(p);
  }
  return results;
}
const allFiles = walk_dir(root).filter(f=>f.endsWith('.php')||f.endsWith('.blade.php'));
const bladeFiles = allFiles.filter(f=>f.startsWith(path.join(root,'resources','views')));
const controllers = allFiles.filter(f=>f.startsWith(path.join(root,'app','Http','Controllers')) && f.endsWith('.php'));
const contents = new Map();
for(const file of allFiles){
  try { contents.set(file, fs.readFileSync(file,'utf8')); } catch(e){ contents.set(file, ''); }
}
const patterns = [
  /view\(['\"]([^'\"]+)['\"]/g,
  /@include\(['\"]([^'\"]+)['\"]/g,
  /@extends\(['\"]([^'\"]+)['\"]/g,
  /@component\(['\"]([^'\"]+)['\"]/g,
  /return view\(['\"]([^'\"]+)['\"]/g,
  /Route::.*->name\(['\"]([^'\"]+)['\"]\)/g,
];
const refs = new Set();
for(const [file, text] of contents){
  for(const pat of patterns){
    let m;
    while((m = pat.exec(text)) !== null){ refs.add(m[1]); }
  }
}
const viewToName = f => path.relative(path.join(root,'resources','views'), f).replace(/\\/g,'/').replace(/\.blade\.php$/,'').replace(/\//g,'.');
const unused = [];
for(const f of bladeFiles){
  const name = viewToName(f);
  if(!refs.has(name)) unused.push({file: path.relative(root,f), view:name});
}
console.log('refs='+refs.size, 'blade='+bladeFiles.length);
console.log('UNUSED VIEWS:');
unused.sort((a,b)=>a.file.localeCompare(b.file)).forEach(u=>console.log(`${u.file} => ${u.view}`));
console.log('---');
console.log('UNUSED BLADE FILES (potential):', unused.length);
console.log('---');
const routeText = contents.get(path.join(root,'routes','web.php'))||'';
const routeMatches = [...routeText.matchAll(/\[\\App\\Http\\Controllers\\([^:\]]+)::class/g)].map(m=>m[1]);
const routeClasses = [...new Set(routeMatches)].sort();
console.log('ROUTE CONTROLLERS:', routeClasses.join(', '));
console.log('---');
const controllerFiles = controllers.map(c=>path.basename(c,'.php')).sort();
console.log('CONTROLLER FILES:', controllerFiles.join(', '));
console.log('---');
console.log('CONTROLLERS NOT IN ROUTES:');
controllerFiles.filter(n=>!routeClasses.includes(n)).forEach(n=>console.log(n));
