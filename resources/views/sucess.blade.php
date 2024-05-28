<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agradecimento pelo Pagamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-gray-800 rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="p-6 w-full text-center">
            <i class="text-7xl fa-regular fa-circle-check mx-auto mb-4 w-20 h-20 text-yellow-400"></i>
            <h2 class="text-2xl leading-8 font-semibold text-white">Agradecemos pelo seu pagamento!</h2>
            <p class="mt-4 text-gray-300">Seu pagamento foi processado com sucesso.</p>
            <p class="mt-2 text-gray-300">Agradecemos a confiança e a preferência em nossos serviços.</p>

            <!-- Início da seção de detalhes da compra -->
            <div class="mt-6 px-6 py-4 bg-gray-700 rounded-lg">
                <h3 class="text-xl text-white font-semibold">Detalhes da Compra</h3>
                <div class="mt-4 text-left">
                    <div id="valorTotal">
                    <p class="text-gray-300"><strong>Valor: R${{ number_format($pedido->description['info']['value'], 2, ',', '.') }}
                </strong></p>
                    </div>
                </div>
            </div>
            <!-- Fim da seção de detalhes da compra -->

            <div class="mt-6">
                <a href="/" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Voltar para o Início</a>
            </div>
        </div>
    </div>
</div>


</body>
</html>
