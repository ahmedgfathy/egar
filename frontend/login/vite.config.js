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
      input: {
        login: resolve(import.meta.dirname, 'src/main.jsx'),
        dashboard: resolve(import.meta.dirname, 'src/dashboard.jsx'),
        product: resolve(import.meta.dirname, 'src/product.jsx')
      },
      output: {
        entryFileNames: '[name].js',
        assetFileNames: '[name].[ext]'
      }
    }
  }
});
