import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],

  // Server configuration
  server: {
    // Set a custom port
    port: 8080,  // Change this to any port you want (e.g., 4000, 5000, etc.)

    // Handling CORS and proxy configuration
    // proxy: {
    //   '/api': {
    //     target: 'http://13.200.223.248',
    //     changeOrigin: true,
    //     rewrite: (path) => path.replace(/^\/api/, ''),
    //   },
    // },
    server: {
      proxy: {
        '/': {
          target: 'http://13.200.223.248',
          changeOrigin: true,
        },
      },
    },
    

    // Enable CORS handling if needed
    cors: {
      origin: '*', // Allows all origins, change it as needed
      methods: ['GET', 'POST', 'PUT', 'DELETE'],  // Specify allowed methods
    },
  },

  // CORS error handling ends here
})

