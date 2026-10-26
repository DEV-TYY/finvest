/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './**/*.js',
    './**/*.html',
  ],
  theme: {
    screens: {
      'xs': '480px',
      'sm': '576px',
      'md': '768px',
      'lg': '992px',
      'xl': '1200px',
      '2xl': '1400px',
    },
    extend: {
      colors: {
        'usw-blue': '#005ea2',
        'usw-blue-dark': '#013f71',
        'usw-blue-light': '#cfe7ff',
        'usw-gold': '#ffb71b',
        'usw-gray': '#4b4f54',
        'usw-slate': '#212529',
        'cloud': '#f1f3f5',
        'white': '#ffffff',
        'dark-green': '#013f71',
        'primary-green': '#013f71',
        'green-700': '#005ea2',
        'gold': '#ffb71b',
        'gold-dark': '#013f71',
        'gold-light': '#cfe7ff',
        'cream': '#f1f3f5',
        'cream-dark': '#dee5ec',
      },
      fontFamily: {
        'source-sans': ['"Source Sans 3"', 'sans-serif'],
      },
    },
  },
  plugins: [],
}