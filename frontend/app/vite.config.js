import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import { resolve } from 'node:path';

const legacySourceRoot = resolve(import.meta.dirname, '../login/src');

export default defineConfig({
  plugins: [react()],

  // Keep the deployed public path stable during the folder migration. Vtiger
  // templates already reference this URL, so changing it would create an
  // unnecessary runtime migration and cache risk.
  base: '/public/react-login/',

  build: {
    outDir: resolve(import.meta.dirname, '../../public/react-login/assets'),
    emptyOutDir: true,
    rollupOptions: {
      input: {
        login: resolve(legacySourceRoot, 'main.jsx'),
        dashboard: resolve(legacySourceRoot, 'dashboard.jsx'),
        product: resolve(legacySourceRoot, 'product.jsx'),
        'product-detail': resolve(legacySourceRoot, 'product-detail.jsx')
      },
      output: {
        entryFileNames: '[name].js',
        assetFileNames: '[name].[ext]'
      }
    }
  }
});
