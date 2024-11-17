const express = require('express');
const bodyParser = require('body-parser');
const path = require('path');

const app = express();
app.use(express.static(path.join(__dirname, 'code')));
app.use(bodyParser.urlencoded({ extended: true }));
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'code', 'index.html'));
});

app.post('/submit_form', (req, res) => {
    const { name, SDT, dob, height, weight, gender, quantity, date } = req.body;

    res.send(`
        <h2>Data của form (Dành cho log data)</h2>
        <ul>
            <li>Name: ${name}</li>
            <li>SDT: ${SDT}</li>
            <li>Date of Birth: ${dob}</li>
            <li>Height: ${height} cm</li>
            <li>Weight: ${weight} kg</li>
            <li>Gender: ${gender}</li>
            <li>Quantity: ${quantity}</li>
            <li>Date: ${date}</li>
        </ul>
    `);
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});