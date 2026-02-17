<?php ?>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0
    }

    body {
        font-family: 'Kanit', sans-serif;
        background: #f5f5f5
    }

    a {
        text-decoration: none;
        color: inherit
    }

    button {
        cursor: pointer;
        border: none;
        font-family: inherit
    }

    table {
        border-collapse: collapse;
        width: 100%
    }

    #sidebar {
        transform: translateX(-100%);
        transition: transform .15s
    }

    #sidebar.open {
        transform: translateX(0)
    }

    .overlay {
        display: none
    }

    @media(min-width:1024px) {
        #sidebar {
            transform: translateX(0)
        }

        .sidebar-toggle {
            display: none
        }

        .overlay {
            display: none !important
        }

        .main-content {
            margin-left: 250px
        }
    }
</style>
<aside id="sidebar"
    style="position:fixed;left:0;top:0;width:250px;height:100vh;background:#fff;padding:20px;overflow-y:auto;z-index:35;border-right:1px solid #ddd;">
    <h1 style="font-size:20px;margin-bottom:30px;color:#7c3aed;"><i class="ri-dashboard-3-line"></i> Admin</h1>
    <nav>
        <a href="dashboard.php" style="display:block;padding:10px;margin-bottom:4px;color:#333;"><i
                class="ri-dashboard-3-line"></i> แดชบอร์ด</a>
        <a href="userlist.php" style="display:block;padding:10px;margin-bottom:4px;color:#333;"><i
                class="ri-user-line"></i> รายชื่อผู้ใช้</a>
        <a href="search.php" style="display:block;padding:10px;margin-bottom:4px;color:#333;"><i
                class="ri-search-line"></i> ค้นหาผู้ใช้</a>
        <a href="Restore.php" style="display:block;padding:10px;margin-bottom:4px;color:#333;"><i
                class="ri-refresh-line"></i> คืนค่าผู้ใช้</a>
    </nav>
    <div style="margin-top:auto;padding-top:20px;border-top:1px solid #ddd;">
        <a href="ck_logout.php" onclick="return confirm('คุณต้องการออกจากระบบหรือไม่?');"
            style="display:block;padding:10px;color:#dc2626;"><i class="ri-logout-box-r-line"></i> ออกจากระบบ</a>
    </div>
</aside>
<button class="sidebar-toggle" id="sidebarToggle"
    style="position:fixed;top:10px;left:10px;z-index:40;background:#7c3aed;color:#fff;padding:8px;border-radius:4px;"><i
        class="ri-menu-2-line"></i></button>
<div class="overlay" id="overlay" style="position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:30;"></div>
<script>
    const sidebar = document.getElementById('sidebar'), sidebarToggle = document.getElementById('sidebarToggle'), overlay = document.getElementById('overlay');
    function toggleSidebar() { sidebar.classList.toggle('open'); overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none'; }
    sidebarToggle.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);
</script>