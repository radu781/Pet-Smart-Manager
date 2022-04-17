// Generate a dynamic number of inputs
function addFields() {
    
    // Cast to Int is required, otherwise we cannot compare numbers
    var number = parseInt(document.getElementById("meals").value);
    var max_number = parseInt(document.getElementById("meals").max);

    // If user insert manually something huge, we take care about his mistake
    if (number >= max_number) {
        number = max_number;
    }

    // Get the element where the inputs will be added to
    var container = document.getElementById("hazi-dynamic-fields");

    // Remove every children it had before
    while (container.hasChildNodes()) {
        container.removeChild(container.lastChild);
    }

    for (i=1; i <= number; i++){
        // Append one div (no attributes)
        var div = document.createElement('div');

        // Append a node with a random text
        var label = container.appendChild(document.createElement('label'));
        label.setAttribute('for', 'meal' + i);
        var text = 'Meal #' + i + ': (required)'.italics();
        label.innerHTML = text;

        // Create an <input> element, set its type and name attributes
        var input = document.createElement("input");
        input.required = true;
        input.type = "time";
        input.name = "meal" + i;
        container.appendChild(input);

        // Append a line break 
        container.appendChild(div);
        div.appendChild(label);
        div.appendChild(input);
    }
}