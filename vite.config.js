// vite.config.js
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost:8000',
        changeOrigin: true,
        secure: false,
      },
    },
  },
  build: {
    manifest: true, 
    rollupOptions: {
      input: {
        main: 'resources/js/main.js', // Set the entry point explicitly
      },
    },
  },
});
