document.addEventListener("DOMContentLoaded", () => {

    const formProduto = document.querySelector(".form-produto");
    if (formProduto) {
        formProduto.addEventListener("submit", (e) => {
            
            const codigo = document.querySelector("#codigo");
            const nome = document.querySelector("#nome");
            const valor = document.querySelector("#valor");
            const quantidade = document.querySelector("#quantidade");
            const status = document.querySelector("#status");
            
            if (codigo && codigo.value.trim() === "") {
                alert("O código do produto é obrigatório.");
                e.preventDefault();
                return;
            }

            if (nome && nome.value.trim() === "") {
                alert("O nome do produto é obrigatório.");
                e.preventDefault();
                return;
            }

            if (valor && valor.value !== "" && isNaN(valor.value)) {
                alert("O valor do produto deve ser um número.");
                e.preventDefault();
                return;
            }

            if (quantidade && (isNaN(quantidade.value) || quantidade.value < 0)) {
                alert("A quantidade deve ser um número maior ou igual a zero.");
                e.preventDefault();
                return;
            }

            if (status && status.value === "") {
                alert("Selecione o status do produto.");
                e.preventDefault();
                return;
            }
        });
    }

    const botoesExcluir = document.querySelectorAll(".btn-excluir");

    botoesExcluir.forEach(btn => {
        btn.addEventListener("click", (e) => {
            if (!confirm("Tem certeza que deseja excluir este produto?")) {
                e.preventDefault();
            }
        });
    });

    const inputBusca = document.querySelector("#buscar");
    const tabela = document.querySelector("table tbody");

    if (inputBusca && tabela) {
        inputBusca.addEventListener("keyup", () => {
            const termo = inputBusca.value.toLowerCase();
            const linhas = tabela.querySelectorAll("tr");

            linhas.forEach(linha => {
                const nome = linha.querySelector("td:nth-child(2)").textContent.toLowerCase();
                linha.style.display = nome.includes(termo) ? "" : "none";
            });
        });
    }
});
