<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
		if(!empty($_POST['sendFilter'])){
			$_SESSION['search'] = $_POST['search'];
			if($_SESSION['search']){
				$_SESSION['where'] = ' AND name LIKE ? ';
				header('Location: ?url=users/users');
			}else{
				unset($_SESSION['search']);
				unset($_SESSION['where']);
				header('Location: ?url=users/users');
			}
		}
?>
            <div class="bloco user" style="display:block">
            	<div class="titulo">Usuários:
<?php
		if(!empty($_SESSION['return'])){
			echo $_SESSION['return'];
			unset($_SESSION['return']);
		}
?>
                	<form name="filtro" action="" method="post">
<?php
		if(!empty($_SESSION['search']) && !empty($_SESSION['where'])){
			echo '<span class="searchInfo">Buscas sobre: <span style="text-transform:uppercase">'.$_SESSION['search'].'</span> <input type="submit" value="Voltar" style="margin:-4px -2px -4px 0" name="sendFilter" class="btn" /></span>';
		}else{
?>
                    	<label>
                        	<input type="text" name="search" class="radius" size="30" placeholder="Titulo:"/>
                        </label>
                        <input type="submit" value="filtrar resultados" name="sendFilter" class="btn" />
<?php	} ?>
                    </form>
                </div><!-- /titulo --> 
<?php
		$pag = $_GET['pag'] ?? 1;
		$max = 10;
		$start = ($pag-1)*$max;
		if(!empty($_GET['deluser'])){
			$readAvatar = read('cuc_users', 'WHERE id=?', array($_GET['deluser']), 'i');
			foreach($readAvatar as $avatar);
			$avatar = $avatar['avatar'];
			if(file_exists('../uploads/avatars/'.$avatar)){
				unlink('../uploads/avatars/'.$avatar);
			}
			delete('cuc_users', 'WHERE id=? AND id!=?', array($_GET['deluser'], $_SESSION['adUser']['id']), 'ii');
			$_SESSION['return'] = '<span class="ms ok">Usúario removido com sucesso!</span>';
			header('Location: ?url=users/users&pag='.$pag);
		}
		if(!empty($_SESSION['search']) && !empty($_SESSION['where'])){
			$params = array($_SESSION['adUser']['id'], '%'.$_SESSION['search'].'%', $start, $max);
			$values = 'isii';
		}else{
			$params = array($_SESSION['adUser']['id'], $start, $max);
			$values = 'iii';
		}
		if($readUser = read('cuc_users', 'WHERE id != ? '.($_SESSION['where'] ?? '').' ORDER BY level ASC, name ASC LIMIT ?, ?', $params, $values)){
?>
                <table width="560" border="0" class="tbdados" style="float:left;" cellspacing="0" cellpadding="0">
                  <tr class="ses">
                    <td align="center">#id</td>
                    <td>nome:</td>
                    <td>email:</td>
                    <td align="center">nível:</td>
                    <td align="center" colspan="3">ações:</td>
                  </tr>
<?php
			foreach($readUser as $user){
				switch($user['level']){
					case 1: $level = 'Administrador'; break;
					case 2: $level = 'Editor'; break;
					case 3: $level = 'Membro'; break;
					case 4: $level = 'Leitor'; break;
					default: $level = 'Error';
				}
?>
                  <tr>
                    <td align="center"><?=$user['id']?></td>
                    <td><?=$user['name']?></td>
                    <td><?=$user['email']?></td>
                    <td align="center"><?=$level?></td>
                    <td align="center"><a href="?url=users/users-edit&userid=<?=$user['id']?>" title="editar"><img src="ico/edit.png" alt="editar" title="editar" /></a></td>
                    <td align="center"><a href="#window-del" rel="<?='?url=users/users&pag='.$pag.'&deluser='.$user['id']?>" title="excluir"><img src="ico/no.png" alt="excluir" title="excluir" /></a></td>
                  </tr>
<?php
			}
            echo '</table>';
			$url = '?url=users/users&pag=';
			if($_SESSION['where'] && $_SESSION['search']){
				$params = array($_SESSION['adUser']['id'], '%'.$_SESSION['search'].'%');
				$types = 'is';
			}else{
				$params = array($_SESSION['adUser']['id']);
				$types = 'i';
			}
			paginator('cuc_users', 'WHERE id!=?'.$_SESSION['where'], $params, $types, $max, $url, $pag);
		}elseif($pag == 1){
			echo '<span class="ms in">Não existem usuários cadastrados!</span>';
		}else header('Location: ?url=users/users');
?>
            </div><!-- /bloco user -->
            <span class="ms al" id="window-del">
                <p>Atenção: Você está prestes a excluir um usuário. Deseja continuar?</p>
                <p style="text-align:center;"><a class="btnalt" name="excluir" href="#">SIM</a> <a class="close-del btn">NÃO</a></p>
            </span>
            <div id="mask"></div>
<?php
	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>