<table>
   <tr>
    <th>Координата X</th>
    <th>Координата Y</th>
    <th>Радиус R</th>
    <th>Результат</th>
    <th>Время выполнения скрипта</th>
    <th>Текущее время</th>
   </tr>
    <?php foreach ($rows as $hit): ?>
      <tr>
        <?php foreach ($hit as $value): ?>
          <td><?php 
              if (is_bool($value)) {
                echo $value ? 'Попал' : 'Не попал'; 
              } else {
                echo $value;
              }
            ?></td>
        <?php endforeach; ?> 
      </tr>   
    <?php endforeach; ?>    
</table>