<nav class="nav">
            <ul class="nav__list container">
            <?foreach ($category as $n => $category_item):?>
                <li class="nav__item">
                    <a href="pages/all-lots.html"><?=htmlspecialchars($category_item['categ_name'])?></a>
                </li>
            <?endforeach?>
            </ul>
        </nav>
        <section class="lot-item container">
            <h2>403 Доступ запрещён</h2>
            <p>Страница доступна только для зарегистрированных пользователей. Войдите в свой аккаунт или пройдите регистрацию.</p>
        </section>