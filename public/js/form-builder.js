document.addEventListener("DOMContentLoaded", () => {
    // Elementos del DOM
    const formBody = document.querySelector(".form-body");
    const addFieldToggle = document.getElementById("addFieldToggle");
    const fieldOptions = document.getElementById("fieldOptions");
    const guardarBtn = document.getElementById("guardarFormularioBtn");
    const deleteBtn = document.querySelector(".red-btn");
    const overlay = document.getElementById("deleteOverlay");
    const cancelBtn = document.getElementById("cancelDelete");
    const addButtonWrapper = document.querySelector(".add-button-wrapper");

    // Mapeo de tipos internos al texto del ENUM de la base de datos
    const typeMap = {
        multiple: "Opción Múltiple",
        text: "Texto",
        number: "Número",
        date: "Fecha"
    };

    // Mostrar/ocultar opciones de campos
    addFieldToggle.addEventListener("click", () => {
        fieldOptions.classList.toggle("hidden");
    });

    // Agregar pregunta desde opciones
    document.querySelectorAll(".field-option").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const type = btn.getAttribute("data-type");
            createQuestionBlock(type);
        });
    });

    // Mostrar modal de confirmación para eliminar
    deleteBtn.addEventListener("click", () => {
        overlay.classList.remove("hidden");
    });

    cancelBtn.addEventListener("click", () => {
        overlay.classList.add("hidden");
    });

    // Guardar formulario
    guardarBtn.addEventListener("click", (e) => {
        e.preventDefault();

        const titulo = document.querySelector(".editable-text").innerText;
        document.getElementById("tituloFormulario").value = titulo;

        const preguntas = Array.from(document.querySelectorAll(".question-block")).map((block) => {
            const pregunta = block.querySelector(".editable-question").innerText;
            const tipoInterno = block.getAttribute("data-type");
            const tipo = typeMap[tipoInterno] || "";

            let opciones = null;
            if (tipoInterno === "multiple") {
                opciones = Array.from(block.querySelectorAll(".multiple-options .editable-option")).map(opt => opt.innerText);
            }

            return { pregunta, tipo, opciones };
        });

        document.getElementById("preguntasJson").value = JSON.stringify(preguntas);
        document.getElementById("formularioCreate").submit();
    });

    // Crear bloque de pregunta
    function createQuestionBlock(type) {
        const questionBlock = document.createElement("div");
        questionBlock.classList.add("question-block");
        questionBlock.setAttribute("data-type", type);
    
        const questionHeader = createQuestionHeader(type, questionBlock);
        const responseContainer = document.createElement("div");
        responseContainer.classList.add("response-container");
    
        if (type === "multiple") {
            const { optionsContainer, addOptionBtn } = createMultipleOptions();
            responseContainer.appendChild(optionsContainer);
            responseContainer.appendChild(addOptionBtn);
        } else {
            const input = document.createElement("input");
            input.classList.add("question-input");
            input.setAttribute("type", type);
            responseContainer.appendChild(input);
        }
    
        questionBlock.appendChild(questionHeader);
        questionBlock.appendChild(responseContainer);
        formBody.appendChild(questionBlock);
    
        const divider = document.createElement("hr");
        divider.classList.add("divider-line");
        formBody.appendChild(divider);
    
        formBody.appendChild(addButtonWrapper);
    }
    

    function createQuestionHeader(type, questionBlock) {
        const header = document.createElement("div");
        header.classList.add("question-header");

        const questionText = document.createElement("div");
        questionText.classList.add("editable-question");
        questionText.textContent = "Escribe tu pregunta aquí";
        questionText.contentEditable = true;
        questionText.spellcheck = false;

        const questionType = document.createElement("span");
        questionType.classList.add("question-type");
        questionType.textContent = `(${getTypeLabel(type)})`;

        const deleteText = document.createElement("span");
        deleteText.classList.add("delete-text");
        deleteText.innerHTML = "Eliminar pregunta";

        const deleteBtn = document.createElement("button");
        deleteBtn.classList.add("delete-question-btn");
        deleteBtn.innerHTML = "🗑️";
        deleteBtn.type = "button";
        deleteBtn.addEventListener("click", () => {
            const dividerLine = questionBlock.nextElementSibling;
            if (dividerLine && dividerLine.classList.contains("divider-line")) {
                dividerLine.remove();
            }
        
            questionBlock.remove();
        });
        

        deleteBtn.insertBefore(deleteText, deleteBtn.firstChild);

        header.appendChild(questionText);
        header.appendChild(questionType);
        header.appendChild(deleteBtn);

        return header;
    }

    function createMultipleOptions() {
        const optionsContainer = document.createElement("div");
        optionsContainer.classList.add("multiple-options");

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

        // Crear la primera opción
        addOption();

        const addOptionBtn = document.createElement("button");
        addOptionBtn.textContent = "+ Agregar opción";
        addOptionBtn.type = "button";
        addOptionBtn.classList.add("add-option-btn");
        addOptionBtn.addEventListener("click", addOption);

        return { optionsContainer, addOptionBtn };
    }

    function getTypeLabel(type) {
        return typeMap[type] || "";
    }
});
