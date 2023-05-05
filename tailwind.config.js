/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,js,php}"],
  darkMode: "class",
  theme: {
    extend: {
      screens: {
        'sm': '640px',
        // => @media (min-width: 640px) { ... }
  
        'md': '728px',
        // => @media (min-width: 768px) { ... }
  
        'lg': '1024px',
        // => @media (min-width: 1024px) { ... }
  
        'xl': '1280px',
        // => @media (min-width: 1280px) { ... }
  
        '2xl': '1536px',
        // => @media (min-width: 1536px) { ... }

        '-lg': {'max': '1023px'},
        // => @media (max-width: 1023px) { ... }
      },

      colors: {
        accentPink: '#DB0E4B',
        accentBlue: '#0FC5AF',
        accentYellow: '#E7AA0D',

        DMtext1: '#E2E2E2',
        DMtext2: '#BFBFBF',
        DMbg: '#1A1E23',

        LMtext1: '#010101',
        LMtext2: '#0B0B0B',
        LMbg: '#E2E2E2',
        'black-rgba': 'rgba(0, 0, 0, 0.54)',
      },
      aspectRatio: {
        '3/4': '3 / 4',
      },
    },
  },
  variants: {
    extend: {
      display: ['dark']
    },
  },
  plugins: [],
}