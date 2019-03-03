<nav class="nav">
      <ul class="nav__list container">
        <?foreach ($category as $n => $category_item):?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?=htmlspecialchars($category_item['categ_name'])?></a>
            </li>
        <?endforeach?>
      </ul>
    </nav>
    <form class="form container <? (isset($errors) && count($errors) > 0) ? 'form--invalid' : ''?>" action="login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <div class="form__item <?= isset($errors['email']) ? 'form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required value="<?= $email ?>">
        <? if(isset($errors['email'])):?>
        <span class="form__error"><?= $errors['email'] ?></span> <!-- Введите e-mail -->
        <?endif?>
      </div>
      <div class="form__item form__item--last <?= isset($errors['password']) ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" required>
        <? if(isset($errors['password'])):?>
        <span class="form__error"><?= $errors['password'] ?></span> <!-- Введите пароль -->
        <?endif?>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>