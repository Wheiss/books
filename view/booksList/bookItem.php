<form method='post'>
	<tr class='book <?= (bool) $even ? 'grey' : 'white'?>'>
		<td class="jsId"><?=$book->id?></td>
		<td class="jsAuthor jsEditableSelect"><?=$book->getAuthor()->getFullName()?></td>
		<td class="jsName jsEditable"><?=$book->name?></td>
		<td class="jsYear jsEditable"><?=$book->year?></td>
        <td><a href="<?=Router::url('deleteBook', array('ID' => $book->id))?>">Удалить</a></td>
        <td><a href="<?=Router::url('editBook', array('ID' => $book->id))?>">Редактировать</a></td>
	</tr>
</form>