/* 관리자 모듈 */
var webPush = require('web-push');
// timestamp 가져와서 seoul에 저장. DB 저장시 timezone을 서울로 변경
var moment = require('moment');
var seoul = require('moment-timezone');

// 관리자 요청 처리
var admin = function(req, res){
    console.log('subscription 모듈 안에 있는 admin 호출됨.');
    var tag = req.body['tag'];
    
    if(tag == 'add'){
        addAdmin(req,res);
    }else if(tag == 'delete'){
        delAdmin(req,res);
    }
}

var addAdmin = function(req, res){
    console.log('subscription 모듈 안에 있는 addAdmin 호출됨.');
    
    var subscription = req.body['subscriptionJson'];
    
    dupAdmin(req, res, function(err, result){
        if(result == 1){
            //중복
            console.log('중복발생. insert 취소');
            res.end();
        }else{
            //중복x
            console.log('중복없음. insert 진행');
            addAdminDB(req, res);    
        }
    });
}

var dupAdmin = function(req, res, callback){
    var database = req.app.get('database');
    
    var dupSub = JSON.parse(req.body['subscriptionJson']);
    var endpoint = dupSub.endpoint;
    
    if(database.db){
        database.db.connect(function(err){
           var sql = "SELECT subscription FROM Admin WHERE JSON_EXTRACT(subscription, '$.endpoint') = ?" 
           var value = [
               endpoint
           ];
           database.db.query(sql, value, function(err, result){
              if(err) throw err;
               if(result.length>0){
                   callback(null, 1);
               }else{
                   callback(null, 0);
               }
           });
        });
    }
}

var addAdminDB = function(req, res){
    console.log('subscription 모듈 안에 있는 addAdminDB 호출됨.');
        // 데이터베이스 객체 참조
        var database = req.app.get('database');

        if(database.db){
            database.db.connect(function(err){
               console.log('addAdminDB 함수 안에서 DB 연결됨.');
                // 타임스탬프 가져오기
                seoul = moment(moment().format());
                var sql = "INSERT INTO Admin(id, subscription, time) VALUES ?";
                var values = [
                    [ '관리자', 
                     req.body['subscriptionJson'], 
                     seoul.tz('Asia/Seoul').format('HH:mm:ss')
                    ]
                ];
                database.db.query(sql, [values], function(err, result){
                   if(err) throw err;
                    console.log('insert 완료!');
                });
            });  
        }

        res.end();
}

var delAdmin = function(req,res){
    console.log('subscripton 모듈 안에 있는 delAdmin 호출됨.');
    
    //var subscription = req.body['subscriptionJson'];
    
    var database = req.app.get('database');
    var delsub = JSON.parse(req.body['subscriptionJson']);
    
    if(database.db){
        database.db.connect(function(err){
           console.log('delDB 함수 안에서 DB 연결됨.');
            var sql = "DELETE FROM Admin WHERE JSON_EXTRACT(subscription, '$.endpoint') = ?";
            var value =[
                delsub.endpoint
            ];
            database.db.query(sql, value, function(err, result){
               if(err) throw err;
                console.log('delete 완료!');
            });
        });
    }
    res.end();
}
/* 관리자 모듈 END*/

module.exports.admin = admin;