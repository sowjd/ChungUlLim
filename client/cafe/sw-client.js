
var CACHE_NAME = 'client-cache';
var urlsToCache = [
    '/',
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(	//프라미스를 사용하여 설치 소요 시간 및 설치 성공 여부를 확인
    caches.open(CACHE_NAME).then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

//다른 페이지로 이동하거나 새로고침 하면 service worker가 fetch event 수신
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)	//요청을 확인, service worker가 생성한 캐시에 캐시된 결과가 있는지 찾음, 응답이 있다면 캐시된 값을 반환 otherwise, fetch결과를 반환
      .then(function(response) {
        // Cache hit - return response
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});

self.addEventListener('notificationclose', function(e) {
    var notification = e.notification;
    var primaryKey = notification.data.primaryKey;

    console.log('Closed notification: ' + primaryKey);
  });

  self.addEventListener('notificationclick', function(e) {
    var notification = e.notification;
    var primaryKey = notification.data.primaryKey;
    var action = e.action;

    if (action === 'close') {
      notification.close();
    } else {
      clients.openWindow('/client/event/html/' + primaryKey + '.html?idx='+notification.data.idx);
      notification.close();
    }
  });

self.addEventListener('push', function(e) {
    var myData = e.data.text();
    var plz = JSON.parse(myData);
    
    if(plz.tag === 'event'){
        var options = {
            body: plz.content,
            icon: 'images/pushicon-coffee.jpg',
            vibrate: [300,100,300], //테스트용
            //vibrate: [500, 700, 500, 700, 500, 700, 500, 700, 500],
            data: {
              dateOfArrival: Date.now(),
              primaryKey: 'showEvent',
              idx: plz.idx
            },
            actions: [
              {action: 'explore', title: '알림 확인',
                icon: 'images/checkmark.png'},
              {action: 'close', title: '알림 끄기',
                icon: 'images/xmark.png'},
            ]
        };
        e.waitUntil(
            self.registration.showNotification(plz.title, options)
        );
    }else if(plz.tag === 'cafe'){
        var options = {
            body: plz.tag,
            icon: 'images/pushicon-coffee.jpg',
            vibrate: [300,100,300], //테스트용
            //vibrate: [500, 700, 500, 700, 500, 700, 500, 700, 500],
            data: {
              dateOfArrival: Date.now(),
              primaryKey: 'confirmNotification'
            },
            actions: [
              {action: 'explore', title: '알림 확인',
                icon: 'images/checkmark.png'},
              {action: 'close', title: '알림 끄기',
                icon: 'images/xmark.png'},
            ]
        };
        e.waitUntil(
            self.registration.showNotification('음료 제조완료', options)
        );
    }
});