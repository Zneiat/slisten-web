require('dotenv').config();
var mysql = require('mysql');

var _dbConf = {
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    database: process.env.DB_DATABASE,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD
};

var _db = dbConnect();

// 连接数据库
function dbConnect() {
    var db = mysql.createConnection(_dbConf);
    db.connect(dbHandleError);
    db.on('error', dbHandleError);
    return db;
}

function dbHandleError(err) {
    if (!err) return;
    // 如果是连接断开，自动重新连接
    if (err.code === 'PROTOCOL_CONNECTION_LOST')
        _db = dbConnect();
    else
        console.error(err.stack || err);
}

_db.query('SELECT 1 + 1 AS solution', function (error, results, fields) {
    if (error) throw error;
    console.log('The solution is: ', results[0].solution);
});