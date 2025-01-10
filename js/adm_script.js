function addVariable() {
    const variablesDiv = document.getElementById('variables');
    const variableIndex = variablesDiv.children.length;
    const newVariable = `
<div class="variable">
    <label>Variable Name:</label>
    <input type="text" name="variable_name[]" required /><br>

    <label>Type:</label>
    <select style="color:black" name="variable_type[]" data-index="${variableIndex}" onchange="updateOptions(this)" required>
        <option style="color:black" value="number">Number</option>
        <option style="color:black" value="select">Select</option>
    </select>

    <div class="options-container" data-index="${variableIndex}" style="display: none;">
        <label>Options:</label><br>
        <button type="button" onclick="addOption(this, ${variableIndex})">Add Option</button><br>
    </div>

    <button type="button" class="remove-button" onclick="removeVariable(this)">Remove Variable</button>
</div>
<hr><br>
`;
    variablesDiv.insertAdjacentHTML('beforeend', newVariable);
}

function updateOptions(selectElement) {
    const optionsContainer = selectElement.parentElement.querySelector('.options-container');
    optionsContainer.style.display = selectElement.value === 'select' ? 'block' : 'none';
}

function addOption(button, index) {
    const container = document.querySelector(`.options-container[data-index="${index}"]`);
    const newOption = `<input type="text" name="variable_options[${index}][]" placeholder="Option" />`;
    container.insertAdjacentHTML('beforeend', newOption);
}

function removeVariable(button) {
    button.parentElement.remove();
}