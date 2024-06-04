/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['*.php', './src/**/*.php', './src/**/*.html', './src/**/*.js'],
  theme: {
    extend: {
      colors: {
        'primary-color': 'var(--primary-color)',
        'secondary-color': 'var(--secondary-color)',
        'tertiary-color': 'var(--tertiary-color)',
        'positive-color': 'var(--positive-color)',
        'danger-color': 'var(--danger-color)',
        'fade-danger-color': 'var(--fade-danger-color)',
        'text-color': 'var(--text-color)',
        'bg-color': 'var(--bg-color)'
      },
      screens: {
        xxs: '200px'
      }
    },
  },
  plugins: [],
}

