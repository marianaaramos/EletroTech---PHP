<?php  ?>

<div class="container admin-page">
    <div class="page-header">
        <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg> Produtos <span class="badge"><?= $total ?></span></h1>
        <a href="<?= APP_URL ?>/index.php?controller=products&action=create" class="btn btn-primary">+ Novo Produto</a>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= $produto['id'] ?></td>
                        <td>
                            <?php if (!empty($produto['imagem'])): ?>
                                <img src="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($produto['imagem']) ?>"
                                     style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                            <?php else: ?>
                                <div style="width:50px;height:50px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= htmlspecialchars($produto['nome']) ?></strong>
                            <?php if (!empty($produto['marca'])): ?>
                                <br><small class="text-muted"><?= htmlspecialchars($produto['marca']) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($produto['categoria_nome'] ?? 'Sem categoria') ?></td>
                        <td>
                            <?php if (!empty($produto['preco_promocional']) && $produto['preco_promocional'] > 0): ?>
                                <span style="text-decoration:line-through;color:#999;">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span><br>
                                <strong style="color:#e74c3c;">R$ <?= number_format($produto['preco_promocional'], 2, ',', '.') ?></strong>
                            <?php else: ?>
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($produto['estoque'] <= 0): ?>
                                <span class="badge badge-danger">0 un.</span>
                            <?php elseif ($produto['estoque'] <= 5): ?>
                                <span class="badge badge-warning"><?= $produto['estoque'] ?> un.</span>
                            <?php else: ?>
                                <span class="badge badge-success"><?= $produto['estoque'] ?> un.</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($produto['ativo']): ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                            <?php if ($produto['destaque']): ?>
                                <span class="badge badge-warning"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5z"/></svg></span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="<?= APP_URL ?>/index.php?controller=products&action=show&id=<?= $produto['id'] ?>"
                               class="btn btn-sm btn-outline" title="Ver"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg></a>
                            <a href="<?= APP_URL ?>/index.php?controller=products&action=edit&id=<?= $produto['id'] ?>"
                               class="btn btn-sm btn-outline" title="Editar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg></a>
                            <a href="<?= APP_URL ?>/index.php?controller=products&action=destroy&id=<?= $produto['id'] ?>&csrf_token=<?= urlencode($csrfToken) ?>"
                               class="btn btn-sm btn-danger" title="Excluir"
                               onclick="return confirm('Excluir o produto \'<?= htmlspecialchars($produto['nome']) ?>\'?')">
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center">Nenhum produto cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= APP_URL ?>/index.php?controller=admin&action=products&page=<?= $i ?>"
               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>
