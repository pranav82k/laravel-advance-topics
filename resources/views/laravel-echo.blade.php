<!DOCTYPE html>
<head>
  <script src="js/app.js"></script>
  <title>Pusher Test</title>
  <!-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> -->
  <script>
    // const APP_KEY = "{{ env('PUSHER_APP_KEY') }}";
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    // var pusher = new Pusher(APP_KEY, {
    //   cluster: 'ap2'
    // });

    // var channel = pusher.subscribe('my-channel');
    // channel.bind('my-event', function(data) {
    //   alert('Im here');
    //   // alert(JSON.stringify(data));
    //   window.location.href= data?.url;
    // });


    // Echo.private(`orders.${orderId}`)
    // .listen('OrderShipmentStatusUpdated', (e) => {
    //     console.log(e.order);
    // });
    // Echo.channel(`first-channel`)
    //   .listen('OrderShipmentStatusUpdated', (e) => {
    //       console.log('e.order.name');
    //       alert("PRANAV");
    //   });

    let orderId = 1;
    console.log(`orders.${orderId}`);
    Echo.channel(`orders.${orderId}`)
      .listen('OrderShipmentStatusUpdated', (e) => {
          console.log(e.order);
          alert("i m here");
      });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
</body>