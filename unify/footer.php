<footer>
    <div class="footer-content">
        <div class="footer-sponsor">
            <b>
                <p>Sponsors 鸣谢赞助: </p>
            </b>
        </div>
        <div class="footer-logo">
            <a href="https://www.zyhost.cn/"><img src="https://api4.lfcup.cn/files/logo2.png" alt="Logo" class="logo"
                    width="150" height="auto"></a>
        </div>
    </div>
    <p>Current Server: Aliyun-Shanghai</p>
</footer>
<footer class="text-center p-5">
    <p>Copyright &copy; 2025 IronMaple@Minur.</p>
</footer>
<div class="menu-container">
    <s-fab>
        <s-icon onclick="toggleMenu()"><img src="/resource/5516logo.jpg" alt="Logo"></s-icon>
    </s-fab>
    <div class="menu" id="menu">
        <ul>
            <li>
                <?php if (isset($_SESSION['username'])): ?>
                    <strong>
                        <p style="color:rgb(0, 0, 0)"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    </strong>
                <?php else: ?>
                    <a href="/login">LOGIN!!!</a>
                <?php endif; ?>
            </li>
            <li><a href="/profile">Profile</a></li>
            <li><a href="/user">Admin</a></li>
        </ul>
    </div>

</div>

<script>
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('show');
    }
</script>