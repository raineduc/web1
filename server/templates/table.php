<div class="des-table-wrapper game-results__wrapper">
  <table class="des-table game-results__table">
    <thead>
      <tr>
        <th class="des-table__th">Координата X</th>
        <th class="des-table__th">Координата Y</th>
        <th class="des-table__th">Радиус R</th>
        <th class="des-table__th">Результат</th>
        <th class="des-table__th">Время выполнения скрипта</th>
        <th class="des-table__th">Текущее время</th>
      </tr>
    </thead>
    <tbody class="des-table__body">
      <?php foreach ($rows as $hit): ?>
      <tr class="des-table__tr">
        <?php foreach ($hit as $value): ?>
          <td class="des-table__td">
            <?php 
              if (is_bool($value)) {
                echo $value ? 'Попал' : 'Не попал'; 
              } else {
                echo $value;
              }
            ?>
          </td>
        <?php endforeach; ?>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>