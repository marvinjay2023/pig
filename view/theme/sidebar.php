<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>
        .w3-sidebar {
            transition: 0.5s;
        }

        .w3-top {
            height: 50px; /* Ensure sufficient height for top bar */
        }

        .w3-sidebar {
            margin-top: 50px; /* Align sidebar below the top bar */
        }

        .w3-main {
            margin-left: 300px; /* Sidebar width */
            margin-top: 50px; /* Ensure content starts below the top bar */
        }

        .w3-overlay {
            z-index: 5;
        }
    </style>
    <title>Sidebar Example</title>
</head>
<body>

<div class="w3-bar w3-top w3-black w3-large" style="z-index:4; height: 50px;">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();">
        <i class="fa fa-bars"></i> Menu
    </button>
    <span class="w3-bar-item w3-right"><?php echo NAME_X; ?></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container w3-row">
        <div class="w3-col s4">
            <img src="asset/default_avatar.jpg" class="w3-circle w3-margin-right" style="width:46px">
        </div>
        <div class="w3-col s8 w3-bar">
            <span>Welcome, <strong><?php echo ucwords($_SESSION['user']); ?></strong></span><br>
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5>Menu</h5>
    </div>
    <div class="w3-bar-block">
        <a href="#" class="bg-danger w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu">
            <i class="fa fa-remove fa-fw"></i> Close Menu
        </a>
        <a href="/" class="w3-bar-item w3-button w3-padding <?= checkUrl('/')? 'w3-blue' : '' ?>"><i class="fa fa-home fa-fw"></i> DASHBOARD</a>
        <a href="/manage-pig" class="w3-bar-item w3-button w3-padding <?= checkUrl('/manage-pig')? 'w3-blue' : '' ?>"><span style="font-size: 1.2em; color: black;">🐷</span> PIGS</a>
        <a href="/manage-breed" class="w3-bar-item w3-button w3-padding <?= checkUrl('/manage-breed')? 'w3-blue' : '' ?>"><i class="fa fa-users fa-fw"></i> BREEDS</a>
        <a href="/quarantine" class="w3-bar-item w3-button w3-padding <?= checkUrl('/quarantine')? 'w3-blue' : '' ?>"><span style="font-size: 1.2em;">💎</span> QUARANTINE</a>
        <a href="/data" class="w3-bar-item w3-button w3-padding <?= checkUrl('/data')? 'w3-blue' : '' ?>"><span style="font-size: 1.2em;">🌡️</span> ENVIRONMENT</a>
        <a href="/monitor" class="w3-bar-item w3-button w3-padding <?= checkUrl('/monitor')? 'w3-blue' : '' ?>">📷 MONITOR</a>
        <a href="/sold" class="w3-bar-item w3-button w3-padding <?= checkUrl('/sold')? 'w3-blue' : '' ?>"><span style="font-size: 1.2em;">🐷</span> Sold Pigs</a>
        <a href="/report" class="w3-bar-item w3-button w3-padding <?= checkUrl('/report')? 'w3-blue' : '' ?>"><span style="font-size: 1.2em;">📝</span> REPORTS</a>
        <a href="logout.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-power-off fa-fw"></i> LOG OUT</a><br><br>
    </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>
