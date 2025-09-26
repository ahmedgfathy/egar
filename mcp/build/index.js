import { McpServer } from "@modelcontextprotocol/sdk/server/mcp.js";
import { StdioServerTransport } from "@modelcontextprotocol/sdk/server/stdio.js";
import { z } from "zod";
import fs from "fs/promises";
import path from "path";
import mysql from "mysql2/promise";
// Database configuration for VTiger/EGAR MariaDB
const dbConfig = {
    host: "localhost",
    user: "root",
    password: "zEROcALL20",
    database: "egar",
};
// Project root (VTiger EGAR project)
const PROJECT_ROOT = "/var/www/html/egar";
const server = new McpServer({
    name: "egar-private-server",
    version: "1.0.0",
    capabilities: {
        resources: {},
        tools: {},
    },
});
// Tool: List files in a directory (VTiger project)
server.tool("list_files", "List files in the VTiger EGAR project directory", {
    dir: z.string().default(".").describe("Directory path (relative to VTiger project root)")
}, async ({ dir }) => {
    const absPath = path.resolve(PROJECT_ROOT, dir);
    try {
        const files = await fs.readdir(absPath, { withFileTypes: true });
        const fileList = files.map(file => file.isDirectory() ? `${file.name}/` : file.name);
        return { content: [{ type: "text", text: fileList.join("\n") }] };
    }
    catch (err) {
        return { content: [{ type: "text", text: `Error: ${err}` }] };
    }
});
// Tool: Read file contents (VTiger project)
server.tool("read_file", "Read contents of a file in the VTiger EGAR project", {
    file: z.string().describe("File path (relative to VTiger project root)")
}, async ({ file }) => {
    const absPath = path.resolve(PROJECT_ROOT, file);
    try {
        const data = await fs.readFile(absPath, "utf-8");
        return { content: [{ type: "text", text: data }] };
    }
    catch (err) {
        return { content: [{ type: "text", text: `Error: ${err}` }] };
    }
});
// Tool: Query MariaDB (VTiger EGAR database)
server.tool("query_db", "Run a SQL query on the VTiger EGAR MariaDB database", {
    sql: z.string().describe("SQL query to execute on the 'egar' database")
}, async ({ sql }) => {
    let connection;
    try {
        connection = await mysql.createConnection(dbConfig);
        const [rows] = await connection.execute(sql);
        return { content: [{ type: "text", text: JSON.stringify(rows, null, 2) }] };
    }
    catch (err) {
        return { content: [{ type: "text", text: `Database Error: ${err}` }] };
    }
    finally {
        if (connection) {
            await connection.end();
        }
    }
});
async function main() {
    const transport = new StdioServerTransport();
    await server.connect(transport);
    console.error("EGAR VTiger MCP Server running on stdio (private access to PHP project & MariaDB)");
}
main().catch((error) => {
    console.error("Fatal error in main():", error);
    process.exit(1);
});
