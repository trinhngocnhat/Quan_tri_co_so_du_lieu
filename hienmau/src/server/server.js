const express = require("express");
const bodyParser = require("body-parser");
const cors = require("cors");
const sql = require("mssql");
const config = require("./dbConfig");

const app = express();
app.use(bodyParser.json());
app.use(cors());

sql.connect(config).then((pool) => {
    console.log("Connected to SQL Server");

    // Register Endpoint
    app.post("/register", async (req, res) => {
        try {
            const { name, age, weight, height, email, password, gender } = req.body;
            await pool
                .request()
                .query(
                    `INSERT INTO Users (Name, Age, Weight, Height, Email, Password, Gender)
          VALUES ('${name}', '${age}', '${weight}', '${height}', '${email}', '${password}', '${gender}')`
                );
            res.json({ message: "User registered successfully" });
        } catch (err) {
            console.error("Error registering user:", err);
            res.status(500).json({ message: "Registration failed" });
        }
    });

    // Login Endpoint
    app.post("/login", async (req, res) => {
        try {
            const { email, password } = req.body;
            const result = await pool
                .request()
                .query(
                    `SELECT * FROM Users WHERE Email='${email}' AND Password='${password}'`
                );
            if (result.recordset.length > 0) {
                res.json({ message: "Login successful" });
            } else {
                res.status(401).json({ message: "Invalid credentials" });
            }
        } catch (err) {
            console.error("Error logging in:", err);
            res.status(500).json({ message: "Login failed" });
        }
    });
});

app.listen(5000, () => {
    console.log("Server running on http://localhost:5000");
});
