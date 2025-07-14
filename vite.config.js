import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
darkMode: 'class',
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        // 🎨 Your custom colors
        primary: '#ff0',     // orange
        secondary: '#374151',   // dark gray
        accent: '#4ADE80',      // green
        background: '#F9FAFB',  // light background
        surface: '#FFFFFF',
        muted: '#9CA3AF',
        'text-main': '#1F2937',
        'text-light': '#6B7280',
      },

      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [forms],
};
