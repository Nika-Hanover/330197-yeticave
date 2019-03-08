    <nav class="nav">
      <ul class="nav__list container">
        <?foreach ($category as $n => $category_item):?>
          <li class="nav__item">
              <a href="pages/all-lots.html"><?=htmlspecialchars($category_item['categ_name'])?></a>
          </li>
        <?endforeach?>
      </ul>
    </nav>
    <div class="container">
      <section class="lots">
        <h2>Результаты поиска по запросу 
          <?if(!isset($error['search']) && count($search) > 0 && isset($search_word)): ?> 
            «<span><?=htmlspecialchars($search_word)?></span>» 
          <?endif?>
        </h2>
        <? if (isset($error['search']) || count($search) === 0 || !isset($search_word)):?>
          <p><?= $error['search'] ?></p>
        <? else: ?>
          <ul class="lots__list">
          <? foreach($search as $n => $lot): ?>
            <li class="lots__item lot">
              <div class="lot__image">
                <img src="<?=htmlspecialchars($lot['image'])?>" width="350" height="260" alt="<?=htmlspecialchars($lot['lot_name'])?>">
              </div>
              <div class="lot__info">
                <span class="lot__category"><?=htmlspecialchars($lot['categ_name'])?></span>
                <h3 class="lot__title"><a class="text-link" href="/pages/lot.php?id=<?=htmlspecialchars($lot['id'])?>"><?=htmlspecialchars($lot['lot_name'])?></a></h3>
                <div class="lot__state">
                  <div class="lot__rate">
                    <span class="lot__amount"><?= htmlspecialchars($lot['q_bets'])>1 ? htmlspecialchars($lot['q_bets'])." ставок" : "Стартовая цена" ?></span>
                    <span class="lot__cost"><?= price_format(htmlspecialchars($lot['current_price'] ?? $lot['start_price']))?></span>
                  </div>
                  <div class="lot__timer timer <?= ((strtotime($lot['date_close'])-time()) < 86400) ? 'timer--finishing' : '' ?>">
                    <?= interval_date($lot['date_close'])?>
                  </div>
                </div>
              </div>
            </li>
          <?endforeach?>
          </ul>
        <?endif?>
      </section>
      <? if(!isset($error['search']) && count($search) > 9) :?>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <? for($i=0; $i < ceil(count($search)/9); $i++):?> <!-- pagination-item-active -->
        <li class="pagination-item"><a href="#"><?= $i+1 ?></a></li>
        <?endfor?>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
      <?endif?>
    </div>