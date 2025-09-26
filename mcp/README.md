# EGAR VTiger MCP Server

This is a **private** Model Context Protocol (MCP) server for the EGAR VTiger CRM project. It provides secure, localhost-only access to all VTiger project files and the MariaDB `egar` database for AI assistants.

## What This Does

The MCP server acts as a bridge between AI assistants and your VTiger CRM system, allowing AI to:
- Browse and read any file in your VTiger project (`/var/www/html/egar/`)
- Query the MariaDB database with full access
- Help with development, debugging, and maintenance tasks

## Available Tools

### 1. `list_files`
Lists files and directories in your VTiger project.
```json
{"name": "list_files", "arguments": {"dir": "modules/Users"}}
```

### 2. `read_file` 
Reads the contents of any file in your VTiger project.
```json
{"name": "read_file", "arguments": {"file": "config.inc.php"}}
```

### 3. `query_db`
Executes SQL queries on the VTiger MariaDB database.
```json
{"name": "query_db", "arguments": {"sql": "SELECT * FROM vtiger_users LIMIT 5"}}
```

## Quick Start

1. **Install dependencies:**
   ```bash
   cd /var/www/html/egar/mcp
   npm install
   ```

2. **Build the server:**
   ```bash
   npm run build
   ```

3. **Test the server:**
   ```bash
   echo '{"jsonrpc": "2.0", "id": 1, "method": "initialize", "params": {"protocolVersion": "2024-11-05", "capabilities": {"roots": {"listChanged": true}}, "clientInfo": {"name": "test", "version": "1.0.0"}}}' | node build/index.js
   ```

## Testing Examples

### List VTiger modules:
```bash
echo '{"jsonrpc": "2.0", "id": 2, "method": "tools/call", "params": {"name": "list_files", "arguments": {"dir": "modules"}}}' | node build/index.js
```

### Read VTiger configuration:
```bash
echo '{"jsonrpc": "2.0", "id": 3, "method": "tools/call", "params": {"name": "read_file", "arguments": {"file": "config.inc.php"}}}' | node build/index.js
```

### Query VTiger users:
```bash
echo '{"jsonrpc": "2.0", "id": 4, "method": "tools/call", "params": {"name": "query_db", "arguments": {"sql": "SELECT user_name, first_name, last_name FROM vtiger_users WHERE status = \"Active\""}}}' | node build/index.js
```

### Show VTiger database tables:
```bash
echo '{"jsonrpc": "2.0", "id": 5, "method": "tools/call", "params": {"name": "query_db", "arguments": {"sql": "SHOW TABLES"}}}' | node build/index.js
```

## Project Structure

```
/var/www/html/egar/           # Your VTiger CRM (PHP project)
├── modules/                  # VTiger modules
├── layouts/                  # Smarty templates  
├── config.inc.php           # VTiger config
├── index.php                # VTiger entry point
├── egar_db_backup.sql       # Database backup
└── mcp/                     # MCP Server (TypeScript)
    ├── src/index.ts         # MCP server code
    ├── build/index.js       # Compiled server
    ├── package.json         # Dependencies
    └── README.md           # This file
```

## Security & Privacy

⚠️ **IMPORTANT SECURITY NOTES:**
- This server is **localhost-only** and **private**
- Never expose this to the public internet
- Database credentials are hardcoded for local development
- All file access is restricted to the VTiger project directory
- Only use on trusted, private networks

## Integration with AI Assistants

This MCP server is designed to work with AI assistants that support the Model Context Protocol, allowing them to:
- Help debug VTiger PHP code
- Analyze database structure and data
- Assist with customizations and modules
- Generate reports from VTiger data
- Help with maintenance tasks

## Database Information

- **Database:** `egar` (MariaDB)
- **User:** `root`
- **Backup:** Available at `/var/www/html/egar/egar_db_backup.sql`
- **Tables:** 400+ VTiger tables (accounts, contacts, leads, etc.)

## Support

- [MCP Protocol Documentation](https://modelcontextprotocol.io/docs/)
- [TypeScript SDK](https://github.com/modelcontextprotocol/typescript-sdk)
- VTiger CRM Documentation
