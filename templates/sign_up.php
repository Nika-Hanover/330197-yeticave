<nav class="nav">
      <ul class="nav__list container">
        <?foreach ($category as $n => $category_item):?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?=htmlspecialchars($category_item['categ_name'])?></a>
            </li>
        <?endforeach?>
      </ul>
    </nav>
    <form class="form container <? (isset($errors) && count($errors) > 0) ? 'form--invalid' : ''?>" action="sign_up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?= isset($errors['email']) ? 'form__item--invalid' : '' ?>" > <!-- form__item--invalid -->
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" required value="<?= $email ?>">
        <? if(isset($errors['email'])):?>
        <span class="form__error"><?= $errors['email'] ?></span> <!-- Введите e-mail -->
        <?endif?>
      </div>
      <div class="form__item <?= isset($errors['password']) ? 'form__item--invalid' : '' ?>" >
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" required value="">
        <? if(isset($errors['password'])):?>
        <span class="form__error"><?= $errors['password'] ?></span> <!-- Введите пароль -->
        <?endif?>
      </div>
      <div class="form__item <?= isset($errors['user_name']) ? 'form__item--invalid' : '' ?>" >
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" required value="<?= $user_name ?>">
        <? if(isset($errors['user_name'])):?>
        <span class="form__error"><?= $errors['user_name'] ?></span> <!-- Введите имя -->
        <?endif?>
      </div>
      <div class="form__item <?= isset($errors['message']) ? 'form__item--invalid' : '' ?>" >
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться" required value="<?= $message ?>"></textarea>
        <? if(isset($errors['message'])):?>
        <span class="form__error"><?= $errors['message'] ?></span> <!-- Напишите как с вами связаться -->
        <?endif?>
      </div>
      <div class="form__item form__item--file form__item--last">
        <label>Аватар</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <? if(!isset($errors['photo2']) && $file_url): ?>
          <div class="preview__img">
            <img src="<? $file_url ?>" width="113" height="113" alt="Ваш аватар"> <!-- img/avatar.jpg -->
          </div>
          <? endif ?>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="photo2" name="photo2" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
        <? if(isset($errors['photo2'])): ?>
          <span class="form__error" style ="display: block"><?= $errors['photo2'] ?></span>
        <?endif?>
      </div>
      <? if(isset($errors) && count($errors) > 0): ?>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <?endif?>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="/pages/login.html">Уже есть аккаунт</a>
    </form>