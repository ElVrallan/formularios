document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("addFieldToggle")
        .addEventListener("click", function () {
            const options = document.getElementById("fieldOptions");
            options.classList.toggle("hidden");
        });

    const formBody = document.querySelector(".form-body");

    function createQuestionBlock(type) {
        const questionBlock = document.createElement("div");
        questionBlock.classList.add("question-block");
        questionBlock.setAttribute("data-type", type);

        // Contenedor de la pregunta
        const questionHeader = document.createElement("div");
        questionHeader.classList.add("question-header");

        // Texto editable para la pregunta
        const questionText = document.createElement("div");
        questionText.classList.add("editable-question");
        questionText.textContent = "Escribe tu pregunta aquí";
        questionText.contentEditable = true;
        questionText.spellcheck = false;

        // Mostrar el tipo de la pregunta (en pequeño)
        const questionType = document.createElement("span");
        questionType.classList.add("question-type");
        questionType.textContent = `(${getTypeLabel(type)})`; // Tipo de la pregunta

        // Crear el texto de "Eliminar pregunta"
        const deleteText = document.createElement("span");
        deleteText.classList.add("delete-text");
        deleteText.innerHTML = "Eliminar pregunta"; // Texto con salto de línea

        // Botón de eliminación
        const deleteBtn = document.createElement("button");
        deleteBtn.classList.add("delete-question-btn");
        deleteBtn.innerHTML = "🗑️"; // El ícono del basurero
        deleteBtn.type = "button";
        deleteBtn.addEventListener("click", () => {
            questionBlock.remove();

            // Eliminar la línea punteada asociada
            if (divider) {
                divider.remove();
            }
        });

        // Insertar el texto antes del ícono
        deleteBtn.insertBefore(deleteText, deleteBtn.firstChild);

        // Agregar los elementos al encabezado
        questionHeader.appendChild(questionText);
        questionHeader.appendChild(questionType);
        questionHeader.appendChild(deleteBtn);
        questionBlock.appendChild(questionHeader);

        // Contenedor para las respuestas
        const responseContainer = document.createElement("div");
        responseContainer.classList.add("response-container");

        if (type === "multiple") {
            const optionsContainer = document.createElement("div");
            optionsContainer.classList.add("multiple-options");

            // Función para agregar una opción
            const addOption = () => {
                const optionWrapper = document.createElement("div");
                optionWrapper.classList.add("option-item");

                const input = document.createElement("input");
                input.type = "radio";
                input.disabled = true;

                const label = document.createElement("div");
                label.classList.add("editable-option");
                label.textContent = "Opción";
                label.contentEditable = true;
                label.spellcheck = false;

                // Botón para eliminar opción
                const deleteOptionBtn = document.createElement("button");
                deleteOptionBtn.innerHTML = "🗑️";
                deleteOptionBtn.classList.add("delete-option-btn");
                deleteOptionBtn.type = "button";
                deleteOptionBtn.addEventListener("click", () => {
                    optionWrapper.remove();
                });

                optionWrapper.appendChild(input);
                optionWrapper.appendChild(label);
                optionWrapper.appendChild(deleteOptionBtn);
                optionsContainer.appendChild(optionWrapper);
            };

            // Agregar 3 opciones por defecto
            for (let i = 0; i < 1; i++) {
                addOption();
            }

            // Botón para añadir más opciones
            const addOptionBtn = document.createElement("button");
            addOptionBtn.textContent = "+ Agregar opción";
            addOptionBtn.type = "button";
            addOptionBtn.classList.add("add-option-btn");
            addOptionBtn.addEventListener("click", addOption);

            questionBlock.appendChild(optionsContainer);
            questionBlock.appendChild(addOptionBtn);
        } else {
            const input = document.createElement("input");
            input.classList.add("question-input");
            input.setAttribute("type", type);
            responseContainer.appendChild(input);
        }

        questionBlock.appendChild(responseContainer);
        formBody.appendChild(questionBlock);

        const divider = document.createElement("hr");
        divider.classList.add("divider-line");
        formBody.appendChild(divider);

        
    const addButtonWrapper = document.querySelector('.add-button-wrapper');
    formBody.appendChild(addButtonWrapper)
    }

    // Función para obtener la etiqueta del tipo de pregunta
    function getTypeLabel(type) {
        switch (type) {
            case "multiple":
                return "Opción Múltiple";
            case "text":
                return "Texto";
            case "number":
                return "Número";
            case "date":
                return "Fecha";
            default:
                return "";
        }
    }
    

    document.querySelectorAll(".field-option").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const type = btn.getAttribute("data-type");
            createQuestionBlock(type);
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const deleteBtn = document.querySelector(".red-btn");
    const overlay = document.getElementById("deleteOverlay");
    const cancelBtn = document.getElementById("cancelDelete");

    deleteBtn.addEventListener("click", () => {
        overlay.classList.remove("hidden");
    });

    cancelBtn.addEventListener("click", () => {
        overlay.classList.add("hidden");
    });
});

document.getElementById("guardarFormularioBtn").addEventListener("click", function (e) {
    e.preventDefault();

    // Obtener el título
    const titulo = document.querySelector(".editable-text").innerText;
    document.getElementById("tituloFormulario").value = titulo;

    // Mapeo de tipos internos al texto del ENUM de la base de datos
    const typeMap = {
        multiple: "Opción Múltiple",
        text: "Texto",
        number: "Número",
        date: "Fecha"
    };

    // Obtener preguntas
// Obtener preguntas
const preguntas = [];
document.querySelectorAll(".question-block").forEach((block) => {
    const pregunta = block.querySelector(".editable-question").innerText;
    const tipoInterno = block.getAttribute("data-type");
    const tipo = typeMap[tipoInterno] || "";

    let opciones = null;

    if (tipoInterno === "multiple") {
        opciones = [];
        block.querySelectorAll(".multiple-options .editable-option").forEach((opt) => {
            opciones.push(opt.innerText);
        });
    }

    preguntas.push({
        pregunta: pregunta,
        tipo: tipo,
        opciones: opciones // puede ser null si no es de tipo múltiple
    });
});


    document.getElementById("preguntasJson").value = JSON.stringify(preguntas);

    document.getElementById("formularioCreate").submit();
});
