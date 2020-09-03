<table>
   <tr>
    <th>Координата X</th>
    <th>Координата Y</th>
    <th>Радиус R</th>
    <th>Результат</th>
   </tr>
    <?php foreach ($rows as $hit): ?>
      <tr>
        <?php foreach ($hit as $value): ?>
          <td><?php 
              if (is_bool($value)) {
                exit($value ? 'Попал' : 'Не попал'); 
              }
              echo $value;
            ?></td>
        <?php endforeach; ?> 
      </tr>   
    <?php endforeach; ?>    
</table>