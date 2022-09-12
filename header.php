<header>
    <div class="logo">
        <a href="/">
            <img src="/image/logo/logo.png" alt="Логотип">
        </a>
    </div>
    <nav class="dws-menu">
        <input type="checkbox" name="toggle" id="menu" class="toggleMenu">
        <label for="menu" class="toggleMenu"><i class="fa fa-bars"></i>&nbsp;&nbsp;&nbsp;Меню</label>
        <ul>
            <li><a href="/" id="index">Главная</a></li>
            <li><a href="/courses.php" id="courses" class="activeTimetable">Курсы</a></li>
            <li><a href="/новости.php" id="новости">Статьи</a></li>
            <li class="shown"><a href="/questions.php" id="questions">Часто задаваемые вопросы</a></li>
            <li><a href="/teachers.php" id="teachers">Преподаватели</a></li>
            <li class="contact"><a href="/contact.php" id="contact">Контакты</a></li>
            <?php
                if ($_SESSION['logged_user']){
                    echo '<li class=""><a href="/login.php/" id="lk">Личный кабинет</a></li>';
                }else{
                    echo '<li class=""><a href="/login.php/" id="lk">Войти</a></li>';
                }
            ?>
        </ul>
    </nav>
</header>
<script>
    switch (document.location.pathname) {
        case '/':
            document.getElementById('index').classList.add('active')
            break;
        case '/courses.php':
            document.getElementById('courses').classList.add('active')
            break;
        case '/%D0%BD%D0%BE%D0%B2%D0%BE%D1%81%D1%82%D0%B8.php':
            document.getElementById('новости').classList.add('active')
            break;
        case '/%D0%BD%D0%BE%D0%B2%D0%BE%D1%81%D1%82%D1%8C.php':
            document.getElementById('новости').classList.add('active')
            break;
        case '/questions.php':
            document.getElementById('questions').classList.add('active')
            break;
        case '/teachers.php':
            document.getElementById('teachers').classList.add('active')
            break;
        case '/contact.php':
            document.getElementById('contact').classList.add('active')
            break;
        case '/lk.php':
            document.getElementById('lk').classList.add('active')
            break;
    }
</script>