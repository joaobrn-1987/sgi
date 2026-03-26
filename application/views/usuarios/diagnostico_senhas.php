<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h2><i class="fa fa-shield"></i> Diagnóstico de Segurança — Senhas</h2>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <h3 class="text-success"><?= $bcrypt_count ?></h3>
                            <p>Senhas seguras (bcrypt)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-danger">
                        <div class="card-body text-center">
                            <h3 class="text-danger"><?= $sha1_count ?></h3>
                            <p>Senhas legadas (SHA1 — vulneráveis)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3><?= $total ?></h3>
                            <p>Total de usuários</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($sha1_count > 0): ?>
            <div class="alert alert-warning mt-3">
                <strong>Atenção:</strong> <?= $sha1_count ?> usuário(s) ainda utilizam hash SHA1 (fraco).
                Eles serão migrados automaticamente para bcrypt ao realizar o próximo login.
                Para forçar a migração imediata (gerando senhas temporárias), use o botão abaixo.
            </div>

            <h4>Usuários com senha SHA1 legada:</h4>
            <table class="table table-bordered table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th><th>Login</th><th>Nome</th><th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sha1_users as $u): ?>
                    <tr class="<?= $u['situacao'] ? '' : 'table-secondary' ?>">
                        <td><?= (int)$u['id'] ?></td>
                        <td><?= htmlspecialchars($u['user'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($u['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= $u['situacao'] ? '<span class="badge badge-success">Ativo</span>' : '<span class="badge badge-secondary">Inativo</span>' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="card border-danger mt-3">
                <div class="card-header bg-danger text-white">
                    <strong>Forçar Reset de Senhas SHA1</strong>
                </div>
                <div class="card-body">
                    <p>Esta ação gera senhas temporárias para todos os <?= $sha1_count ?> usuários com hash SHA1
                    e exibe na tela para você enviar a cada um. <strong>A operação não pode ser desfeita.</strong></p>
                    <form method="POST" action="<?= base_url() ?>index.php/usuarios/forcar_reset_senhas"
                          onsubmit="return confirm('Tem certeza? Isso irá resetar as senhas de <?= $sha1_count ?> usuário(s).')">
                        <?= $this->security->get_csrf_token_name() ? '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'">' : '' ?>
                        <div class="form-group">
                            <label>Digite <strong>SIM_CONFIRMO</strong> para confirmar:</label>
                            <input type="text" name="confirmar" class="form-control" placeholder="SIM_CONFIRMO" required>
                        </div>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-exclamation-triangle"></i> Forçar Reset de Senhas SHA1
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-success mt-3">
                <strong>Parabéns!</strong> Todos os usuários já utilizam bcrypt. Nenhuma ação necessária.
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
