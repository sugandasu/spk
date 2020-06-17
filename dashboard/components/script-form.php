  <script>
    function resetForm() {
      inputForms = document.querySelectorAll('input');
      inputForms.forEach((inputForm) => {
        $(inputForm).val('');
      })

      selectForms = document.querySelectorAll('select');
      selectForms.forEach((selectForm) => {
        $(selectForm).val('');
      })
    }

    function getForm(options) {
      return fetch(options.url).then(response => {
        return response.json();
      });
    }

    function renderForm(formData) {
      const modalForm = document.querySelector("#modalForm");
      const modalBody = document.createElement("div");
      modalBody.setAttribute("id", "modalBody");
      modalBody.setAttribute("class", "modal-body");

      formData.forEach(inputData => {
        let divFormGroup = document.createElement("div");
        divFormGroup.setAttribute("class", "form-group");

        let divRow = document.createElement("div");
        divRow.setAttribute("class", "row");

        let divCol = document.createElement("div");
        divCol.setAttribute("class", "offset-md-1 col-md-10");

        let labelInput = document.createElement("label");
        labelInput.setAttribute("class", "control-label");
        labelInput.setAttribute("for", inputData.name);

        let labelText = document.createTextNode(inputData.text);
        let inputForm = document.createElement(inputData.inputType);
        inputForm.setAttribute("id", inputData.name);
        inputForm.setAttribute("class", "form-control");
        inputForm.setAttribute("name", inputData.name);
        inputForm.setAttribute("required", "required");

        if (inputData.inputType == "input") {
          inputForm.setAttribute("type", inputData.type);

          if (inputData.type == "number") {
            inputForm.setAttribute("step", 0.01);
          }
        } else if (inputData.inputType == "select") {
          inputForm.appendChild(document.createElement("option"));

          inputData.selectData.forEach(optionData => {
            let selectOption = document.createElement("option");
            selectOption.setAttribute("value", optionData.value);
            inputForm.appendChild(selectOption);

            let optionText = document.createTextNode(optionData.text);
            selectOption.appendChild(optionText);
            inputForm.appendChild(selectOption);
          });
        }

        labelInput.appendChild(labelText);
        divCol.appendChild(labelInput);
        divCol.appendChild(inputForm);
        divRow.appendChild(divCol);
        divFormGroup.appendChild(divRow);

        modalBody.appendChild(divFormGroup);
      });

      const oldModalBody = document.querySelector("#modalBody");
      modalForm.replaceChild(modalBody, oldModalBody);
    }

    function initForm(url) {
      const options = {
        url: url
      };

      getForm(options).then(responseJson => {
        renderForm(responseJson.form);
      });
    }

    function setForm(options) {
      const modalForm = document.querySelector("#modalForm");
      const modalTitle = document.querySelector("#modalTitle");
      const modalButton = document.querySelector("#modalButton");

      modalForm.setAttribute("action", options.url);
      modalTitle.innerHTML = options.title;
      modalButton.setAttribute("class", options.buttonClass);
      modalButton.innerHTML = options.title;
    }

    function setFormInput(columns = [], id = "") {
      columns.forEach(name => {
        const inputForm = document.querySelector(`#${name}`);
        const data = document.querySelector(`#${name}_${id}`);

        if (inputForm.tagName == "INPUT") {
          inputForm.setAttribute("value", data.getAttribute('data-value'));
        } else if (inputForm.tagName == "SELECT") {
          $(inputForm).val(data.getAttribute('data-value'));
        }
      });
    }
  </script>