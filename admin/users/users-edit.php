<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 2)){
		if($readUser = read('cuc_users', 'WHERE id=?', array($_GET['userid']), 'i')){
			foreach($readUser as $user);
			if($_SESSION['adUser']['id'] != 1 && getUser($_SESSION['adUser']['id']) != $user['id']){
				header('Location: ../index2.php');
			}
		}else header('Location: ?url=users/users');
?>
            <div class="bloco form" style="display:block">
            	<div class="titulo">Editar Usúario <span style="color: #900;"><?=$user['name']?></span>: <a href="?url=users/users" class="btnalt" style="float:right;">Voltar</a></div>
<?php
		if(!empty($_POST['sendForm'])){
			$f['name'] = $_POST['name'];
			$f['email'] = $_POST['email'];
			$f['address'] = $_POST['address'];
			$f['cep'] = $_POST['cep'];
			$f['city'] = $_POST['city'];
			$f['state'] = $_POST['state'];
			$f['cel'] = $_POST['cel'];
			if($_SESSION['adUser']['level'] == 1){
				$f['cpf'] = $_POST['cpf'];
				$f['level'] = $_POST['level'];
				$f['reg_date'] = date('Y-m-d H:i:s');
				$f['status'] = $_POST['status'];
				$types = 'sssssssssisis';
			}else $types = 'sssssssss';
			if($_POST['pswd']){
				$f['pswd'] = encPswd($_POST['pswd']);
				$repwrd = encPswd($_POST['repswd']);
				$types = 's'.$types;
			}
			
			if(in_array('', $f)){
				echo '<span class="ms al">Preencha todos os campos!</span>';
			}elseif(!validCPF($f['cpf'])){
				echo '<span class="ms al">CPF informado é invalido!</span>';
			}elseif(!validMail($f['email'])){
				echo '<span class="ms al">E-mail informado é invalido!</span>';
			}elseif($_POST['pswd'] && $f['pswd'] != $repwrd){
				echo '<span class="ms al">Senhas informadas não conferem!</span>';
			}elseif($_POST['pswd'] && strlen($_POST['pswd']) < 3){
				echo '<span class="ms al">A senha deve conter no mínimo 6 caracteres!</span>';
			}else{
				if($_POST['tel']){
					$f['tel'] = $_POST['tel'];
				}else $f['tel'] = NULL;
				if($readCpfEmail = read('cuc_users', 'WHERE (cpf=? OR email=?) AND id!=?', array($f['cpf'], $f['email'], $user['id']), 'ssi')){
					echo '<span class="ms al">E-mail ou CPF já cadastrado!</span>';
				}else{
					if($_FILES['avatar']['tmp_name']){
						$avatar = $_FILES['avatar']['name'];
						if(preg_match('/\.(jpg|png|gif|jpeg)$/i', $avatar, $ext)){
							$tmp = $_FILES['avatar']['tmp_name'];
							$folder = '../uploads/avatars/';
							if(file_exists($folder.$user['avatar']) && is_file($folder.$user['avatar'])){
								unlink($folder.$user['avatar']);
							}
							$f['avatar'] = md5(time()).$ext[0];
							uploadImage($tmp, $f['avatar'], 200, $folder);							
						}
					}
					if(update('cuc_users', $f, 'WHERE id=?', array($_GET['userid']), $types)){
						$_SESSION['return'] = '<span class="ms ok">Usúario editado com sucesso!</span>';
						if($_SESSION['adUser']['id'] == $_GET['userid'] && $f['pswd']){
							$_SESSION['adUser']['pswd'] = $f['pswd'];
						}
						if($_SESSION['adUser']['level'] == 1){
							header('Location: ?url=users/users');
						}else header('Location: index2.php');	
					}
				}
			}
		}
?>                
                <form name="formulario" action="" method="post" enctype="multipart/form-data">
                    <label class="line">
                    	<span class="data">Nome:</span>
                        <input type="text" name="name" value="<?=$user['name']?>" />
                    </label>
<?php
		if($_SESSION['adUser']['level'] == 1){
?>
                    <label class="line">
                    	<span class="data">CPF:</span>
                        <input type="text" id="formCpf" class="formCpf" name="cpf" value="<?=$user['cpf']?>" />
                    </label>
<?php
		}
?>
                    <label class="line">
                    	<span class="data">E-mail:</span>
                        <input type="text" name="email" value="<?=$user['email']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Nova Senha:</span>
                        <input type="password" name="pswd" value="" />
                    	<span class="obs">Obs.: Para manter a senha inalterada, deixe o campo em branco!</span>
                    </label>
                    <label class="line">
                    	<span class="data">Repitir senha:</span>
                        <input type="password" name="repswd" value="" />
                    	<span class="obs">Obs.: Para manter a senha inalterada, deixe o campo em branco!</span>
                    </label>
                    <label class="line">
                    	<span class="data">Endereço:</span>
                        <input type="text" name="address" value="<?=$user['address']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">CEP:</span>
                        <input type="text" class="formCep" name="cep" value="<?=$user['cep']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Cidade:</span>
                        <input type="text" name="city" value="<?=$user['city']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Estado:</span>
                        <input type="text" name="state" value="<?=$user['state']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Telefone:</span>
                        <input type="text" class="formFone" placeholder="(__) ____-____" name="tel" value="<?=$user['tel']?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Celular:</span>
                        <input type="text" class="formFone" placeholder="(__) _____-____" name="cel" value="<?=$user['cel']?>" />
                    </label>
                    <label class="line">
                    	<div class="data">Avatar:
<?php
		if($user['avatar']){
			echo '			<a style="float:right;" href="../uploads/avatars/'.$user['avatar'].'" rel="shadowbox" title="ver avatar">
								<img src="../tim.php?src='.BASE.'/uploads/avatars/'.$user['avatar'].'&w=50&h=50" alt="avatar do usúario" title="avatar do usúario"/>
							</a>';
		}
?>
                        	
                        </div>
                        <input type="file" class="fileinput" name="avatar" size="60" style="cursor:pointer; background:#FFF;" />
                    	<span class="obs">Obs.: Para manter o avatar inalterado, deixe o campo em branco!</span>
                    </label>
<?php
		if($_SESSION['adUser']['level'] == 1){
?>
                    <label class="line">
                        <select name="level">
                        	<option value="">Selecione o nível deste usúario:</option>
                        	<option <?php if($user['level'] == 4) echo 'selected';?> value="4">Leitor</option>
                        	<option <?php if($user['level'] == 3) echo 'selected';?> value="3">Membro</option>
                        	<option <?php if($user['level'] == 2) echo 'selected';?> value="2">Editor</option>
                        	<option <?php if($user['level'] == 1) echo 'selected';?> value="1">Administrador</option>
                        </select>
                    </label>
                    <div class="check">
                        <span class="data">Selecione o status deste usúario:</span>
                        <ul>
                            <li><label><input type="radio" value="1" <?php if($user['status'] == 1) echo 'checked';?> name="status" /> Ativo</label></li>
                            <li class="last"><label><input type="radio" <?php if($user['status'] == 0) echo 'checked';?> value="0" name="status" /> Inativo</label></li>
                        </ul>
                    </div>
<?php
		}
?>
                    <input type="reset" value="clear" class="btnalt" />
                    <input type="submit" value="Editar" name="sendForm" class="btn" />
                    
                </form>
                	
            </div><!-- /bloco form -->
<?php
	}else{
		echo '<span class="ms al">Você não tem permissão para acessar essa página!</span>';
	}
}else{
	header('Location: ../index2.php');
}
?>