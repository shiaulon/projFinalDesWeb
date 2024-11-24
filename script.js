let cartCount = 0;

function startOrder() {
    window.location.href = "menu.php";
}
function addItem() {
    cartCount++;
    updateCart();
    document.getElementById("cart-status").textContent = "Adicionado ao Carrinho";
}

function removeItem() {
    if (cartCount > 0) {
        cartCount--;
        updateCart();
        document.getElementById("cart-status").textContent = "Adicionar ao Carrinho";
    }
}

function updateCart() {
    document.getElementById('cart-count').textContent = cartCount;
}


function toggleCarrinho() {
    const carrinho = document.getElementById('carrinho');
    carrinho.style.display = carrinho.style.display === 'block' ? 'none' : 'block';
}

function alterarQuantidade(index, delta) {
    const quantidadeElement = document.getElementById(`quantidade-${index}`);
    const itemElement = document.getElementById(`item-${index}`);
    const totalElement = document.getElementById('total');
    const quantidadeAtual = parseInt(quantidadeElement.textContent);
    const novaQuantidade = quantidadeAtual + delta;

    if (novaQuantidade > 0) {
        quantidadeElement.textContent = novaQuantidade;

        const preco = parseFloat(itemElement.querySelector('.item-nome').dataset.preco);
        const totalAtual = parseFloat(totalElement.textContent.replace(',', '.'));
        totalElement.textContent = (totalAtual + delta * preco).toFixed(2).replace('.', ',');
    } else {
        itemElement.remove();
        atualizarTotal();
    }
}

function atualizarTotal() {
    const totalElement = document.getElementById('total');
    let total = 0;

    document.querySelectorAll('.item-nome').forEach((item, index) => {
        const quantidade = parseInt(document.getElementById(`quantidade-${index}`).textContent);
        const preco = parseFloat(item.dataset.preco);
        total += quantidade * preco;
    });

    totalElement.textContent = total.toFixed(2).replace('.', ',');
}


    // Função para enviar os dados do carrinho para a página carrinho.php
function salvarCarrinho() {
        // Criação de um array para armazenar os dados do carrinho
    let carrinho = [];
        
        // Coletar os itens do carrinho na sessão
    const itens = document.querySelectorAll('.item-nome');
    itens.forEach((item, index) => {
        const quantidade = document.getElementById('quantidade-' + index).innerText;
        const preco = item.dataset.preco;
        carrinho.push({
            nome: item.innerText,
            quantidade: quantidade,
            preco: preco
         });
     });

     // Enviar os dados via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "carrinho.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert("Carrinho salvo com sucesso!");
             window.location.href = "carrinho.php"; // Redireciona para a página do carrinho
           }
    };
    xhr.send(JSON.stringify(carrinho));
}
