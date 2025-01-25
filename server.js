const express = require('express');
const bodyParser = require('body-parser');
const oracledb = require('oracledb');

const app = express();
const port = 4000;

// Middleware to parse JSON request body
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Database connection config
const dbConfig = {
  user: 'ban_sys',
  password: '202114178',
  connectString: 'localhost:1521/XE' // Adjust this to your Oracle DB configuration
};

// Route to handle registration form submission
app.post('/register', async (req, res) => {
  const { no, rank, name, unit, mobile, password } = req.body;

  let connection;
  try {
    connection = await oracledb.getConnection(dbConfig);

    // SQL query to insert the form data into the user_applicants table
    const result = await connection.execute(
      `INSERT INTO user_applicants (id_no, rank, name, unit, mobile_no, password) 
      VALUES (:no, :rank, :name, :unit, :mobile, :password)`,
      [no, rank, name, unit, mobile, password],
      { autoCommit: true }
    );

    res.status(200).send('Registration successful!');
  } catch (err) {
    console.error('Error:', err);
    res.status(500).send('There was an error during registration.');
  } finally {
    if (connection) {
      await connection.close();
    }
  }
});

// Start server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
