# EGAR VTiger CRM - MCP Server Access Report

## 📋 Project Overview
- **Project Name**: EGAR (formerly ElHadaba-RS.COM)
- **Type**: VTiger CRM System
- **Location**: `/var/www/html/egar`
- **Database**: MariaDB `egar` database
- **MCP Server**: Private access with full project integration

## 🗂️ Project Structure Analysis

### Main Directories:
```
/var/www/html/egar/
├── .git/                     # Git repository
├── cache/                    # VTiger cache files
├── config/                   # Configuration files
├── cron/                     # Scheduled tasks
├── data/                     # Core VTiger data classes
├── include/                  # VTiger core includes
├── includes/                 # Additional includes
├── kcfinder/                 # File manager
├── languages/                # Multi-language support
├── layouts/                  # UI templates (including login footer)
├── libraries/                # Third-party libraries
├── modules/                  # VTiger modules
├── packages/                 # Extension packages
├── storage/                  # File storage
├── vtlib/                    # VTiger library
├── mcp/                      # MCP Server (our private server)
└── [Database Backups]        # egar_db_backup.sql, egar_database_backup.sql
```

### Key Configuration Files:
- `config.db.php` - Database configuration
- `config.inc.php` - Main VTiger configuration
- `config.security.php` - Security settings
- `index.php` - Main entry point

## 🛠️ MCP Server Capabilities

### 1. File System Access
✅ **Full Read Access** to all project files and folders
✅ **Directory Listing** capability
✅ **File Content Reading** for any file in the project

### 2. Database Access
✅ **MariaDB Connection** to `egar` database
✅ **SQL Query Execution** capability
✅ **Full Database Schema Access**

### 3. MCP Server Tools Available:
1. **`list_files`** - List files/folders in any project directory
2. **`read_file`** - Read content of any file in the project
3. **`query_db`** - Execute SQL queries on the MariaDB database

## 🔒 Security Configuration
- **Database**: localhost, user: root, password: zEROcALL20
- **Access Level**: Private (stdio transport)
- **Project Root**: `/var/www/html/egar`

## 📊 Database Information
- **Database Name**: egar
- **Type**: MariaDB
- **Tables**: 100+ VTiger CRM tables
- **Backup**: Available as `egar_db_backup.sql` (79MB)

## 🚀 MCP Server Status
- **Built**: ✅ TypeScript compiled successfully
- **Configured**: ✅ All tools and database connection configured
- **Ready**: ✅ Server ready for private access

## 📝 Usage Examples

### List Project Files:
```json
{
  "method": "tools/call",
  "params": {
    "name": "list_files",
    "arguments": { "dir": "." }
  }
}
```

### Read Configuration File:
```json
{
  "method": "tools/call",
  "params": {
    "name": "read_file",
    "arguments": { "file": "config.inc.php" }
  }
}
```

### Query Database:
```json
{
  "method": "tools/call",
  "params": {
    "name": "query_db",
    "arguments": { "sql": "SELECT * FROM vtiger_users LIMIT 5" }
  }
}
```

## ✨ Recent Changes Made:
1. 🔄 Footer updated from "ElHadaba-RS.COM" to "EGAR" in login page
2. 💾 Database backup created and saved to project root
3. 🔧 MCP server built and configured for private access
4. 📁 Full project access confirmed

---
**MCP Server Location**: `/var/www/html/egar/mcp/`
**Start Command**: `cd /var/www/html/egar/mcp && npm start`
**Server Type**: Private stdio transport with full project and database access