<?php

require_once __DIR__ . '/bootstrap.php';

$sidebarUserName = auth_user_name();
$sidebarUserRole = auth_user_role();
$sidebarUserEmail = auth_user_email();
$sidebarUserInitial = auth_user_initial();
?>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
:root{
--sb-bg:#0f1222;
--sb-bg2:#141a33;
--sb-border:rgba(255,255,255,.08);
--sb-text:rgba(255,255,255,.92);
--sb-accent:99,102,241;
--sb-open:260px;
--sb-close:70px;
}

/* SIDEBAR */

.sidebar{
position:fixed;
top:0;
left:0;
height:100vh;
width:var(--sb-open);
display:flex;
flex-direction:column;
background:
radial-gradient(1200px 700px at -200px -200px,rgba(var(--sb-accent),.18),transparent 55%),
linear-gradient(180deg,var(--sb-bg2),var(--sb-bg));
border-right:1px solid var(--sb-border);
transition:width .3s ease;
z-index:1000;
overflow-x:hidden;
}

/* PAGE SHIFT */

.app{
margin-left:var(--sb-open);
transition:margin-left .3s ease;
}

body.sb-collapsed .sidebar{
width:var(--sb-close);
}

body.sb-collapsed .app{
margin-left:var(--sb-close);
}

/* TOP */

.sidebar__top{
display:flex;
align-items:center;
justify-content:space-between;
padding:14px 14px;
border-bottom:1px solid var(--sb-border);
}

/* BRAND */

.brand{
display:flex;
align-items:center;
gap:10px;
text-decoration:none;
color:white;
font-weight:800;
min-width:0;
}

.brand__logo{
width:36px;
height:36px;
border-radius:10px;
display:flex;
align-items:center;
justify-content:center;
background:rgba(var(--sb-accent),.2);
flex-shrink:0;
}

.brand__text{
font-size:18px;
white-space:nowrap;
}

/* hide brand completely when collapsed */
body.sb-collapsed .brand{
display:none;
}

/* center hamburger when collapsed */
body.sb-collapsed .sidebar__top{
justify-content:center;
}

/* BUTTON */

.icon-btn{
width:36px;
height:36px;
border-radius:10px;
border:1px solid rgba(255,255,255,.1);
background:rgba(255,255,255,.05);
color:white;
cursor:pointer;
}

/* NAV */

.sidebar__nav{
flex:1;
padding:12px 10px;
overflow-y:auto;
overflow-x:hidden;
}

.nav-item{
display:flex;
align-items:center;
gap:12px;
padding:9px 10px;
border-radius:10px;
color:white;
text-decoration:none;
font-size:13px;
font-weight:600;
background:none;
border:none;
width:100%;
cursor:pointer;
white-space:nowrap;
}

.nav-item:hover{
background:rgba(255,255,255,.08);
}

.nav-icon{
width:28px;
height:28px;
display:flex;
align-items:center;
justify-content:center;
border-radius:8px;
background:rgba(255,255,255,.05);
flex-shrink:0;
}

body.sb-collapsed .nav-text{
display:none;
}

body.sb-collapsed .nav-caret{
display:none;
}

/* CARET */

.nav-caret{
margin-left:auto;
font-size:11px;
transition:transform .25s;
}

/* SUBMENU */

.submenu{
display:none;
flex-direction:column;
margin-left:28px;
margin-top:6px;
padding-left:12px;
border-left:1px solid rgba(255,255,255,.15);
}

.nav-item.active + .submenu{
display:flex;
}

.nav-item.active .nav-caret{
transform:rotate(180deg);
}

.submenu-item{
padding:6px 8px;
font-size:12px;
color:#ddd;
text-decoration:none;
border-radius:6px;
position:relative;
}

.submenu-item:hover{
background:rgba(255,255,255,.08);
color:white;
}

body.sb-collapsed .submenu{
display:none;
}

/* BOTTOM */

.sidebar__bottom{
padding:10px;
border-top:1px solid var(--sb-border);
}

.userbottom{
display:flex;
align-items:center;
gap:10px;
padding:8px;
border-radius:10px;
background:rgba(255,255,255,.05);
margin-bottom:8px;
overflow:hidden;
}

.userbottom__avatar{
width:30px;
height:30px;
display:flex;
align-items:center;
justify-content:center;
border-radius:8px;
background:rgba(var(--sb-accent),.4);
color:white;
font-weight:bold;
flex-shrink:0;
}

.user-info{
min-width:0;
}

.user-name{
font-size:12px;
font-weight:700;
color:white;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}

.user-role{
font-size:10px;
color:#aaa;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
}

body.sb-collapsed .user-info{
display:none;
}
</style>

<aside class="sidebar">

<div class="sidebar__top">

<a href="dashboard" class="brand">
<span class="brand__logo"><i class="fa-solid fa-dumbbell"></i></span>
<span class="brand__text">NNGK</span>
</a>

<button id="sidebarToggle" class="icon-btn">
<i class="fa-solid fa-bars"></i>
</button>

</div>

<nav class="sidebar__nav">

<button class="nav-item">
<span class="nav-icon"><i class="fa-solid fa-calendar"></i></span>
<span class="nav-text">Booking</span>
<span class="nav-caret"><i class="fa-solid fa-chevron-down"></i></span>
</button>

<div class="submenu">
<a class="submenu-item" href="court_form">Court</a>
<a class="submenu-item" href="event_form">Event</a>
</div>

<button class="nav-item">
<span class="nav-icon"><i class="fa-solid fa-clock"></i></span>
<span class="nav-text">History</span>
<span class="nav-caret"><i class="fa-solid fa-chevron-down"></i></span>
</button>

<div class="submenu">
<a class="submenu-item" href="court_history">Court</a>
<a class="submenu-item" href="event_history">Event</a>
</div>

<a class="nav-item" href="admin_panel">
<span class="nav-icon"><i class="fa-solid fa-user-gear"></i></span>
<span class="nav-text">Admin Panel</span>
</a>

</nav>

<div class="sidebar__bottom">

<div class="userbottom">
<div class="userbottom__avatar"><?php echo htmlspecialchars($sidebarUserInitial, ENT_QUOTES, 'UTF-8'); ?></div>

<div class="user-info">
<div class="user-name"><?php echo htmlspecialchars($sidebarUserName, ENT_QUOTES, 'UTF-8'); ?></div>
<div class="user-role"><?php echo htmlspecialchars($sidebarUserEmail !== '' ? $sidebarUserEmail : $sidebarUserRole, ENT_QUOTES, 'UTF-8'); ?></div>
</div>

</div>

<a class="nav-item" href="profile">
<span class="nav-icon"><i class="fa-solid fa-user"></i></span>
<span class="nav-text">Profile</span>
</a>

<a class="nav-item" href="logout">
<span class="nav-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
<span class="nav-text">Logout</span>
</a>

</div>

</aside>

<script>

/* collapse */

document.getElementById("sidebarToggle").onclick=function(){
document.body.classList.toggle("sb-collapsed");
};

/* dropdown */

document.querySelectorAll(".sidebar__nav .nav-item").forEach(btn=>{

btn.addEventListener("click",function(){

const submenu=this.nextElementSibling;

if(!submenu || !submenu.classList.contains("submenu")) return;

document.querySelectorAll(".sidebar__nav .nav-item").forEach(i=>{
if(i!==this) i.classList.remove("active");
});

this.classList.toggle("active");

});

});

</script>
