import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'node:path';

export default defineConfig({
  plugins: [react()],
  base: '/public/react-login/',
  build: {
    outDir: resolve(import.meta.dirname, '../../public/react-login/assets'),
    emptyOutDir: true,
    rollupOptions: {
      input: resolve(import.meta.dirname, 'src/main.jsx'),
      output: {
        entryFileNames: 'login.js',
        assetFileNames: 'login.[ext]'
      }
    }
  }
});
