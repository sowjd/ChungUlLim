/*
작성자 : 김응준
requestSubscription.html(현재 index.html)과 연결된 js 파일.
서비스워커 등록, 구독신청 버튼 있음.
*/


var app = (function() {
  'use strict';

  var isSubscribed = false;
  var swRegistration = null;
    
    // 알림테스트 버튼 & 알림신청 버튼
  var notifyButton = document.querySelector('.js-notify-btn');
  var pushButton = document.querySelector('.js-push-btn');

  if (!('Notification' in window)) {
    console.log('This browser does not support notifications!');
  return;
  }

  // TODO 2.2 - request permission to show notifications
  Notification.requestPermission(function(status) {
        console.log('Notification permission status:', status);
  });

  function displayNotification() {
    // TODO 2.3 - display a Notification
      if (Notification.permission == 'granted') {
          navigator.serviceWorker.getRegistration().then(function(reg) {
    // TODO 2.4 - Add 'options' object to configure the notification
        var options = {
            body: 'First notification!',
            icon: 'images/notification-flat.png',
            vibrate: [100, 50, 100],
            data: {
                dateOfArrival: Date.now(),
                primaryKey: 1
            },
  // TODO 2.5 - add actions to the notification
            actions: [
                {action: 'explore', title: 'Go to the site',
                 icon: 'images/checkmark.png'},
                {action: 'close', title: 'Close the notification',
                 icon: 'images/xmark.png'},
            ]
  // TODO 5.1 - add a tag to the notification
        };
        reg.showNotification('Hello world!');
        });
      }
  }

  function initializeUI() {
      console.log('이닛UI 실행됨');
    // TODO 3.3b - add a click event listener to the "Enable Push" button
    // and get the subscription object
      pushButton.addEventListener('click', function() {
          console.log('클릭이벤트발생');
        pushButton.disabled = true;
        if (isSubscribed) {
            console.log('구독자가 있으니 구독취소하기');
            unsubscribeUser();
        } else {
            console.log('구독자가 없으니 구독신청하기');
            subscribeUser();
        }
      });
        

      swRegistration.pushManager.getSubscription()
          .then(function(subscription) {
          
          isSubscribed = (subscription !== null);

          updateSubscriptionOnServer(subscription);

          if (isSubscribed) {
              console.log('User IS subscribed.');
                          
              //server로 subscription 추가요청 전송
              console.log('Subscription 추가 요청 전송 시도... Json:'+JSON.stringify(subscription));
              $.ajax({
                type: 'POST',
                url: 'https://domybest.kr:3000/process/addSubscription',
                contentType: 'application/json',
                data: JSON.stringify(subscription),
                dataType:'json',
                processData: true,
                success: function(msg){
                    alert(msg);
                    console.log('Subscription 전송!');
                }
              });
          } else {
              console.log('User is NOT subscribed.');
          }

          updateBtn();
      });
  }

  // TODO 4.2a - add VAPID public key
    var applicationServerPublicKey = 'BERHh9W9ZpHepyo6CM1A8QJmO5k8qbRQ7jR8Xmo8DKfEeE2b48PAjjCFHuB2BO66lj9tPChZnbSLiEOq0MvdXPM';

    function subscribeUser() {
        var applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
        swRegistration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: applicationServerKey
        })
        .then(function(subscription) {
            console.log('User is subscribed:', subscription);
            updateSubscriptionOnServer(subscription);
            isSubscribed = true;
            updateBtn();
            
            //server로 subscription 추가요청 전송
            console.log('Subscription 추가 요청 전송 시도... Json:'+JSON.stringify(subscription));
            $.ajax({
                type: 'POST',
                url: 'https://domybest.kr:3000/process/addSubscription',
                contentType: 'application/json',
                data: JSON.stringify(subscription),
                dataType:'json',
                processData: true,
                success: function(msg){
                    alert(msg);
                    console.log('Subscription 전송!');
                }
            });
            
            console.log(isSubscribed);
            if(isSubscribed){
                console.log('다음페이지로!');
                //window.location.href="https://domybest.kr/waiting.html";
            }
        })
        .catch(function(err) {
            if (Notification.permission === 'denied') {
                console.warn('Permission for notifications was denied');
            } else {
                console.error('Failed to subscribe the user: ', err);
            }
            updateBtn();
        });
        /*
        .then(function() {
           // waiting 페이지로 이동
            console.log(isSubscribed);
            if(isSubscribed){
                console.log('다음페이지로!');
                //window.location.href="https://domybest.kr/waiting.html";
            }
        });
        */
    }
  
  var delSub={};    
    
  function unsubscribeUser() {
    // TODO 3.5 - unsubscribe from the push service
      swRegistration.pushManager.getSubscription()
          .then(function(subscription) {
            if (subscription) {
                delSub = subscription;
                return subscription.unsubscribe();
            }
          })
          .catch(function(error) {
            console.log('Error unsubscribing', error);
          })
          .then(function() {
            updateSubscriptionOnServer(null);
            console.log('User is unsubscribed');
            isSubscribed = false;
            updateBtn();
            
            //server로 subscription 삭제 요청 전송
            console.log('Subscription 삭제 요청 전송 시도... Json:'+JSON.stringify(delSub));
            $.ajax({
                type: 'POST',
                url: 'https://domybest.kr:3000/process/delSubscription',
                contentType: 'application/json',
                data: JSON.stringify(delSub),
                dataType:'json',
                processData: true,
                success: function(msg){
                    alert(msg);
                    console.log('Subscription 전송!');
                }
            });
          });
  }

  function updateSubscriptionOnServer(subscription) {
    // Here's where you would send the subscription to the application server
    var subscriptionJson = document.querySelector('.js-subscription-json');
    //var endpointURL = document.querySelector('.js-endpoint-url');
    var subAndEndpoint = document.querySelector('.js-sub-endpoint');

    if (subscription) {
      subscriptionJson.textContent = JSON.stringify(subscription);
      //endpointURL.textContent = subscription.endpoint;
      subAndEndpoint.style.display = 'block';
       // ajax 있던자리.
    } else {
      subAndEndpoint.style.display = 'none';
    }
  }

  function updateBtn() {
    if (Notification.permission === 'denied') {
      pushButton.textContent = 'Push Messaging Blocked';
      pushButton.disabled = true;
      updateSubscriptionOnServer(null);
      return;
    }

    if (isSubscribed) {
      pushButton.textContent = '알림 받기 허용 안함';
    } else {
      pushButton.textContent = '알림 받기 허용';
    }

    pushButton.disabled = false;
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

  notifyButton.addEventListener('click', function() {
    displayNotification();
  });

  if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('sw.js')
    .then(function(swReg) {
      console.log('Service Worker is registered', swReg);

      swRegistration = swReg;

      // TODO 3.3a - call the initializeUI() function
      initializeUI();
    })
    .catch(function(error) {
      console.error('Service Worker Error', error);
    });
  } else {
    console.warn('Push messaging is not supported');
    pushButton.textContent = 'Push Not Supported';
  }

});
