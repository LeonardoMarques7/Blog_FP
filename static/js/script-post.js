const styleToggle = document.getElementById("style-toggle");
const styleLink = document.getElementById("style-link");
const toggleImage = document.getElementById("img");

document.addEventListener("DOMContentLoaded", () => {
    // Verifique se já há uma escolha armazenada no Local Storage
    const storedStyle = localStorage.getItem("selectedStyle");
    if (storedStyle === "dark") {
        updateTinyMCEStyle(true); // Atualiza o estilo do TinyMCE para o modo escuro
        styleToggle.checked = true;
        styleLink.href = "./css/style-escuro.css";
        toggleImage.src = toggleImage.getAttribute("data-dark-image");N  
    } else {
        updateTinyMCEStyle(false);
    }

    document.body.style.display = "block";
});

styleToggle.addEventListener("change", () => {
    if (styleToggle.checked) {
        styleLink.href = "./css/style-escuro.css";
        toggleImage.src = toggleImage.getAttribute("data-dark-image");
        localStorage.setItem("selectedStyle", "dark"); // Armazene a escolha no Local Storage
        updateTinyMCEStyle(true); // Atualiza o estilo do TinyMCE para o modo escuro
    } else {
        styleLink.href = "./css/style.css";
        toggleImage.src = "./img/modo-escuro.png"; // Imagem do modo claro
        localStorage.removeItem("selectedStyle"); // Remova a escolha do Local Storage
        updateTinyMCEStyle(false); // Atualiza o estilo do TinyMCE para o modo claro
    }
});

function updateTinyMCEStyle(isDarkMode) {
    tinymce.remove(); // Remove qualquer instância anterior do TinyMCE

    tinymce.init({
        selector: 'textarea',
        plugins: 'paste link',
        toolbar: 'undo redo | bold italic underline strikethrough | link | checklist numlist bullist | emoticons charmap | removeformat ',
        menubar: false,
        statusbar: false,
        language: 'pt_BR',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
        content_style: isDarkMode ? 'body { background-color: #242424; color: #eee; }' : 'body { background-color: #f0f0f0; }',
        setup: function (editor) {
            editor.on('init', function () {
                // Remova o tamanho da textarea
                editor.getContainer().style.height = '300px';
                editor.getContainer().style.width = 'auto';
                editor.getContainer().style.maxWidth = '500px';
                editor.getContainer().style.marginRight = '20px';
                editor.getContainer().style.marginTop = '5px';
            });
        },
        forced_root_block_attrs: {
            'class': 'description'
        }
    });
}

    

   
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
