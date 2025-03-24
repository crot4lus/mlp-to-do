/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          'grey': '#f1f1f1',
          'blue': '#327AB7'
        }
      }
    },
  },
  plugins: [],
}

