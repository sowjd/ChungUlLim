var confirmbtn = document.querySelector('#confirm-btn'); // 알림 수신 확인 버튼

var swRegistartion;
var confirmedSub=[];

// 서비스워커 등록
if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker and Push is supported');

    navigator.serviceWorker.register('/client/cafe/sw-client.js')
    .then(function(swReg) {
      console.log('Service Worker is registered', swReg);

      swRegistration = swReg;

    })
    .catch(function(error) {
      console.error('Service Worker Error', error);
    });
} else {
    console.warn('Push messaging is not supported');
    pushbtn.textContent = '푸시 지원 불가';
}

confirmbtn.addEventListener('click', function(){
    swRegistration.pushManager.getSubscription()
    .then(function(subscription) {
        if (subscription) {
            console.log('읽어온 sub: '+JSON.stringify(subscription));
            confirmedSub = subscription;
            return subscription.unsubscribe();
        }
    })
    .catch(function(error) {
          console.log('Error unsubscribing', error);
    })
    .then(function() {
          console.log('User is unsubscribed');
            
          //server로 reception 변경 요청

        $.ajax({
            type: 'POST',
            url: 'https://hdarts.kr:3000/process/reception',
            async: true, //비동기식
            contentType: 'application/json',
            data: JSON.stringify({
                "subscriptionJson": JSON.stringify(confirmedSub),
                "payload": '손님이 푸시 알림을 확인했습니다.'
            }),
            dataType:'json',
            processData: true,
            success: function(msg){
                alert(msg);
                console.log('Subscription 전송!');
            }
          });
        
        //btn 비활성화
        confirmbtn.disabled = true;
        confirmbtn.textContent = "감사합니다. :)";
    });
});