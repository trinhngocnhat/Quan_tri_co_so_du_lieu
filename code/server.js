const express = require('express');
const sql = require('mssql');
const cors = require('cors');

const app = express();
const PORT = 3000;

// Allow CORS for frontend to fetch data
app.use(cors());

// SQL Server connection configuration
const dbConfig = {
    user: 'TRINHNGOCNHAT',
    password: '',
    server: '16.0.1135.2', // e.g., 'localhost'
    database: 'hienmau',
    options: {
        encrypt: true, // Use encryption
        trustServerCertificate: true, // For local development
    },
};

// API endpoint to fetch min and max values
app.get('/get-limits', async (req, res) => {
    try {
        // Connect to SQL Server
        const pool = await sql.connect(dbConfig);

        // Query the database
        const result = await pool.request().query(
            `SELECT MIN(value_column) AS min, MAX(value_column) AS max 
             FROM your_table`
        );

        // Send the response
        res.json(result.recordset[0]);
    } catch (err) {
        console.error('Error fetching limits:', err);
        res.status(500).send('Internal Server Error');
    }
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
