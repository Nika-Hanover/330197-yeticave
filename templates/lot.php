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
            <img src="<?= "/".htmlspecialchars($lot['image']) ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['lot_name'])?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['categ_name'])?></span></p>
          <p class="lot-item__description"><?= htmlspecialchars($lot['description'])?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state">
            <div class="lot-item__timer timer">
              10:54
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?= price_format(htmlspecialchars($lot['start_price']))?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?= price_format(htmlspecialchars($lot['step']))?></span>
              </div>
            </div>
            <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
              <p class="lot-item__form-item form__item form__item--invalid">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="12 000">
                <span class="form__error">Введите наименование лота</span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
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