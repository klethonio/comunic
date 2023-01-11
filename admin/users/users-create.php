<?php
if(function_exists('getUser')){
	if(getUser($_SESSION['adUser']['id'], 1)){
?>
            <div class="bloco form" style="display:block">
            	<div class="titulo">Cadastrar Usúario:</div>
<?php
		if(!empty($_POST['sendForm'])){
			$f['name'] = $_POST['name'];
			$f['cpf'] = $_POST['cpf'];
			$f['email'] = $_POST['email'];
			$f['pswd'] = encPswd($_POST['pswd']);
			$repwrd = encPswd($_POST['repswd']);
			$f['address'] = $_POST['address'];
			$f['cep'] = $_POST['cep'];
			$f['city'] = $_POST['city'];
			$f['state'] = $_POST['state'];
			$f['cel'] = $_POST['cel'];
			$f['level'] = $_POST['level'];
			$f['reg_date'] = date('Y-m-d H:i:s');
			$f['status'] = $_POST['status'];
			
			if(in_array('', $f) || !$_POST['pswd'] || !$_POST['repswd']){
				echo '<span class="ms al">Preencha todos os campos!</span>';
			}elseif(!validCPF($f['cpf'])){
				echo '<span class="ms al">CPF informado é invalido!</span>';
			}elseif(!validMail($f['email'])){
				echo '<span class="ms al">E-mail informado é invalido!</span>';
			}elseif($f['pswd'] != $repwrd){
				echo '<span class="ms al">Senhas informadas não conferem!</span>';
			}elseif(strlen($_POST['pswd']) < 3){
				echo '<span class="ms al">A senha deve conter no mínimo 8 caracteres!</span>';
			}else{
				if($readCpfEmail = read('cuc_users', 'WHERE cpf=? OR email=?', array($f['cpf'], $f['email']), 'ss')){
					echo '<span class="ms al">E-mail ou CPF já cadastrado!</span>';
				}else{
					if($_POST['tel']){
						$f['tel'] = $_POST['tel'];
					}else $f['tel'] = NULL;
					if($_FILES['avatar']['tmp_name']){
						echo 'foi';
						if(preg_match('/\.(jpg|png|gif|jpeg)$/i', $_FILES['avatar']['name'], $ext)){
							$tmp = $_FILES['avatar']['tmp_name'];
							$f['avatar'] = md5(time()).$ext[0];
							$folder = '../uploads/avatars/';
							uploadImage($tmp, $f['avatar'], 200, $folder);
						}
					}
					if(create('cuc_users', $f, 'ssssssssssisis')){
						$_SESSION['return'] = '<span class="ms ok">Usúario cadastrado com sucesso!</span>';
						header('Location: ?url=users/users');
					}
				}
			}
		}
?>                
                <form name="formulario" action="" method="post" enctype="multipart/form-data">
                    <label class="line">
                    	<span class="data">Nome:</span>
                        <input type="text" name="name" value="<?=$f['name'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">CPF:</span>
                        <input type="text" id="formCpf" class="formCpf" name="cpf" value="<?=$f['cpf'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">E-mail:</span>
                        <input type="text" name="email" value="<?=$f['email'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Senha:</span>
                        <input type="password" name="pswd" value="" />
                    </label>
                    <label class="line">
                    	<span class="data">Repitir senha:</span>
                        <input type="password" name="repswd" value="" />
                    </label>
                    <label class="line">
                    	<span class="data">Endereço:</span>
                        <input type="text" name="address" value="<?=$f['address'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">CEP:</span>
                        <input type="text" class="formCep" name="cep" value="<?=$f['cep'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Cidade:</span>
                        <input type="text" name="city" value="<?=$f['city'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Estado:</span>
                        <input type="text" name="state" value="<?=$f['state'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Telefone:</span>
                        <input type="text" class="formFone" placeholder="(__) ____-____" name="tel" value="<?=$f['tel'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Celular:</span>
                        <input type="text" class="formFone" placeholder="(__) _____-____" name="cel" value="<?=$f['cel'] ?? null?>" />
                    </label>
                    <label class="line">
                    	<span class="data">Avatar:</span>
                        <input type="file" class="fileinput" name="avatar" size="60" style="cursor:pointer; background:#FFF;" />
                    </label> 
                    <label class="line">
                        <select name="level">
                        	<option value="">Selecione o nível deste usúario:</option>
                        	<option <?php if(($f['level'] ?? null) == 4) echo 'selected';?> value="4">Leitor</option>
                        	<option <?php if(($f['level'] ?? null) == 3) echo 'selected';?> value="3">Membro</option>
                        	<option <?php if(($f['level'] ?? null) == 2) echo 'selected';?> value="2">Editor</option>
                        	<option <?php if(($f['level'] ?? null) == 1) echo 'selected';?> value="1">Administrador</option>
                        </select>
                    </label>
                    <div class="check">
                        <span class="data">Selecione o status deste usúario:</span>
                        <ul>
                            <li><label><input type="radio" value="1" <?php if(!empty($f['status'])) echo 'checked';?> name="status" /> Ativo</label></li>
                            <li class="last"><label><input type="radio" <?php if(empty($f['status'])) echo 'checked';?> value="0" name="status" /> Inativo</label></li>
                        </ul>
                    </div>
                    
                    <input type="reset" value="clear" class="btnalt" />
                    <input type="submit" value="Cadastrar" name="sendForm" class="btn" />
                    
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