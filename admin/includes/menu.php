    	<ul class="nav">
        	<li class="tt"><span>Artigos</span>
            	<ul class="sub">
                	<li><a href="?url=posts/posts-create" title="Criar artigo">Criar Artigo</a></li>
                    <li><a href="?url=posts/posts" title="Editar artigo">Artigos</a></li>
                    <li><a href="?url=posts/categories" title="Categorias">Gerenciar Categorias</a></li>
                </ul>
            </li>
<?php
if($_SESSION['adUser']['level'] == 1){
?>
            <li class="tt"><span>Páginas</span>
            	<ul class="sub">
                	<li><a href="?url=pages/pages-create" title="Criar Página">Criar Página</a></li>
                    <li><a href="?url=pages/pages" title="Editar Páginas">Gerenciar Páginas</a></li>
                </ul>
            </li>
            <li class="tt"><span>Regiões de Artigos</span>
            	<ul class="sub">
                    <li><a href="?url=regions/home" title="Editar Páginas">Home</a></li>
                    <li><a href="?url=regions/notfound" title="Editar Páginas">404 Not Found</a></li>
                </ul>
            </li>
<?php
}
?>
            <li class="tt"><span>Usuários</span>
            	<ul class="sub">
                	<li><a href="?url=users/users-edit&userid=<?=$_SESSION['adUser']['id']?>" title="Perfil">Meu Perfil</a></li>
<?php
if($_SESSION['adUser']['level'] == 1){
?>
                    <li><a href="?url=users/users-create" title="Criar Usuário">Criar Usuário</a></li>
                    <li><a href="?url=users/users" title="Gerenciar Usuário">Gerenciar Usuários</a></li>
<?php
}
?>
                </ul>
            </li>
        </ul><!-- /nav -->