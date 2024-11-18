const styleToggle = document.getElementById("style-toggle");
const styleLink = document.getElementById("style-link");
const toggleImage = document.getElementById("img");

document.addEventListener("DOMContentLoaded", () => {
    // Verifique se já há uma escolha armazenada no Local Storage
    const storedStyle = localStorage.getItem("selectedStyle");
    if (storedStyle === "dark") {
        styleToggle.checked = true;
        styleLink.href = "./static/css/style-escuro.css";
        toggleImage.src = toggleImage.getAttribute("data-dark-image");
    }

    document.body.style.display = "block";
});

styleToggle.addEventListener("change", () => {
    if (styleToggle.checked) {
        styleLink.href = "./static/css/style-escuro.css";
        toggleImage.src = toggleImage.getAttribute("data-dark-image");
        localStorage.setItem("selectedStyle", "dark"); // Armazene a escolha no Local Storage
    } else {
        styleLink.href = "./static/css/style.css";
        toggleImage.src = "./static/img/modo-escuro.png"; // Imagem do modo claro
        localStorage.removeItem("selectedStyle"); // Remova a escolha do Local Storage
    }

    var slug = $slug;
    var url = "https://blog-fp.infinityfreeapp.com/viewPost.php?slug=";
    var link = document.getElementById("copyLink");
    var like = document.getElementById("likeButton");
    var isLiked = false;

    like.addEventListener("click", function () {
        // Alterne entre os ícones com base no estado atual
        if (isLiked) {
            likeButton.innerHTML = '<i class="fa-regular fa-heart"></i>';
        } else {
            likeButton.innerHTML = '<i class="fa-solid fa-heart"></i>';
        }

        // Inverta o estado
        isLiked = !isLiked;
    });

    link.addEventListener("click", function () {
        // Copie a URL completa (parte fixa + código) para a área de transferência
        var urlCompleta = url + slug;
        navigator.clipboard
            .writeText(urlCompleta)
            .then(function () {
                // Altere o ícone para o ícone de check após a cópia bem-sucedida
                link.innerHTML =
                    '<i class="fa-regular fa-copy"></i> Link copiado';
            })
            .catch(function (err) {
                console.error("Erro ao copiar a URL: ", err);
            });
    });
});

// Habilitado

// styleLink.href = "../css/style-escuro.css";
// toggleImage.src = toggleImage.getAttribute("data-dark-image");

// Desabilitado

// styleLink.href = "../css/style.css";
// toggleImage.src = "../img/modo-escuro.png";

// Adicionando botões de atalho na textarea

function adicionarAtalho(atalho) {
    var editor = document.getElementById("assunto");
    var textoAtual = editor.value;
    var selecaoInicio = editor.selectionStart;
    var selecaoFim = editor.selectionEnd;

    var textoAntes = textoAtual.substring(0, selecaoInicio);
    var textoDepois = textoAtual.substring(selecaoFim);

    var novoTexto = textoAntes + atalho + textoDepois;

    editor.value = novoTexto;

    // Atualize a posição do cursor após a inserção do atalho
    var novaPosicaoCursor = selecaoInicio + atalho.length;
    editor.setSelectionRange(novaPosicaoCursor, novaPosicaoCursor);
}

// Script do PESQUISAR

var search = document.getElementById("pesquisar");

search.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
        searchData();
    }
});

function searchData() {
    var Caminho = window.location.pathname;
    window.location = Caminho + "?search=" + search.value;
}

// Limpa o campo de pesquisa e remove o parâmetro da URL quando a página é recarregada.
if (!window.location.search.includes("search=")) {
    search.value = "";
}

// Script do butão de like
function likePost(button) {
    button.classList.toggle("liked");
}

$(document).ready(function () {
    $(".profession-select").select2({
        theme: "classic", // Use the 'classic' theme
        dropdownCssClass: "dark-theme-dropdown", // Add a custom class for dark theme styling
    });
});

function togglePasswordVisibility() {
    const passwordInput = document.querySelector('.input-senha');
    const icon = document.querySelector('#icon-senha');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text'; 
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password'; 
        icon.classList.remove('fa-eye-slash'); 
        icon.classList.add('fa-eye'); 
    }
}
