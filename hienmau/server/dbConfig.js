const sql = require("mssql");

const config = {
    user: "your_username",
    password: "your_password",
    server: "your_server", // Replace with your SQL Server name
    database: "your_database",
    options: {
        encrypt: true, // For Azure
        trustServerCertificate: true, // For local development
    },
};

module.exports = config;
