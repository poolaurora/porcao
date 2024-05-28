<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INFO PAINEL - INFO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
</head>
<body class="bg-gray-900 text-gray-100">

<div class="flex items-center justify-center min-h-screen bg-gray-800">
    <div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg max-w-md w-full">
        <div class="mb-4">
            <h1 class="text-xl font-bold">Consultável</h1>
            <p class="text-sm text-gray-400">Informações da Consultável</p>
        </div>

        <!-- Textarea com as informações -->
        <textarea readonly class="w-full h-64 bg-gray-800 p-3 rounded text-sm text-white border border-gray-700 focus:outline-none" id="infoText">
Registro #{{ $item->id }}  R${{ number_format($item->itemable->limite, 2, ',', '.') }}
{{ $item->itemable->banco }}
Cartão: {{ $item->itemable->ccn }}
Validade: {{ $item->itemable->validade }}
Cod. Segurança: {{ $item->itemable->cvv }}
@if($item->itemable->senha6)
Senha do cartão: {{ $item->itemable->senha6 }}
@endif
Titular: {{ $item->itemable->nome }}
CPF: {{ $item->itemable->cpf }}
E-Mail: {{ $item->itemable->email }}
Telefone: {{ $item->itemable->telefone }}

@if($content)
================================
PUXADA
================================

{{ $content }}

@endif
        </textarea>

        <!-- Botões de ação -->
        <div class="flex justify-between mt-4">
        <button onclick="copyInfo()" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Copiar Info
            </button>
            <a href="/items" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Voltar
            </a>
        </div>
    </div>
</div>

<script>
function copyInfo() {
    // Encontre o elemento textarea
    var copyText = document.getElementById("infoText");
    if (copyText) { // Verifica se o elemento existe
        copyText.select(); // Seleciona o texto
        copyText.setSelectionRange(0, 99999); // Seleciona o texto para compatibilidade com dispositivos móveis

        // Tenta escrever no clipboard
        navigator.clipboard.writeText(copyText.value).then(function() {
            alert("Informações copiadas com sucesso!");
        }, function(err) {
            alert("Erro ao copiar informações: " + err);
        });
    } else {
        alert("Elemento de texto não encontrado!");
    }
}
</script>


</body>
</html>
