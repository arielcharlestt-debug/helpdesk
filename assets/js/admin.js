document.addEventListener("alpine:init", () => {
    console.log('alpine:init');
});


function isEmpty(value) {
    if (value == null) {
        // Check for null or undefined
        return true;
    }

    if (typeof value === 'string' || Array.isArray(value)) {
        // Check if string or array is empty
        return value.length === 0;
    }

    if (value instanceof Map || value instanceof Set) {
        // Check if Map or Set is empty
        return value.size === 0;
    }

    if (typeof value === 'object' && value !== null) {
        // Check if it's a plain object and has no own properties
        return Object.keys(value).length === 0;
    }

    // For other types (e.g., numbers, booleans, functions), they are not "empty"
    return false;
}