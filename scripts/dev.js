#!/usr/bin/env node

const { execSync, spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const HEADER = `/*
Theme Name: Futuristic IT Theme
Theme URI: https://example.com
Author: Your Name
Author URI: https://example.com
Description: A modern WordPress theme for IT and healthcare solutions with a dark green and gold color scheme
Version: 2.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: futuristic-it
*/
`;

function copyToStyle() {
  const output = path.join(__dirname, '..', 'dist', 'output.css');
  const target = path.join(__dirname, '..', 'style.css');
  if (fs.existsSync(output)) {
    const css = fs.readFileSync(output, 'utf8');
    fs.writeFileSync(target, HEADER + css);
  }
}

const tailwind = spawn('npx', ['tailwindcss', '-i', './src/input.css', '-o', './dist/output.css', '--watch'], {
  cwd: path.join(__dirname, '..'),
  stdio: 'inherit'
});

const outputDir = path.join(__dirname, '..', 'dist');
const outputCss = path.join(outputDir, 'output.css');

let lastSize = 0;
const poll = setInterval(() => {
  try {
    const stat = fs.statSync(outputCss);
    if (stat.size !== lastSize) {
      lastSize = stat.size;
      copyToStyle();
    }
  } catch {}
}, 300);

tailwind.on('close', () => {
  clearInterval(poll);
  process.exit();
});

process.on('SIGINT', () => { tailwind.kill(); process.exit(); });
process.on('SIGTERM', () => { tailwind.kill(); process.exit(); });
