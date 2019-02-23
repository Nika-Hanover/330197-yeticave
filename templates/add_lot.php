<nav class="nav">
      <ul class="nav__list container">
        <?foreach ($category as $n => $category_item):?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?=htmlspecialchars($category_item['categ_name'])?></a>
            </li>
        <?endforeach?>
      </ul>
    </nav>
    <form class="form form--add-lot container <? (isset($errors) && count($errors) > 0) ? 'form--invalid' : ''?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?= isset($errors['lot-name']) ? 'form__item--invalid' : '' ?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование</label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" required value="<?= $lot_name ?>">
          <? if(isset($errors['lot-name'])):?>
          <span class="form__error"><?= $errors['lot-name'] ?></span><!--Введите наименование лота-->
          <?endif?>
        </div>
        <div class="form__item <?= isset($errors['category']) ? 'form__item--invalid' : '' ?>">
          <label for="category">Категория</label>
          <select id="category" name="category" required>
            <option value = "">Выберите категорию</option>
            <?foreach ($category as $n => $category_item):?>
            <option value = '<?= htmlspecialchars($category_item['id']) ?>' <?= (htmlspecialchars($category_item['id']) === $category_id) ? 'selected=selected' : '' ?> ><?=htmlspecialchars($category_item['categ_name'])?></option>
            <?endforeach?>
          </select>
          <? if(isset($errors['category'])):?>
          <span class="form__error">Выберите категорию</span>
          <?endif?>
        </div>
      </div>
      <div class="form__item form__item--wide <?= isset($errors['message']) ? 'form__item--invalid' : '' ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота" required maxlength="2000"><?= $message?></textarea>
        <? if(isset($errors['message'])):?>
        <span class="form__error"><?= $errors['message'] ?></span>
        <?endif?>
      </div>
      <div class="form__item form__item--file <? isset($errors['message']) ? 'form__item--invalid' : 'form__item--uploaded' ?>"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <? if(isset($errors['message'])): ?>
            <img src="<? $file_url ?>" width="113" height="113" alt="Изображение лота">
            <? endif ?>
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="photo2" value="" name="photo2" required>
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
          <? if(isset($errors['photo2'])): ?>
          <span class="form__error" style ="display: block"><?= $errors['photo2'] ?></span>
          <?endif?>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?= isset($errors['lot-rate']) ? 'form__item--invalid' : '' ?>">
          <label for="lot-rate">Начальная цена</label>
          <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?= $lot_rate ?>" required>
          <? if(isset($errors['lot-rate'])): ?>
          <span class="form__error"><?= $errors['lot-rate'] ?></span>
          <?endif?>
        </div>
        <div class="form__item form__item--small <?= isset($errors['lot-step']) ? 'form__item--invalid' : '' ?>">
          <label for="lot-step">Шаг ставки</label>
          <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?= $lot_step ?>" required>
          <? if(isset($errors['lot-step'])): ?>
          <span class="form__error"><?= $errors['lot-step'] ?></span>
          <?endif?>
        </div>
        <div class="form__item <?= isset($errors['lot-date']) ? 'form__item--invalid' : '' ?>">
          <label for="lot-date">Дата окончания торгов</label>
          <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?= $lot_date ?>" required>
          <? if(isset($errors['lot-date'])): ?>
          <span class="form__error"><?= $errors['lot-date']?></span>
          <?endif?>
        </div>
      </div>
      <? if(isset($errors) && count($errors) > 0): ?>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <?endif?>
      <button type="submit" class="button">Добавить лот</button>
    </form>