#!/usr/bin/env node

// Simple test script to verify MCP server functionality
const { spawn } = require('child_process');
const path = require('path');

console.log('Testing EGAR VTiger MCP Server...\n');

// Test 1: List files in project root
console.log('=== Test 1: Listing project files ===');
const mcpProcess = spawn('node', ['build/index.js'], {
  cwd: '/var/www/html/egar/mcp',
  stdio: ['pipe', 'pipe', 'pipe']
});

const testCall1 = {
  jsonrpc: "2.0",
  id: 1,
  method: "tools/call",
  params: {
    name: "list_files",
    arguments: {
      dir: "."
    }
  }
};

const testCall2 = {
  jsonrpc: "2.0",
  id: 2,
  method: "tools/call",
  params: {
    name: "query_db",
    arguments: {
      sql: "SELECT COUNT(*) as table_count FROM information_schema.tables WHERE table_schema = 'egar'"
    }
  }
};

mcpProcess.stdin.write(JSON.stringify(testCall1) + '\n');

setTimeout(() => {
  mcpProcess.stdin.write(JSON.stringify(testCall2) + '\n');
}, 1000);

mcpProcess.stdout.on('data', (data) => {
  console.log('MCP Response:', data.toString());
});

mcpProcess.stderr.on('data', (data) => {
  console.log('MCP Status:', data.toString());
});

setTimeout(() => {
  mcpProcess.kill();
  console.log('\nMCP Server test completed!');
}, 3000);