<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque Atual - Ubertec</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/tableimprimir.css" />

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
                    <table class="table table-striped table-hover" id="tabelaEstoque">
                        <thead class="table-dark">
                            <tr>
                                <th>PN</th>
                                <th>DESCRIÇÃO</th>
                                <th class="text-center">QUANTIDADE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($estoque as $r){
                                echo '<tr>';
                                echo '<td>'.$r->pn.'</td>';
                                echo '<td>'.$r->descricao.'</td>';
                                echo '<td class="text-center">'.$r->quantidade.'</td>';
                                echo '</tr>';
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
$(document).ready(function() {
    $('#tabelaEstoque').DataTable({
        "language": { 
            "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json"
        },
        "pageLength": 10,
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ]
    });

    $("#imprimir").click(function() {
        PrintElem('#divEstoque');
    });

    function PrintElem(elem) {
        Popup($(elem).html());
    }

    function Popup(data) {
        var mywindow = window.open('', 'SGI', 'height=600,width=800');
        mywindow.document.write('<html><head><title>SGI</title>');
        mywindow.document.write("<link rel='stylesheet' href='<?php echo base_url();?>assets/css/tableimprimir.css' />");
        mywindow.document.write('<style> body { font-family: sans-serif; } table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; } thead { background-color: #f2f2f2; } </style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write('<div style="text-align: center;margin-bottom: 15px;"><img src="https://sgisistemas.site/assets5_2/img/logo/ubertec_logo.png"></div>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        mywindow.focus();
        setTimeout(function () {
            mywindow.print();
            mywindow.close();
        }, 250);
        return true;
    }

    $(".export-csv").on('click', function(event) {
        var args = [$('#tabelaEstoque'), $(this).data("filename") + ".csv", 0];
        exportTableToCSV.apply(this, args);
    });

    function exportTableToCSV($table, filename, type) {
        var startQuote = ";UBERTEC SERVICE USINAGEM LTDA;\r\n;;\r\n"
        var $rows = $table.find('tr').not(".no-csv"),
            tmpColDelim = String.fromCharCode(11),
            tmpRowDelim = String.fromCharCode(0),
            colDelim = type == 0 ? '";"' : '\t',
            rowDelim = type == 0 ? '"\r\n"' : '\r\n',
            csv = startQuote + $rows.map(function(i, row) {
                var $row = $(row),
                    $cols = $row.find('td,th');
                return $cols.map(function(j, col) {
                    var $col = $(col),
                        text = $col.text().trim();
                    return text.replace(/"/g, '""');
                }).get().join(tmpColDelim);
            }).get().join(tmpRowDelim)
            .split(tmpRowDelim).join(rowDelim)
            .split(tmpColDelim).join(colDelim) + startQuote;

        var BOM = "\uFEFF";
        if (window.Blob && window.URL) {
            var blob = new Blob([BOM + csv], { type: 'text/csv;charset=utf8' });
            var csvUrl = URL.createObjectURL(blob);
            $(this).attr({ 'download': filename, 'href': csvUrl });
        } else {
            var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(BOM + csv);
            $(this).attr({ 'download': filename, 'href': csvData, 'target': '_blank' });
        }
    }
});
</script>
</body>
</html>
