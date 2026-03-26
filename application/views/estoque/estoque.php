<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Atual - Ubertec</title>

    <!-- === CSS (Usando ficheiros locais) === -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- CSS do DataTables local -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.bootstrap5.min.css'); ?>" />

    <style>
        body {
            background-color: #f0f2f5;
        }
        .main-card {
            margin-top: 2rem;
            margin-bottom: 2rem;
            border: none;
            box-shadow: 0 0 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            background-color: rgba(255, 255, 255, 0.95);
        }
        #bg-video {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -100;
            transform: translateX(-50%) translateY(-50%);
            background-size: cover;
        }
        #video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: -99;
        }
        .content-wrapper {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>

<div id="video-overlay"></div>
<video autoplay muted loop id="bg-video">
    <source src="<?php echo base_url('assets/videos/background-video.mp4'); ?>" type="video/mp4">
</video>

<div class="content-wrapper">
    <main class="container">
        <div class="card main-card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center p-3">
                <img src="<?php echo base_url('assets5_2/img/logo/oz.png'); ?>" alt="Cliente Logo" height="60">
                <h4 class="mb-0">
                    <i class="bi bi-box-seam"></i> Estoque Atual Ubertec
                </h4>
                <div>
                    <button id="imprimir" class="btn btn-secondary">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                    <a href="javascript:;" class="export-csv btn btn-success" data-filename="EstoqueAtual">
                        <i class="bi bi-file-earmark-excel"></i> Exportar para Excel
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div id="divEstoque">
                    <table class="table table-striped table-hover" id="tabelaEstoque" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>PN</th>
                                <th>DESCRIÇÃO</th>
                                <th class="text-center">QUANTIDADE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($estoque as $r): ?>
                                <tr>
                                    <td><?= htmlspecialchars($r->pn, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?= htmlspecialchars($r->descricao, ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center"><?= htmlspecialchars($r->quantidade, ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- === SCRIPTS JS (Usando ficheiros locais com caminhos corrigidos) === -->
<script src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap5.min.js'); ?>"></script>

<script>
$(document).ready(function() {
    $('#tabelaEstoque').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/Portuguese-Brasil.json"
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        responsive: true
    });

    $("#imprimir").click(function() {
        PrintElem('#divEstoque');
    });

    $(".export-csv").on('click', function(event) {
        var args = [$('#tabelaEstoque'), $(this).data("filename") + ".csv"];
        exportTableToCSV.apply(this, args);
    });
});

function PrintElem(elem) {
    Popup($(elem).html());
}

function Popup(data) {
    var mywindow = window.open('', 'SGI', 'height=600,width=800');
    mywindow.document.write('<html><head><title>SGI</title>');
    mywindow.document.write('<style> body { font-family: sans-serif; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; } thead { background-color: #f2f2f2; } </style>');
    mywindow.document.write('</head><body>');
    mywindow.document.write('<div style="text-align: center;margin-bottom: 15px;"><img src="https://sgisistemas.site/assets5_2/img/logo/ubertec_logo.png"></div>');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');
    mywindow.document.close();
    mywindow.document.focus();
    setTimeout(function () {
        mywindow.print();
        mywindow.close();
    }, 250);
    return true;
}

function exportTableToCSV($table, filename) {
    var startQuote = ";UBERTEC SERVICE USINAGEM LTDA;\r\n;;\r\n"
    var $rows = $table.find('tr').not(".no-csv"),
        tmpColDelim = String.fromCharCode(11),
        tmpRowDelim = String.fromCharCode(0),
        colDelim = '";"',
        rowDelim = '"\r\n"',
        csv = startQuote + '"' + $rows.map(function(i, row) {
            var $row = $(row),
                $cols = $row.find('td,th');
            return $cols.map(function(j, col) {
                var $col = $(col),
                    text = $col.text().trim();
                return text.replace(/"/g, '""');
            }).get().join(tmpColDelim);
        }).get().join(tmpRowDelim)
        .split(tmpRowDelim).join(rowDelim)
        .split(tmpColDelim).join(colDelim) + '"';

    var BOM = "\uFEFF";
    if (window.Blob && window.URL) {
        var blob = new Blob([BOM + csv], { type: 'text/csv;charset=utf8' });
        var csvUrl = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = csvUrl;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(BOM + csv);
        $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
    }
}
</script>

</body>
</html>
