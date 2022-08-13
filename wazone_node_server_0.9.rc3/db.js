const mysql = require('mysql2');
require('dotenv').config();

// START DB Connection option 1
const db = mysql.createConnection({
  host: process.env.DB_HOST,
  port: process.env.DB_PORT,
  user: process.env.DB_USERNAME,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_DATABASE,
  charset: 'utf8mb4',
});

db.connect((err) => {
  if (err) throw err;
  console.log('\x1b[33m%s\x1b[0m', '[mysql.createConnection] Connected.');
});
// END DB Connection option 1

// START DB Connection option 2
// const db = mysql.createPool({
//   connectionLimit: 100,
//   host: process.env.DB_HOST,
//   port: process.env.DB_PORT,
//   user: process.env.DB_USERNAME,
//   password: process.env.DB_PASSWORD,
//   database: process.env.DB_DATABASE,
//   charset: 'utf8mb4',
// });

// db.getConnection((err) => {
//   if (err) throw err;
//   console.log('\x1b[36m%s\x1b[0m', '[mysql.createPool] Connected.');
// });
// END DB Connection option 2

module.exports = db;
