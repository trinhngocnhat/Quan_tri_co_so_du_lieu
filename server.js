const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');
const sql = require('mssql'); // Install with: npm install mssql

// Configure SQL Server connection
const dbConfig = {
    user: 'root',
    password: '', // Empty if there's no password
    server: 'TRINHNGOCNHAT', // Replace with your server name
    database: 'hienmau',
    options: {
        encrypt: false, // Disable encryption if not using SSL
        trustServerCertificate: true // Needed for local development
    }
};

// Initialize Express
const app = express();
app.use(express.static(path.join(__dirname, 'code')));
app.use(bodyParser.urlencoded({ extended: true }));

// Serve the HTML form
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'code', 'index.html'));
});

// Handle form submission and insert into the database
app.post('/submit_form', async (req, res) => {
    const { name, SDT, dob, height, weight, gender, quantity, date } = req.body;

    // Generate a unique ID for the donor (replace with actual logic if needed)
    const id_donor = `DNR${Date.now()}`;

    // Map form data to the Donor table schema
    const donorData = {
        id_donor,
        name,
        phone: SDT,
        blood_type: gender, // Assuming gender field is mapped to blood_type
        height: height || null,
        weight: weight || null,
        day_of_birth: dob,
        last_donation: date || null // Optional field
    };

    try {
        // Connect to the database
        const pool = await sql.connect(dbConfig);

        // Insert the data into the Donor table
        const query = `
            INSERT INTO Donor (id_donor, name, phone, blood_type, height, weight, day_of_birth, last_donation)
            VALUES (@id_donor, @name, @phone, @blood_type, @height, @weight, @day_of_birth, @last_donation)
        `;

        const request = pool.request();
        request.input('id_donor', sql.Char(12), donorData.id_donor);
        request.input('name', sql.VarChar(50), donorData.name);
        request.input('phone', sql.VarChar(15), donorData.phone);
        request.input('blood_type', sql.Char(2), donorData.blood_type);
        request.input('height', sql.Int, donorData.height);
        request.input('weight', sql.Int, donorData.weight);
        request.input('day_of_birth', sql.Date, donorData.day_of_birth);
        request.input('last_donation', sql.Date, donorData.last_donation);

        await request.query(query);

        res.send(`
            <h2>Form Submitted Successfully!</h2>
            <p>Thank you, ${name}, for your submission.</p>
            <a href="/">Back to form</a>
        `);
    } catch (error) {
        console.error('Database error:', error.message);
        console.error('Full error details:', error);
        res.status(500).send(`Error inserting data into the database: ${error.message}`);
    }

});

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
// app.js
const connectDB = require('./db');

// Gọi hàm kết nối và truy vấn
connectDB().then((data) => {
    console.log("Dữ liệu từ cơ sở dữ liệu:", data);
});
