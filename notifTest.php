<!DOCTYPE html>
<html lang="Fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="global.css">
    <link rel="stylesheet" href="header/header.css">

    
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <title>Rezo</title>
</head>
<body>
    <?php

    // include('header/header.php');
    // include('navBar/navBar.php');
    // include('body/body.php');
    // include('footer/footer.php');

    ?>
    <button>notif</button>
</body>
</html>

<script>
let button = document.querySelector('button');

button.addEventListener('click', () => {
    if(!window.Notification) return;

    Notification.requestPermission().then(showNotification)
    console.log(permission);
})



function showNotification(permission){
    if(permission !== 'granted') return;

    let notification = new Notification('My Title', {
        body:"bonjour !",
        //icon:'image/.png'
    })

    notification.onclick = () => { 
        window. open('https://google.com')
    }
}

</script>