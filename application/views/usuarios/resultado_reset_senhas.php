<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2><i class="fa fa-key"></i> Reset de Senhas Concluído</h2>
            <div class="alert alert-warning">
                <strong>ATENÇÃO:</strong> Copie ou imprima esta página agora. As senhas temporárias
                abaixo são exibidas <strong>apenas uma vez</strong> e devem ser enviadas
                individualmente a cada usuário. Após o primeiro login, o sistema solicitará
                a criação de uma nova senha.
            </div>

            <?php if (count($resetados) > 0): ?>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Nome</th>
                        <th>Senha Temporária</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resetados as $r): ?>
                    <tr>
                        <td><?= (int)$r['id'] ?></td>
                        <td><code><?= htmlspecialchars($r['user'], ENT_QUOTES, 'UTF-8') ?></code></td>
                        <td><?= htmlspecialchars($r['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><strong><code><?= htmlspecialchars($r['senha_temp'], ENT_QUOTES, 'UTF-8') ?></code></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="alert alert-info">
                <strong><?= count($resetados) ?></strong> usuário(s) tiveram suas senhas redefinidas com bcrypt.
                Oriente cada usuário a alterar a senha temporária imediatamente após o login em
                <strong>Minha Conta → Alterar Senha</strong>.
            </div>
            <?php else: ?>
            <div class="alert alert-success">Nenhum usuário com SHA1 encontrado. Nenhuma ação foi necessária.</div>
            <?php endif; ?>

            <a href="<?= base_url() ?>index.php/usuarios/diagnostico_senhas" class="btn btn-primary">
                <i class="fa fa-refresh"></i> Verificar novamente
            </a>
        </div>
    </div>
</div>
