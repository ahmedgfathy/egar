# Copilot Instructions for EGAR MCP Server

## Overview
This MCP server exposes tools for file and MariaDB access for the EGAR project. It is intended for private/local use only.

## Tools
- **list_files**: List files in a directory. Parameter: `directory` (string)
- **read_file**: Read the contents of a file. Parameter: `filePath` (string)
- **query_db**: Run a SQL query on the MariaDB `egar` database. Parameter: `query` (string)

## Security
- The server is private. Do not expose to the public internet.
- Database credentials are for local root access. Change for production if needed.

## Usage
1. Install dependencies: `npm install`
2. Build: `npm run build`
3. Run: `node build/index.js`

## Database
- MariaDB database: `egar`
- Backup: `egar_db_backup.sql` in project root
