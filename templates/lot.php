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
      <h2><?= htmlspecialchars($lot['lot_name']) ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= htmlspecialchars($lot['image']) ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['lot_name'])?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['categ_name'])?></span></p>
          <p class="lot-item__description"><?= htmlspecialchars($lot['description'])?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state">
            <div class="lot-item__timer timer <?= ((strtotime($lot['date_close'])-time()) < 86400) ? 'timer--finishing' : '' ?>">
              <?= $interval_hours ?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?= price_format(htmlspecialchars($lot['current_price'] ?? $lot['start_price']))?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?= price_format(htmlspecialchars($min_bet))?></span>
              </div>
            </div>
            <?if(isset($_SESSION['user']) && $_SESSION['user']['id'] !== htmlspecialchars($lot['author_id']) && ((count($bets) >0 && $user_bets === 0) || count($bets) === 0) && $interval_hours !== '00:00'):?>
            <form class="lot-item__form <? (isset($errors) && count($errors) > 0) ? 'form--invalid' : ''?>" action="/pages/lot.php?id=<?= $lot['id'] ?>" method="post">
              <p class="lot-item__form-item form__item">
                <label for="cost">Ваша ставка</label>
                <input id="cost <?= isset($errors['cost']) ? 'form__item--invalid' : '' ?>" type="text" name="cost" placeholder="<?= htmlspecialchars($min_bet) ?>">
                <? if(isset($errors['cost'])):?>
                <span class="form__error" style="display: block"><?= $errors['cost']?></span> <!-- Сделайте Вашу ставку -->
                <? endif ?>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
            <?endif?>
          </div>
          <div class="history">
            <h3>История ставок (<span><?= count($bets) ?></span>)</h3>
            <table class="history__list">
              <? if(count($bets)>0):?>
                <?foreach ($bets as $n => $bet):?>
                <tr class="history__item">
                  <td class="history__name"><?= $bet['user_name']?></td>
                  <td class="history__price"><?= price_format(htmlspecialchars($bet['amount']))?></td>
                  <td class="history__time"><?= diff_result(htmlspecialchars($bet['date_bet']))?></td>
                </tr>
                <?endforeach?>
              <?endif?>
            </table>
          </div>
        </div>
      </div>
    </section>