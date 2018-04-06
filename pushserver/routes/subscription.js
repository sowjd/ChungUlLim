var webPush = require('web-push');

// timestamp 가져와서 seoul에 저장. DB 저장시 timezone을 서울로 변경
var moment = require('moment');
var seoul = require('moment-timezone');

// /process/addSub를 처리
var addSub = function (req, res) {
    console.log('subscription 모듈 안에 있는 addSub 호출됨.');

    var subscription = req.body['subscriptionJson'];

    dupSub(req, res, function (err, result) {
        if (result == 1) {
            //중복
            console.log('중복발생. insert 취소');
            res.end();
        } else {
            //중복x
            console.log('중복없음. insert 진행');
            addDB(req, res);
        }
    });
}

var dupSub = function (req, res, callback) {
    var database = req.app.get('database');

    var dupSub = JSON.parse(req.body['subscriptionJson']);
    var endpoint = dupSub.endpoint;

    if (database.db) {
        database.db.connect(function (err) {
            /*
            var sql = "SELECT subscription FROM CustomerEvent WHERE JSON_EXTRACT(subscription, '$.endpoint') = ?";
           ajax data에 넣어서 던져줌
            */
            var sql = req.body['dupSubSql'];
            var value = [
                endpoint
            ];
            database.db.query(sql, value, function (err, result) {
                if (err) throw err;
                if (result.length > 0) {
                    callback(null, 1);
                } else {
                    callback(null, 0);
                }
            });
        });
    }
}

var addDB = function (req, res) {
    console.log('subscription 모듈 안에 있는 addDB 호출됨.');
    // 데이터베이스 객체 참조
    var database = req.app.get('database');

    if (database.db) {
        database.db.connect(function (err) {
            console.log('addDB 함수 안에서 DB 연결됨.');
            var sql = req.body['addDBSql'];
            console.log("sql: " + sql);
            var arr_values = req.body['addDBValue'].split('&');
            //var arr_values = req.body['addDBValue'];
            // console.log("arr: " + arr_values);
            var values = [arr_values];
            database.db.query(sql, [values], function (err, result) {
                if (err) throw err;
                console.log('insert 완료!');
            });

        });
    }

    res.end();
}


// /process/delSub를 처리
var delSub = function (req, res) {
    console.log('subscripton 모듈 안에 있는 delsub 호출됨.');

    //var subscription = req.body['subscriptionJson'];

    var database = req.app.get('database');
    var delsub = JSON.parse(req.body['subscriptionJson']);

    if (database.db) {
        database.db.connect(function (err) {
            console.log('delDB 함수 안에서 DB 연결됨.');
            //var sql = "DELETE FROM Customer WHERE JSON_EXTRACT(subscription, '$.endpoint') = ?";
            var value = [
                delsub.endpoint
            ];
            database.db.query(sql, value, function (err, result) {
                if (err) throw err;
                console.log('delete 완료!');
            });
        });
    }
    res.end();
}

// sendPush 처리
var sendPush = function (req, res) {
    console.log('subscription 모듈 안에 있는 sendPush 호출됨');

    var idx = req.body['idx']; //EventList idx
    console.log('푸시요청 idx: ' + JSON.stringify(idx));

    // DB에서 해당 객체 찾기
    findClient(req, res);
}

var findClient = function (req, res) {
    console.log('subscription 모듈 안에 있는 findClient 호출됨.');

    var database = req.app.get('database');

    if (database.db) {
        database.db.connect(function (err) {
            console.log('findClient 함수 안에서 DB 연결됨.');
            var sql = req.body['findClientSql'];

            database.db.query(sql, function (err, result) {
                if (err) throw err;
                console.log('해당 Obj 찾음.');
                console.log("result: " + result);
                console.log("result length: " + result.length);
                // 해당 Obj에게 푸시
                push2Client(req, result, res);
            });
        });
    }
}

var push2Client = function (req, result, res) {
    console.log('subscription 모듈 안에 있는 push2Client 호출됨.');
    console.log("rrrrrrrr " + req.body['title']);

    for (var i = 0; i < result.length; i++) {
        console.log('pushsubscription: ' + JSON.stringify(result[i].subscription));
        var pushSubscription = JSON.parse(result[i].subscription);

        var vapidPublicKey = 'BJ792AUa15-nfCKkVDRUXGWSa9LmXiDfBONwJHIOnleZr4HIcm7qzPVrhYzGF4ypQmLnu1y5udiFs3gBLFO834Y';
        var vapidPrivateKey = '3keuxCtR_UlxR6sfS3JsJR-dfHboLdy-buz4Etq3LHw';
        console.log("ccccccc"+req.body['content']);
        var payload = req.body['title'];       
        var options = {
            TTL: 60,
            vapidDetails: {
                subject: 'mailto:21500383@handong.edu',
                publicKey: vapidPublicKey,
                privateKey: vapidPrivateKey
            }
        };

        //push2Client
        webPush.sendNotification(
            pushSubscription,
            payload,
            options
        );
        console.log('Push 전송 완료!');
        res.end();
    }
}

// 수신상태 변경
var reception = function (req, res) {
    console.log('subscription 모듈 안에 있는 reception 호출됨.');
    var database = req.app.get('database');
    var confirmedSub = JSON.parse(req.body['subscriptionJson']);
    if (database.db) {
        database.db.connect(function (err) {
            var sql = "UPDATE Customer SET reception = '수신 확인' WHERE JSON_EXTRACT(subscription, '$.endpoint') = ?";
            var value = [
                confirmedSub.endpoint
            ];
            database.db.query(sql, value, function (err, result) {
                if (err) throw err;
                console.log('reception 변경 완료!');

                // 관리자를 찾아서 푸시 알림: 새로고침 요청
                findAdmin(req, res);
            });
        });
    }
    res.end();
}

var push2Admin = function (result, res) {
    console.log('subscription 모듈 안에 있는 push2Admin 호출됨.');

    console.log('pushsubscription: ' + JSON.stringify(result[0].subscription));
    var pushSubscription = JSON.parse(result[0].subscription);

    var vapidPublicKey = 'BJ792AUa15-nfCKkVDRUXGWSa9LmXiDfBONwJHIOnleZr4HIcm7qzPVrhYzGF4ypQmLnu1y5udiFs3gBLFO834Y';
    var vapidPrivateKey = '3keuxCtR_UlxR6sfS3JsJR-dfHboLdy-buz4Etq3LHw';
    var payload = 'please~~~';
    var options = {
        TTL: 60,
        vapidDetails: {
            subject: 'mailto:21500383@handong.edu',
            publicKey: vapidPublicKey,
            privateKey: vapidPrivateKey
        }
    };

    //push2Client
    webPush.sendNotification(
        pushSubscription,
        payload,
        options
    );
    console.log('Push 전송 완료!');
    res.end();
}

var findAdmin = function (req, res) {
    console.log('subscription 모듈 안에 있는 findAdmin 호출됨.');

    var database = req.app.get('database');

    if (database.db) {
        database.db.connect(function (err) {
            console.log('findAdmin 함수 안에서 DB 연결됨.');
            var sql = "SELECT * FROM Admin WHERE id=?";
            var value = [
                '관리자'
            ];
            database.db.query(sql, value, function (err, result) {
                if (err) throw err;
                console.log('해당 Obj 찾음.');

                // 해당 Obj에게 푸시
                push2Admin(result, res);
            });
        });
    }
}

module.exports.addSub = addSub;
module.exports.delSub = delSub;
module.exports.sendPush = sendPush;
module.exports.reception = reception;
