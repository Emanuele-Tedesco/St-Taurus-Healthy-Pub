<?php
	require 'functions.php';
	$type = $_GET['type'];
	if (!$type) {
		$type = 'dinner';
	}
	$subtype = $_GET['subtype'];
	if (!$subtype) {
		$subtype = 'classici';
	}
	$conn = open_db_connection();
?>
<script src="js/menu.js"></script>
<div class="col-md-2">
	<ul class="nav nav-pills nav-stacked">
<?php //genero i pills
	$conn = open_db_connection();
	$query = "select id, type, substring_index(subtype,' ',-1) subtype
				from (select a.id, a.descrizione type, (select descrizione from tipo_sub_menu where id_menu = a.id having(min(id)) = b.id) as subtype from tipo_menu a inner join tipo_sub_menu b on a.id = b.id_menu order by 2) a
				where subtype is not null
				order by 1";
	$result = get_resultset($conn, $query);
	if ($result->num_rows) {
		while ($row = mysqli_fetch_assoc($result)) {
			$class = strtolower($row['type'].'-'.$row['subtype']);
			$desc = ucfirst($row['type']);
			echo '<li><a class="'.$class.' link">'.$desc.' menu</a></li>';
		}
	}
?>
	</ul>
</div>
<br />
<div class="col-sm-10">
	<ul class="nav nav-tabs">
<?php //genero i tabs
	$query = "SELECT a.id, a.id_menu, lower(substring_index(a.descrizione,' ',-1)) subtype, lower(b.descrizione) type, a.descrizione descrizione
			FROM tipo_sub_menu a inner join tipo_menu b	on a.id_menu = b.id
			where b.descrizione like '%".$type."'";
	$result = get_resultset($conn, $query);
	if ($result->num_rows) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<li><a style="background-color: #5cb85c; padding: 4px;" class="'.$row['type'].'-'.$row['subtype'].' link" data-toggle="tab" >'.ucfirst($row['descrizione']).'</a></li>';
		}
	}
?>
	</ul>
<?php //genero la tabella
	$query = "SELECT c.id as type, b.id as subtype, titolo, a.descrizione as descrizione, prezzo, light, vegan, vegetarian, gluten_free, lower(substring_index(b.descrizione,' ',-1)) as descrMenu 
		FROM menu a inner join tipo_sub_menu b on a.id_sub_menu = b.id inner join tipo_menu c on b.id_menu = c.id 
		WHERE c.descrizione like '%".$type."'AND b.descrizione like '%".$subtype."' ";
	$result = get_resultset($conn, $query);
	if ($result->num_rows) {
		echo '<div class="tab-pane"><table class="table table-striped"><thead><tr class="info"><th>Nome</th><th></th><th>Prezzo</th><th>LightFood</th><th>Vegetariano</th><th>Vegano</th><th>Gluten Free</th></tr></thead><tbody>';
		
		/*foreach ($row as $key => $value) {
						 echo $key.' '.$value.'<br/>';
					}*/
		
		while ($row = mysqli_fetch_assoc($result)) {
			$t = ucwords($row['titolo']);
			$d = $row['descrizione'];
			$p = $row['prezzo'];
			if ($row['light'])
				$l = '<span class="glyphicon glyphicon-ok"></span>';
			else
				$l = '<span class="glyphicon glyphicon-remove"></span>';
			if ($row['vegetarian'])
				$vegetarian = '<span class="glyphicon glyphicon-ok"></span>';
			else
				$vegetarian = '<span class="glyphicon glyphicon-remove"></span>';
			if ($row['vegan'])
				$v = '<span class="glyphicon glyphicon-ok"></span>';
			else
				$v = '<span class="glyphicon glyphicon-remove"></span>';
			if ($row['gluten_free'])
				$gluten_free = '<span class="glyphicon glyphicon-ok"></span>';
			else
				$gluten_free = '<span class="glyphicon glyphicon-remove"></span>';
			echo '<tr><td>'.$t.'</td><td>';
			if ($d)
				echo '<a class="link-popover" data-trigger="hover" data-toggle="popover" data-content="'.$d.'"><span class="glyphicon glyphicon-plus"></span></a>';
			echo '</td><td>'.$p.' €</td><td>'.$l.'</td><td>'.$vegetarian.'</td><td>'.$v.'</td><td>'.$gluten_free.'</td></tr>';
		}
		echo '</tbody></table></div>';// &nbsp
	}
	$conn->close();
?>
</div>