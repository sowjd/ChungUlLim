/*
Copyright 2016 Google Inc.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
  '/',
  '/index.html'
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


(function() {
  'use strict';
    
// Install Service Worker
    self.addEventListener('install', function(event) {
        console.log('Service worker installing...');
        self.skipWaiting();
    });

    self.addEventListener('activate', function(event) {
        console.log('Service worker activating...');
    });

  // I'm a new service worker
    self.addEventListener('fetch', function(event) {
        console.log('Fetching:', event.request.url);
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
            clients.openWindow('samples/page' + primaryKey + '.html');
            notification.close();
        }
        
    // TODO 5.3 - close all notifications when one is clicked

    });

  // TODO 3.1 - handle the push event
    self.addEventListener('push', function(e) {
      var options = {
          body: 'This notification was generated from a push!',
          icon: 'images/notification-flat.png',
          vibrate: [100, 50, 100],
          data: {
          dateOfArrival: Date.now(),
          primaryKey: '-push-notification'
          },
        actions: [
            {action: 'explore', title: 'Go to the site',
             icon: 'images/checkmark.png'},
            {action: 'close', title: 'Close the notification',
            icon: 'images/xmark.png'},
        ]};
        e.waitUntil(
            self.registration.showNotification('Hello world!', options)
        );
    });
})();
