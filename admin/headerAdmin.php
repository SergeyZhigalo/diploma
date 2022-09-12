<nav class="dws-menu">
    <input type="checkbox" name="toggle" id="menu" class="toggleMenu">
    <label for="menu" class="toggleMenu"><i class="fa fa-bars"></i>&nbsp&nbsp&nbspМеню</label>
    <ul>
        <li><a href="/admin/index.php" id="index">Главная</a></li>
        <li>
            <input type="checkbox" name="toggle" class="toggleSubmenu" id="sub_m1">
            <a href="#" id="news">Статьи&nbsp&nbsp&nbsp<i class="fa fa-caret-down"></i></a>
            <label for="sub_m1" class="toggleSubmenu"></label>
            <ul>
                <li><a href="/admin/newPost.php" id="newPost">Добавление статьи</a></li>
                <li><a href="/admin/postManagement.php" id="postManagement">Редактирование статьи</a></li>
            </ul>
        </li>
        <li>
            <input type="checkbox" name="toggle" class="toggleSubmenu" id="sub_m2">
            <a href="#" id="courseA">Курсы&nbsp&nbsp&nbsp<i class="fa fa-caret-down"></i></a>
            <label for="sub_m2" class="toggleSubmenu"></label>
            <ul>
                <li><a href="/admin/editCourse.php" id="courses">Редактирование курсов</a></li>
                <li><a href="/admin/editingEntries.php" id="enrollment">Редактирование записей на курс</a>
            </ul>
        </li>
        <li><a href="/" id="index">На сайт</a></li>
        <li><a href="/admin/changePassword.php" id="changePassword">Сменить пароль</a></li>
        <li><a href="/admin/logout.php" id="logout">Выйти</a></li>
    </ul>
</nav>
<script>
    switch (document.location.pathname) {
        case '/admin/':
            document.getElementById('index').classList.add('active')
            break;
        case '/admin/newPost.php':
            document.getElementById('news').classList.add('active')
            document.getElementById('newPost').classList.add('active')
            break;
        case '/admin/postManagement.php':
            document.getElementById('news').classList.add('active')
            document.getElementById('postManagement').classList.add('active')
            break;

        case '/admin/editCourse.php':
            document.getElementById('courseA').classList.add('active')
            document.getElementById('courses').classList.add('active')
            break;

        case '/admin/editingEntries.php':
            document.getElementById('courseA').classList.add('active')
            document.getElementById('enrollment').classList.add('active')
            break;
    }
</script>