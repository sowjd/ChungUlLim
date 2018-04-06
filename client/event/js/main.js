// SW 객체
var swRegistration = null;

// VAPID 공개키
var vapidPublicKey = 'BJ792AUa15-nfCKkVDRUXGWSa9LmXiDfBONwJHIOnleZr4HIcm7qzPVrhYzGF4ypQmLnu1y5udiFs3gBLFO834Y';
var applicationServerKey = urlB64ToUint8Array(vapidPublicKey);

var pushbtn = document.querySelector('#push-btn'); // 진동벨 버튼
var nopushbtn = document.querySelector('#no-push-btn');
var isSubscribed = false; // 구독 상황 체크

if (!('Notification' in window)) {
    console.log('This browser does not support notifications!');
}

// 서비스워커 등록
if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('/client/event/sw-client.js')
        .then(function (swReg) {
            console.log('Service Worker is registered', swReg);

            swRegistration = swReg;

            initUI();
        })
        .catch(function (error) {
            console.error('Service Worker Error', error);
        });
} else {
    console.warn('Push messaging is not supported');
    pushbtn.textContent = '푸시지원 불가';
}

function initUI() {
    console.log('initUI함수 실행');

    // 알림 권한 얻기
    Notification.requestPermission(function (status) {
        console.log('Notification permission status:', status);
        if (status == 'denied') {
            pushbtn.checked = false;
        }
    });

    pushbtn.addEventListener('click', function () {
        console.log('구독신청하기');
        subscribeUser();
    });

    nopushbtn.addEventListener('click', function () {
        console.log('구독취소하기');
        unsubscribeUser();
    });

}

function subscribeUser() {
    swRegistration.pushManager.subscribe({
        userVisibleOnly: true,
        applicationServerKey: applicationServerKey
    })
        .then(function (subscription) {
            console.log('User is subscribed:', subscription);
            isSubscribed = true;
            updateBtn();

            //server로 subscription 추가요청 전송
            var subscriptionJson = JSON.stringify(subscription);
            console.log('Subscription 추가 요청 전송 시도. Json:' + subscriptionJson);
            var dateTime = getDatetime();
            //console.log("===" + dateTime);

            $.ajax({
                type: 'POST',
                url: 'https://chunggak.kr:3000/process/addSub',
                async: true,
                contentType: 'application/json',
                data: JSON.stringify({
                    "subscriptionJson": subscriptionJson,
                    "tag": "event",
                    "dupSubSql": "SELECT subscription FROM CustomerEvent WHERE JSON_EXTRACT(subscription, '$.endpoint') = ?",
                    "addDBSql": "INSERT INTO CustomerEvent(subscription, subscriptionDatetime, reception) VALUES ?",
                    "addDBValue": JSON.stringify(subscription) + "&" + dateTime + "&수신대기"
                }),
                dataType: 'json',
                processData: true,
                success: function (msg) {
                    alert(msg);
                    console.log('Subscription 전송!');
                }
            });
        })
        .catch(function (err) {
            if (Notification.permission === 'denied') {
                console.warn('Permission for notifications was denied');
            } else {
                console.error('Failed to subscribe the user: ', err);
            }
            updateBtn();
        });
}

var delSub = {};

function unsubscribeUser() {
    swRegistration.pushManager.getSubscription()
        .then(function (subscription) {
            if (subscription) {
                delSub = subscription;
                return subscription.unsubscribe();
            }
        })
        .catch(function (error) {
            console.log('Error unsubscribing', error);
        })
        .then(function () {
            console.log('User is unsubscribed');
            isSubscribed = false;
            updateBtn();

            //server로 subscription 삭제 요청 전송
            console.log('Subscription 삭제 요청 전송 시도... Json:' + JSON.stringify(delSub));
            $.ajax({
                type: 'POST',
                url: 'https://chunggak.kr:3000/process/delSub',
                contentType: 'application/json',
                async: true,
                data: JSON.stringify({
                    "delSubSql" : "DELETE FROM CustomerEvent  WHERE JSON_EXTRACT(subscription, '$.endpoint') = ?",
                    "subscriptionJson": JSON.stringify(delSub)
                }),
                dataType: 'json',
                processData: true,
                success: function (msg) {
                    alert(msg);
                    console.log('Subscription 전송!');
                }
            });
        });
}

function updateBtn() {
    console.log('updateBtn() 실행됨.');
    if (Notification.permission === 'denied') {
        pushbtn.textContent = 'Push Messaging Blocked';
        pushbtn.checked = true;

        return;
    }

    if (isSubscribed) {
        console.log('btn on으로 변경!');
        pushbtn.textContent = '수신 허용됨';
        nopushbtn.textContent = '수신취소하기';
        pushbtn.disabled = true;
        nopushbtn.disabled = false;
    } else {
        console.log('btn off으로 변경!');
        pushbtn.textContent = '수신하기';
        nopushbtn.textContent = '수신 거부됨';
        pushbtn.disabled = false;
        nopushbtn.disabled = true;
    }

    //pushbtn.checked = false;
}

function urlB64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function getDatetime() {
    var temp = new Date();
    var year = temp.getFullYear().toString();
    var month = pad(temp.getMonth() + 1, 2);
    var day = pad(temp.getDate(), 2);
    var hour = pad(temp.getHours(), 2);
    var min = pad(temp.getMinutes(), 2);
    var sec = pad(temp.getSeconds(), 2);
    var datetime = year + '-' + month + '-' + day + ' ' + hour + ':' + min + ':' + sec;
    return datetime;
}

function pad(num, len) {
    var str = num.toString();
    while (str.length < len)
        str = '0' + str;
    return str
}