import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  //handling cors error

  server: {
    proxy: {
      '/': {
        target: 'http://13.200.223.248',
        changeOrigin: true,
      },
    },
  },

  //cors error handling ends here
})
